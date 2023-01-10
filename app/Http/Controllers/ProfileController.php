<?php

namespace App\Http\Controllers;

use App\Department;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;


class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();
        $user->profile_image = $this->getProfileImage($user->profile_image);
        return view('back.pages.user.profile', compact(['user']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }
    public function changePassword(Request $request, $id)
    {

        $user_id = Auth::user()->id;
        $user = User::find($id);
        $user->password = bcrypt($request->password);
        $user->save();
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function show($id)
    {

        // $user =User::find($id);
        // return view('back.pages.user.profile', compact('user'));

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
        return view('back.pages.user.profile.edit', compact('user', 'departments'));
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
            'name' => 'required',

        ]);
        $user = User::find($id);
        if ($request->hasfile('image')) {
            $this->removeOldProfileImage($user->profile_image);
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();

            $image->move('public/images/users', $imageName);
            $update_profile = array(
                'department_id' => $request->department_id,
                'name' => $request->name,
                'email' => $request->email,
                'contact' => $request->contact,
                'status' => $request->status,
                'profile_image' => 'images/users/' . $imageName
            );
        } else {
            $update_profile = array(


                'department_id' => $request->department_id,
                'name' => $request->name,
                'email' => $request->email,

                'contact' => $request->contact,
                'status' => $request->status,


            );
        }
        $user->update($update_profile);

        Session::flash('message', 'User Updated Successfully !');
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
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
