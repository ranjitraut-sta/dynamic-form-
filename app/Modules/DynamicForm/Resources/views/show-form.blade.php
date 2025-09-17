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
                                            @break

                                        @case('date')
                                            <input
                                                type="date"
                                                class="form-control"
                                                name="{{ $field['name'] ?? $field['id'] }}"
                                                {{ ($field['required'] ?? false) ? 'required' : '' }}>
                                            @break

                                        @case('tel')
                                            <input
                                                type="tel"
                                                class="form-control"
                                                name="{{ $field['name'] ?? $field['id'] }}"
                                                placeholder="{{ $field['placeholder'] ?? 'Enter phone number' }}"
                                                {{ ($field['required'] ?? false) ? 'required' : '' }}>
                                            @break

                                        @case('email')
                                            <input
                                                type="email"
                                                class="form-control"
                                                name="{{ $field['name'] ?? $field['id'] }}"
                                                placeholder="{{ $field['placeholder'] ?? 'Enter email address' }}"
                                                {{ ($field['required'] ?? false) ? 'required' : '' }}>
                                            @break

                                        @case('number')
                                            <input
                                                type="number"
                                                class="form-control"
                                                name="{{ $field['name'] ?? $field['id'] }}"
                                                placeholder="{{ $field['placeholder'] ?? 'Enter number' }}"
                                                {{ ($field['required'] ?? false) ? 'required' : '' }}>
                                            @break

                                        @case('file')
                                            <input
                                                type="file"
                                                class="form-control"
                                                name="{{ $field['name'] ?? $field['id'] }}"
                                                {{ ($field['required'] ?? false) ? 'required' : '' }}>
                                            @break

                                        @default
                                            <input
                                                type="text"
                                                class="form-control"
                                                name="{{ $field['name'] ?? $field['id'] }}"
                                                placeholder="{{ $field['placeholder'] ?? 'Enter ' . strtolower($field['label']) }}"
                                                {{ ($field['required'] ?? false) ? 'required' : '' }}>
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

            const formData = new FormData(this);

            fetch(this.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Form submitted successfully!');
                    this.reset();
                } else {
                    alert('Error submitting form');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error submitting form');
            });
        });
    </script>
</body>
</html>
