<footer class="amd-footer">
    <div class="container">
        <div class="text-center footer-bottom mt-4">
            © {{ date('Y') }} <strong class="amd-soft">AMD Soft and Service</strong> — All rights reserved.
        </div>
    </div>
</footer>

</div>

{{-- Jquery --}}
<script src="{{ asset('admin/assets/js/jquery-3.6.0.min.js') }}"></script>
<script src="{{ asset('admin/assets/js/jquery-ui.min.js') }}"></script>
{{-- dragtable js --}}
<script src="{{ asset('admin/assets/js/jquery.dragtable.js') }}"></script>
{{-- Main(Custom Js) --}}
<script src="{{ asset('admin/assets/js/main.js') }}"></script>
{{-- Bootstrap --}}
<script src="{{ asset('admin/assets/js/bootstrap.bundle.min.js') }}"></script>
<!-- SweetAlert2 JS -->
<script src="{{ asset('admin/assets/js/sweetalert2.js') }}"></script>
{{-- custom Message SweetAlert2 --}}
<script src="{{ asset('admin/assets/js/customalert.js') }}"></script>
{{-- UI Components --}}
<script src="{{ asset('admin/assets/js/ui-components.js') }}"></script>

{{-- Custom(from my side) --}}
<script src="{{ asset('admin/assets/js/custom.js') }}"></script>

{{-- Nepali Date Picker --}}
<script src="https://nepalidatepicker.sajanmaharjan.com.np/v5/nepali.datepicker/js/nepali.datepicker.v5.0.5.min.js">
</script>

{{-- Ranjit Editor --}}
<script src="https://cdn.jsdelivr.net/gh/ranjitraut-sta/ranjit-editor@main/assets/main.js?v=2.1"></script>
<script>
    $(document).ready(function() {
        // Check if editor already initialized
        if (!$('.ranjit-editor').hasClass('ranjit-editor-initialized')) {
            $('.ranjit-editor').ranjitEditor({
                autosave: true,
                wordCount: true,
                darkMode: false,
                fullscreen: true,
                emoji: true,
                autosaveInterval: 5000
            }).addClass('ranjit-editor-initialized');
        }
    });
</script>

{{-- For DatePicker --}}
<script src="{{ asset('admin/assets/js/flatpickr.js') }}"></script>
<script>
    $(document).ready(function() {
        flatpickr(".my-flatpickr", {
            dateFormat: "Y-m-d",
        });
    });
</script>

{{-- Scripts for used inline --}}
@stack('scripts')
