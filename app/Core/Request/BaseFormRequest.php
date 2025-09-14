<?php

namespace App\Core\Request;

use App\Core\Traits\HandlesTempImageUploads;
use Illuminate\Foundation\Http\FormRequest;

abstract class BaseFormRequest extends FormRequest
{
    use HandlesTempImageUploads;
    public function authorize(): bool
    {
        return true;
    }

    protected function getCommonRules(): array
    {
        return [
            'status' => 'sometimes|in:active,inactive',
            'display_order' => 'sometimes|integer|min:1',
        ];
    }

    protected function getCreateRules(): array
    {
        return [];
    }

    protected function getUpdateRules(): array
    {
        return [];
    }

    protected function getCommonMessages(): array
    {
        return [
            'status.in' => 'Status must be either active or inactive.',
            'display_order.integer' => 'Display order must be a number.',
            'display_order.min' => 'Display order must be at least 1.',
        ];
    }

    protected function getMessages(): array
    {
        return [];
    }

    protected function getCreateMessages(): array
    {
        return [];
    }

    protected function getUpdateMessages(): array
    {
        return [];
    }

    public function rules()
    {
        $method = $this->getMethod();
        $rules = $this->getCommonRules();

        if ($method === 'POST') {
            $rules = array_merge($rules, $this->getCreateRules());
        } elseif (in_array($method, ['PUT', 'PATCH'])) {
            $rules = array_merge($rules, $this->getUpdateRules());
        }

        return $rules;
    }

    public function messages()
    {
        $messages = array_merge($this->getCommonMessages(), $this->getMessages());

        if ($this->isCreate()) {
            $messages = array_merge($messages, $this->getCreateMessages());
        } elseif ($this->isUpdate()) {
            $messages = array_merge($messages, $this->getUpdateMessages());
        }

        return $messages;
    }

    protected function isUpdate(): bool
    {
        return in_array($this->getMethod(), ['PUT', 'PATCH']);
    }

    protected function isCreate(): bool
    {
        return $this->getMethod() === 'POST';
    }

    protected function getRouteId(): ?int
    {
        return $this->route('id');
    }
}
