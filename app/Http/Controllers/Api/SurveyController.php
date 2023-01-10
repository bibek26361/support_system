<?php

namespace App\Http\Controllers\Api;

use App\Feedback;
use App\Survey;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SurveyController extends Controller
{
    public function all()
    {
        $auth = Auth::user();
        if ($auth->user_type == 'Admin') {
            $surveys = Survey::all()->reverse();
        } else {
            $surveys = Survey::whereUserId(Auth::id())->get()->reverse();
        }
        foreach ($surveys as $key => $survey) {
            $surveys[$key] = $survey->filterDataApi();
        }

        $surveys = array_values($surveys->toArray());
        return response([
            'success' => true,
            'data' => $surveys
        ]);
    }

    public function create(Request $request, $isQuickSurvey = null)
    {
        if (empty($request->organization_id) || empty($request->representative_name) || empty($request->feedback) || empty($request->signature_image) || empty($request->latitude) || empty($request->longitude)) {
            return response([
                'success' => false,
                'message' => 'Please fill all fields'
            ], 422);
        }

        DB::beginTransaction();
        $base64EncodedSignatureImage = $request->signature_image;
        $base64DecodedSignatureImage = base64_decode($base64EncodedSignatureImage);
        $signatureImageName = time() . '.png';
        $signatureDirectory = 'public/images/surveys/signatures/' . $signatureImageName;
        file_put_contents($signatureDirectory, $base64DecodedSignatureImage);

        $survey = new Survey();
        $survey->organization_id = $request->organization_id;
        $survey->user_id = Auth::id();
        $survey->representative_name = $request->representative_name;
        $survey->signature_image = 'images/surveys/signatures/' . $signatureImageName;
        $survey->latitude = $request->latitude;
        $survey->longitude = $request->longitude;

        $base64EncodedImages = $request->images;
        if ($base64EncodedImages) {
            $imageNames = array();
            foreach ($base64EncodedImages as $key => $image) {
                $base64DecodedImage = base64_decode($image);
                $imageName = time() . $key . '.jpg';
                $directory = 'public/images/surveys/' . $imageName;
                file_put_contents($directory, $base64DecodedImage);
                array_push($imageNames, 'images/surveys/' . $imageName);
            }
            $survey->images = json_encode($imageNames);
        }
        if ($survey->save()) {
            if ($isQuickSurvey) {
                $survey->quick_survey_feedback = $request->feedback;
                $survey->save();
            } else {
                $surveyFeedbackData = $request->feedback;
                $surveyFeedback = new Feedback();
                $surveyFeedback->survey_id = $survey->id;
                $surveyFeedback->company_recommendation = $surveyFeedbackData['company_recommendation'];
                $surveyFeedback->company_satisfaction = $surveyFeedbackData['company_satisfaction'];
                $surveyFeedback->product_description = json_encode($surveyFeedbackData['product_description']);
                $surveyFeedback->meets_customer_needs = $surveyFeedbackData['meets_customer_needs'];
                $surveyFeedback->product_quality = $surveyFeedbackData['product_quality'];
                $surveyFeedback->product_valuability = $surveyFeedbackData['product_valuability'];
                $surveyFeedback->customer_service = $surveyFeedbackData['customer_service'];
                $surveyFeedback->product_usage_since = $surveyFeedbackData['product_usage_since'];
                $surveyFeedback->want_other_products = $surveyFeedbackData['want_other_products'];
                $surveyFeedback->feedback = $surveyFeedbackData['feedback'];
                $surveyFeedback->save();
            }
        }
        DB::commit();

        return response([
            'success' => true,
            'data' => $survey->filterDataApi()
        ], 200);
    }
}
