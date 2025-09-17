<?php

namespace App\Modules\DynamicForm\Database\Seeders;

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
                    ['id' => 'name', 'type' => 'text', 'label' => 'Full Name', 'required' => true, 'placeholder' => 'Enter your full name'],
                    ['id' => 'email', 'type' => 'email', 'label' => 'Email Address', 'required' => true, 'placeholder' => 'your@email.com'],
                    ['id' => 'phone', 'type' => 'text', 'label' => 'Phone Number', 'required' => false, 'placeholder' => '+1 (555) 123-4567'],
                    ['id' => 'subject', 'type' => 'select', 'label' => 'Subject', 'required' => true, 'options' => ['General Inquiry', 'Support', 'Sales', 'Partnership']],
                    ['id' => 'message', 'type' => 'textarea', 'label' => 'Message', 'required' => true, 'placeholder' => 'Your message here...']
                ]
            ],
            [
                'name' => 'Customer Survey',
                'description' => 'Comprehensive customer satisfaction survey',
                'category' => 'survey',
                'fields' => [
                    ['id' => 'satisfaction', 'type' => 'rating', 'label' => 'Overall Satisfaction', 'required' => true],
                    ['id' => 'recommend', 'type' => 'radio', 'label' => 'Would you recommend us?', 'options' => ['Definitely', 'Probably', 'Not Sure', 'Probably Not', 'Definitely Not'], 'required' => true],
                    ['id' => 'features', 'type' => 'checkbox', 'label' => 'Which features do you use most?', 'options' => ['Dashboard', 'Reports', 'Analytics', 'Integrations', 'Mobile App'], 'required' => false],
                    ['id' => 'improvements', 'type' => 'textarea', 'label' => 'Suggestions for improvement', 'required' => false, 'placeholder' => 'Tell us how we can improve...']
                ]
            ],
            [
                'name' => 'Event Registration',
                'description' => 'Complete event registration with attendee details',
                'category' => 'registration',
                'fields' => [
                    ['id' => 'first_name', 'type' => 'text', 'label' => 'First Name', 'required' => true],
                    ['id' => 'last_name', 'type' => 'text', 'label' => 'Last Name', 'required' => true],
                    ['id' => 'email', 'type' => 'email', 'label' => 'Email Address', 'required' => true],
                    ['id' => 'company', 'type' => 'text', 'label' => 'Company/Organization', 'required' => false],
                    ['id' => 'job_title', 'type' => 'text', 'label' => 'Job Title', 'required' => false],
                    ['id' => 'ticket_type', 'type' => 'radio', 'label' => 'Ticket Type', 'options' => ['Regular - $50', 'VIP - $100', 'Student - $25'], 'required' => true],
                    ['id' => 'dietary', 'type' => 'select', 'label' => 'Dietary Requirements', 'options' => ['None', 'Vegetarian', 'Vegan', 'Gluten-free', 'Other'], 'required' => false],
                    ['id' => 'special_requests', 'type' => 'textarea', 'label' => 'Special Requests', 'required' => false]
                ]
            ],
            [
                'name' => 'Job Application',
                'description' => 'Professional job application form',
                'category' => 'application',
                'fields' => [
                    ['id' => 'position', 'type' => 'select', 'label' => 'Position Applied For', 'options' => ['Software Developer', 'Product Manager', 'Designer', 'Marketing Manager'], 'required' => true],
                    ['id' => 'full_name', 'type' => 'text', 'label' => 'Full Name', 'required' => true],
                    ['id' => 'email', 'type' => 'email', 'label' => 'Email Address', 'required' => true],
                    ['id' => 'phone', 'type' => 'text', 'label' => 'Phone Number', 'required' => true],
                    ['id' => 'experience', 'type' => 'select', 'label' => 'Years of Experience', 'options' => ['0-1 years', '2-3 years', '4-5 years', '6-10 years', '10+ years'], 'required' => true],
                    ['id' => 'resume', 'type' => 'file', 'label' => 'Upload Resume', 'required' => true],
                    ['id' => 'cover_letter', 'type' => 'textarea', 'label' => 'Cover Letter', 'required' => false],
                    ['id' => 'availability', 'type' => 'date', 'label' => 'Available Start Date', 'required' => true]
                ]
            ],
            [
                'name' => 'Product Feedback',
                'description' => 'Collect detailed product feedback from users',
                'category' => 'feedback',
                'fields' => [
                    ['id' => 'product', 'type' => 'select', 'label' => 'Product', 'options' => ['Product A', 'Product B', 'Product C'], 'required' => true],
                    ['id' => 'usage_frequency', 'type' => 'radio', 'label' => 'How often do you use this product?', 'options' => ['Daily', 'Weekly', 'Monthly', 'Rarely'], 'required' => true],
                    ['id' => 'rating', 'type' => 'rating', 'label' => 'Overall Rating', 'required' => true],
                    ['id' => 'liked_features', 'type' => 'checkbox', 'label' => 'What do you like most?', 'options' => ['Easy to use', 'Fast performance', 'Great design', 'Helpful support', 'Good value'], 'required' => false],
                    ['id' => 'issues', 'type' => 'textarea', 'label' => 'Any issues or problems?', 'required' => false],
                    ['id' => 'suggestions', 'type' => 'textarea', 'label' => 'Suggestions for improvement', 'required' => false]
                ]
            ]
        ];

        foreach ($templates as $template) {
            FormTemplate::create($template);
        }
    }
}