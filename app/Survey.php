<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Survey extends Model
{
    protected $guarded = [];

    public function organization()
    {
        return $this->belongsTo(Organization::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function feedback()
    {
        return $this->hasOne(Feedback::class);
    }

    public function filterDataApi()
    {
        return [
            'id' => $this->id,
            'organization_name' => $this->organization->organizationname,
            'survey_by' => $this->user->name,
            'representative_name' => $this->representative_name,
            'is_quick_survey' => $this->feedback ? 0 : 1,
            'quick_survey_feedback' => $this->quick_survey_feedback ?? 'N/A',
            'feedback' => $this->getSurveyFeedbackData(),
            'signature_image' => $this->getSignatureImage(),
            'latitude' => $this->latitude,
            'longitude' => $this->longitude,
            'survey_day' => $this->created_at->format('d'),
            'survey_month_year' => $this->created_at->format('M Y'),
            'survey_date' => $this->created_at->format('Y-m-d'),
            'survey_time' => $this->created_at->format('h:i:s A'),
            'survey_date_time' => $this->created_at->format('Y-m-d h:i:s A'),
            'survey_at' => $this->created_at->diffForHumans(),
            'images' => $this->getImages()
        ];
    }

    public function getSurveyFeedbackData()
    {
        if ($this->feedback) {
            return $this->feedback->filterSurveyFeedbackDataApi();
        }

        return [
            'company_recommendation' => 0,
            'company_satisfaction' => "-",
            'product_description' => [],
            'meets_customer_needs' => "-",
            'product_quality' => "-",
            'product_valuability' => "-",
            'customer_service' => "-",
            'product_usage_since' => "-",
            'want_other_products' => "-",
            'feedback' => "-",
        ];
    }

    public function getSignatureImage()
    {
        if (empty($this->signature_image)) {
            return asset('public/images/logo.png');
        } elseif (file_exists('public/' . $this->signature_image)) {
            return asset('public/' . $this->signature_image);
        } else {
            return asset('public/images/logo.png');
        }
    }

    public function getImages()
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
