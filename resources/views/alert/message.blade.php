{{-- Section Message with SweetAlert2 --}}
@if (Session('success'))
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            Swal.fire({
                icon: 'success',
                title: 'Success!',
                text: @json(Session('success')),
                timer: 2000,
                showConfirmButton: true,
                position: 'center',
            });
        });
    </script>
@endif

@if (Session('error'))
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            Swal.fire({
                icon: 'error',
                title: 'Oops!',
                text: @json(Session('error')),
                timer: 2000,
                showConfirmButton: true,
                position: 'center',
            });
        });
    </script>
@endif
<!-- Add SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
