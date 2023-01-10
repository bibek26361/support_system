<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function filterDataApi()
    {
        $taskCreatedBy = User::find($this->created_by);
        return [
            'id' => $this->id,
            'user' => $this->user ? $this->user->name : 'N/A',
            'title' => $this->title,
            'description' => $this->description,
            'remarks' => $this->remarks ?? '',
            'status' => $this->status ?? 2,
            'status_text' => $this->getTaskStatusText(),
            'priority' => $this->priority,
            'priority_text' => $this->getTaskPriorityText(),
            'created_by' => $taskCreatedBy ? $taskCreatedBy->name : 'N/A',
            'issued_day' => Carbon::parse($this->created_at)->format('d'),
            'issued_month_year' => Carbon::parse($this->created_at)->format('M, y'),
            'created_date_time' => $this->created_at->format('Y-m-d h:i:s A'),
            'created_at' => $this->created_at->diffForHumans(),
            'updated_date_time' => $this->updated_at->format('Y-m-d h:i:s A'),
            'updated_at' => $this->updated_at->diffForHumans(),
            'image' => $this->getImage()
        ];
    }

    public function getTaskPriorityText()
    {
        switch ($this->priority) {
            case 1:
                return 'Lowest';
                break;
            case 2:
                return 'Low';
                break;
            case 3:
                return 'Medium';
                break;
            case 4:
                return 'High';
                break;
            case 5:
                return 'Highest';
                break;
        }
    }

    public function getTaskStatusText()
    {
        switch ($this->status ?? 2) {
            case 0:
                return 'Cancelled';
                break;
            case 1:
                return 'New';
                break;
            case 2:
                return 'In Progress';
                break;
            case 3:
                return 'Completed';
                break;
            case 4:
                return 'Closed';
                break;
        }
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
