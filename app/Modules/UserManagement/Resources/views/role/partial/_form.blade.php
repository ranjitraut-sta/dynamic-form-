<form class="row g-3"
    action="{{ isset($data['record']->id) ? route('role.update', $data['record']->id) : route('role.store') }}"
    method="POST" enctype="multipart/form-data">
    @csrf
    @isset($data['record']->id)
        @method('PUT')
    @endisset

    <div class="col-md-12 mb-3">
        <x-form.text-input :id="'name'" :label="'Name'" :name="'name'" :value="old('name', $data['record']->name ?? '')" />
    </div>

    <div class="col-12 col-lg-12 button_submit pt-20 d-flex justify-content-end">
        <x-form.submit-button :label="'Submit'" />
    </div>
</form>
