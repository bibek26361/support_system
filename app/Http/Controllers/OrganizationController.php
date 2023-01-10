<?php

namespace App\Http\Controllers;

use App\Organization;
use App\OrganizationType;
use App\SystemLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session as FacadesSession;
use Illuminate\Support\Facades\Session;

class OrganizationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $organizations = Organization::all()->reverse();
        return view('back.pages.organization.index', compact('organizations'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $organizationtypes = OrganizationType::all();

        return view('back.pages.organization.create', compact('organizationtypes'));
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
            'security_key' => 'required|min:9|max:9|unique:organizations'
        ]);

        for (
            $apiKey = 'SUPPORTAPP', $i = 0, $z = strlen($a = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789') - 1;
            $i != 64;
            $x = rand(0, $z),
            $apiKey .= $a[$x], $i++
        );

        $organization = new Organization();
        $organization->organization_type_id = $request->organization_type_id;
        $organization->organizationname = $request->organizationname;
        $organization->address = $request->address;
        $organization->mobilenumber = $request->mobilenumber;
        $organization->phonenumber = $request->phonenumber;
        $organization->pan_vat_number = $request->pan_vat_number;
        $organization->representativename = $request->representativename;
        $organization->api_key = $apiKey;
        $organization->security_key = $request->security_key;
        $organization->system_base_url = $request->system_base_url;
        $organization->latitude = $request->latitude;
        $organization->longitude = $request->longitude;
        $organization->save();

        SystemLog::create([
            'user_id' => Auth::user()->id,
            'operation' => 'Organization Added',
            'description' => $request->organizationname . ' has beed added from Web Panel.'
        ]);

        Session::flash('message', 'Created Successfully');
        return redirect()->route('organization.index');
    }

    public function generateApiKey($id)
    {
        for (
            $apiKey = 'SUPPORTAPP', $i = 0, $z = strlen($a = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789') - 1;
            $i != 64;
            $x = rand(0, $z),
            $apiKey .= $a[$x], $i++
        );

        $organization = Organization::find($id);
        $organization->api_key = $apiKey;
        $organization->save();

        Session::flash('message', 'API Key Generated Successfully');
        return redirect()->route('organization.index');
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
        $organization = Organization::find($id);
        $organizationtypes = OrganizationType::all();

        return view('back.pages.organization.edit', compact('organization', 'organizationtypes'));
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
        $this->validate($request, [
            'security_key' => 'required|min:9|max:9|unique:organizations,security_key,' . $id
        ]);

        $organization = Organization::find($id);
        $organization->organization_type_id = $request['organization_type_id'];
        $organization->organizationname = $request['organizationname'];
        $organization->address = $request['address'];
        $organization->mobilenumber = $request['mobilenumber'];
        $organization->phonenumber = $request['phonenumber'];
        $organization->pan_vat_number = $request['pan_vat_number'];
        $organization->representativename = $request['representativename'];
        $organization->status = $request['status'];
        if ($request['security_key']) {
            $organization->security_key = $request['security_key'];
        }
        $organization->system_base_url = $request['system_base_url'];
        $organization->latitude = $request['latitude'];
        $organization->longitude = $request['longitude'];

        $organization->save();

        session::flash('message', 'Organization Updated Successfully !');
        return redirect()->route('organization.index')->with('msg', 'updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $organization = Organization::find($id);
        $organization->delete();
        return redirect()->back();
    }
}
