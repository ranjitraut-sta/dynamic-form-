<?php

namespace App\Modules\DynamicForm\Controllers;

use App\Http\Controllers\Controller;

class FieldController extends Controller
{
    public function getFieldTypes()
    {
        // Get custom field types from database
        $customFields = \App\Modules\DynamicForm\Models\FieldType::where('is_active', true)->get();

        $fieldTypes = [
            [
                'type' => 'text',
                'label' => 'Text Input',
                'icon' => 'fas fa-font',
                'html' => '<input type="text" class="form-control" name="{name}" placeholder="{label}">',
                'validation' => ['string', 'max:255']
            ],
            [
                'type' => 'email',
                'label' => 'Email',
                'icon' => 'fas fa-envelope',
                'html' => '<input type="email" class="form-control" name="{name}" placeholder="{label}">',
                'validation' => ['email']
            ],
            [
                'type' => 'number',
                'label' => 'Number',
                'icon' => 'fas fa-hashtag',
                'html' => '<input type="number" class="form-control" name="{name}" placeholder="{label}">',
                'validation' => ['numeric']
            ],
            [
                'type' => 'textarea',
                'label' => 'Textarea',
                'icon' => 'fas fa-align-left',
                'html' => '<textarea class="form-control" name="{name}" placeholder="{label}" rows="3"></textarea>',
                'validation' => ['string']
            ],
            [
                'type' => 'select',
                'label' => 'Select Dropdown',
                'icon' => 'fas fa-list',
                'html' => '<select class="form-control" name="{name}">{options}</select>',
                'validation' => ['string'],
                'hasOptions' => true
            ],
            [
                'type' => 'radio',
                'label' => 'Radio Button',
                'icon' => 'fas fa-dot-circle',
                'html' => '<div class="form-check">{options}</div>',
                'validation' => ['string'],
                'hasOptions' => true
            ],
            [
                'type' => 'checkbox',
                'label' => 'Checkbox',
                'icon' => 'fas fa-check-square',
                'html' => '<div class="form-check">{options}</div>',
                'validation' => ['array'],
                'hasOptions' => true
            ],
            [
                'type' => 'date',
                'label' => 'Date',
                'icon' => 'fas fa-calendar',
                'html' => '<input type="date" class="form-control" name="{name}">',
                'validation' => ['date']
            ],
            [
                'type' => 'file',
                'label' => 'File Upload',
                'icon' => 'fas fa-file',
                'html' => '<input type="file" class="form-control" name="{name}">',
                'validation' => ['file']
            ]
        ];

        // Add custom field types
        foreach($customFields as $custom) {
            $fieldTypes[] = [
                'type' => $custom->name,
                'label' => $custom->label,
                'icon' => $custom->icon,
                'html' => $custom->html_template,
                'validation' => $custom->validation_rules ?? [],
                'hasOptions' => $custom->has_options
            ];
        }

        return view('dynamicform::partials.field-palette', compact('fieldTypes'));
    }
    
    public function getFieldPalette()
    {
        // Get custom field types from database
        $customFields = \App\Modules\DynamicForm\Models\FieldType::where('is_active', true)->get();
        
        $fieldTypes = [
            ['type' => 'text', 'label' => 'Text Input', 'icon' => 'fas fa-font'],
            ['type' => 'email', 'label' => 'Email', 'icon' => 'fas fa-envelope'],
            ['type' => 'tel', 'label' => 'Phone', 'icon' => 'fas fa-phone'],
            ['type' => 'number', 'label' => 'Number', 'icon' => 'fas fa-hashtag'],
            ['type' => 'textarea', 'label' => 'Textarea', 'icon' => 'fas fa-align-left'],
            ['type' => 'date', 'label' => 'Date', 'icon' => 'fas fa-calendar'],
            ['type' => 'select', 'label' => 'Select', 'icon' => 'fas fa-list'],
            ['type' => 'radio', 'label' => 'Radio', 'icon' => 'fas fa-dot-circle'],
            ['type' => 'checkbox', 'label' => 'Checkbox', 'icon' => 'fas fa-check-square'],
            ['type' => 'file', 'label' => 'File Upload', 'icon' => 'fas fa-file']
        ];
        
        // Add custom field types
        foreach($customFields as $custom) {
            $fieldTypes[] = [
                'type' => $custom->name,
                'label' => $custom->label,
                'icon' => $custom->icon
            ];
        }
        
        $html = '<div class="field-palette-grid">';
        foreach($fieldTypes as $field) {
            $html .= '<div class="field-card" draggable="true" data-type="' . $field['type'] . '" title="Drag to add ' . $field['label'] . '">';
            $html .= '<div class="field-icon"><i class="' . $field['icon'] . '"></i></div>';
            $html .= '<div class="field-name">' . $field['label'] . '</div>';
            $html .= '</div>';
        }
        $html .= '</div>';
        
        return response()->json(['html' => $html]);
    }

