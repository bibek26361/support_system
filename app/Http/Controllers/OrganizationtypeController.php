<?php

namespace App\Http\Controllers;

use App\OrganizationType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class OrganizationTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $organizationtypes = OrganizationType::all();
        return view('back.pages.organizationtype.index', compact('organizationtypes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('back.pages.organizationtype.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        OrganizationType::create($request->all());
        Session::flash('message', 'Created Successfully');
        return redirect()->route('organizationtype.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $organizationtype = OrganizationType::find($id);

        return view('back.pages.organizationtype.edit', compact('organizationtype'));
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
        $organizationtype = OrganizationType::find($id);
        $organizationtype->name = $request['name'];
        $organizationtype->status = $request['status'];

        $organizationtype->save();

        Session::flash('message', 'Organizationtype Updated Successfully !');
        return redirect()->route('organizationtype.index')->with('msg', 'updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $organizationtype = OrganizationType::find($id);
        $organizationtype->delete();
        return redirect()->back();
    }
}
