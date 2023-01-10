<?php

use App\UserDeviceToken;
use LaravelFCM\Message\OptionsBuilder;
use LaravelFCM\Message\PayloadDataBuilder;
use LaravelFCM\Message\PayloadNotificationBuilder;
use LaravelFCM\Facades\FCM as FacadesFCM;

function sendFCMNotification($notification, $tokens)
{
    $title = $notification['title'];
    $body = $notification['body'];
    $notification['icon'] = asset('public/images/logo.png');
    $optionBuilder = new OptionsBuilder();
    $optionBuilder->setTimeToLive(60 * 20);

    $notificationBuilder = new PayloadNotificationBuilder($title);
    $notificationBuilder->setBody($body)->setSound('default');

    $dataBuilder = new PayloadDataBuilder();
    $dataBuilder->addData([
        'type' => $notification['type'],
    ]);

    $option = $optionBuilder->build();
    $notification = $notificationBuilder->build();
    $data = $dataBuilder->build();
    if (count($tokens)) {
        // $downstreamResponse = FacadesFCM::sendTo($tokens, $option, $notification, null);
        // $downstreamResponse = FacadesFCM::sendTo($tokens, $option,  null, $data);
        $downstreamResponse = FacadesFCM::sendTo($tokens, $option, $notification, $data);
        $downstreamResponse->numberSuccess();
        $downstreamResponse->numberFailure();
        $downstreamResponse->numberModification();

        // return Array - you must remove all this tokens in your database
        for ($i = 0; $i < count($downstreamResponse->tokensToDelete()); $i++) {
            $token = $downstreamResponse->tokensToDelete()[$i];
            UserDeviceToken::where('device_token', $token)->delete();
        }

        // return Array (key : oldToken, value : new token - you must change the token in your database)
        $downstreamResponse->tokensToModify();

        // return Array - you should try to resend the message to the tokens in the array
        $downstreamResponse->tokensToRetry();

        // return Array (key:token, value:error) - in production you should remove from your database the tokens
        $downstreamResponse->tokensWithError();
    } else return 'No Device Token Found';
}