    public function getFieldHtml($type, $config = [])
    {
        $fieldTypes = $this->getFieldTypesArray();
        $fieldType = collect($fieldTypes)->firstWhere('type', $type);

        if (!$fieldType) {
            return response()->json(['error' => 'Field type not found'], 404);
        }

        $html = $fieldType['html'];
        $html = str_replace('{name}', $config['name'] ?? 'field_name', $html);
        $html = str_replace('{label}', $config['label'] ?? $fieldType['label'], $html);

        if (isset($fieldType['hasOptions']) && $fieldType['hasOptions']) {
            $options = $this->generateOptions($type, $config['options'] ?? ['Option 1', 'Option 2']);
            $html = str_replace('{options}', $options, $html);
        }

        return response()->json(['html' => $html, 'config' => $fieldType]);
    }

    private function generateOptions($type, $options)
    {
        switch ($type) {
            case 'select':
                return implode('', array_map(fn($opt) => "<option value=\"{$opt}\">{$opt}</option>", $options));
            case 'radio':
                return implode('', array_map(fn($opt) =>
                    "<input class=\"form-check-input\" type=\"radio\" name=\"{name}\" value=\"{$opt}\">
                     <label class=\"form-check-label\">{$opt}</label><br>", $options));
            case 'checkbox':
                return implode('', array_map(fn($opt) =>
                    "<input class=\"form-check-input\" type=\"checkbox\" name=\"{name}[]\" value=\"{$opt}\">
                     <label class=\"form-check-label\">{$opt}</label><br>", $options));
            default:
                return '';
        }
    }

    private function getFieldTypesArray()
    {
        return [
            ['type' => 'text', 'label' => 'Text Input', 'icon' => 'fas fa-font', 'html' => '<input type="text" class="form-control" name="{name}" placeholder="{label}">', 'validation' => ['string', 'max:255']],
            ['type' => 'email', 'label' => 'Email', 'icon' => 'fas fa-envelope', 'html' => '<input type="email" class="form-control" name="{name}" placeholder="{label}">', 'validation' => ['email']],
            ['type' => 'number', 'label' => 'Number', 'icon' => 'fas fa-hashtag', 'html' => '<input type="number" class="form-control" name="{name}" placeholder="{label}">', 'validation' => ['numeric']],
            ['type' => 'textarea', 'label' => 'Textarea', 'icon' => 'fas fa-align-left', 'html' => '<textarea class="form-control" name="{name}" placeholder="{label}" rows="3"></textarea>', 'validation' => ['string']],
            ['type' => 'select', 'label' => 'Select Dropdown', 'icon' => 'fas fa-list', 'html' => '<select class="form-control" name="{name}">{options}</select>', 'validation' => ['string'], 'hasOptions' => true],
            ['type' => 'radio', 'label' => 'Radio Button', 'icon' => 'fas fa-dot-circle', 'html' => '<div class="form-check">{options}</div>', 'validation' => ['string'], 'hasOptions' => true],
            ['type' => 'checkbox', 'label' => 'Checkbox', 'icon' => 'fas fa-check-square', 'html' => '<div class="form-check">{options}</div>', 'validation' => ['array'], 'hasOptions' => true],
            ['type' => 'date', 'label' => 'Date', 'icon' => 'fas fa-calendar', 'html' => '<input type="date" class="form-control" name="{name}">', 'validation' => ['date']],
            ['type' => 'file', 'label' => 'File Upload', 'icon' => 'fas fa-file', 'html' => '<input type="file" class="form-control" name="{name}">', 'validation' => ['file']]
        ];
    }
}
