<?php

namespace App\Http\Controllers;

use App\User;
use App\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class UserController extends Controller

{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::all();
        foreach ($users as $key => $user) {
            $user->department_name = $user->department ?? '-';
            $user->profile_image = $this->getProfileImage($user->profile_image);
        }
        return view('back.pages.user.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $departments = Department::all();
        return view('back.pages.user.create', compact('departments'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'department_id' => 'required',
            'name' => 'required',
            'email' => ['required', 'unique:users'],
            'password' => 'required',
            'contact' => 'required|min:10|max:15|unique:users',
            'status' => 'required',

        ]);

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move('public/images/users', $imageName);
            User::create([
                'user_type' => $request->user_type,
                'department_id' => $request->department_id,
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password),
                'contact' => $request->contact,
                'status' => $request->status,
                'profile_image' => 'images/users/' . $imageName
            ]);
        } else {
            User::create([
                'user_type' => $request->user_type,
                'department_id' => $request->department_id,
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password),
                'contact' => $request->contact,
                'status' => $request->status,
            ]);
        }
        Session::flash('message', 'Created Successfully');
        return redirect()->route('user.index');;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::find($id);
        return view('back.pages.user.profile', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::find($id);
        $user->profile_image = $this->getProfileImage($user->profile_image);
        $departments = Department::all();

        return view('back.pages.user.edit', compact('user', 'departments'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'department_id' => ['required'],
            'name' => ['required'],
            'email' => 'required|unique:users,email,' . $id,
            'password' => ['required'],
            'contact' => 'required|min:10|max:15|unique:users,contact,' . $id,
            'status' => ['required'],

        ]);
        $user = User::find($id);
        $user->user_type = $request->user_type;
        if ($request->hasfile('image')) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move('public/images/users', $imageName);
            $this->removeOldProfileImage($user->profile_image);
            $user->department_id = $request->department_id;
            $user->name = $request->name;
            $user->email = $request->email;
            if ($request->password) {
                $user->password = bcrypt($request->password);
            }
            $user->contact = $request->contact;
            $user->status = $request->status;
            $user->profile_image = 'images/users/' . $imageName;
        } else {
            $user->department_id = $request->department_id;
            $user->name = $request->name;
            $user->email = $request->email;
            if ($request->password) {
                $user->password = bcrypt($request->password);
            }
            $user->contact = $request->contact;
            $user->status = $request->status;
        }
        $user->save();

        Session::flash('message', 'User Updated Successfully !');
        return redirect()->route('user.index')->with('msg', 'updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::find($id);
        $user->delete();
        return redirect()->back();
    }

    public function departmentWiseUser($departmentId)
    {
        $users = User::whereDepartmentId($departmentId)->get();
        return $users;
    }

    public function getProfileImage($image)
    {
        if (empty($image)) {
            return asset('public/images/logo.png');
        } elseif (file_exists('public/' . $image)) {
            return asset('public/' . $image);
        } else {
            return asset('public/images/logo.png');
        }
    }

    public function removeOldProfileImage($image)
    {
        if (empty($image)) {
            return true;
        } elseif (file_exists('public/' . $image)) {
            unlink('public/' . $image);
            return true;
        } else {
            return true;
        }
    }
}
