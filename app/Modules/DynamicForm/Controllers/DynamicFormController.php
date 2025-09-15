<?php

namespace App\Modules\DynamicForm\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\DynamicForm\Models\Form;
use App\Modules\DynamicForm\Models\FormSubmission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class DynamicFormController extends Controller
{
    public function index()
    {
        $forms = Form::latest()->paginate(10);
        return view('dynamicform::index', compact('forms'));
    }

    public function create()
    {
        return view('dynamicform::builder');
    }

    public function store(Request $request)
    {
        $form = Form::create([
            'title' => $request->title,
            'description' => $request->description,
            'fields' => $request->fields,
            'settings' => $request->settings ?? [],
            'is_active' => $request->boolean('is_active', true),
            'unique_url' => $this->generateUniqueUrl()
        ]);

        return response()->json(['success' => true, 'form' => $form]);
    }

    private function generateUniqueUrl()
    {
        do {
            $url = substr(str_shuffle('0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'), 0, 12);
        } while (Form::where('unique_url', $url)->exists());

        return $url;
    }

    public function show(Form $form)
    {
        $submissions = $form->submissions()->latest()->paginate(10);
        return view('dynamicform::show', compact('form', 'submissions'));
    }

    public function publicForm(Form $form,$formId)
    {
        // Fresh fetch from database
        $form = Form::find($formId);

        return view('dynamicform::show-form', compact('form'));
    }

    public function edit(Form $form)
    {
        return view('dynamicform::builder', compact('form'));
    }

    public function update(Request $request, Form $form)
    {
        $form->update([
            'title' => $request->title,
            'description' => $request->description,
            'fields' => $request->fields,
            'settings' => $request->settings ?? [],
            'is_active' => $request->boolean('is_active', true)
        ]);

        return response()->json(['success' => true, 'form' => $form]);
    }

    public function destroy(Form $form)
    {
        $form->delete();
        return response()->json(['success' => true]);
    }

    public function publicFormByUrl($uniqueUrl)
    {
        $form = Form::where('unique_url', $uniqueUrl)->firstOrFail();
        return view('dynamicform::show-form', compact('form'));
    }

    public function submit(Request $request, $formId)
    {
        // Get form by ID
        $form = Form::findOrFail($formId);

        FormSubmission::create([
            'form_id' => $form->id,
            'data' => $request->except(['_token', '_method']),
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent()
        ]);

        return response()->json(['success' => true, 'message' => 'Form submitted successfully']);
    }

    public function submitByUrl(Request $request, $uniqueUrl)
    {
        $form = Form::where('unique_url', $uniqueUrl)->firstOrFail();

        FormSubmission::create([
            'form_id' => $form->id,
            'data' => $request->except(['_token', '_method']),
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent()
        ]);

        return response()->json(['success' => true, 'message' => 'Form submitted successfully']);
    }

    public function deleteSubmission(FormSubmission $submission)
    {
        $submission->delete();
        return response()->json(['success' => true, 'message' => 'Submission deleted successfully']);
    }
}
