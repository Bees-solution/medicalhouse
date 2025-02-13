@extends('layouts.admin')

@section('content')

<div class="flex justify-center items-center min-h-screen bg-gradient-to-r from-blue-100 to-blue-300 py-12">
    <div class="bg-white bg-opacity-80 backdrop-blur-lg p-8 rounded-lg shadow-lg w-full max-w-lg">
        <h2 class="text-2xl font-bold text-gray-700 text-center mb-6">Lab Test Details</h2>

        <!-- Test Name -->
        <div class="mb-4">
            <label class="block text-gray-700 font-semibold">Test Name</label>
            <input type="text" class="w-full p-3 border rounded-lg bg-gray-100 text-gray-600" value="{{ $labTest->name }}" readonly>
        </div>

        <!-- Description -->
        <div class="mb-4">
            <label class="block text-gray-700 font-semibold">Description</label>
            <textarea class="w-full p-3 border rounded-lg bg-gray-100 text-gray-600" readonly>{{ $labTest->description }}</textarea>
        </div>

        <!-- Price -->
        <div class="mb-4">
            <label class="block text-gray-700 font-semibold">Price</label>
            <input type="text" class="w-full p-3 border rounded-lg bg-gray-100 text-gray-600" value="{{ $labTest->price }}" readonly>
        </div>

        <!-- Category -->
        <div class="mb-6">
            <label class="block text-gray-700 font-semibold">Category</label>
            <input type="text" class="w-full p-3 border rounded-lg bg-gray-100 text-gray-600" value="{{ $labTest->category->name ?? 'No Category' }}" readonly>
        </div>

        <!-- Back Button -->
        <a href="{{ route('lab.index') }}" class="w-full bg-blue-600 text-white py-3 px-6 rounded-lg font-semibold hover:bg-blue-700 transition duration-300 text-center block">
            <i class="fas fa-arrow-left mr-2"></i> Back
        </a>
    </div>
</div>

@endsection
