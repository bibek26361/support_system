<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Remark;
use App\Task;
use App\TaskRemark;
use App\Ticket;
use App\UserNotification;
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

        return response([
            'success' => true,
            'data' => $task->filterDataApi()
        ], 200);
    }

    // Remarks For Task
    public function getTaskWiseRemarks(Request $request)
    {
        if (empty($request->task_id)) {
            return response([
                'success' => false,
                'message' => 'Please fill all fields'
            ], 422);
        }

        $taskData = Task::find($request->task_id);
        if (empty($taskData)) {
            return response([
                'success' => false,
                'message' => 'Task not found'
            ], 404);
        }

        $taskId = $taskData->id;
        $remarks = TaskRemark::whereTaskId($taskId)->get()->reverse();
        foreach ($remarks as $key => $remark) {
            $remarks[$key] = $remark->filterDataApi();
        }
        $remarks = array_values($remarks->toArray());
        return response([
            'success' => true,
            'data' => $remarks
        ]);
    }

    public function addTaskRemark(Request $request)
    {
        if (empty($request->task_id) || empty($request->description)) {
            return response([
                'success' => false,
                'message' => 'Please fill all fields'
            ], 422);
        }

        $taskData = Task::find($request->task_id);
        if (empty($taskData)) {
            return response([
                'success' => false,
                'message' => 'Task not found'
            ], 404);
        }

        $taskId = $taskData->id;
        $remarkAddedByUserId = Auth::user()->id;
        $remarkAddedBy = Auth::user()->name;
        $task = TaskRemark::create([
            'user_id' => $remarkAddedByUserId,
            'task_id' => $taskId,
            'description' => $request->description,
            'audience' => $request->audience ?? 1,
        ]);

        if ($remarkAddedByUserId === $taskData->user_id) {
            $userId = $taskData->created_by;
        } else {
            $userId = $taskData->user_id;
        }
        $title = "Task Remarked [" . $taskData->title . "]";
        $message = $remarkAddedBy . ": " . $request->description;

        $createNotification = UserNotification::create([
            'user_id' => $userId,
            'title' => $title,
            'message' => $message,
            'model_name' => 'Task',
            'model_id' => $taskId
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
            'data' => $task->filterDataApi()
        ], 200);
    }
}
