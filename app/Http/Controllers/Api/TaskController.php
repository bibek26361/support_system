<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\SystemLog;
use App\Task;
use App\TaskRemark;
use App\User;
use App\UserNotification;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    public function getAllTasks()
    {
        $auth = Auth::user();
        if ($auth->user_type == 'Admin') {
            $tasks = Task::all()->reverse();
        } else {
            $tasks = Task::whereCreatedBy($auth->id)->orWhere('user_id', $auth->id)->get()->reverse();
        }
        foreach ($tasks as $key => $task) {
            $tasks[$key] = $task->filterDataApi();
        }
        $tasks = array_values($tasks->toArray());
        return response([
            'success' => true,
            'data' => $tasks
        ]);
    }

    public function createTask(Request $request)
    {
        if (empty($request->user_id) || empty($request->title) || empty($request->description) || empty($request->priority)) {
            return response([
                'success' => false,
                'message' => 'Please fill all fields'
            ], 422);
        }
        $task = new Task();
        $task->user_id = $request->user_id;
        $task->title = $request->title;
        $task->description = $request->description;
        $task->priority = $request->priority;
        $task->created_by = Auth::id();

        $base64EncodedImages = $request->images;
        if ($base64EncodedImages) {
            $imageNames = array();
            foreach ($base64EncodedImages as $key => $image) {
                $base64DecodedImage = base64_decode($image);
                $imageName = time() . $key . '.jpg';
                $directory = 'public/images/tasks/' . $imageName;
                file_put_contents($directory, $base64DecodedImage);
                array_push($imageNames, 'images/tasks/' . $imageName);
            }
            $task->images = json_encode($imageNames);
        }
        $task->save();

        $createdUser = User::find($task->created_by);
        $createdUserName = explode(' ', $createdUser->name)[0];
        $assignedUser = User::find($task->user_id);
        $assignedUserName = explode(' ', $assignedUser->name)[0];
        if ($task->created_by !== $task->user_id) {
            $title = "Task Assigned";
            $message = 'Dear ' . $assignedUserName . ',
        ' . $createdUserName . ' has assigned you a Task for [' . $task->title . '].';

            $userId = $assignedUser->id;
            $createNotification = UserNotification::create([
                'user_id' => $userId,
                'title' => $title,
                'message' => $message,
                'model_name' => 'Task',
                'model_id' => $task->id
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

        SystemLog::create([
            'user_id' => $task->created_by,
            'operation' => $title,
            'description' => 'Task assigned to ' . $assignedUserName . ' for [' . $task->title . '].'
        ]);

        return response([
            'success' => true,
            'data' => $task->filterDataApi()
        ], 200);
    }

    public function inProgressTask(Request $request)
    {
        if (empty($request->id) || empty($request->remarks)) {
            return response([
                'success' => false,
                'message' => 'Please fill all fields'
            ], 422);
        }
        $task = Task::find($request->id);
        $task->status = 2;
        $task->save();
        $this->addRemark($task->id, $request->remarks);

        $createdUser = User::find($task->created_by);
        $createdUserName = explode(' ', $createdUser->name)[0];
        $assignedUser = User::find($task->user_id);
        $assignedUserName = explode(' ', $assignedUser->name)[0];
        $title = "Task In-Progress";
        $message = 'Dear ' . $createdUserName . ',
        ' . $assignedUserName . ' has started you assigned Task for [' . $task->title . '].';

        $userId = $assignedUser->id;
        $createNotification = UserNotification::create([
            'user_id' => $userId,
            'title' => $title,
            'message' => $message,
            'model_name' => 'Task',
            'model_id' => $task->id
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
            'message' => "Task in Progress",
        ], 200);
    }

    public function completeTask(Request $request)
    {
        if (empty($request->id) || empty($request->remarks)) {
            return response([
                'success' => false,
                'message' => 'Please fill all fields'
            ], 422);
        }

        $task = Task::find($request->id);
        $task->status = 3;
        $task->save();
        $this->addRemark($task->id, $request->remarks);

        $createdUser = User::find($task->created_by);
        $createdUserName = explode(' ', $createdUser->name)[0];
        $assignedUser = User::find($task->user_id);
        $assignedUserName = explode(' ', $assignedUser->name)[0];
        $title = "Task In-Progress";
        $message = 'Dear ' . $createdUserName . ',
        ' . $assignedUserName . ' has completed you assigned Task for [' . $task->title . '].';

        $userId = $assignedUser->id;
        $createNotification = UserNotification::create([
            'user_id' => $userId,
            'title' => $title,
            'message' => $message,
            'model_name' => 'Task',
            'model_id' => $task->id
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
            'message' => "Task Completed",
        ], 200);
    }

    public function filterAllTasks(Request $request)
    {
        $auth = Auth::user();
        $currentUserId = Auth::id();
        if ($request->start_date && $request->end_date) {
            if ($auth->user_type == 'Admin') {
                $tasks = Task::whereBetween('created_at', [$request->start_date, Carbon::parse($request->end_date)->addDay()])->get()->reverse();
            } else {
                $tasks = Task::whereBetween('created_at', [$request->start_date, Carbon::parse($request->end_date)->addDay()])->where(function ($query) use ($currentUserId) {
                    $query->whereUserId($currentUserId)->orWhere('created_by', $currentUserId);
                })->get()->reverse();
            }
        } else {
            if ($auth->user_type == 'Admin') {
                $tasks = Task::all()->reverse();
            } else {
                $tasks = Task::whereUserId($currentUserId)->orWhere('created_by', $currentUserId)->get()->reverse();
            }
        }
        foreach ($tasks as $key => $task) {
            $tasks[$key] = $task->filterDataApi();
        }
        $tasks = array_values($tasks->toArray());
        return response([
            'success' => true,
            'data' => $tasks
        ]);
    }

    public function filterInProgressTasks(Request $request)
    {
        $auth = Auth::user();
        $currentUserId = Auth::id();
        if ($request->start_date && $request->end_date) {
            if ($auth->user_type == 'Admin') {
                $tasks = Task::whereStatus(2)->whereBetween('created_at', [$request->start_date, Carbon::parse($request->end_date)->addDay()])->get()->reverse();
            } else {
                $tasks = Task::whereStatus(2)->whereBetween('created_at', [$request->start_date, Carbon::parse($request->end_date)->addDay()])->where(function ($query) use ($currentUserId) {
                    $query->whereUserId($currentUserId)->orWhere('created_by', $currentUserId);
                })->get()->reverse();
            }
        } else {
            if ($auth->user_type == 'Admin') {
                $tasks = Task::whereStatus(2)->get()->reverse();
            } else {
                $tasks = Task::whereStatus(2)->where(function ($query) use ($currentUserId) {
                    $query->whereUserId($currentUserId)->orWhere('created_by', $currentUserId);
                })->get()->reverse();
            }
        }
        foreach ($tasks as $key => $task) {
            $tasks[$key] = $task->filterDataApi();
        }
        $tasks = array_values($tasks->toArray());
        return response([
            'success' => true,
            'data' => $tasks
        ]);
    }

    public function filterNewTasks(Request $request)
    {
        $auth = Auth::user();
        $currentUserId = Auth::id();
        if ($request->start_date && $request->end_date) {
            if ($auth->user_type == 'Admin') {
                $tasks = Task::whereStatus(1)->whereBetween('created_at', [$request->start_date, Carbon::parse($request->end_date)->addDay()])->get()->reverse();
            } else {
                $tasks = Task::whereStatus(1)->whereBetween('created_at', [$request->start_date, Carbon::parse($request->end_date)->addDay()])->where(function ($query) use ($currentUserId) {
                    $query->whereUserId($currentUserId)->orWhere('created_by', $currentUserId);
                })->get()->reverse();
            }
        } else {
            if ($auth->user_type == 'Admin') {
                $tasks = Task::whereStatus(1)->get()->reverse();
            } else {
                $tasks = Task::whereStatus(1)->where(function ($query) use ($currentUserId) {
                    $query->whereUserId($currentUserId)->orWhere('created_by', $currentUserId);
                })->get()->reverse();
            }
        }
        foreach ($tasks as $key => $task) {
            $tasks[$key] = $task->filterDataApi();
        }
        $tasks = array_values($tasks->toArray());
        return response([
            'success' => true,
            'data' => $tasks
        ]);
    }

    public function filterCompletedTasks(Request $request)
    {
        $auth = Auth::user();
        $currentUserId = Auth::id();
        if ($request->start_date && $request->end_date) {
            if ($auth->user_type == 'Admin') {
                $tasks = Task::whereStatus(3)->whereBetween('created_at', [$request->start_date, Carbon::parse($request->end_date)->addDay()])->get()->reverse();
            } else {
                $tasks = Task::whereStatus(3)->whereBetween('created_at', [$request->start_date, Carbon::parse($request->end_date)->addDay()])->where(function ($query) use ($currentUserId) {
                    $query->whereUserId($currentUserId)->orWhere('created_by', $currentUserId);
                })->get()->reverse();
            }
        } else {
            if ($auth->user_type == 'Admin') {
                $tasks = Task::whereStatus(3)->get()->reverse();
            } else {
                $tasks = Task::whereStatus(3)->where(function ($query) use ($currentUserId) {
                    $query->whereUserId($currentUserId)->orWhere('created_by', $currentUserId);
                })->get()->reverse();
            }
        }
        foreach ($tasks as $key => $task) {
            $tasks[$key] = $task->filterDataApi();
        }
        $tasks = array_values($tasks->toArray());
        return response([
            'success' => true,
            'data' => $tasks
        ]);
    }

    public function getTaskDetails(Request $request)
    {
        if (empty($request->task_id)) {
            return response([
                'success' => false,
                'message' => "Task Id is required",
            ], 422);
        }
        $task = Task::find($request->task_id);
        if ($task) {
            return response([
                'success' => true,
                'data' => $task->filterDataApi()
            ]);
        } else {
            return response([
                'success' => false,
                'message' => "Task not found",
            ], 404);
        }
    }

    public function addRemark($taskId, $descriptions, $audience = 1)
    {
        $remarkAddedByUserId = Auth::user()->id;
        $remarkAddedBy = Auth::user()->name;
        TaskRemark::create([
            'user_id' => $remarkAddedByUserId,
            'task_id' => $taskId,
            'description' => $descriptions,
            'audience' => $audience,
        ]);

        $taskData = Task::find($taskId);
        if ($remarkAddedByUserId === $taskData->user_id) {
            $userId = $taskData->created_by;
        } else {
            $userId = $taskData->user_id;
        }
        $title = "Task Remarked [" . $taskData->title . "]";
        $message = $remarkAddedBy . ": " . $descriptions;

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
    }
}
