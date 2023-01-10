<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use SMartins\PassportMultiauth\HasMultiAuthApiTokens;

class User extends Authenticatable
{
    use Notifiable, HasMultiAuthApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'department_id', 'name', 'email', 'password', 'contact', 'status', 'profile_image'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * removing tokens
     * @param App\User
     * @return void
     */
    public function revokeTokens()
    {
        $this->tokens()->each(function ($token) {
            $token->delete();
        });
        return;
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function filterDataApi()
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'contact' => $this->contact,
            'address' => $this->address ?? '-',
            'status' => $this->status,
            'department' => $this->department->departmentname,
            'reward_points' => $this->reward_points,
            'user_type' => $this->user_type,
            'profile_image' => $this->getProfileImage(),
            'status' => $this->status,
            'status_text' => $this->getStatusText(),
            'joined_date' => $this->created_at->format('jS M Y'),
            'joined_time' => $this->created_at->format('h:i:s A'),
            'joined_at' => $this->created_at->diffForHumans(),
        ];
    }

    public function getStatusText()
    {
        switch ($this->status) {
            case 0:
                return 'Suspended';
                break;
            case 1:
                return 'Active';
                break;
        }
    }

    public function getProfileImage()
    {
        if (empty($this->profile_image)) {
            return asset('public/images/logo.png');
        } elseif (file_exists('public/' . $this->profile_image)) {
            return asset('public/' . $this->profile_image);
        } else {
            return asset('public/images/logo.png');
        }
    }
}
