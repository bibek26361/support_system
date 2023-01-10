<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Ticket extends Model
{
    protected $guarded = [];

    public function organization()
    {
        return $this->belongsTo(Organization::class);
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function problemType()
    {
        return $this->belongsTo(ProblemType::class);
    }

    public function problemCategory()
    {
        return $this->belongsTo(ProblemCategory::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function filterDataApi($userId = null)
    {
        $assignedUser = User::find($this->assigned_to);
        return [
            'id' => $this->id,
            'ticket_id' => $this->ticket_id,
            'organization_id' => $this->organization_id,
            'organization_name' => $this->organization->organizationname,
            'product_id' => $this->product_id,
            'product_name' => $this->product->name ?? '-',
            'organization_number' => $this->organization ? $this->organization->mobilenumber : '9800000000',
            'department_name' => $this->department ? $this->department->departmentname : 'Support Center',
            'assigned_to' => $assignedUser ? $assignedUser->name : 'Not Assigned',
            'problem_type' => $this->problemType->name,
            'problem_category' => $this->problemCategory ? $this->problemCategory->name : '-',
            'priority' => $this->priority,
            'priority_text' => $this->getPriorityText(),
            'status' => $this->status,
            'status_text' => $this->getStatusText($userId),
            'issued_day' => Carbon::parse($this->created_at)->format('d'),
            'issued_month_year' => Carbon::parse($this->created_at)->format('M, y'),
            'issued_date' => Carbon::parse($this->created_at)->format('jS M Y'),
            'issued_time' => Carbon::parse($this->created_at)->format('h:i:s A'),
            'issued_at' => Carbon::parse($this->created_at)->diffForHumans(),
            'details' => $this->details ? $this->details : 'N/A',
            'total_remarks' => $this->countTotalRemarks(),
            'images' => $this->getImage()
        ];
    }

    public function getPriorityText()
    {
        if ($this->priority == 1) {
            return 'Lowest';
        } elseif ($this->priority == 2) {
            return 'Low';
        } elseif ($this->priority == 3) {
            return 'Medium';
        } elseif ($this->priority == 4) {
            return 'High';
        } elseif ($this->priority == 5) {
            return 'Highest';
        } else {
            return 'N/A';
        }
    }

    public function getStatusText($userId = null)
    {
        if ($this->status === 2) {
            return 'Opened';
        } elseif ($this->status === 1) {
            if ($userId) {
                if ($this->created_by == $userId && $this->assigned_to != $userId)
                    return 'Transfered';
                else
                    return 'Assigned';
            } else {
                if ($this->created_by == Auth::user()->id && $this->assigned_to != Auth::user()->id)
                    return 'Transfered';
                else
                    return 'Assigned';
            }
        } elseif ($this->status === 0) {
            return 'Closed';
        }
    }

    public function countTotalRemarks()
    {
        return Remark::whereTicketId($this->id)->get()->count();
    }

    public function getImage()
    {
        $images = array();
        if (!empty($this->images)) {
            $totalImages = json_decode($this->images);
            if ($totalImages > 0) {
                foreach (json_decode($this->images) as $key => $image) {
                    if (file_exists('public/' . $image)) {
                        array_push($images, asset('public/' . $image));
                    } else {
                        array_push($images, asset('public/images/logo.png'));
                    }
                }
            } else {
                array_push($images, asset('public/images/logo.png'));
            }
        } else {
            array_push($images, asset('public/images/logo.png'));
        }
        return $images;
    }
}
