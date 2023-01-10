<?php

namespace App\Http\Controllers;

use App\User;
use App\UserDeviceToken;
use App\UserNotification;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $notifications = UserNotification::all()->reverse();
        foreach ($notifications as $key => $notification) {
            if ($notification->user_id === 0)
                $notification->user_name = "<i class='text-success'>All Users</i>";
            else {
                $userData = User::find($notification->user_id);
                $notification->user_name = $userData->name . ' - ' . $userData->contact;
            }
        }
        $userDevices = activeUserDevices();
        return view('back.pages.notifications.index', compact('notifications', 'userDevices'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        dd('Create');
    }

    public function getDeviceTokens()
    {
        $deviceTokens = UserDeviceToken::all()->reverse();
        foreach ($deviceTokens as $key => $deviceToken) {
            $deviceToken->device_token = explode('-', $deviceToken->device_token)[0];
            if ($deviceToken->user_id === 0)
                $deviceToken->user_name = "<i class='text-success'>All Users</i>";
            else {
                $userData = User::find($deviceToken->user_id);
                $deviceToken->user_name = $userData->name . ' - ' . $userData->contact;
            }
        }
        return view('back.pages.notifications.device-tokens', compact('deviceTokens'));
    }

    public function createNotification(Request $request)
    {
        $sendNotification = array();
        $title = $request->title;
        $message = $request->message;
        $userId = $request->user_id;
        $saveAndSend = $request->save_and_send;

        $createNotification = UserNotification::create([
            'user_id' => $userId,
            'title' => $title,
            'message' => $message
        ]);
        if ($createNotification && $saveAndSend) {
            if ($userId == 0) {
                $tokens = activeUserDeviceTokens();
            } else {
                $userName = explode(' ', User::whereId($userId)->first()->name)[0];
                $createNotification->message = 'Dear ' . $userName . ',
        ' . $message;
                $tokens = activeUserDeviceTokens($userId);
            }
            $sendNotification = array(
                'title' => $createNotification->title,
                'body' => $createNotification->message,
                'type' => $createNotification->model_id ? $createNotification->model_type : 'Notification',
                'icon' => url('public/images/logo/logo.png'),
            );
            sendFCMNotification($sendNotification, $tokens);
            return redirect()->back()->with('response', [
                'status' => 'success',
                'title' => 'Saved & Sent',
                'message' => 'Notification Saved & Sent Successfully!'
            ]);
        }
        return redirect()->back()->with('response', [
            'status' => 'success',
            'title' => 'Saved',
            'message' => 'Notification Saved Successfully!'
        ]);
    }

    public function resendNotification($id)
    {
        $notification = UserNotification::find($id);
        if ($notification) {
            if ($notification->user_id == 0) {
                $tokens = activeUserDeviceTokens();
            } else
                $tokens = activeUserDeviceTokens($notification->user_id);

            $sendNotification = array(
                'title' => $notification->title,
                'body' => $notification->message,
                'type' => $notification->model_id ? $notification->model_type : 'Notification',
                'icon' => url('public/images/logo/logo.png'),
            );
            sendFCMNotification($sendNotification, $tokens);
            return redirect()->back()->with('response', [
                'status' => 'success',
                'title' => 'Resent',
                'message' => 'Notification Resent Successfully!'
            ]);
        }
    }

    public function sendNotificationToAll($id)
    {
        $notification = UserNotification::find($id);
        if ($notification) {
            $tokens = activeUserDeviceTokens();
            $sendNotification = array(
                'title' => $notification->title,
                'body' => $notification->message,
                'type' => $notification->model_id ? $notification->model_type : 'Notification',
                'icon' => url('public/images/logo/logo.png'),
            );
            sendFCMNotification($sendNotification, $tokens);
            return redirect()->back()->with('response', [
                'status' => 'success',
                'title' => 'Sent To All',
                'message' => 'Notification Sent To All Successfully!'
            ]);
        }
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
        dd('Show');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $notification = UserNotification::find($id);
        if ($notification->user_id === 0)
            $notification->user_name = "<i class='text-success'>All Users</i>";
        else {
            $userData = User::find($notification->user_id);
            $notification->user_name = $userData->name . ' - ' . $userData->contact;
        }
        $userDevices = activeUserDevices();
        return view('back.pages.notifications.edit', compact('notification', 'userDevices'));
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
        $updateAndSend = $request->update_and_send;
        $notification = UserNotification::find($id);
        $userId = $request->user_id;
        $message = $request->message;
        $notification->user_id = $userId;
        $notification->title = $request->title;
        $notification->message = $message;
        if ($notification->save() && $updateAndSend) {
            if ($userId == 0) {
                $tokens = activeUserDeviceTokens();
            } else {
                $userName = explode(' ', User::whereId($userId)->first()->first_name)[0];
                $notification->message = 'Dear ' . $userName . ',
        ' . $message;
                $tokens = activeUserDeviceTokens($userId);
            }
            $sendNotification = array(
                'title' => $notification->title,
                'body' => $notification->message,
                'type' => $notification->model_id ? $notification->model_type : 'Notification',
                'icon' => url('/public/images/logo/logo.png')
            );
            sendFCMNotification($sendNotification, $tokens);
            return redirect()->route('notifications.index')->with('response', [
                'status' => 'success',
                'title' => 'Updated & Sent',
                'message' => 'Notification Updated & Sent Successfully!'
            ]);
        }
        return redirect()->route('notifications.index')->with('response', [
            'status' => 'success',
            'title' => 'Updated',
            'message' => 'Notification Updated Successfully!'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $notification = UserNotification::find($id);
        if ($notification->delete()) {
            return redirect()->back()->with([
                'status' => 'success',
                'message' => 'Notification Deleted Successfully!'
            ]);
        }
    }
}
