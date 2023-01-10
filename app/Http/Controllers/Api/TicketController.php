<?php

namespace App\Http\Controllers\Api;

use App\Ticket;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\TicketCreateRequest;
use App\Remark;
use App\User;
use App\UserNotification;
use Illuminate\Support\Facades\Auth;

class TicketController extends Controller
{
    public function create(TicketCreateRequest $request)
    {
        if ($request->assigned_to)
            $status = 1;
        else
            $status = 2;

        $notifyCustomer = true;
        if ($request->notify_customer == false)
            $notifyCustomer = false;

        $ticket = new Ticket();
        $ticket->organization_id = $request->organization_id;
        $ticket->product_id = $request->product_id;
        $ticket->problem_type_id = $request->problem_type_id;
        $ticket->problem_category_id = $request->problem_category_id;
        $ticket->assigned_to = $request->assigned_to;
        $ticket->priority = $request->priority;
        $ticket->support_type = $request->support_type;
        $ticket->details = $request->details;
        $ticket->status = $status;

        $base64EncodedImages = $request->images;
        if ($base64EncodedImages) {
            $imageNames = array();
            foreach ($base64EncodedImages as $key => $image) {
                $base64DecodedImage = base64_decode($image);
                $imageName = time() . $key . '.jpg';
                $directory = 'public/images/tickets/' . $imageName;
                file_put_contents($directory, $base64DecodedImage);
                array_push($imageNames, 'images/tickets/' . $imageName);
            }
            $ticket->images = json_encode($imageNames);
        }

        $ticket->created_by = Auth::user()->id;
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
            $productName = "-";
            if ($ticket->product) {
                $productName = $ticket->product->name;
            }
            if ($notifyCustomer) {
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
        Your Ticket [ID ' . $ticket_id . '] of ' . $productName . ' for [' . $ticket->details .  '] is created.
NCT Soft Pvt Ltd
' . $departmentName . '
' . $contactInfo;
                } else {
                    $message = 'Dear Customer, 
        Your Ticket [ID ' . $ticket_id . '] of ' . $productName . ' for [' . $ticket->problemType->name . '] is created.
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
            }
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
                $userName = explode(' ', $assignedUser->name)[0];

                $token = 'DlqPpgnAT5ukD1qi770o2GgWKLKKlojcDEJ';
                $to =  $assignedUser->contact;
                $sender = "NCTSUPPORT";
                if (strtoupper($ticket->problemType->name) === strtoupper('Others') || strtoupper($ticket->problemType->name) === strtoupper('Other')) {
                    $message = 'Dear ' . $userName . ',
        Ticket [ID ' . $ticket->ticket_id . '] of [' . $ticket->organization->organizationname . '] in ' . $productName . ' for [' . $ticket->details . '] has been assigned to you.
NCT Soft Pvt Ltd
071-537167';
                } else {
                    $message = 'Dear ' . $userName . ',
        Ticket [ID ' . $ticket->ticket_id . '] of [' . $ticket->organization->organizationname . '] in ' . $productName . ' for [' . $ticket->problemType->name . '] has been assigned to you.
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

                $title = "Ticket Assigned";
                if (strtoupper($ticket->problemType->name) === strtoupper('Others') || strtoupper($ticket->problemType->name) === strtoupper('Other')) {
                    $message = 'Dear ' . $userName . ',
Ticket [ID ' . $ticket->ticket_id . '] of [' . $ticket->organization->organizationname . '] in ' . $productName . ' for [' . $ticket->details . '] has been assigned to you.';
                } else {
                    $message = 'Dear ' . $userName . ',
Ticket [ID ' . $ticket->ticket_id . '] of [' . $ticket->organization->organizationname . '] in ' . $productName . ' for [' . $ticket->problemType->name . '] has been assigned to you.';
                }

                $userId = $assignedUser->id;
                $createNotification = UserNotification::create([
                    'user_id' => $userId,
                    'title' => $title,
                    'message' => $message,
                    'model_name' => 'Ticket',
                    'model_id' => $ticket->id
                ]);
                $tokens = activeUserDeviceTokens($userId);
                $sendNotification = array(
                    'title' => $createNotification->title,
                    'body' => $createNotification->message,
                    'type' => $createNotification->model_name,
                    'icon' => url('public/images/logo.png'),
                );
                sendFCMNotification($sendNotification, $tokens);
            }
        }

