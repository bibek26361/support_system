<?php

namespace App\Http\Controllers;

use App\ProblemType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;


class ProblemTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $problemtypes = ProblemType::all();
        return view('back.pages.problemtype.index', compact('problemtypes'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('back.pages.problemtype.create');

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
        ]);
        ProblemType::create($request->all());
        Session::flash('message','Created Successfully');
        return redirect()->route('problemtype.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ProblemType  $problemType
     * @return \Illuminate\Http\Response
     */
    public function show(ProblemType $problemType)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ProblemType  $problemType
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $problemtype=ProblemType::find($id);
        // return $problemtype;
        return view('back.pages.problemtype.edit',compact('problemtype'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ProblemType  $problemType
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required',
        ]);
        $problemtype = ProblemType::find($id);
        $problemtype->name = $request['name'];
        $problemtype->status = $request['status'];
        $problemtype->save();
        Session::flash('message', 'Problem Type Updated Successfully !');
        return redirect()->route('problemtype.index')->with('msg','updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ProblemType  $problemType
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $problemtype = ProblemType::find($id);
        $problemtype->delete();
        return redirect()->back();
    }
}
