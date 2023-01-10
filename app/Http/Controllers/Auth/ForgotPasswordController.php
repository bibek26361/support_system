<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\User;
use App\UserDeviceToken;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\ChangePasswordRequest;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\Request;

class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    use SendsPasswordResetEmails;

    public function forgotPassword()
    {
        return view('back.auth.forgetPassword');
    }

    public function forgotPasswordProcess(Request $request)
    {
        $this->validate($request, array(
            'email' => 'required|exists:users'
        ));

        $user = User::whereEmail($request->email)->first(['name','contact']);

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
            // $token = 'bDjmMpP7fyZpQNro764kwXwkQn4NgKL635R'; // SGBC
            $token = 'DlqPpgnAT5ukD1qi770o2GgWKLKKlojcDEJ';
            $to = $user->contact;
            $sender = "NctSupportSystem";
            $message = 'Dear ' . $user->name . ',
        ' . $otp . ' is your OTP for Nct Support System.';
            $content = [
                'token' => rawurlencode($token),
                'to' => rawurlencode($to),
                'sender' => rawurlencode($sender),
                'message' => wordwrap($message),
            ];

            sendSMS($content);
            return redirect('verify');


            // return response([
            //     'success' => true,
            //     'message' => "Verification Code Sent Successfully."
            // ], 200);
        }
    }

    public function verify()
    {
        return view('back.auth.verify');
    }

    public function verifyProcess(Request $request)
    {
        $selectedUser = User::whereOtp($request->otp);
        if ($selectedUser->exists()) {
            $user = $selectedUser->first();
            $user->status = 1;
            if ($user->update()) {
                return response([
                    'success' => true,
                    'message' => 'Successfully Verified.'
                ], 200);
            }
        } else {
            return response([
                'success' => false
            ], 200);
        }
    }

    public function changePasswordProcess(ChangePasswordRequest $request){
        $email = $request->email;
        $user = User::whereEmail('email')->first(['name','contact']);
        $user->password = bcrypt($request->password);
        if ($user->update()) {
            Auth::guard('user')->login($user);
            return response([
                'success' => true,
                'message' => "Password Changed Successfully !"
            ], 200);
        }
    }
}
