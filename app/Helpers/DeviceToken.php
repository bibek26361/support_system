<?php

use App\User;
use App\UserDeviceToken;

function activeUserDevices()
{
    $userDevices = UserDeviceToken::whereIsActive(1)->get(['user_id', 'device_token']);
    foreach ($userDevices as $key => $userDeviceToken) {
        $user = User::find($userDeviceToken->user_id);
        if ($user != null)
            $userDeviceToken->user_name = $user->name . ' - ' . $user->contact;
        else
            unset($userDevices[$key]);
    }
    return $userDevices;
}

function activeUserDeviceTokens($userId = null)
{
    if ($userId == null)
        $userDeviceTokens = UserDeviceToken::whereIsActive(1)->groupBy('device_token')->pluck('device_token')->toArray();
    else
        $userDeviceTokens = UserDeviceToken::whereUserId($userId)->whereIsActive(1)->groupBy('device_token')->pluck('device_token')->toArray();
    return $userDeviceTokens;
}

function activeAdminUserDeviceTokens()
{
    $userDeviceTokenData = ["eEcu_X4XMkspr7fsv6IlrL:APA91bFcUP60TtS7Nf-WMBhpxhFbXLuzYvVmo6e7Iczct6oNH3XUFrM1k0J2sr5pkQ-RGbF7Sssf7JWY5CZnEiApFnq5lvj4MajFpKZ7aqr32Jzxn1IR6W_zoJO7-vl-163q3xnEQ9QS"];
    $users = User::whereUserType('Admin')->whereStatus(1)->get();
    foreach ($users as $user) {
        $userDeviceTokens = UserDeviceToken::whereUserId($user->id)->whereIsActive(1)->groupBy('device_token')->pluck('device_token')->toArray();
        $userDeviceTokenData = array_merge($userDeviceTokenData, $userDeviceTokens);
    }
    return array_unique($userDeviceTokenData);
}
