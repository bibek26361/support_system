<?php

namespace App\Http\Controllers\Api;

use App\Department;
use App\Http\Controllers\Controller;

class DepartmentController extends Controller
{
    public function all()
    {
        $departments = Department::whereStatus(1)->get(['id', 'departmentname', 'contact', 'contact_network']);
        return response([
            'success' => true,
            'data' => $departments
        ]);
    }
}
