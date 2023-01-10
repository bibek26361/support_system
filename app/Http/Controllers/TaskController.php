<?php

namespace App\Http\Controllers;

use App\Department;
use App\Organization;
use App\SystemLog;
use App\Task;
use App\User;
use App\UserNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $auth = Auth::user();
        if ($auth->user_type == 'Admin') {
            $tasks = Task::all()->reverse();
        } else {
            $tasks = Task::whereCreatedBy($auth->id)->orWhere('user_id', $auth->id)->get()->reverse();
        }
        foreach ($tasks as $key => $task) {
            $task->image = $this->getImage($task->image);
        }

        return view('back.pages.task.index', compact('tasks'));
    }

    public function getNewTasks()
    {
        $tasks = Task::whereStatus(3)->get()->reverse();
        foreach ($tasks as $key => $task) {
            $task->image = $this->getImage($task->image);
        }

        return view('back.pages.task.index', compact('tasks'));
    }

    public function getInProgressTasks()
    {
        $tasks = Task::whereStatus(2)->get()->reverse();
        foreach ($tasks as $key => $task) {
            $task->image = $this->getImage($task->image);
        }

        return view('back.pages.task.index', compact('tasks'));
    }

    public function getCompletedTasks()
    {
        $tasks = Task::whereStatus(0)->get()->reverse();
        foreach ($tasks as $key => $task) {
            $task->image = $this->getImage($task->image);
        }

        return view('back.pages.task.index', compact('tasks'));
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

        $departments = Department::all();
        return view('back.pages.task.create', compact('organizations', 'departments', 'users'));
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
            'user_id' => 'required',
            'priority' => 'required',
            'title' => 'required',
            'description' => 'required'
        ]);

        $task = new Task();
        $task->user_id = $request->user_id;
        $task->priority = $request->priority;
        $task->title = $request->title;
        $task->description = $request->description;
        $task->created_by = Auth::user()->id;
        $task->save();

        $createdUser = User::find($task->created_by);
        $createdUserName = explode(' ', $createdUser->name)[0];
        $assignedUser = User::find($task->user_id);
        $assignedUserName = explode(' ', $assignedUser->name)[0];
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

        SystemLog::create([
            'user_id' => $task->created_by,
            'operation' => $title,
            'description' => 'Task assigned to ' . $assignedUserName . ' for [' . $task->title . '].'
        ]);

        return response([
            'success' => true,
            'data' => array(
                'task_id' => $task->id,
            )
        ]);
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
                //here we are geeting task alogn with an image
                $imageName = time() . '-' . $img[$i]->getClientOriginalName();
                $img[$i]->move('public/images/tasks', $imageName);
                array_push($imageNames, 'images/tasks/' . $imageName);
            }
            $taskId = $request->task_id;
            $task = Task::find($taskId);
            // we are updating our image column with the help of task id
            $task->where('id', $taskId)->update(['images' => $imageNames]);

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

        $task = Task::find($id);
        $task->created_by = User::find($task->created_by)->name;
        $task->images = $task->getImage();
        $task->assigned_at = $task->created_at->diffForHumans();
        $task->action_at = $task->updated_at->diffForHumans();

        return view('back.pages.task.show', compact('task'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $task = Task::find($id);
        $users = User::all();

        return view('back.pages.task.edit', compact('task', 'users'));
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
        $task = Task::find($id);
        if ($request->hasfile('image')) {
            $image = $request->file('image');
            $imageName = time() . '-' . $image->getClientOriginalName();
            $image->move('public/images/tasks', $imageName);
            $update_task = array(
                'user_id' => $request->user_id,
                'title' => $request->title,
                'priority' => $request->priority,
                'status' => $request->status,
                'description' => $request->description,
                'image' => $imageName
            );
        } else {
            $update_task = array(
                'user_id' => $request->user_id,
                'title' => $request->title,
                'priority' => $request->priority,
                'status' => $request->status,
                'description' => $request->description,
            );
        }
        $task->update($update_task);
        Session::flash('message', 'Task Updated Successfully !');
        return redirect()->route('task.index')->with('msg', 'updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $task = Task::find($id);
        $task->delete();
        return redirect()->back();
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
