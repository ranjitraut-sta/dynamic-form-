<?php

namespace App\Modules\DynamicForm\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\DynamicForm\Models\Form;
use App\Modules\DynamicForm\Models\FormSubmission;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AnalyticsController extends Controller
{
    public function getFormAnalytics($formId)
    {
        $form = Form::findOrFail($formId);
        $submissions = FormSubmission::where('form_id', $formId);

        $analytics = [
            'totalSubmissions' => $submissions->count(),
            'completionRate' => $this->calculateCompletionRate($form),
            'avgTime' => $this->calculateAverageTime($submissions),
            'dropOffRate' => $this->calculateDropOffRate($form),
            'submissionsByDate' => $this->getSubmissionsByDate($submissions),
            'fieldAnalytics' => $this->getFieldAnalytics($form, $submissions)
        ];

        return response()->json($analytics);
    }

    private function calculateCompletionRate($form)
    {
        // Mock calculation - in real implementation, track form views vs submissions
        return rand(75, 95);
    }

    private function calculateAverageTime($submissions)
    {
        // Mock calculation - in real implementation, track time spent on form
        return rand(120, 300);
    }

    private function calculateDropOffRate($form)
    {
        // Mock calculation
        return rand(5, 25);
    }

    private function getSubmissionsByDate($submissions)
    {
        $data = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i)->format('Y-m-d');
            $count = $submissions->clone()->whereDate('created_at', $date)->count();
            $data[] = ['date' => $date, 'count' => $count];
        }
        return $data;
    }

    private function getFieldAnalytics($form, $submissions)
    {
        $fields = $form->fields ?? [];
        $analytics = [];

        foreach ($fields as $field) {
            $completionRate = rand(80, 100); // Mock data
            $analytics[] = [
                'field' => $field['label'] ?? $field['id'],
                'completionRate' => $completionRate
            ];
        }

        return $analytics;
    }
}