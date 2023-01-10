<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Task;
use GuzzleHttp\Client;

class DashboardController extends Controller
{
    public function getDashboardData()
    {
        $dashboardData = array(
            'new_task' => array(),
            'progress_task' => array(),
            'completed_task' => array()
        );

        $auth = auth()->user();
        if ($auth->user_type == 'Admin') {
            try {
                if ($this->getLicenseCountData()) {
                    $dashboardData = $this->getLicenseCountData();
                }
            } catch (\Throwable $th) {
                $dashboardData = array(
                    "total_used_license" => 0,
                    "total_available_license" => 0,
                    "total_expired_license" => 0,
                    "total_alert_license" => 0,
                    "total_license" => 0,
                );
            }
        } else {
            $dashboardData = array(
                "total_used_license" => 0,
                "total_available_license" => 0,
                "total_expired_license" => 0,
                "total_alert_license" => 0,
                "total_license" => 0,
            );
        }
        $newTaskModel = Task::whereStatus(1);
        $progressTaskModel = Task::whereStatus(2);
        $completedTaskModel = Task::whereStatus(3);

        if ($auth->user_type === "Admin") {
            $newTaskData = $newTaskModel->orderBy('id', 'DESC')->get()->take(3);
            $progressTaskData = $progressTaskModel->orderBy('id', 'DESC')->get()->take(3);
            $completedTaskData = $completedTaskModel->orderBy('id', 'DESC')->get()->take(3);
        } else {
            $currentUserId = $auth->id;
            $newTaskData = $this->taskCommonMiltipleQuery($newTaskModel, $currentUserId);
            $progressTaskData = $this->taskCommonMiltipleQuery($progressTaskModel, $currentUserId);
            $completedTaskData = $this->taskCommonMiltipleQuery($completedTaskModel, $currentUserId);
        }

        if ($newTaskData->count()) {
            foreach ($newTaskData as $key => $task) {
                $dashboardData['new_task'][$key] = $task->filterDataApi();
            }
        } else {
            $dashboardData['new_task'] = [];
        }

        if ($progressTaskData->count()) {
            foreach ($progressTaskData as $key => $task) {
                $dashboardData['progress_task'][$key] = $task->filterDataApi();
            }
        } else {
            $dashboardData['progress_task'] = [];
        }

        if ($completedTaskData->count()) {
            foreach ($completedTaskData as $key => $task) {
                $dashboardData['completed_task'][$key] = $task->filterDataApi();
            }
        } else {
            $dashboardData['completed_task'] = [];
        }

        return response([
            'success' => true,
            'data' => $dashboardData
        ]);
    }

    public function getLicenseCountData()
    {
        $client = new Client();
        $res = $client->get(
            'https://server-restroms.nctbutwal.com.np/api/support-app/v1/restaurant/license/count',
            [
                'headers' => [
                    'api_key' => 'SUPPORTAPPVs6KSWeJztptlu9rEYeRweVGxDwn5r1GuaHrofpRBnS4plSpqCP1YJ'
                ]
            ]
        );
        $statusCode = $res->getStatusCode();
        if ($statusCode === 200) {
            return json_decode($res->getBody(), true)['data'];
        } else {
            return [
                'success' => false
            ];
        }
    }

    public function taskCommonMiltipleQuery($taskModel, $currentUserId)
    {
        return $taskModel->where(function ($query) use ($currentUserId) {
            $query->whereUserId($currentUserId)->orWhere('created_by', $currentUserId);
        })->orderBy('priority', 'DESC')->get()->take(3);
    }
}
