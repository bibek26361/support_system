<?php

namespace App\Http\Controllers\Api;

use App\Organization;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\OrganizationCreateRequest;
use App\OrganizationProduct;
use App\OrganizationType;
use App\SystemLog;
use App\Ticket;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrganizationController extends Controller
{
    public function getOrganizationTypeData()
    {
        $organizationTypes = OrganizationType::whereStatus(1)->get();
        foreach ($organizationTypes as $key => $organizationType) {
            $organizationTypes[$key] = $organizationType->filterDataApi();
        }
        return response([
            'success' => true,
            'data' => $organizationTypes
        ]);
    }

    public function create(OrganizationCreateRequest $request)
    {
        DB::beginTransaction();
        for (
            $apiKey = 'SUPPORTAPP', $i = 0, $z = strlen($a = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789') - 1;
            $i != 64;
            $x = rand(0, $z),
            $apiKey .= $a[$x], $i++
        );
        $organization = new Organization();
        $organization->organization_type_id = $request->organization_type_id;
        $organization->organizationname = $request->organization_name;
        $organization->address = $request->address;
        $organization->mobilenumber = $request->mobile_no;
        $organization->phonenumber = $request->phone_no;
        $organization->pan_vat_number = $request->pan_vat_no;
        $organization->representativename = $request->representative_name;
        $organization->api_key = $apiKey;
        $organization->security_key = $request->pan_vat_no;
        $organization->latitude = $request->latitude;
        $organization->longitude = $request->longitude;
        $organization->save();

        $usedProducts = $request->used_products;
        foreach ($usedProducts as $usedProduct) {
            OrganizationProduct::create([
                'organization_id' => $organization->id,
                'product_id' => $usedProduct
            ]);
        }

        SystemLog::create([
            'user_id' => Auth::user()->id,
            'operation' => 'Organization Added',
            'description' => $request->organizationname . ' has beed added from Mobile App.'
        ]);

        DB::commit();
        return response([
            'success' => true,
            'data' => $organization->filterDataApi()
        ]);
    }

    public function allOrganizations()
    {
        $totalOrganizations = Organization::count();
        return response([
            'success' => true,
            'total_organizations' => $totalOrganizations,
            'data' => $this->getAllOrganizationData()
        ]);
    }

    public function getAllOrganizationData()
    {
        $organizations = Organization::whereStatus(1)->get()->reverse();
        foreach ($organizations as $key => $customer) {
            $organizations[$key] = $customer->filterDataApi();
        }
        $organizations = array_values($organizations->toArray());
        return $organizations;
    }

    public function getTicketData(Request $request)
    {
        if (empty($request->organization_id)) {
            return response([
                'success' => false,
                'message' => 'Organization id is missing'
            ], 422);
        }

        $organizationId = $request->organization_id;
        $organization = Organization::find($organizationId);
        if (!$organization) {
            return response([
                'success' => false,
                'message' => 'Organization not found'
            ], 404);
        }

        $tickets = Ticket::whereOrganizationId($organizationId)->orderBy('id', 'desc')->get();
        foreach ($tickets as $key => $ticket) {
            $tickets[$key] = $ticket->filterDataApi();
        }
        return response([
            'success' => true,
            'data' => $tickets
        ], 200);
    }

    public function getUsedProductData(Request $request)
    {
        if (empty($request->organization_id)) {
            return response([
                'success' => false,
                'message' => 'Organization id is missing'
            ], 422);
        }

        $organizationId = $request->organization_id;
        $organization = Organization::find($organizationId);
        if (!$organization) {
            return response([
                'success' => false,
                'message' => 'Organization not found'
            ], 404);
        }

        $organizationProducts = OrganizationProduct::whereOrganizationId($organizationId)->orderBy('id', 'desc')->get();
        foreach ($organizationProducts as $key => $organizationProduct) {
            $organizationProducts[$key] = $organizationProduct->filterDataApi();
        }
        return response([
            'success' => true,
            'data' => $organizationProducts
        ], 200);
    }

    public function addProducts(Request $request)
    {
        if (empty($request->organization_id)) {
            return response([
                'success' => false,
                'message' => 'Organization id is missing'
            ], 422);
        }

        $organizationId = $request->organization_id;
        $organization = Organization::find($organizationId);
        if (!$organization) {
            return response([
                'success' => false,
                'message' => 'Organization not found'
            ], 404);
        }

        $productIds = $request->used_products;
        try {
            foreach ($productIds as $key => $productId) {
                $organizationProduct = new OrganizationProduct();
                $organizationProduct->organization_id = $organizationId;
                $organizationProduct->product_id = $productId;
                if (!$this->isProductAlreadyUsed($organizationId, $productId)) {
                    $organizationProduct->save();
                }
            }
            DB::commit();
            return response([
                'success' => true,
                'message' => "Product Added To Organization Successfully !"
            ], 200);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response([
                'success' => false,
                'message' => "Something went wrong, please try again !"
            ], 500);
        }
    }

    public function isProductAlreadyUsed($organizationId, $productId)
    {
        $organizationProducts = OrganizationProduct::whereOrganizationId($organizationId)->whereProductId($productId)->first();
        return $organizationProducts ? true : false;
    }
}
