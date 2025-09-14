<!-- resources/views/errors/403.blade.php -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Unauthorized</title>
    <!-- Include Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="d-flex align-items-center justify-content-center" style="height: 100vh; background-color: #f8f9fa;">

    <div class="text-center">
        <div class="alert alert-danger" role="alert">
            <h1 class="display-4">403 - Unauthorized</h1>
            <p class="lead">Sorry, you are not authorized to access this page.</p>
            <a href="{{ route('adminLayout') }}" class="btn btn-primary btn-lg">Go to Homepage</a>
        </div>
    </div>

    <!-- Include Bootstrap JS (Optional for interactivity) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
