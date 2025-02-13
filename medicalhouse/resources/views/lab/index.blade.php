@extends('layouts.admin')

@section('content')

<div class="flex justify-center">
    <div class="w-full max-w-6xl">
        <div class="bg-white shadow-lg p-6 rounded-lg">

            <!-- Success Message (Inside Container) -->
            @if(session()->has('success'))
                <div id="success-message" class="bg-green-100 border border-green-400 text-green-800 px-4 py-3 rounded-lg relative fade-in mb-4">
                    <strong>Success!</strong> {{ session()->get('success') }}
                </div>
            @endif

            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-bold text-gray-700">Lab Tests List</h2>
                <a href="{{ route('lab.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">Create Lab Test</a>
            </div>

            <!-- Grid Layout for Lab Tests -->
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                @foreach($labTests as $labTest)
                <div class="bg-white p-4 rounded-lg shadow-md border border-gray-200">
                    <h3 class="text-lg font-bold text-gray-800">{{ $labTest->name }}</h3>
                    <p class="text-sm text-gray-600 mt-2">{{ $labTest->description }}</p>
                    <p class="text-md font-semibold text-blue-600 mt-2">Price: Rs.{{ $labTest->price }}</p>
                    <p class="text-sm text-gray-500">Category: {{ $labTest->category->name ?? 'No Category' }}</p>

                    <!-- Action Buttons -->
                    <div class="mt-4 flex justify-between">
                        <a href="{{ route('lab.show', $labTest->slug) }}" class="text-white bg-blue-500 px-3 py-1 rounded-md hover:bg-blue-600">Show</a>
                        <a href="{{ route('lab.edit', $labTest->slug) }}" class="text-white bg-yellow-500 px-3 py-1 rounded-md hover:bg-yellow-600">Edit</a>
                        <form action="{{ route('lab.destroy', $labTest->slug) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-white bg-red-500 px-3 py-1 rounded-md hover:bg-red-600">Delete</button>
                        </form>
                    </div>
                </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="mt-6">
                {{ $labTests->links() }}
            </div>
        </div>
    </div>
</div>

<!-- Auto-Dismiss Success Message -->
<script>
    document.addEventListener("DOMContentLoaded", function() {
        let successMessage = document.getElementById("success-message");
        if (successMessage) {
            setTimeout(() => {
                successMessage.style.transition = "opacity 1s";
                successMessage.style.opacity = "0";
                setTimeout(() => {
                    successMessage.remove();
                }, 1000);
            }, 3000); // 3 seconds delay before disappearing
        }
    });
</script>

<!-- Smooth Fade-In Animation for Success Message -->
<style>
    .fade-in {
        animation: fadeIn 0.8s ease-in-out;
    }

    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }
</style>

@endsection
