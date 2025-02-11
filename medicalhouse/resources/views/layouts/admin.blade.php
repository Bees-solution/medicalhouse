<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-gray-100 flex">

    <!-- Include Sidebar -->
    @include('layouts.sidebar')

    <!-- Main Content -->
    <div class="flex-1 flex flex-col">
        <!-- Include Header -->
        @include('layouts.admin-header')

        <!-- Page Content -->
        <main class="p-6 bg-gray-200 min-h-screen">
            @yield('content')
        </main>
    </div>

</body>
</html>
