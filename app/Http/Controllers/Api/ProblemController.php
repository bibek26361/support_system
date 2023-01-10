<?php

namespace App\Http\Controllers\Api;
use App\ProblemType;
use App\ProblemCategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProblemController extends Controller
{
    public function type()
    {
        $problemtypes = ProblemType::whereStatus(1)->orderBy('id','desc')->get(['id','name']);
        return response([
            'success' => true,
            'data' => $problemtypes
            ]);
        
    }
    public function category()
    {
        $problemcategories = ProblemCategory::whereStatus(1)->orderBy('id','desc')->get(['id','problem_type_id','name']);
        return response([
            'success' => true,
            'data' => $problemcategories
            ]);
        
    }
}