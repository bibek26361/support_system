<?php

namespace App\Http\Controllers\Api;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\UserCreateRequest;
use App\Task;
use App\Ticket;
use App\UserPassword;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function create(UserCreateRequest $request)
    {
        try {
            $user = new User();
            $user->department_id = $request->department_id;
            $user->name = $request->name;
            $user->email = $request->email;
            $user->contact = $request->mobile_no;
            $user->address = $request->address;
            $user->password = Hash::make($request->password);
            $user->user_type = "Staff";
            $user->status = 1;
            $user->reward_points = 0;
            $user->save();
            return response([
                'success' => true,
                'message' => 'User created successfully',
                'data' => $user->filterDataApi()
            ], 200);
        } catch (\Exception $e) {
            return response([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function getAllUserData()
    {
        $users = User::whereStatus(1)->get();
        foreach ($users as $key => $user) {
            $users[$key] = $user->filterDataApi();
        }
        return response([
            'success' => true,
            'data' => $users
        ]);
    }

    public function getTicketData(Request $request)
    {
        if (empty($request->user_id)) {
            return response([
                'success' => false,
                'message' => 'User id is missing'
            ], 422);
        }

        $userId = $request->user_id;
        $user = User::find($userId);
        if (!$user) {
            return response([
                'success' => false,
                'message' => 'User not found'
            ], 404);
        }

        $tickets = Ticket::where('status', '<>', 0)->where(function ($query) use ($userId) {
            $query->whereAssignedTo($userId)->orWhere('created_by', $userId);
        })->orderBy('id', 'desc')->get();
        foreach ($tickets as $key => $ticket) {
            $tickets[$key] = $ticket->filterDataApi($userId);
        }
        return response([
            'success' => true,
            'data' => $tickets
        ], 200);
    }

    public function getTaskData(Request $request)
    {
        if (empty($request->user_id)) {
            return response([
                'success' => false,
                'message' => 'User id is missing'
            ], 422);
        }

        $userId = $request->user_id;
        $user = User::find($userId);
        if (!$user) {
            return response([
                'success' => false,
                'message' => 'User not found'
            ], 404);
        }

        $tasks = Task::where('status', '<>', 0)->where(function ($query) use ($userId) {
            $query->whereUserId($userId)->orWhere('created_by', $userId);
        })->orderBy('id', 'desc')->get();
        foreach ($tasks as $key => $task) {
            $tasks[$key] = $task->filterDataApi();
        }
        return response([
            'success' => true,
            'data' => $tasks
        ], 200);
    }

    public function forgotPassword(Request $request)
    {
        $mobileNo = $request->mobile_no;
        if (strlen($mobileNo) != 10) {
            return response([
                'success' => false,
                'message' => 'Mobile number is not valid'
            ], 422);
        }

        $user = User::whereContact($mobileNo);
        if ($user->count()) {
            $otp = rand(100000, 999999);
            if ($user->update(['otp' => $otp])) {
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
                $to = $mobileNo;
                $sender = "NCTSUPPORT";
                $message = "<#> NCTSupport: Your verification code is " . $otp . "
zLfKAPboK3l";
                $content = [
                    'token' => rawurlencode($token),
                    'to' => rawurlencode($to),
                    'sender' => rawurlencode($sender),
                    'message' => wordwrap($message),
                ];

                sendSMS($content);
                return response([
                    'success' => true,
                    'message' => "Verification Code Sent Successfully."
                ], 200);
            }
        } else
            return response([
                'success' => false,
                'message' => "Mobile No. doesn't exists"
            ], 400);
    }

    public function verifyOtp(Request $request)
    {
        if (empty($request->otp) || strlen($request->otp) != 6) {
            return response([
                'success' => false,
                'message' => 'OTP must be 6 digits'
            ], 422);
        }

        $selectedUser = User::whereOtp($request->otp);
        if ($selectedUser->exists()) {
            $user = $selectedUser->first();
            if ($user->update()) {
                $api_token = $user->createToken($user->display_name)->accessToken;
                $user = $this->getActiveUserAttributes($user);
                return response([
                    'success' => true,
                    'api_token' => $api_token,
                    'data' => $user
                ], 200);
            }
        } else {
            return response([
                'success' => false,
                'message' => 'OTP is not valid'
            ], 400);
        }
    }

    public function resetPassword(Request $request)
    {
        $password = $request->password;
        if (strlen($password) < 8)
            return response([
                'success' => false,
                'message' => 'Password must be at least 8 characters'
            ], 422);

        $currentUserId = Auth::id();
        $user = User::find($currentUserId);
        $user->password = bcrypt($password);
        if ($user->update()) {
            $userPassword = UserPassword::whereUserId($user->id)->first();
            if ($userPassword) {
                $userPassword->password = $password;
                $userPassword->save();
            } else {
                UserPassword::create([
                    'user_id' => $user->id,
                    'password' => $password
                ]);
            }
            $user->revokeTokens();
            return response([
                'success' => true,
                'message' => "Password Reset Successfully !"
            ], 200);
        }
    }

    public function changePassword(Request $request)
    {
        $newPassword = $request->new_password;
        if (empty($request->old_password) || strlen($newPassword) < 8)
            return response([
                'success' => false,
                'message' => "The given data was invalid"
            ], 422);

        if ($request->old_password === $newPassword) {
            return response([
                'success' => false,
                'message' => "Old Password and New Password cannot be same"
            ], 409);
        }

        $currentUserId = Auth::user()->id;
        $user = User::find($currentUserId);
        if (Hash::check($request->old_password, $user->password)) {
            $user->password = bcrypt($newPassword);
            if ($user->update()) {
                $userPassword = UserPassword::whereUserId($user->id)->first();
                if ($userPassword) {
                    $userPassword->password = $newPassword;
                    $userPassword->save();
                } else {
                    UserPassword::create([
                        'user_id' => $user->id,
                        'password' => $newPassword
                    ]);
                }
                $user->revokeTokens();
                return response([
                    'success' => true,
                    'message' => "Password Changed Successfully !"
                ], 200);
            }
        } else {
            return response([
                'success' => false,
                'message' => "Old Password does not match."
            ], 404);
        }
    }

    private function getActiveUserAttributes($user)
    {
        if ($user->department) {
            $department = $user->department->departmentname;
        } else {
            $department = '-';
        }
        return array(
            'id' => $user->id,
            'department' => $department,
            'contact' => $user->contact != null ? $user->contact : '',
            'email' => $user->email != null ? $user->email : '',
            'name' => $user->name,
            'address' => $user->address ?? $user->address,
            'profile_image' => $this->getProfileImage($user->profile_image),
            'reward_points' => $user->reward_points,
            'user_type' => $user->user_type,
            'is_active' => $user->status,
        );
    }

    public function getProfileImage($image)
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
