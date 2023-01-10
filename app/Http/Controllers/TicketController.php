<?php

namespace App\Http\Controllers;

use App\Ticket;
use App\Organization;
use App\Department;
use App\ProblemCategory;
use App\ProblemType;
use App\Remark;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class TicketController extends Controller
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
        $auth = Auth::user();
        if ($auth->user_type == 'Admin') {
            $tickets = Ticket::all()->reverse();
        } else {
            $tickets = Ticket::whereCreatedBy($auth->id)->orWhere('assigned_to', $auth->id)->get()->reverse();
        }
        foreach ($tickets as $key => $ticket) {
            $ticket->problem_type = $ticket->problemType ? $ticket->problemType->name : '-';
            if ($ticket->assigned_to) {
                $ticket->assigned_user = User::find($ticket->assigned_to)->name;
            } else {
                $ticket->assigned_user = "<i class='text-danger'>Not Assigned</i>";
            }
            if ($ticket->department_id) {
                $ticket->department_name = Department::find($ticket->department_id)->departmentname;
            } else {
                $ticket->department_name = "<i class='text-danger'>Not Selected</i>";
            }
        }
        return view('back.pages.ticket.index', compact('tickets'));
    }

    public function getOpenedTickets()
    {
        $auth = Auth::user();
        if ($auth->user_type == 'Admin') {
            $tickets = Ticket::whereStatus(2)->get()->reverse();
        } else {
            $tickets = Ticket::whereStatus(2)->whereCreatedBy($auth->id)->orWhere('assigned_to', $auth->id)->get()->reverse();
        }
        foreach ($tickets as $key => $ticket) {
            $ticket->problem_type = $ticket->problemType ? $ticket->problemType->name : '-';
            if ($ticket->assigned_to) {
                $ticket->assigned_user = User::find($ticket->assigned_to)->name;
            } else {
                $ticket->assigned_user = "<i class='text-danger'>Not Assigned</i>";
            }
            if ($ticket->department_id) {
                $ticket->department_name = Department::find($ticket->department_id)->departmentname;
            } else {
                $ticket->department_name = "<i class='text-danger'>Not Selected</i>";
            }
        }
        return view('back.pages.ticket.index', compact('tickets'));
    }

    public function getAssignedTickets()
    {
        $auth = Auth::user();
        $tickets = Ticket::whereStatus(1)->whereAssignedTo($auth->id)->get()->reverse();

        foreach ($tickets as $key => $ticket) {
            $ticket->problem_type = $ticket->problemType ? $ticket->problemType->name : '-';
            if ($ticket->assigned_to) {
                $ticket->assigned_user = User::find($ticket->assigned_to)->name;
            } else {
                $ticket->assigned_user = "<i class='text-danger'>Not Assigned</i>";
            }
            if ($ticket->department_id) {
                $ticket->department_name = Department::find($ticket->department_id)->departmentname;
            } else {
                $ticket->department_name = "<i class='text-danger'>Not Selected</i>";
            }
        }
        return view('back.pages.ticket.index', compact('tickets'));
    }

    public function getTransferedTickets()
    {
        $currentUserId = Auth::user()->id;
        $tickets = Ticket::whereCreatedBy($currentUserId)->where('assigned_to', '<>', $currentUserId)->whereStatus(1)->get()->reverse();

        foreach ($tickets as $key => $ticket) {
            $ticket->problem_type = $ticket->problemType ? $ticket->problemType->name : '-';
            if ($ticket->assigned_to) {
                $ticket->assigned_user = User::find($ticket->assigned_to)->name;
                if ($ticket->status === 1) {
                    $ticket->status_text = 'Transferred';
                }
            } else {
                $ticket->assigned_user = "<i class='text-danger'>Not Transfered</i>";
            }
            if ($ticket->department_id) {
                $ticket->department_name = Department::find($ticket->department_id)->departmentname;
            } else {
                $ticket->department_name = "<i class='text-danger'>Not Selected</i>";
            }
        }
        return view('back.pages.ticket.index', compact('tickets'));
    }

    public function getClosedTickets()
    {
        $auth = Auth::user();
        if ($auth->user_type == 'Admin') {
            $tickets = Ticket::whereStatus(0)->get()->reverse();
        } else {
            $tickets = Ticket::whereStatus(0)->whereCreatedBy($auth->id)->orWhere('assigned_to', $auth->id)->get()->reverse();
        }
        foreach ($tickets as $key => $ticket) {
            $ticket->problem_type = $ticket->problemType ? $ticket->problemType->name : '-';
            if ($ticket->assigned_to) {
                $ticket->assigned_user = User::find($ticket->assigned_to)->name;
            } else {
                $ticket->assigned_user = "<i class='text-danger'>Not Assigned</i>";
            }
            if ($ticket->department_id) {
                $ticket->department_name = Department::find($ticket->department_id)->departmentname;
            } else {
                $ticket->department_name = "<i class='text-danger'>Not Selected</i>";
            }
        }
        return view('back.pages.ticket.index', compact('tickets'));
    }

    public function getOrganizationWiseTickets($organizationId)
    {
        $auth = Auth::user();
        if ($auth->user_type == 'Admin') {
            $tickets = Ticket::whereOrganizationId($organizationId)->get()->reverse();
        } else {
            $tickets = Ticket::whereOrganizationId($organizationId)->whereCreatedBy($auth->id)->orWhere('assigned_to', $auth->id)->get()->reverse();
        }
        foreach ($tickets as $key => $ticket) {
            $ticket->problem_type = $ticket->problemType ? $ticket->problemType->name : '-';
            if ($ticket->assigned_to) {
                $ticket->assigned_user = User::find($ticket->assigned_to)->name;
            } else {
                $ticket->assigned_user = "<i class='text-danger'>Not Assigned</i>";
            }
            if ($ticket->department_id) {
                $ticket->department_name = Department::find($ticket->department_id)->departmentname;
            } else {
                $ticket->department_name = "<i class='text-danger'>Not Selected</i>";
            }
        }
        return view('back.pages.ticket.index', compact('tickets'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $organizations = Organization::whereStatus(1)->get();
        $users = User::all();
        $problemtypes = ProblemType::whereStatus(1)->get();
        $problemcategories = ProblemCategory::whereStatus(1)->get();
        $departments = Department::all();
        return view('back.pages.ticket.create', compact('organizations', 'departments', 'users', 'problemtypes', 'problemcategories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if ($request->assigned_to)
            $status = 1;
        else
            $status = 2;

        $ticket = new Ticket([
            'organization_id' => $request->organization_id,
            'details' => $request->details,
            'assigned_to' => $request->assigned_to,
            'problem_type_id' => $request->problem_type_id,
            'problem_category_id' => $request->problem_category_id,
            'priority' => $request->priority,
            'support_type' => $request->support_type,
            'status' => $status,
            'created_by' => Auth::user()->id
        ]);
        if ($ticket->save()) {
            $month = date('m');
            $day = date('d');
            $ticket_id = $month . $day . $ticket->id;
            $ticket->ticket_id = $ticket_id;
            if ($request->assigned_to) {
                $assignedUser = User::find($ticket->assigned_to);
                $ticket->department_id = $assignedUser->department->id;
            }
            $ticket->save();

            function sendSMS($content)
            {
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, "http://bulksms.nctbutwal.com.np/api/v3/sms?");
                curl_setopt($ch, CURLOPT_POST, 1);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $content);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                $server_output = curl_exec($ch);
                curl_close($ch);
                return $server_output;
            }
            $token = 'DlqPpgnAT5ukD1qi770o2GgWKLKKlojcDEJ';
            $to = $ticket->organization->mobilenumber;
            $sender = "NCTSUPPORT";
            $departmentName = "Support Center";
            $contactInfo = "071-537167";
            if ($ticket->department_id) {
                $departmentName = $ticket->department->name . " Department";
                $contactInfo = "071-537167 / " . $ticket->department->contact;
            }
            if (strtoupper($ticket->problemType->name) === strtoupper('Others') || strtoupper($ticket->problemType->name) === strtoupper('Other')) {
                $message = 'Dear Customer, 
        Your Ticket [ID ' . $ticket_id . '] for [' . $ticket->details .  '] is created. 
NCT Soft Pvt Ltd
' . $departmentName . '
' . $contactInfo;
            } else {
                $message = 'Dear Customer, 
        Your Ticket [ID ' . $ticket_id . '] for [' . $ticket->problemType->name .  '] is created. 
NCT Soft Pvt Ltd
' . $departmentName . '
' . $contactInfo;
            }
            $content = [
                'token' => rawurlencode($token),
                'to' => rawurlencode($to),
                'sender' => rawurlencode($sender),
                'message' => wordwrap($message),
            ];

            sendSMS($content);
            $assignedUser = User::find($ticket->assigned_to);

            function sendMessage($message)
            {
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, "http://bulksms.nctbutwal.com.np/api/v3/sms?");
                curl_setopt($ch, CURLOPT_POST, 1);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $message);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                $server_output = curl_exec($ch);
                curl_close($ch);
                return $server_output;
            }
            if ($request->assigned_to) {
                $token = 'DlqPpgnAT5ukD1qi770o2GgWKLKKlojcDEJ';
                $to =  $assignedUser->contact;
                $sender = "NCTSUPPORT";
                if (strtoupper($ticket->problemType->name) === strtoupper('Others') || strtoupper($ticket->problemType->name) === strtoupper('Other')) {
                    $message = 'Dear ' . explode(' ', $assignedUser->name)[0] . ',
        Ticket [ID ' . $ticket->ticket_id . '] of [' . $ticket->organization->organizationname . '] for [' . $ticket->details .  '] has been assigned to you.
NCT Soft Pvt Ltd
071-537167';
                } else {
                    $message = 'Dear ' . explode(' ', $assignedUser->name)[0] . ',
        Ticket [ID ' . $ticket->ticket_id . '] of [' . $ticket->organization->organizationname . '] for [' . $ticket->problemType->name .  '] has been assigned to you.
NCT Soft Pvt Ltd
071-537167';
                }
                $message = [
                    'token' => rawurlencode($token),
                    'to' => rawurlencode($to),
                    'sender' => rawurlencode($sender),
                    'message' => wordwrap($message),
                ];
                sendMessage($message);
            }
            return response([
                'success' => true,
                'data' => array(
                    'ticket_id' => $ticket->id,
                )
            ]);
        } else {
            return response(["Something went wrong"]);
        }
    }

    /**
     * Store Task Image
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function storeImage(Request $request)
    {
        if ($request->file('file')) {
            $img = $request->file('file');
            $imageNames = array();
            for ($i = 0; $i < count($img); $i++) {
                //here we are geeting ticket alogn with an image
                $imageName = time() . '-' . $img[$i]->getClientOriginalName();
                $img[$i]->move('public/images/tickets', $imageName);
                array_push($imageNames, 'images/tickets/' . $imageName);
            }
            $ticketId = $request->ticket_id;
            $ticket = Ticket::find($ticketId);
            // we are updating our image column with the help of ticket id
            $ticket->where('id', $ticketId)->update(['images' => $imageNames]);

            return response([
                'success' => true,
                'message' => "Image Uploaded Successfully"
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $ticket = Ticket::find($id);
        if ($ticket->assigned_to) {
            $ticket->assigned_to = User::find($ticket->assigned_to)->name;
            $ticket->department_name = Department::find($ticket->department_id)->departmentname;
            $ticket->department_number = Department::find($ticket->department_id)->contact;
        } else {
            $ticket->assigned_to = "<i class='text-danger'>Not Assigned</i>";
            $ticket->department_name = "-";
            $ticket->department_number = '-';
        }
        if ($ticket->remarks) {
            $ticket->remarks = $ticket->remarks;
        } else {
            $ticket->remarks = "<i>N/A</i>";
        }
        $ticket->issued_date_time = $ticket->created_at->format('jS M Y h:i:s A');
        $ticket->issued_at = $ticket->created_at->diffForHumans();
        $ticket->action_at = $ticket->updated_at->diffForHumans();
        $ticket->images = $ticket->getImage();
        $totalRemarks = Remark::whereTicketId($ticket->id)->count();
        $ticket->total_remarks = $totalRemarks > 1 ? $totalRemarks . ' Remarks' : $totalRemarks . ' Remark';

        $listTickets = Ticket::whereOrganizationId($ticket->organization_id)->where('id', '<>', $id)->orderBy('id', 'desc')->get();
        foreach ($listTickets as $key => $listTicket) {
            if ($listTicket->assigned_to) {
                $listTicket->assigned_to = User::find($listTicket->assigned_to)->name;
            } else {
                $listTicket->assigned_to = "<i class='text-danger'>Not Assigned</i>";
            }
        }
        // return $listTickets;
        $organizations = Organization::all();
        $departments = Department::all();
        $assignedUser = User::find($ticket->assigned_to);
        // return $assignedUser;
        // $users = User::all();
        $problemtypes = ProblemType::all();
        $problemcategories = ProblemCategory::all();
        // return $ticket;
        return view('back.pages.ticket.show', compact('listTickets', 'ticket', 'organizations', 'departments', 'assignedUser', 'problemtypes', 'problemcategories'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $ticket = Ticket::find($id);
        $ticket->image = $this->getImage($ticket->image);
        $organizations = Organization::all();
        $departments = Department::all();
        $users = User::all();
        $problemtypes = ProblemType::all();
        $problemcategories = ProblemCategory::all();
        return view('back.pages.ticket.edit', compact('ticket', 'organizations', 'departments', 'users', 'problemtypes', 'problemcategories'));
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
        $ticket = Ticket::find($id);
        if ($request->hasfile('image')) {
            $image = $request->file('image');
            $imageName = time() . '-' . $image->getClientOriginalName();

            $image->move('public/images/ticket', $imageName);
            $update_ticket = array(
                'organization_id' => $request->organization_id,
                'department_id' => $request->department_id,
                'assigned_to' => $request->assigned_to,
                'support_type' => $request->support_type,
                'problem_type_id' => $request->problem_type_id,
                'problem_category_id' => $request->problem_category_id,
                'details' => $request->details,
                'remarks' => $request->remarks,
                'image' => $imageName
            );
        } else {
            $update_ticket = array(
                'organization_id' => $request->organization_id,
                'department_id' => $request->department_id,
                'assigned_to' => $request->assigned_to,
                'support_type' => $request->support_type,
                'problem_type_id' => $request->problem_type_id,
                'problem_category_id' => $request->problem_category_id,
                'details' => $request->details,
                'remarks' => $request->remarks
            );
        }
        $ticket->update($update_ticket);
        Session::flash('message', 'Ticket Updated Successfully !');
        return redirect()->route('ticket.index')->with('msg', 'updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $ticket = Ticket::find($id);
        $ticket->delete();
        return redirect()->back();
    }

    public function changeStateToSolved($id)
    {
        $ticket = Ticket::find($id);
        $ticket->state = 'Solved';
        $ticket->status = 0;
        if ($ticket->save()) {
            $problemCategpryPoints = $ticket->problemCategory ? $ticket->problemCategory->points : 0;
            $assignedUser = User::find($ticket->assigned_to);
            $assignedUser->reward_points = $assignedUser->reward_points + $problemCategpryPoints;
            $assignedUser->save();

            function sendMessage($message)
            {
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, "http://bulksms.nctbutwal.com.np/api/v3/sms?");
                curl_setopt($ch, CURLOPT_POST, 1);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $message);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                $server_output = curl_exec($ch);
                curl_close($ch);
                return $server_output;
            }
            $token = 'DlqPpgnAT5ukD1qi770o2GgWKLKKlojcDEJ';
            $to = $ticket->organization->mobilenumber;
            $sender = "NCTSUPPORT";
            $departmentName = "Support Center";
            $contactInfo = "071-537167";
            if ($ticket->department_id) {
                $departmentName = $ticket->department->name . " Department";
                $contactInfo = "071-537167 / " . $ticket->department->contact;
            }
            if (strtoupper($ticket->problemType->name) === strtoupper('Others') || strtoupper($ticket->problemType->name) === strtoupper('Other')) {
                $message = 'Dear Customer,
        Ticket [ID ' . $ticket->ticket_id . '] for [' . $ticket->details .  '] has been closed.
NCT Soft Pvt Ltd
' . $departmentName . '
' . $contactInfo;
            } else {
                $message = 'Dear Customer,
        Ticket [ID ' . $ticket->ticket_id . '] for [' . $ticket->problemType->name .  '] has been closed.
NCT Soft Pvt Ltd
' . $departmentName . '
' . $contactInfo;
            }
            $message = [
                'token' => rawurlencode($token),
                'to' => rawurlencode($to),
                'sender' => rawurlencode($sender),
                'message' => wordwrap($message),
            ];
            sendMessage($message);
            return redirect()->back();
        }
    }

    public function transfer($id)
    {
        $ticket = Ticket::find($id);
        $users = User::all();
        return view('back.pages.ticket.transfer', compact('ticket', 'users'));
    }

    public function changeStateToTransfer(Request $request, $id)
    {
        $ticket = Ticket::find($id);
        $prevAssignedUser = $ticket->assigned_to;
        $currentAssignedUser = $request->assigned_to;
        if ($currentAssignedUser)
            $assignedTo = $request['assigned_to'];
        else
            $assignedTo = $prevAssignedUser;

        $ticket->assigned_to = $assignedTo;
        $ticket->status = 1;
        $assignedUser = User::find($ticket->assigned_to);
        if ($ticket->save()) {
            $this->addRemark($ticket->ticket_id, $request->remarks, $audience ?? 1);
            function sendMessage($message)
            {
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, "http://bulksms.nctbutwal.com.np/api/v3/sms?");
                curl_setopt($ch, CURLOPT_POST, 1);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $message);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                $server_output = curl_exec($ch);
                curl_close($ch);
                return $server_output;
            }
            $token = 'DlqPpgnAT5ukD1qi770o2GgWKLKKlojcDEJ';
            $to = $assignedUser->contact;
            $sender = "NCTSUPPORT";
            if (strtoupper($ticket->problemType->name) === strtoupper('Others') || strtoupper($ticket->problemType->name) === strtoupper('Other')) {
                $message = 'Dear ' . explode(' ', $assignedUser->name)[0] . ',
        Ticket [ID ' . $ticket->ticket_id . '] of [' . $ticket->organization->organizationname . '] for [' . $ticket->details .  '] has been transfered to you.
NCT Soft Pvt Ltd
071-537167';
            } else {
                $message = 'Dear ' . explode(' ', $assignedUser->name)[0] . ',
        Ticket [ID ' . $ticket->ticket_id . '] of [' . $ticket->organization->organizationname . '] for [' . $ticket->problemType->name .  '] has been transfered to you.
NCT Soft Pvt Ltd
071-537167';
            }
            $message = [
                'token' => rawurlencode($token),
                'to' => rawurlencode($to),
                'sender' => rawurlencode($sender),
                'message' => wordwrap($message),
            ];
            if ($prevAssignedUser != $request->assigned_to) {
                sendMessage($message);
                $responseMessage = 'Ticket Transfered to ' . $assignedUser->name . ' Successfully !';
            } else {
                $responseMessage = 'Ticket Transfered Successfully !';
            }
            return redirect('ticket')->with('message', $responseMessage);
        } else {
            return response(["Something went wrong"]);
        }
    }

    public function changeStateToSurvey($id)
    {
        $ticket = Ticket::find($id);
        $ticket->state = 'survey';
        $ticket->save();
        return redirect()->back();
    }

    public function updateStatus(Request $request, $id)
    {
        $ticket = Ticket::find($id);
        $ticket->status = $request->status;
        if ($ticket->update())
            return response([
                'success' => true,
                'ticketStatus' => $request->status
            ], 200);
    }

    public function addRemark($ticketId, $descriptions, $audience)
    {
        $ticketData = Ticket::whereTicketId($ticketId)->first();
        Remark::create([
            'user_id' => Auth::user()->id,
            'ticket_id' => $ticketData->id,
            'description' => $descriptions,
            'audience' => $audience,
        ]);
    }

    public function getImage($image)
    {
        if (empty($image)) {
            return asset('public/images/logo.png');
        } elseif (file_exists('public/' . $image)) {
            return asset('public/' . $image);
        } else {
            return asset('public/images/logo.png');
        }
    }
}
