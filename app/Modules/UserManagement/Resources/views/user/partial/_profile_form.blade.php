@php
    // यो डाटा कन्ट्रोलरबाट आएको हो भन्ने मानौं
    // $data['record'] = (object) [
    //     'id' => 1,
    //     'name' => 'Sagar Sharma',
    //     'email' => 'sagar@example.com',
    //     'profile_image_url' => 'https://i.pravatar.cc/150?u=sagar',
    //     'created_at' => now()->subYear(),
    //     'role' => 'Administrator',
    // ];
@endphp

<div class="container-fluid py-4">
    <div class="row">

        <!-- Column 1: Profile Display Card -->
        <div class="col-lg-4 mb-4 mb-lg-0">
            <div class="card shadow-sm">
                <div class="card-body text-center p-4">
                    <div class="mb-3">
                        @if (isset($data['record']->profile_image_url) && $data['record']->profile_image_url)
                            <img src="{{ $data['record']->profile_image_url }}" alt="{{ $data['record']->name }}"
                                class="rounded-circle img-fluid shadow-sm" style="width: 150px; height: 150px; object-fit: cover;">
                        @else
                            <div class="bg-secondary rounded-circle d-inline-flex align-items-center justify-content-center"
                                style="width: 150px; height: 150px;">
                                <i class="fas fa-user fa-4x text-white"></i>
                            </div>
                        @endif
                    </div>
                    <h4 class="card-title mb-1">{{ $data['record']->name ?? 'New User' }}</h4>
                    <p class="text-muted mb-2">{{ $data['record']->email ?? 'No email provided' }}</p>
                    @if (isset($data['record']->created_at))
                        <small class="text-muted">Member since {{ $data['record']->created_at->format('M, Y') }}</small>
                    @endif
                </div>
            </div>
        </div>

        <!-- Column 2: Edit Details and Password Card -->
        <div class="col-lg-8">
            <div class="card shadow-sm">
                <!-- Tab Navigation -->
                <div class="card-header bg-light border-bottom">
                    <ul class="nav nav-tabs card-header-tabs" id="profileTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="details-tab" data-bs-toggle="tab" data-bs-target="#details-pane" type="button" role="tab" aria-controls="details-pane" aria-selected="true">
                                <i class="fas fa-user-edit me-1"></i> Account Details
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="password-tab" data-bs-toggle="tab" data-bs-target="#password-pane" type="button" role="tab" aria-controls="password-pane" aria-selected="false">
                                <i class="fas fa-key me-1"></i> Change Password
                            </button>
                        </li>
                    </ul>
                </div>

                <!-- Tab Content -->
                <div class="tab-content" id="profileTabContent">

                    <!-- Account Details Tab Pane -->
                    <div class="tab-pane fade show active" id="details-pane" role="tabpanel" aria-labelledby="details-tab" tabindex="0">
                        <form action="{{ isset($data['record']->id) ? route('user.profile.update', $data['record']->id) : route('user.store') }}"
                            method="POST" enctype="multipart/form-data">
                            @csrf
                            @isset($data['record']->id)
                                @method('PUT')
                            @endisset

                            <div class="card-body p-4">
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <x-form.text-input :id="'name'" :label="'User Name'" :name="'name'" :value="old('name', $data['record']->name ?? '')" />
                                    </div>

                                    <div class="col-md-6">
                                        <x-form.text-input :id="'fullName'" :label="'Full Name'" :name="'full_name'" :value="old('full_name', $data['record']->full_name ?? '')" />
                                    </div>

                                    <div class="col-md-12">
                                        <x-form.email-input :id="'email'" :label="'Email Address'" :name="'email'" :value="old('email', $data['record']->email ?? '')" />
                                    </div>
                                    <div class="col-12">
                                        <x-form.file-upload :id="'profile_image'" :label="'Profile Image'" :name="'profile_image'" :value="$data['record']->profile_image ?? null" fullpath="uploads/profile/images" />
                                        <small class="form-text text-muted">Leave blank to keep the current image.</small>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer bg-light text-end border-top py-3">
                                <x-form.submit-button :label="'Save Changes'" :icon="'fas fa-check-circle'" />
                            </div>
                        </form>
                    </div>

                    <!-- Change Password Tab Pane -->
                    <div class="tab-pane fade" id="password-pane" role="tabpanel" aria-labelledby="password-tab" tabindex="0">
                        {{-- Note: Password update should ideally have its own route and controller method for better security --}}
                        <form action="{{ route('user.profile.update', $data['record']->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="name" value="{{ $data['record']->name }}">
                            <input type="hidden" name="email" value="{{ $data['record']->email }}">
                            <input type="hidden" name="password_change_only" value="1">
                            <div class="card-body p-4">
                                <p class="text-muted">To change your password, please fill out the fields below. For security, you should choose a strong password.</p>
                                <div class="row g-3 mt-3">
                                    <div class="col-md-12">
                                        {{-- Current password might be needed for security. Let's assume it's not for this example. --}}
                                        {{-- <x-form.password-input :id="'current_password'" :label="'Current Password'" :name="'current_password'" /> --}}
                                    </div>
                                    <div class="col-md-6">
                                        <x-form.password-input :id="'password'" :label="'New Password'" :name="'password'" />
                                    </div>
                                    <div class="col-md-6">
                                        <x-form.password-input :id="'confirm_password'" :label="'Confirm New Password'" :name="'password_confirmation'" />
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer bg-light text-end border-top py-3">
                               <x-form.submit-button :label="'Update Password'" :icon="'fas fa-key'" />
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

