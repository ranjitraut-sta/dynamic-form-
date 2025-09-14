<form class="row g-3"
    action="{{ isset($data['record']->id) ? route('user.update', $data['record']->id) : route('user.store') }}"
    method="POST" enctype="multipart/form-data">
    @csrf
    @isset($data['record']->id)
        @method('PUT')
    @endisset

    <div class="col-md-6 mb-3">
        <x-form.text-input :id="'name'" :label="'User Name'" :name="'name'" :value="old('name', $data['record']->name ?? '')" />
    </div>

    <div class="col-md-6 mb-3">
        <x-form.email-input :id="'email'" :label="'User Email'" :name="'email'" :value="old('email', $data['record']->email ?? '')" />
    </div>

    <div class="col-md-6 mb-3">
        <x-form.password-input :id="'password'" :label="'Password'" :name="'password'" />
    </div>

    <div class="col-md-6 mb-3">
        <x-form.password-input :id="'confirm_password'" :label="'Confirm Password'" :name="'password_confirmation'" />
    </div>

    <div class="col-md-6 mb-3">
        <x-form.select-input :id="'role_id'" :label="'Role'" :name="'role_id'" :options="$data['roles']->pluck('name', 'id')"
            :value="old('role_id', $data['record']->role_id ?? '')" />
    </div>

    <div class="col-md-6 mb-3">
        <x-form.select-input :id="'status'" :label="'Status'" :name="'status'" :options="['1' => 'Active', '0' => 'Inactive']"
            :value="old('status', $data['record']->status ?? '')" />
    </div>

    <div class="col-12">
        <x-form.file-upload :id="'profile_image'" :label="'Profile Image'" :name="'profile_image'" :value="$data['record']->profile_image ?? null"
            fullpath="uploads/profile/images" />
        <small class="form-text text-muted">Leave blank to keep the current image.</small>
    </div>

    <div class="col-12 col-lg-12 button_submit pt-20 d-flex justify-content-end">
        <x-form.submit-button :label="'Submit'" />
    </div>

</form>
