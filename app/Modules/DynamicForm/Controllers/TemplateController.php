<?php

namespace App\Modules\DynamicForm\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\DynamicForm\Models\FormTemplate;
use Illuminate\Http\Request;

class TemplateController extends Controller
{
    public function index()
    {
        $templates = FormTemplate::where('is_active', true)->get();
        return response()->json($templates);
    }

    public function show($id)
    {
        $template = FormTemplate::findOrFail($id);
        return response()->json($template);
    }

    public function store(Request $request)
    {
        $template = FormTemplate::create($request->all());
        return response()->json($template);
    }

    public function getPrebuiltTemplates()
    {
        $templates = FormTemplate::where('is_active', true)->get();
        return response()->json($templates);
    }
}