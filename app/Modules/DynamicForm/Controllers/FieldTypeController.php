<?php

namespace App\Modules\DynamicForm\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\DynamicForm\Models\FieldType;
use Illuminate\Http\Request;

class FieldTypeController extends Controller
{
    public function index()
    {
        $fieldTypes = FieldType::latest()->paginate(10);
        return view('dynamicform::field-types.index', compact('fieldTypes'));
    }

    public function create()
    {
        return view('dynamicform::field-types.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:field_types',
            'label' => 'required',
            'html_template' => 'required'
        ]);

        FieldType::create([
            'name' => $request->name,
            'label' => $request->label,
            'icon' => $request->icon ?: 'fas fa-square',
            'html_template' => $request->html_template,
            'validation_rules' => $request->validation_rules ? explode(',', $request->validation_rules) : [],
            'has_options' => $request->boolean('has_options'),
            'is_active' => $request->boolean('is_active', true)
        ]);

        return redirect()->route('field-types.index')->with('success', 'Field type created successfully');
    }

    public function edit(FieldType $fieldType)
    {
        return view('dynamicform::field-types.edit', compact('fieldType'));
    }

    public function update(Request $request, FieldType $fieldType)
    {
        $request->validate([
            'name' => 'required|unique:field_types,name,' . $fieldType->id,
            'label' => 'required',
            'html_template' => 'required'
        ]);

        $fieldType->update([
            'name' => $request->name,
            'label' => $request->label,
            'icon' => $request->icon ?: 'fas fa-square',
            'html_template' => $request->html_template,
            'validation_rules' => $request->validation_rules ? explode(',', $request->validation_rules) : [],
            'has_options' => $request->boolean('has_options'),
            'is_active' => $request->boolean('is_active', true)
        ]);

        return redirect()->route('field-types.index')->with('success', 'Field type updated successfully');
    }

    public function destroy(FieldType $fieldType)
    {
        $fieldType->delete();
        return response()->json(['success' => true]);
    }
}