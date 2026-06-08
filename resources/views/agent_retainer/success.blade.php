<!DOCTYPE html>
<html>
<head>
    <title>Success</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

<div class="container mt-5">
    <div class="card text-center shadow">
        <div class="card-body">

            <h2 class="text-success mb-3">✅ Success!</h2>

            <p>Your data has been submitted successfully.</p>

            <a href="{{ route('agent_retainer_new.create') }}" class="btn btn-primary mt-3">
                Add New Entry
            </a>

        </div>
    </div>
</div>

</body>
</html>
