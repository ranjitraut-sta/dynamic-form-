@if (Session('success'))
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            showToast({
                type: 'success',
                message: @json(Session('success'))
            });
        });
    </script>
@endif
@if (Session('error'))
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            showToast({
                type: 'error',
                message: @json(Session('error'))
            });
        });
    </script>
@endif
