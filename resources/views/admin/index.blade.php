<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Panel</title>
</head>
<body>
    <h1>Admin Panel</h1>

    <p>Welcome, {{ auth()->user()->name }}!</p>
    <p>You have access to the admin panel.</p>

    <h2>Management</h2>

    <a href="{{ route('admin.categories.index') }}">
        Manage Categories
    </a>
</body>
</html>