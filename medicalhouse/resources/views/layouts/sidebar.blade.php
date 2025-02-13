<aside class="w-64 bg-blue-900 text-white min-h-screen p-6 hidden md:block">
    <!-- Logo Section -->
    <div class="flex items-center justify-center mb-6">
        <img src="/images/logo.jpg" alt="Logo" class="h-12 md:h-16">
    </div>

    <!-- Sidebar Title -->
    <h2 class="text-xl font-bold text-center">Admin Panel</h2>

    <!-- Navigation Links -->
    <nav class="mt-6">
        <a href="{{ url('/admin/dashboard') }}" class="block py-2 px-4 rounded-lg hover:bg-blue-700">Dashboard</a>
        <a href="#" class="block py-2 px-4 rounded-lg hover:bg-blue-700">Users</a>
        <a href="{{ url('/lab') }}" class="block py-2 px-4 rounded-lg hover:bg-blue-700">Lab Tests</a>
        <a href="#" class="block py-2 px-4 rounded-lg hover:bg-blue-700">Settings</a>
    </nav>
</aside>
