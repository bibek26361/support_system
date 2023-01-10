<?php

namespace App\Http\Controllers\Api;

use App\CustomerDeviceToken;
use App\Http\Controllers\Controller;
use App\Model\Authenticator;
use App\SystemLog;
use App\UserDeviceToken;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\Request;
use Auth;

class AuthController extends Controller
{
    /**
     * @var Authenticator
     */
    private $authenticator;

    public function __construct(Authenticator $authenticator)
    {
        $this->authenticator = $authenticator;
    }

    /**
     * @param Request $request
     * @return array
     * @throws AuthenticationException
     */
    public function login(Request $request)
    {
        if (empty($request->username) || empty($request->password)) {
            return response([
                'success' => false,
                'message' => 'Username or password is required !'
            ], 422);
        } elseif (empty($request->device_token)) {
            return response([
                'success' => false,
                'message' => 'Device token is required !'
            ], 422);
        }

        $credentials = array_values($request->only('username', 'password'));

        if (!$user = $this->authenticator->attempt(...$credentials, ...['users'])) {
            throw new AuthenticationException();
        }
        $this->registerUserDeviceToken($user->id, $request->device_token);
        if ($user->status) {
            SystemLog::create([
                'user_id' => $user->id,
                'operation' => "Login To Support App"
            ]);

            $api_token = $user->createToken($user->name)->accessToken;
            $user = $this->getActiveUserAttributes($user);

            return response([
                'success' => true,
                'api_token' => $api_token,
                'data' => $user
            ], 200);
        } else {
            return response([
                'success' => true,
                'data' => $user
            ], 200);
        }
    }

    /**
     * @param Request $request
     * @return array
     * @throws AuthenticationException
     */
    public function customerLogin(Request $request)
    {
        if (empty($request->username) || empty($request->password)) {
            return response([
                'success' => false
            ], 422);
        }

        $credentials = array_values($request->only('username', 'password'));
        if (!$customer = $this->authenticator->attempt(...$credentials, ...['customers'])) {
            throw new AuthenticationException();
        }
        $this->registerDeviceToken($customer->id, $request->device_token);
        if ($customer->status) {
            $api_token = $customer->createToken($customer->display_name)->accessToken;
            $customer = $this->getActiveCustomerAttributes($customer);
            return response([
                'success' => true,
                'api_token' => $api_token,
                'data' => $customer
            ], 200);
        } else {
            $customer = $this->getInActiveCustomerAttributes($customer);
            return response([
                'success' => true,
                'data' => $customer
            ], 203);
        }
    }

    public function isCustomerAuthenticated()
    {
        return response([
            'success' => true,
            'customer_info' => Auth::user()
        ], 200);
    }

    public function logout()
    {
        $user = Auth::user();
        $user->revokeTokens();
        return response([
            'success' => true,
            'message' => 'Logged Out Successfully !'
        ], 200);
    }

    public function customerLogout()
    {
        $customer = Auth::user();
        $customer->revokeTokens();
        return response([
            'success' => true,
            'message' => 'Logged Out Successfully !'
        ], 200);
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
            'address' => $user->address ?? '',
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

    private function getInActiveUserAttributes($user)
    {
        return array(
            'id' => $user->id,
            'first_name' => $user->first_name,
            'last_name' => $user->last_name,
            'is_active' => $user->status,
        );
    }
    private function getActiveCustomerAttributes($customer)
    {
        $imageBasePath = url('public/images/customers');
        return array(
            'id' => $customer->id,
            'mobile_no' => $customer->mobile_no != null ? $customer->mobile_no : '',
            'first_name' => $customer->first_name,
            'last_name' => $customer->last_name,
            'username' => $customer->username ? $customer->username : '',
            'email' => $customer->email != null ? $customer->email : '',
            'display_name' => $customer->display_name,
            'profile_image' => file_exists('public/images/customers/' . $customer->profile_image) ? $imageBasePath . '/' . $customer->profile_image : 'https://ui-avatars.com/api/?name=' . $customer->display_name,
            'reward_point' => $customer->reward_point,
            'provider' => $customer->provider,
            'is_social_login' => $customer->is_social_login,
            'is_active' => $customer->status,
        );
    }

    private function getInActiveCustomerAttributes($customer)
    {
        return array(
            'id' => $customer->id,
            'first_name' => $customer->first_name,
            'last_name' => $customer->last_name,
            'is_active' => $customer->status,
        );
    }

    public function getRewardPoint()
    {
        $rewardPoint = Auth::user()->reward_point;
        return response([
            'success' => true,
            'data' => [
                'reward_point' => $rewardPoint
            ]
        ]);
    }

    public function registerUserDeviceToken($userId, $deviceToken)
    {
        $checkDeviceToken = UserDeviceToken::whereDeviceToken($deviceToken);
        if (!$checkDeviceToken->count()) {
            UserDeviceToken::create([
                'user_id' => $userId,
                'device_token' => $deviceToken
            ]);
        } else {
            $checkUserIdAndToken = UserDeviceToken::whereUserId($userId)->whereDeviceToken($deviceToken);
            if (!$checkUserIdAndToken->count()) {
                $checkDeviceToken->update([
                    'is_active' => 0
                ]);
                UserDeviceToken::create([
                    'user_id' => $userId,
                    'device_token' => $deviceToken
                ]);
            } else {
                $checkDeviceToken->update([
                    'is_active' => 1
                ]);
            }
        }
    }
}
