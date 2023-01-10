<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Organization;
use App\OrganizationLog;
use App\SystemLog;
use App\UserNotification;
use Illuminate\Http\Request;

class LogController extends Controller
{
    public function getSystemLogData(Request $request)
    {
        $userId = $request->user_id;
        if ($userId) {
            $logData = SystemLog::whereUserId($userId)->get()->reverse();
        } else {
            $logData = SystemLog::all()->reverse();
        }

        foreach ($logData as $key => $log) {
            $logData[$key] = $log->filterDataApi();
        }

        $logData = array_values($logData->toArray());

        return response([
            'success' => true,
            'data' => $logData
        ]);
    }

    public function createOrganizationLog(Request $request)
    {
        $apiKey = $request->header('api-key');
        if (!$apiKey) {
            return response([
                'message' => "Unauthenticated."
            ], 401);
        }

        $organization = Organization::whereApiKey($apiKey)->first(['id', 'organizationname']);
        if (!$organization) {
            return response([
                'message' => "Unauthenticated."
            ], 401);
        }

        OrganizationLog::create([
            'organization_id' => $organization->id,
            'operation' => $request->operation,
            'description' => $request->description
        ]);

        $createNotification = UserNotification::create([
            'user_id' => 0,
            'title' => $organization->organizationname,
            'model_name' => "Organization Notification",
            'message' => $request->description
        ]);

        if ($createNotification) {
            $tokens = activeAdminUserDeviceTokens();
            $sendNotification = array(
                'title' => $createNotification->title,
                'body' => strip_tags($createNotification->message),
                'type' => "Notification",
                'icon' => url('public/images/logo.png'),
            );
            sendFCMNotification($sendNotification, $tokens);
        }

        return response([
            'success' => true,
            'message' => "Successfully Registered."
        ]);
    }

    public function getOrganizationLogData(Request $request)
    {
        $organizationId = $request->organization_id;
        if ($organizationId) {
            $logData = OrganizationLog::whereOrganizationId($organizationId)->get()->reverse();
        } else {
            $logData = OrganizationLog::all()->reverse();
        }

        foreach ($logData as $key => $log) {
            $logData[$key] = $log->filterDataApi();
        }

        $logData = array_values($logData->toArray());

        return response([
            'success' => true,
            'data' => $logData
        ]);
    }
}
