<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 - Page Not Found</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            min-height: 100vh;
            background: #f8f9fa;
            font-family: Arial, sans-serif;
        }

        .error-code {
            font-size: clamp(120px, 25vw, 220px);
            font-weight: 800;
            line-height: 1;
            color: #0d6efd;
            letter-spacing: -10px;
        }

        .error-content {
            max-width: 600px;
        }

        .home-btn {
            padding: 12px 30px;
            border-radius: 8px;
            font-weight: 600;
        }
    </style>
</head>

<body>

    <div class="container min-vh-100 d-flex align-items-center justify-content-center text-center">

        <div class="error-content">

            <div class="error-code">404</div>

            <h1 class="fw-bold mb-3">Oops! Page Not Found</h1>

            <p class="text-secondary fs-5 mb-4">
                Sorry, the page you're looking for doesn't exist
                or has been moved.
            </p>

            <a href="/home" class="btn btn-primary home-btn">
                <i class="bi bi-house-door me-2"></i>
                Back to Home
            </a>

        </div>

    </div>

</body>

</html>
```