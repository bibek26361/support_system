<?php

namespace App\Http\Controllers;

use App\Remark;
use App\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RemarkController extends Controller
{
    public function getTicketWiseRemarks(Request $request)
    {
        if (empty($request->ticket_id)) {
            return response([
                'success' => false,
                'message' => 'Please fill all fields'
            ], 422);
        }

        $ticketData = Ticket::whereTicketId($request->ticket_id)->first();
        if (empty($ticketData)) {
            return response([
                'success' => false,
                'message' => 'Ticket not found'
            ], 404);
        }

        $ticketId = $ticketData->id;
        $remarks = Remark::whereTicketId($ticketId)->get()->reverse();
        foreach ($remarks as $key => $remark) {
            $remarks[$key] = $remark->filterDataApi();
        }
        $remarks = array_values($remarks->toArray());
        return response([
            'success' => true,
            'data' => $remarks
        ]);
    }

    public function addTicketRemark(Request $request)
    {
        if (empty($request->ticket_id) || empty($request->description)) {
            return response([
                'success' => false,
                'message' => 'Please fill all fields'
            ], 422);
        }

        $ticketData = Ticket::whereTicketId($request->ticket_id)->first();
        if (empty($ticketData)) {
            return response([
                'success' => false,
                'message' => 'Ticket not found'
            ], 404);
        }

        $ticketId = $ticketData->id;
        $task = Remark::create([
            'user_id' => Auth::user()->id,
            'ticket_id' => $ticketId,
            'description' => $request->description,
            'audience' => $request->audience ?? 1,
        ]);

        $remarks = Remark::whereTicketId($ticketId)->get()->reverse();
        foreach ($remarks as $key => $remark) {
            $remarks[$key] = $remark->filterDataApi();
        }
        $totalRemarks = $remarks->count();
        $remarks = array_values($remarks->toArray());
        return response([
            'success' => true,
            'total_remarks' => $totalRemarks > 1 ? $totalRemarks . ' Remarks' : $totalRemarks . ' Remark',
            'data' => $remarks
        ], 200);
    }
}
