<!-- Add SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

@if (Session('success'))
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            Swal.fire({
                toast: true,
                position: 'top-end',
                icon: 'success',
                title: @json(Session('success')),
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true
            });
        });
    </script>
@endif

@if (Session('error'))
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            Swal.fire({
                toast: true,
                position: 'top-end',
                icon: 'error',
                title: @json(Session('error')),
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true
            });
        });
    </script>
@endif
