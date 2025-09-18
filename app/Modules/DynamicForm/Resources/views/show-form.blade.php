<!DOCTYPE html>
<html>
<head>
    <title>{{ $form->title ?? 'Form' }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        @if($form)
                            <h3>{{ $form->title }}</h3>
                            @if($form->description)
                                <p class="text-muted">{{ $form->description }}</p>
                            @endif
                            <small class="text-muted">Fields Count: {{ count($form->fields ?? []) }}</small>
                        @else
                            <h3>Form Not Found</h3>
                            <p class="text-danger">The requested form could not be found.</p>
                        @endif
                    </div>
                    <div class="card-body">
                        @if($form)
                        <form id="dynamicForm" action="{{ url('f/' . $form->unique_url . '/submit') }}" method="POST">
                        @endif
                            @csrf
                            @if($form && empty($form->fields))
                                <div class="alert alert-warning">
                                    <strong>No fields found!</strong> This form has no fields configured.
                                </div>
                            @endif

                            @if($form)
                            @foreach($form->fields ?? [] as $field)
                                <div class="mb-3">
                                    <label class="form-label">
                                        {{ $field['label'] }}
                                        @if($field['required'] ?? false)
                                            <span class="text-danger">*</span>
                                        @endif
                                    </label>

                                    @switch($field['type'])
                                        @case('textarea')
                                            <textarea
                                                class="form-control"
                                                name="{{ $field['name'] ?? $field['id'] }}"
                                                placeholder="{{ $field['placeholder'] ?? 'Enter ' . strtolower($field['label']) }}"
                                                rows="3"
                                                {{ ($field['required'] ?? false) ? 'required' : '' }}>
                                            </textarea>
                                            <div class="error-message text-danger small mt-1" style="display: none;"></div>
                                            @break

                                        @case('select')
                                            <select class="form-control" name="{{ $field['name'] ?? $field['id'] }}" {{ ($field['required'] ?? false) ? 'required' : '' }}>
                                                <option value="">Choose...</option>
                                                @if(isset($field['options']))
                                                    @foreach($field['options'] as $option)
                                                        <option value="{{ $option }}">{{ $option }}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                            <div class="error-message text-danger small mt-1" style="display: none;"></div>
                                            @break

                                        @case('radio')
                                            @if(isset($field['options']))
                                                @foreach($field['options'] as $option)
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" name="{{ $field['name'] ?? $field['id'] }}" value="{{ $option }}" {{ ($field['required'] ?? false) ? 'required' : '' }}>
                                                        <label class="form-check-label">{{ $option }}</label>
                                                    </div>
                                                @endforeach
                                            @endif
                                            <div class="error-message text-danger small mt-1" style="display: none;"></div>
                                            @break

                                        @case('checkbox')
                                            @if(isset($field['options']))
                                                @foreach($field['options'] as $option)
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="{{ $field['name'] ?? $field['id'] }}[]" value="{{ $option }}">
                                                        <label class="form-check-label">{{ $option }}</label>
                                                    </div>
                                                @endforeach
                                            @endif
                                            <div class="error-message text-danger small mt-1" style="display: none;"></div>
                                            @break

                                        @case('date')
                                            <input
                                                type="date"
                                                class="form-control"
                                                name="{{ $field['name'] ?? $field['id'] }}"
                                                {{ ($field['required'] ?? false) ? 'required' : '' }}>
                                            <div class="error-message text-danger small mt-1" style="display: none;"></div>
                                            @break

                                        @case('tel')
                                            <input
                                                type="tel"
                                                class="form-control"
                                                name="{{ $field['name'] ?? $field['id'] }}"
                                                placeholder="{{ $field['placeholder'] ?? 'Enter phone number' }}"
                                                {{ ($field['required'] ?? false) ? 'required' : '' }}>
                                            <div class="error-message text-danger small mt-1" style="display: none;"></div>
                                            @break

                                        @case('email')
                                            <input
                                                type="email"
                                                class="form-control"
                                                name="{{ $field['name'] ?? $field['id'] }}"
                                                placeholder="{{ $field['placeholder'] ?? 'Enter email address' }}"
                                                {{ ($field['required'] ?? false) ? 'required' : '' }}>
                                            <div class="error-message text-danger small mt-1" style="display: none;"></div>
                                            @break

                                        @case('number')
                                            <input
                                                type="number"
                                                class="form-control"
                                                name="{{ $field['name'] ?? $field['id'] }}"
                                                placeholder="{{ $field['placeholder'] ?? 'Enter number' }}"
                                                {{ ($field['required'] ?? false) ? 'required' : '' }}>
                                            <div class="error-message text-danger small mt-1" style="display: none;"></div>
                                            @break

                                        @case('file')
                                            <input
                                                type="file"
                                                class="form-control"
                                                name="{{ $field['name'] ?? $field['id'] }}"
                                                {{ ($field['required'] ?? false) ? 'required' : '' }}>
                                            <div class="error-message text-danger small mt-1" style="display: none;"></div>
                                            @break

                                        @default
                                            <input
                                                type="text"
                                                class="form-control"
                                                name="{{ $field['name'] ?? $field['id'] }}"
                                                placeholder="{{ $field['placeholder'] ?? 'Enter ' . strtolower($field['label']) }}"
                                                {{ ($field['required'] ?? false) ? 'required' : '' }}>
                                            <div class="error-message text-danger small mt-1" style="display: none;"></div>
                                    @endswitch
                                </div>
                            @endforeach
                            @endif

                            @if($form)
                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary">Submit Form</button>
                            </div>
                        </form>
                            @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('dynamicForm').addEventListener('submit', function(e) {
            e.preventDefault();

            // Clear previous errors
            document.querySelectorAll('.is-invalid').forEach(el => el.classList.remove('is-invalid'));
            document.querySelectorAll('.error-message').forEach(el => {
                el.style.display = 'none';
                el.textContent = '';
            });

            const formData = new FormData(this);
            
            // Debug: Log form data being sent
            console.log('Form data being sent:');
            for (let [key, value] of formData.entries()) {
                console.log(key, value);
            }

            fetch(this.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            })
            .then(response => {
                console.log('Response status:', response.status);
                const contentType = response.headers.get('content-type');
                console.log('Content type:', contentType);
                
                if (response.status === 422) {
                    return response.json().then(data => {
                        console.log('Validation errors:', data.errors);
                        throw { validation: true, errors: data.errors };
                    });
                }
                
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                
                // Check if response is JSON
                if (contentType && contentType.includes('application/json')) {
                    return response.json();
                } else {
                    // If HTML response, log it for debugging
                    return response.text().then(html => {
                        console.log('HTML response received:', html.substring(0, 500));
                        throw new Error('Server returned HTML instead of JSON');
                    });
                }
            })
            .then(data => {
                console.log('Success response:', data);
                if (data.success) {
                    alert('Form submitted successfully!');
                    this.reset();
                } else {
                    alert('Form submission failed');
                }
            })
            .catch(error => {
                console.log('Caught error:', error);
                if (error.validation && error.errors) {
                    console.log('Processing validation errors:', error.errors);
                    // Display validation errors
                    Object.keys(error.errors).forEach(fieldName => {
                        console.log(`Processing field: ${fieldName}`);
                        const field = document.querySelector(`[name="${fieldName}"], [name="${fieldName}[]"]`);
                        console.log('Found field:', field);
                        if (field) {
                            field.classList.add('is-invalid');
                            const errorContainer = field.parentNode.querySelector('.error-message');
                            console.log('Found error container:', errorContainer);
                            if (errorContainer) {
                                errorContainer.textContent = error.errors[fieldName][0];
                                errorContainer.style.display = 'block';
                            }
                        }
                    });
                } else {
                    console.error('Non-validation error:', error);
                    alert('Error submitting form: ' + (error.message || 'Unknown error'));
                }
            });
        });
    </script>
</body>
</html>
