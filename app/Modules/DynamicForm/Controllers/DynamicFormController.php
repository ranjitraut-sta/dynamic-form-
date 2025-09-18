<?php

namespace App\Modules\DynamicForm\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\DynamicForm\Models\Form;
use App\Modules\DynamicForm\Models\FormSubmission;
use App\Modules\DynamicForm\Helpers\FormValidationHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class DynamicFormController extends Controller
{
    public function index()
    {
        $forms = Form::with('submissions')
            ->where('user_id', auth()->id())
            ->latest()
            ->paginate(12);
        return view('dynamicform::workspace-index', compact('forms'));
    }

    public function create()
    {
        return view('dynamicform::template-wizard');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'fields' => 'nullable|array',
        ]);

        try {
            $form = Form::create([
                'user_id' => auth()->id(),
                'title' => $request->title,
                'description' => $request->description,
                'fields' => $request->fields ?? [],
                'settings' => $request->settings ?? [],
                'unique_url' => $this->generateUniqueUrl(),
                'is_active' => false
            ]);

            return response()->json(['success' => true, 'form' => $form]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
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
        if ($form->user_id !== auth()->id()) {
            abort(403, 'Unauthorized');
        }

        return view('dynamicform::show', compact('form'));
    }

    public function submissions(Form $form)
    {
        if ($form->user_id !== auth()->id()) {
            abort(403, 'Unauthorized');
        }

        $submissions = $form->submissions()->latest()->paginate(15);
        return view('dynamicform::submissions', compact('form', 'submissions'));
    }

    public function publicForm(Form $form,$formId)
    {
        // Fresh fetch from database
        $form = Form::find($formId);

        return view('dynamicform::show-form', compact('form'));
    }

    public function edit(Form $form)
    {
        if ($form->user_id !== auth()->id()) {
            abort(403, 'Unauthorized');
        }

        return view('dynamicform::builder', compact('form'));
    }

    public function update(Request $request, Form $form)
    {
        if ($form->user_id !== auth()->id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'fields' => 'nullable|array',
        ]);

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
        if ($form->user_id !== auth()->id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

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

        // Generate validation rules dynamically
        $rules = $this->generateValidationRules($form->fields);

        // Validate the request
        $request->validate($rules);

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

        // Generate validation rules dynamically
        $rules = $this->generateValidationRules($form->fields);

        // Validate the request
        try {
            $request->validate($rules);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        }

        FormSubmission::create([
            'form_id' => $form->id,
            'data' => $request->except(['_token', '_method']),
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent()
        ]);

        return response()->json(['success' => true, 'message' => 'Form submitted successfully']);
    }

    private function generateValidationRules($fields)
    {
        return FormValidationHelper::generateRules($fields);
    }

    public function deleteSubmission(FormSubmission $submission)
    {
        $submission->delete();
        return response()->json(['success' => true, 'message' => 'Submission deleted successfully']);
    }
    public function deleteSingleSubmission(FormSubmission $submission, $submissionId)
    {
        $submission = FormSubmission::find($submissionId);
        $submission->delete();
        return response()->json(['success' => true, 'message' => 'Submission deleted successfully']);
    }

    public function enhancedBuilder(Form $form)
    {
        if ($form->user_id !== auth()->id()) {
            abort(403, 'Unauthorized');
        }

        return view('dynamicform::enhanced-builder', compact('form'));
    }

    public function templateWizard()
    {
        return view('dynamicform::template-wizard');
    }

    public function saveEnhanced(Request $request, Form $form)
    {
        if ($form->user_id !== auth()->id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $form->update([
            'title' => $request->title,
            'description' => $request->description,
            'fields' => $request->fields,
            'conditional_logic' => $request->conditional_logic,
            'form_settings' => $request->form_settings,
            'is_active' => true
        ]);

        return response()->json(['success' => true, 'form' => $form]);
    }
}
