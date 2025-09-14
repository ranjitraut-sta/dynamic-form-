<form class="row g-3"
    action="{{ isset($data['record']->id) ? route('permission.update', $data['record']->id) : route('permission.store') }}"
    method="POST" enctype="multipart/form-data">
    @csrf
    @isset($data['record']->id)
        @method('PUT')
    @endisset

    <div class="col-md-12 mb-3">
        <x-form.text-input :id="'name'" :label="'Name'" :name="'name'" :value="old('name', $data['record']->name ?? '')" />
    </div>

    <div class="col-md-12 mb-3">
        <x-form.text-input :id="'controller'" :label="'Controller'" :name="'controller'" :value="old('controller', $data['record']->controller ?? '')" />
    </div>

    <div class="col-md-12 mb-3">
        <x-form.text-input :id="'action'" :label="'Action'" :name="'action'" :value="old('action', $data['record']->action ?? '')" />
    </div>

    <div class="col-md-12 mb-3">
        <x-form.text-input :id="'group_name'" :label="'Group Name'" :name="'group_name'" :value="old('group_name', $data['record']->group_name ?? '')" />
    </div>

    <div class="col-12 col-lg-12 button_submit pt-20 d-flex justify-content-end">
        <x-form.submit-button :label="'Submit'" />
    </div>

</form>
