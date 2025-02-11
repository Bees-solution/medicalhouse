@extends('layouts.admin')

@section('content')

<div class="flex justify-center items-center min-h-screen bg-gradient-to-r from-blue-100 to-blue-300 py-12">
    <div class="bg-white bg-opacity-80 backdrop-blur-lg p-8 rounded-lg shadow-lg w-full max-w-lg">
        <a href="{{ route('lab.index') }}" class="text-blue-600 hover:text-blue-800 font-semibold flex items-center mb-4">
            <i class="fas fa-arrow-left mr-2"></i> Back to List
        </a>

        <h2 class="text-2xl font-bold text-gray-700 text-center">Update Lab Test</h2>

        <!-- Success Message (Inside Form) -->
        @if(session()->has('success'))
            <div class="bg-green-100 border border-green-400 text-green-800 px-4 py-3 rounded-lg relative mt-4 fade-in">
                <strong>Success!</strong> {{ session()->get('success') }}
            </div>
        @endif

        <!-- Form -->
        <form action="{{ route('lab.update', $labTest->id) }}" method="POST" novalidate class="mt-6 space-y-4">
            @method('PUT')
            @csrf

            <!-- Test Name -->
            <div>
                <label for="name" class="block text-gray-700 font-semibold">Test Name</label>
                <input type="text" name="name" id="name" class="w-full p-3 border rounded-lg focus:ring-2 focus:ring-blue-400 focus:outline-none" value="{{ $labTest->name }}" required>
                @if($errors->has('name'))
                    <p class="text-red-500 text-sm mt-1">{{ $errors->first('name') }}</p>
                @endif
            </div>

            <!-- Description -->
            <div>
                <label for="description" class="block text-gray-700 font-semibold">Description</label>
                <textarea name="description" id="description" class="w-full p-3 border rounded-lg focus:ring-2 focus:ring-blue-400 focus:outline-none">{{ $labTest->description }}</textarea>
                @if($errors->has('description'))
                    <p class="text-red-500 text-sm mt-1">{{ $errors->first('description') }}</p>
                @endif
            </div>

            <!-- Price -->
            <div>
                <label for="price" class="block text-gray-700 font-semibold">Price</label>
                <input type="number" step="0.01" name="price" id="price" class="w-full p-3 border rounded-lg focus:ring-2 focus:ring-blue-400 focus:outline-none" value="{{ $labTest->price }}" required>
                @if($errors->has('price'))
                    <p class="text-red-500 text-sm mt-1">{{ $errors->first('price') }}</p>
                @endif
            </div>

            <!-- Type of Test -->
            <div>
                <label for="lab_category_id" class="block text-gray-700 font-semibold">Type of Test</label>
                <select name="lab_category_id" id="lab_category_id" class="w-full p-3 border rounded-lg focus:ring-2 focus:ring-blue-400 focus:outline-none">
                    <option value="">-- Select Type --</option>
                    @foreach($labCategories as $labCategory)
                        <option value="{{ $labCategory->id }}" {{ $labTest->lab_category_id == $labCategory->id ? 'selected' : '' }}>
                            {{ $labCategory->name }}
                        </option>
                    @endforeach
                </select>
                @if($errors->has('lab_category_id'))
                    <p class="text-red-500 text-sm mt-1">{{ $errors->first('lab_category_id') }}</p>
                @endif
            </div>

            <!-- Submit Button -->
            <button type="submit" class="w-full bg-blue-600 text-white py-3 rounded-lg font-semibold hover:bg-blue-700 transition duration-300">
                <i class="fas fa-edit mr-2"></i> Update Lab Test
            </button>
        </form>
    </div>
</div>

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
