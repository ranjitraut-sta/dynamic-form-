<?php

namespace App\Modules\DynamicForm\Helpers;

class FormValidationHelper
{
    public static function generateRules(array $fields): array
    {
        $rules = [];

        foreach ($fields as $field) {
            $rule = [];

            // required
            if (!empty($field['required']) && $field['required'] === true) {
                $rule[] = 'required';
            } else {
                $rule[] = 'nullable';
            }

            // type-based validation
            switch ($field['type']) {
                case 'email':
                    $rule[] = 'email';
                    break;
                case 'tel':
                    $rule[] = 'regex:/^[0-9+\-\s()]*$/';
                    break;
                case 'number':
                    $rule[] = 'numeric';
                    break;
                case 'date':
                    $rule[] = 'date';
                    break;
                case 'file':
                    if (!empty($field['accept'])) {
                        if ($field['accept'] === 'image/*') {
                            $rule[] = 'image';
                        } else {
                            $rule[] = 'mimes:' . str_replace('.', '', $field['accept']);
                        }
                    }
                    break;
            }

            // min & max
            if (!empty($field['minlength'])) {
                $rule[] = 'min:' . $field['minlength'];
            }
            if (!empty($field['maxlength'])) {
                $rule[] = 'max:' . $field['maxlength'];
            }

            $fieldName = $field['name'] ?? $field['id'];

            // checkbox with multiple
            if ($field['type'] === 'checkbox' && !empty($field['multiple'])) {
                $rules[$fieldName . '.*'] = implode('|', $rule);
            } else {
                $rules[$fieldName] = implode('|', $rule);
            }
        }

        return $rules;
    }
}
