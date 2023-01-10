<?php

namespace App\Http\Controllers;

use App\OrganizationLog;
use App\SystemLog;

class LogController extends Controller
{
    public function getSystemLog()
    {
        $logData = SystemLog::all()->reverse();
        foreach ($logData as $key => $log) {
            $log->user_name = $log->user ? $log->user->name : "<i class='text-danger'>Not Available</i>";
            $log->description = $log->description ?? "-";
            $log->operation_at = $log->created_at->diffForHumans();
            $log->operation_time = $log->created_at->format('Y-m-d h:i:s A');
        }
        return view('back.pages.log.system.index', compact('logData'));
    }

    public function getOrganizationLog()
    {
        $logData = OrganizationLog::all()->reverse();
        foreach ($logData as $key => $log) {
            $log->organization_name = $log->organization ? $log->organization->organizationname : "<i class='text-danger'>Not Available</i>";
            $log->description = $log->description ?? "-";
            $log->operation_at = $log->created_at->diffForHumans();
            $log->operation_time = $log->created_at->format('Y-m-d h:i:s A');
        }
        return view('back.pages.log.organization.index', compact('logData'));
    }
}
