<?php

namespace App\Http\Controllers;

use App\Ticket;
use App\Organization;
use App\Department;
use App\User;
use Illuminate\Http\Request;
use App\OrganizationType;
use App\ProblemCategory;
use App\ProblemType;
use App\Remark;
use App\Task;
use Illuminate\Support\Facades\Auth;


class DashboardController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tickets = Ticket::all();
        $totalTickets = $tickets->count();

        $departments = Department::all();
        $countdepartments = $departments->count();

        $users = User::all();
        $countusers = $users->count();

        $organizations = Organization::all();
        $countorganizations = $organizations->count();

        $currentUserId = Auth::user()->id;
        $totalAssignedTickets = Ticket::whereStatus(1)->whereAssignedTo($currentUserId)->get()->count();
        $totalTransferedTickets = Ticket::whereCreatedBy($currentUserId)->where('assigned_to', '<>', $currentUserId)->whereStatus(1)->get()->count();
        $totalClosedTickets = Ticket::whereStatus(0)->get()->count();

        $opentickets = Ticket::whereStatus(2)->get();
        $countopentickets = $opentickets->count();

        $auth = Auth::user();
        if ($auth->user_type == 'Admin') {
            $latestTickets = Ticket::orderBy('id', 'desc')->limit(10)->get();
        } else {
            $latestTickets = Ticket::whereCreatedBy($auth->id)->orWhere('assigned_to', $auth->id)->orderBy('id', 'desc')->limit(10)->get();
        }
        if ($auth->user_type == 'Admin') {
            $latestTasks = Task::orderBy('id', 'desc')->limit(10)->get();
        } else {
            $latestTasks = Task::whereCreatedBy($auth->id)->orWhere('user_id', $auth->id)->orderBy('id', 'desc')->limit(10)->get();
        }

        return view('back.pages.dashboard', compact(
            'tickets',
            'totalTickets',
            'totalAssignedTickets',
            'totalTransferedTickets',
            'totalClosedTickets',
            'countdepartments',
            'countusers',
            'countorganizations',
            'countopentickets',
            'latestTickets',
            'latestTasks'
        ));
    }

    public function count()
    {
        $tickets = Ticket::all();
        $counttickets = $tickets->count();
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
        //
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
        //
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
}
