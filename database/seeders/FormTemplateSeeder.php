<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Modules\DynamicForm\Models\FormTemplate;

class FormTemplateSeeder extends Seeder
{
    public function run()
    {
        $templates = [
            [
                'name' => 'Contact Form',
                'description' => 'Simple contact form with name, email, and message',
                'category' => 'contact',
                'fields' => [
                    ['id' => 'name', 'type' => 'text', 'label' => 'Full Name', 'required' => true],
                    ['id' => 'email', 'type' => 'email', 'label' => 'Email Address', 'required' => true],
                    ['id' => 'phone', 'type' => 'text', 'label' => 'Phone Number', 'required' => false],
                    ['id' => 'message', 'type' => 'textarea', 'label' => 'Message', 'required' => true]
                ]
            ],
            [
                'name' => 'Customer Survey',
                'description' => 'Customer satisfaction survey with ratings',
                'category' => 'survey',
                'fields' => [
                    ['id' => 'satisfaction', 'type' => 'rating', 'label' => 'Overall Satisfaction', 'required' => true],
                    ['id' => 'recommend', 'type' => 'radio', 'label' => 'Would you recommend us?', 'options' => ['Yes', 'No', 'Maybe'], 'required' => true],
                    ['id' => 'improvements', 'type' => 'checkbox', 'label' => 'Areas for improvement', 'options' => ['Customer Service', 'Product Quality', 'Pricing', 'Delivery'], 'required' => false],
                    ['id' => 'comments', 'type' => 'textarea', 'label' => 'Additional Comments', 'required' => false]
                ]
            ],
            [
                'name' => 'Event Registration',
                'description' => 'Event registration form with personal details',
                'category' => 'registration',
                'fields' => [
                    ['id' => 'first_name', 'type' => 'text', 'label' => 'First Name', 'required' => true],
                    ['id' => 'last_name', 'type' => 'text', 'label' => 'Last Name', 'required' => true],
                    ['id' => 'email', 'type' => 'email', 'label' => 'Email', 'required' => true],
                    ['id' => 'company', 'type' => 'text', 'label' => 'Company', 'required' => false],
                    ['id' => 'dietary', 'type' => 'select', 'label' => 'Dietary Requirements', 'options' => ['None', 'Vegetarian', 'Vegan', 'Gluten-free'], 'required' => false]
                ]
            ]
        ];

        foreach ($templates as $template) {
            FormTemplate::create($template);
        }
    }
}