        return response([
            'success' => true,
            'message' => 'Ticket created successfully',
            'data' => $ticket->filterDataApi()
        ], 200);
    }

    public function all(Request $request)
    {
        $auth_user_type = Auth::user()->user_type;
        $filterDate = $request->date;
        $currentUserId = Auth::user()->id;
        if ($filterDate) {
            if ($auth_user_type === 'Admin') {
                $tickets = Ticket::whereDate('created_at', $filterDate)->orderBy('id', 'desc')->get();
            } else {
                $tickets = Ticket::whereDate('created_at', $filterDate)->where(function ($query) use ($currentUserId) {
                    $query->whereAssignedTo($currentUserId)->orWhere('created_by', $currentUserId);
                })->orderBy('id', 'desc')->get();
            }
        } else {
            if ($auth_user_type === 'Admin') {
                $tickets = Ticket::orderBy('id', 'desc')->get();
            } else {
                $tickets = Ticket::whereAssignedTo($currentUserId)->orWhere('created_by', $currentUserId)->orderBy('id', 'desc')->get();
            }
        }
        foreach ($tickets as $key => $ticket) {
            $tickets[$key] = $ticket->filterDataApi();
        }
        return response([
            'success' => true,
            'data' => $tickets
        ]);
    }

    public function created(Request $request)
    {
        $filterDate = $request->date;
        $currentUserId = Auth::user()->id;
        if ($filterDate)
            $tickets = Ticket::whereDate('created_at', $filterDate)->where(function ($query) use ($currentUserId) {
                $query->whereAssignedTo($currentUserId)->orWhere('created_by', $currentUserId);
            })->orderBy('id', 'desc')->get()->reverse();
        else
            $tickets = Ticket::whereAssignedTo($currentUserId)->orWhere('created_by', $currentUserId)->get()->reverse();
        foreach ($tickets as $key => $ticket) {
            $tickets[$key] = $ticket->filterDataApi();
        }
        $tickets = array_values($tickets->toArray());
        return response([
            'success' => true,
            'data' => $tickets
        ]);
    }

    public function opened(Request $request)
    {
        $auth_user_type = Auth::user()->user_type;
        $filterDate = $request->date;
        $currentUserId = Auth::user()->id;
        if ($filterDate) {
            if ($auth_user_type === 'Admin')
                $tickets = Ticket::whereDate('created_at', $filterDate)->whereStatus(2)->get()->reverse();
            else
                $tickets = Ticket::whereDate('created_at', $filterDate)->whereCreatedBy($currentUserId)->whereStatus(2)->get()->reverse();
        } else {
            if ($auth_user_type === 'Admin')
                $tickets = Ticket::whereStatus(2)->get()->reverse();
            else
                $tickets = Ticket::whereCreatedBy($currentUserId)->whereStatus(2)->get()->reverse();
        }
        foreach ($tickets as $key => $ticket) {
            $tickets[$key] = $ticket->filterDataApi();
        }
        $tickets = array_values($tickets->toArray());
        return response([
            'success' => true,
            'data' => $tickets
        ]);
    }

    public function assigned(Request $request)
    {
        $filterDate = $request->date;
        $currentUserId = Auth::user()->id;
        if ($filterDate)
            $tickets = Ticket::whereDate('created_at', $filterDate)->whereAssignedTo($currentUserId)->whereStatus(1)->get()->reverse();
        else
            $tickets = Ticket::whereAssignedTo($currentUserId)->whereStatus(1)->get()->reverse();
        foreach ($tickets as $key => $ticket) {
            $tickets[$key] = $ticket->filterDataApi();
        }
        $tickets = array_values($tickets->toArray());
        return response([
            'success' => true,
            'data' => $tickets
        ]);
    }

    public function transfered(Request $request)
    {
        $filterDate = $request->date;
        $currentUserId = Auth::user()->id;
        if ($filterDate)
            $tickets = Ticket::whereDate('created_at', $filterDate)->whereCreatedBy($currentUserId)->where('assigned_to', '<>', $currentUserId)->whereStatus(1)->get()->reverse();
        else
            $tickets = Ticket::whereCreatedBy($currentUserId)->where('assigned_to', '<>', $currentUserId)->whereStatus(1)->get()->reverse();
        foreach ($tickets as $key => $ticket) {
            $tickets[$key] = $ticket->filterDataApi();
        }

        return response([
            'success' => true,
            'data' => $tickets
        ]);
    }

    public function closed(Request $request)
    {
        $auth_user_type = Auth::user()->user_type;
        $filterDate = $request->date;
        $currentUserId = Auth::user()->id;
        if ($filterDate) {
            if ($auth_user_type === 'Admin')
                $tickets = Ticket::whereStatus(0)->whereDate('created_at', $filterDate)->get()->reverse();
            else
                $tickets = Ticket::whereStatus(0)->whereDate('created_at', $filterDate)->where(function ($query) use ($currentUserId) {
                    $query->whereAssignedTo($currentUserId)->orWhere('created_by', $currentUserId);
                })->get()->reverse();
        } else {
            if ($auth_user_type === 'Admin')
                $tickets = Ticket::whereStatus(0)->get()->reverse();
            else
                $tickets = Ticket::whereStatus(0)->where(function ($query) use ($currentUserId) {
                    $query->whereAssignedTo($currentUserId)->orWhere('created_by', $currentUserId);
                })->get()->reverse();
        }
        foreach ($tickets as $key => $ticket) {
            $tickets[$key] = $ticket->filterDataApi();
        }
        return response([
            'success' => true,
            'data' => $tickets
        ]);
    }

    public function search(Request $request)
    {
        $auth_user_type = Auth::user()->user_type;
        $tickedId = $request->ticket_id;
        $currentUserId = Auth::user()->id;
        if ($auth_user_type === "Admin")
            $ticket = Ticket::whereTicketId($tickedId)->first();
        else
            $ticket = Ticket::whereTicketId($tickedId)->where(function ($query) use ($currentUserId) {
                $query->whereAssignedTo($currentUserId)->orWhere('created_by', $currentUserId);
            })->first();

        if ($ticket) {
            return response([
                'success' => true,
                'data' => $ticket->filterDataApi()
            ], 200);
        } else {
            return response([
                'success' => false,
                'message' => 'Ticket not found'
            ], 404);
        }
    }

    public function filter(Request $request)
    {
        $date = $request->date;
        $currentUserId = Auth::user()->id;
        $tickets = Ticket::whereDate('created_at', $date)->where(function ($query) use ($currentUserId) {
            $query->whereAssignedTo($currentUserId)->orWhere('created_by', $currentUserId);
        })->get();
        if ($tickets->count()) {
            foreach ($tickets as $key => $ticket) {
                $tickets[$key] = $ticket->filterDataApi();
            }
            return response([
                'success' => true,
                'data' => $tickets
            ]);
        } else {
            return response([
                'success' => false,
                'message' => 'Tickets not available'
            ], 404);
        }
    }

    public function transfer(Request $request)
    {
        if (empty($request->ticket_id) || empty($request->assigned_to)) {
            return response([
                'success' => false,
                'message' => 'Ticket id or assigned user id is missing'
            ], 422);
        }

        $ticketId = $request->ticket_id;
        $ticket = Ticket::whereTicketId($ticketId)->first();
        if (!$ticket) {
            return response([
                'success' => false,
                'message' => 'Ticket not found'
            ], 404);
        }

        $prevAssignedUser = $ticket->assigned_to;
        $currentAssignedUser = $request->assigned_to;
        if ($currentAssignedUser)
            $assignedTo = $request->assigned_to;
        else
            $assignedTo = $prevAssignedUser;

        $ticket->assigned_to = $assignedTo;
        $ticket->status = 1;
        $assignedUser = User::find($ticket->assigned_to);
        if ($ticket->save()) {
            $productName = "-";
            if ($ticket->product) {
                $productName = $ticket->product->name;
            }
            $this->addRemark($ticketId, $request->remarks);
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
            $userName = explode(' ', $assignedUser->name)[0];

            $token = 'DlqPpgnAT5ukD1qi770o2GgWKLKKlojcDEJ';
            $to = $assignedUser->contact;
            $sender = "NCTSUPPORT";
            if (strtoupper($ticket->problemType->name) === strtoupper('Others') || strtoupper($ticket->problemType->name) === strtoupper('Other')) {
                $message = 'Dear ' . $userName . ',
        Ticket [ID ' . $ticket->ticket_id . '] of [' . $ticket->organization->organizationname . '] in ' . $productName . ' for [' . $ticket->details . '] has been transfered to you.
NCT Soft Pvt Ltd
071-537167';
            } else {
                $message = 'Dear ' . $userName . ',
        Ticket [ID ' . $ticket->ticket_id . '] of [' . $ticket->organization->organizationname . '] in ' . $productName . ' for [' . $ticket->problemType->name . '] has been transfered to you.
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
                $title = "Ticket Transfered";
                if (strtoupper($ticket->problemType->name) === strtoupper('Others') || strtoupper($ticket->problemType->name) === strtoupper('Other')) {
                    $message = 'Dear ' . $userName . ',
Ticket [ID ' . $ticket->ticket_id . '] of [' . $ticket->organization->organizationname . '] in ' . $productName . ' for [' . $ticket->details . '] has been transfered to you.';
                } else {
                    $message = 'Dear ' . $userName . ',
Ticket [ID ' . $ticket->ticket_id . '] of [' . $ticket->organization->organizationname . '] in ' . $productName . ' for [' . $ticket->problemType->name . '] has been transfered to you.';
                }

                $userId = $assignedUser->id;
                $createNotification = UserNotification::create([
                    'user_id' => $userId,
                    'title' => $title,
                    'message' => $message,
                    'model_name' => 'Ticket',
                    'model_id' => $ticket->id
                ]);
                $tokens = activeUserDeviceTokens($userId);
                $sendNotification = array(
                    'title' => $createNotification->title,
                    'body' => $createNotification->message,
                    'type' => $createNotification->model_name,
                    'icon' => url('public/images/logo.png'),
                );
                sendFCMNotification($sendNotification, $tokens);
                $responseMessage = 'Ticket Transfered to ' . $assignedUser->name . ' Successfully !';
            } else {
                $responseMessage = 'Ticket Transfered Successfully !';
            }

            return response([
                'success' => true,
                'message' => $responseMessage
            ], 200);
        }
    }

    public function solve(Request $request)
    {
        if (empty($request->ticket_id) || empty($request->remarks)) {
            return response([
                'success' => false,
                'message' => 'Ticket id ore remark is missing'
            ], 422);
        }

        $ticketId = $request->ticket_id;
        $ticket = Ticket::whereTicketId($ticketId)->first();
        if (!$ticket) {
            return response([
                'success' => false,
                'message' => 'Ticket not found'
            ], 404);
        }

        if ($ticket->status == 0 || $ticket->status == 2) {
            return response([
                'success' => false,
                'message' => 'Ticket is not assigned or already solved!'
            ], 422);
        }

        $ticket->state = 'Solved';
        $ticket->status = 0;
        if ($ticket->save()) {
            $productName = "-";
            if ($ticket->product) {
                $productName = $ticket->product->name;
            }
            $this->addRemark($ticketId, $request->remarks);
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
Ticket [ID ' . $ticket->ticket_id . '] of ' . $productName . ' for [' . $ticket->details .  '] has been closed.
NCT Soft Pvt Ltd
' . $departmentName . '
' . $contactInfo;
            } else {
                $message = 'Dear Customer,
Ticket [ID ' . $ticket->ticket_id . '] of ' . $productName . ' for [' . $ticket->problemType->name .  '] has been closed.
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

            $createdUser = User::find($ticket->created_by);
            $createdUserName = explode(' ', $createdUser->name)[0];
            $title = "Ticket Closed";
            if (strtoupper($ticket->problemType->name) === strtoupper('Others') || strtoupper($ticket->problemType->name) === strtoupper('Other')) {
                $message = 'Dear ' . $createdUserName . ',
Ticket [ID ' . $ticket->ticket_id . '] of ' . $productName . ' for [' . $ticket->details .  '] has been closed.';
            } else {
                $message = 'Dear ' . $createdUserName . ',
Ticket [ID ' . $ticket->ticket_id . '] of ' . $productName . ' for [' . $ticket->problemType->name .  '] has been closed.';
            }

            $userId = $createdUser->id;
            $createNotification = UserNotification::create([
                'user_id' => $userId,
                'title' => $title,
                'message' => $message,
                'model_name' => 'Ticket',
                'model_id' => $ticket->id
            ]);
            $tokens = activeUserDeviceTokens($userId);
            $sendNotification = array(
                'title' => $createNotification->title,
                'body' => $createNotification->message,
                'type' => $createNotification->model_name,
                'icon' => url('public/images/logo.png'),
            );
            sendFCMNotification($sendNotification, $tokens);

            return response([
                'success' => true,
                'message' => 'Ticket Solved Successfully'
            ], 200);
        }
    }

    public function addRemark($ticketId, $descriptions, $audience = 1)
    {
        $ticketData = Ticket::whereTicketId($ticketId)->first();
        Remark::create([
            'user_id' => Auth::user()->id,
            'ticket_id' => $ticketData->id,
            'description' => $descriptions,
            'audience' => $audience,
        ]);
    }
}
