@extends('layouts.admin')

@section('content')
    <div class="bg-white p-6 rounded-lg shadow-lg">
        <h2 class="text-2xl font-bold text-gray-800">Welcome to Admin Dashboard</h2>
        <p class="mt-4 text-gray-600">Manage your website and settings from here.</p>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-6">
            <div class="p-6 bg-blue-700 text-white rounded-lg shadow-md">
                <h3 class="text-xl font-bold">Users</h3>
                <p class="mt-2">Manage registered users.</p>
            </div>
            <div class="p-6 bg-blue-700 text-white rounded-lg shadow-md">
                <h3 class="text-xl font-bold">Reports</h3>
                <p class="mt-2">View system analytics.</p>
            </div>
            <div class="p-6 bg-blue-700 text-white rounded-lg shadow-md">
                <h3 class="text-xl font-bold">Settings</h3>
                <p class="mt-2">Update system preferences.</p>
            </div>
        </div>
    </div>
@endsection
