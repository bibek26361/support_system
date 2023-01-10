<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    protected $guarded = [];

    public function filterSurveyFeedbackDataApi()
    {
        return [
            'company_recommendation' => $this->company_recommendation,
            'company_satisfaction' => $this->company_satisfaction,
            'product_description' => json_decode($this->product_description),
            'meets_customer_needs' => $this->meets_customer_needs,
            'product_quality' => $this->product_quality,
            'product_valuability' => $this->product_valuability,
            'customer_service' => $this->customer_service,
            'product_usage_since' => $this->product_usage_since,
            'want_other_products' => $this->want_other_products,
            'feedback' => $this->feedback,
        ];
    }
}
