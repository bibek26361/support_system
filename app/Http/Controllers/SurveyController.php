<?php

namespace App\Http\Controllers;

use App\Department;
use App\Organization;
use App\ProblemCategory;
use App\ProblemType;
use App\Survey;
use App\User;
use Illuminate\Contracts\Session\Session;
use Illuminate\Http\Request;

class SurveyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $surveys = Survey::all()->reverse();
        foreach ($surveys as $key => $survey) {
            $survey->signature_image = $survey->getSignatureImage();
            $survey->survey_at = $survey->created_at->diffForHumans();
        }
        return view('back.pages.surveys.index', compact('surveys'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $organizations = Organization::all()->reverse();
        return view('back.pages.surveys.create', compact('organizations'));
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
            'organization_id' => 'required',
            'representative_name' => 'required',
            'feedback' => 'required',
            'signature_image' => 'required',
        ]);

        $survey = new Survey();
        $survey->organization_id = $request->organization_id;
        $survey->user_id = auth()->user()->id;
        $survey->representative_name = $request->representative_name;
        $survey->feedback = $request->feedback;
        $survey->signature_image = $request->signature_image;
        $survey->latitude = $request->latitude;
        $survey->longitude = $request->longitude;
        $file = $request->file('signature_image');
        $extension = $file->getClientOriginalExtension();
        $filename = time() . '.' . $extension;
        $file->move('public/images/surveys/signatures/', $filename);
        $survey->signature_image = 'images/surveys/signatures/' . $filename;
        if ($request->hasfile('image')) {
            $file = $request->file('image');
            $extension = $file->getClientOriginalExtension();
            $filename = time() . '.' . $extension;
            $file->move('public/images/surveys/', $filename);
            $survey->image = 'images/surveys/' . $filename;
        }
        if ($survey->save()) {
            return redirect()->route('surveys.index')->with('success', 'Survey has been added successfully');
        }
        return redirect()->route('surveys.index')->with('error', 'Something went wrong');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $survey = Survey::find($id);
        $survey->signature_image = $survey->getSignatureImage();
        $survey->images = $survey->getImages();
        $survey->survey_at = $survey->created_at->diffForHumans();
        $survey->survey_date_time = $survey->created_at->format('jS M, Y h:i:s A');
        return view('back.pages.surveys.show', compact('survey'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $survey = Survey::find($id);

        $organizations = Organization::all();
        $departments = Department::all();
        $users = User::all();
        $problemtypes = ProblemType::all();
        $problemcategories = ProblemCategory::all();
        return view('back.pages.surveys.edit', compact('survey', 'organizations', 'departments', 'users', 'problemtypes', 'problemcategories'));
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
        $survey = Survey::find($id);
        if ($request->hasfile('signature_image')) {
            $image = $request->file('signature_image');
            $imageName = time() . '-' . $image->getClientOriginalName();

            $image->move('public/images/surveys', $imageName);
            $update_survey = array(
                'organization_id' => $request->organization_id,
                'representative_name' => $request->representative_name,
                'feedback' => $request->feedback,
                'latitude' => $request->latitude,
                'longitude' => $request->longitude,

                'signature_image' => $imageName,
            );
        } else {
            $update_survey = array(
                'organization_id' => $request->organization_id,
                'representative_name' => $request->representative_name,
                'feedback' => $request->feedback,
                'latitude' => $request->latitude,
                'longitude' => $request->longitude,
            );
        }
        $survey->update($update_survey);

        return redirect()->route('surveys.index')->with('msg', 'updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $survey = Survey::find($id);
        if ($survey->delete()) {
            return redirect()->route('surveys.index')->with('success', 'Survey has been deleted successfully');
        }
        return redirect()->route('surveys.index')->with('error', 'Something went wrong');
    }
}
