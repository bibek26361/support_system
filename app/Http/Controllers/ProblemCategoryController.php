<?php

namespace App\Http\Controllers;

use App\ProblemCategory;
use App\ProblemType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;


class ProblemCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $problemcategories = ProblemCategory::all();
        $problemtypes = ProblemType::all();
        return view('back.pages.problemcategory.index', compact('problemcategories', 'problemtypes'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $problemtypes = ProblemType::all();
        return view('back.pages.problemcategory.create', compact('problemtypes'));
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
            'problem_type_id' => 'required',
            'name' => 'required',
            'points' => 'required',
        ]);
        ProblemCategory::create($request->all());
        Session::flash('message', 'Created Successfully');
        return redirect()->route('problemcategory.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ProblemCategory  $problemCategory
     * @return \Illuminate\Http\Response
     */
    public function show(ProblemCategory $problemCategory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ProblemCategory  $problemCategory
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $problemcategory = ProblemCategory::find($id);
        $problemtypes = ProblemType::all();
        // return $problemcategory;
        return view('back.pages.problemcategory.edit', compact('problemcategory', 'problemtypes'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ProblemCategory  $problemCategory
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'problem_type_id' => 'required',
            'name' => 'required',
            'points' => 'required',
        ]);
        $problemcategory = ProblemCategory::find($id);
        $problemcategory->problem_type_id = $request['problem_type_id'];
        $problemcategory->name = $request['name'];
        $problemcategory->points = $request->points;
        $problemcategory->status = $request['status'];
        $problemcategory->save();
        Session::flash('message', 'Problem Category Updated Successfully !');
        return redirect()->route('problemcategory.index')->with('msg', 'updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ProblemCategory  $problemCategory
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $problemcategory = ProblemCategory::find($id);
        $problemcategory->delete();
        return redirect()->back();
    }

    public function typeWiseCategory($problemTypeId)
    {
        $problemcategories = ProblemCategory::whereProblemTypeId($problemTypeId)->get();
        return $problemcategories;
    }
}
