<?php

namespace App\Http\Controllers\Api\Upasthiti;

use App\Http\Controllers\Controller;
use App\Organization;
use Illuminate\Http\Request;

class VerificationController extends Controller
{
    public function verifySecutityKey(Request $request)
    {
        $securityKey = $request->security_key;
        if (empty($securityKey)) {
            return response([
                'success' => false,
                'message' => "Security Key is required !"
            ], 422);
        }
        
        if (strlen($securityKey) != 9) {
            return response([
                'success' => false,
                'message' => "9 Digits Security Key is required !"
            ], 422);
        }

        $organization = Organization::whereSecurityKey($securityKey)->first();
        if (!$organization) {
            return response([], 204);
        }

        return response([
            'success' => true,
            'data' => array([
                'organization_name' => $organization->organizationname,
                'mobile_no' => $organization->mobilenumber,
                'address' => $organization->address,
                'base_url' => $organization->system_base_url
            ])
        ], 200);
    }
}
