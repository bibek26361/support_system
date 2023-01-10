<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class TaskRemark extends Model
{
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function filterDataApi()
    {
        return [
            'id' => $this->id,
            'user' => $this->user->name,
            'user_image' => $this->getUserProfileImage(),
            'description' => $this->description,
            'audience' => $this->audience ?? 1,
            'audience_text' => $this->getRemarkAudienceText(),
            'created_date_time' => $this->created_at->format('Y-m-d h:i:s A'),
            'created_at' => $this->created_at->diffForHumans(),
            'is_my_remark' => $this->user->id == Auth::user()->id ? true : false,
        ];
    }

    public function getRemarkAudienceText()
    {
        switch ($this->audience ?? 1) {
            case 0:
                return 'Private';
                break;
            case 1:
                return 'Public';
                break;
        }
    }

    public function getUserProfileImage()
    {
        if (empty($this->user->profile_image)) {
            return "https://ui-avatars.com/api/?name=" . $this->user->name;
        } elseif (file_exists('public/' . $this->user->profile_image)) {
            return asset('public/' . $this->user->profile_image);
        } else {
            return "https://ui-avatars.com/api/?name=" . $this->user->name;
        }
    }
}
