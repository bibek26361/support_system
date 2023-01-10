<?php

namespace App\Http\Controllers\Api;

use App\Department;
use App\Organization;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\OrganizationProduct;
use App\ProblemCategory;
use App\ProblemType;
use App\User;

class AllInfoController extends Controller
{
    public function allInfo()
    {
        $organizations = Organization::whereStatus(1)->get(['id', 'organizationname']);
        foreach ($organizations as $key => $organization) {
            $usedProducts = array();
            $organizationProducts = OrganizationProduct::where('organization_id', $organization->id)->get();
            foreach ($organizationProducts as $usedKey => $organizationProduct) {
                $usedProducts[$usedKey]['id'] = $organizationProduct->product_id;
                $usedProducts[$usedKey]['name'] = $organizationProduct->product->name;
            }
            $organizations[$key]->used_products = $usedProducts;
        }
        $users = User::whereStatus(1)->get(['id', 'name']);
        $problemTypes = ProblemType::whereStatus(1)->get(['id', 'name']);
        foreach ($problemTypes as $key => $problemType) {
            $problemCategories = ProblemCategory::whereProblemTypeId($problemType->id)->get(['id', 'name']);
            if ($problemCategories->count()) {
                $problemType->problem_categories = $problemCategories;
            } else
                $problemType->problem_categories = [];
        }
        $problemtypes = ProblemType::whereStatus(1)->get(['id', 'name']);
        foreach ($problemtypes as $key => $problemtype) {
            $problemtypes[$key]->problemcategories = ProblemCategory::whereProblemTypeId($problemtype->id)->first(['id', 'name']);
        }
        return response([
            'success' => true,
            'data' => array([
                'organizations' => $organizations,
                'users' => $users,
                'problem_types' => $problemTypes
            ])
        ]);
    }
}
