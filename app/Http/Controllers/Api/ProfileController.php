<?php

namespace App\Http\Controllers\Api;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function updateProfile(Request $request)
    {
        if (empty($request->name) || empty($request->contact) || empty($request->address)) {
            return response([
                'success' => false,
                'message' => 'Please fill all fields'
            ], 422);
        }

        $currentUserId = Auth::user()->id;
        $user = User::find($currentUserId);
        $user->name = $request->name;
        $user->contact = $request->contact;
        $user->address = $request->address;
        if ($user->save()) {
            $user = $this->getActiveUserAttributes($user);
            return response([
                'success' => true,
                'message' => 'Profile updated successfully',
                'data' => $user
            ], 200);
        }
    }

    public function changeProfilePicture(Request $request)
    {
        if (empty($request->profile_image)) {
            return response([
                'success' => false,
                'message' => 'Image is required!'
            ], 422);
        }

        $currentUserId = Auth::user()->id;
        $user = User::find($currentUserId);
        $this->removeOldProfileImage($user->profile_image);
        $base64EncodedImage = $request->profile_image;
        $base64DecodedImage = base64_decode($base64EncodedImage);
        $imageName = time() . '.jpg';
        $directory = 'public/images/users/' . $imageName;
        file_put_contents($directory, $base64DecodedImage);
        $user->profile_image = 'images/users/' . $imageName;
        if ($user->save()) {
            $userData = $this->getActiveUserAttributes($user);
            return response([
                'success' => true,
                'message' => 'Profile picture updated successfully!',
                'data' => $userData
            ], 200);
        }
    }

    private function getActiveUserAttributes($user)
    {
        if ($user->department) {
            $department = $user->department->departmentname;
        } else {
            $department = '-';
        }
        return array(
            'id' => $user->id,
            'department' => $department,
            'contact' => $user->contact != null ? $user->contact : '',
            'email' => $user->email != null ? $user->email : '',
            'name' => $user->name,
            'address' => $user->address ?? $user->address,
            'profile_image' => $this->getProfileImage($user->profile_image),
            'reward_points' => $user->reward_points,
            'is_active' => $user->status,
        );
    }

    public function getProfileImage($image)
    {
        if (empty($image)) {
            return asset('public/images/logo.png');
        } elseif (file_exists('public/' . $image)) {
            return asset('public/' . $image);
        } else {
            return asset('public/images/logo.png');
        }
    }

    public function removeOldProfileImage($image)
    {
        if (empty($image)) {
            return true;
        } elseif (file_exists('public/' . $image)) {
            unlink('public/' . $image);
            return true;
        } else {
            return true;
        }
    }
}
