<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Doctor</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        .form-section {
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 20px;
            background-color: #f9f9f9;
        }
        .form-section h2 {
            margin-bottom: 15px;
            color: #007bff;
            font-size: 1.5rem;
        }
        .form-control {
            border-radius: 5px;
        }
        .btn-success {
            background-color: #28a745;
            border-color: #28a745;
        }
        .btn-success:hover {
            background-color: #218838;
            border-color: #1e7e34;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center mb-4">Edit Doctor</h1>

        <!-- Validation Errors -->
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Edit Doctor Form -->
        <form action="{{ route('doctor.update', $doctor->Doc_id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <!-- Personal Information Section -->
            <div class="form-section">
                <h2>Personal Information</h2>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="name" class="form-label">Doctor's Name</label>
                        <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $doctor->name) }}" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="License" class="form-label">License</label>
                        <input type="text" name="License" id="License" class="form-control" value="{{ old('License', $doctor->License) }}" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="gender" class="form-label">Gender</label>
                        <select name="gender" id="gender" class="form-select" required>
                            <option value="Male" {{ old('gender', $doctor->gender) == 'Male' ? 'selected' : '' }}>Male</option>
                            <option value="Female" {{ old('gender', $doctor->gender) == 'Female' ? 'selected' : '' }}>Female</option>
                            <option value="Other" {{ old('gender', $doctor->gender) == 'Other' ? 'selected' : '' }}>Other</option>
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="dob" class="form-label">Date of Birth</label>
                        <input type="date" name="dob" id="dob" class="form-control" value="{{ old('dob', $doctor->dob) }}" required>
                    </div>
                </div>
            </div>

            <!-- Professional Information Section -->
            <div class="form-section">
                <h2>Professional Information</h2>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="Type" class="form-label">Type</label>
                        <select name="Type" id="Type" class="form-select" required>
                            <option value="Special" {{ old('Type', $doctor->Type) == 'Special' ? 'selected' : '' }}>Special</option>
                            <option value="Normal" {{ old('Type', $doctor->Type) == 'Normal' ? 'selected' : '' }}>Normal</option>
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="Specialty" class="form-label">Specialty</label>
                        <input type="text" name="Specialty" id="Specialty" class="form-control" value="{{ old('Specialty', $doctor->Specialty) }}" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="Qualification" class="form-label">Qualification</label>
                        <input type="text" name="Qualification" id="Qualification" class="form-control" value="{{ old('Qualification', $doctor->Qualification) }}" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="Fee" class="form-label">Fee</label>
                        <input type="number" step="0.01" name="Fee" id="Fee" class="form-control" value="{{ old('Fee', $doctor->Fee) }}" required>
                    </div>
                </div>
            </div>

            <!-- Additional Details Section -->
            <div class="form-section">
                <h2>Additional Details</h2>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="No_of_patients" class="form-label">Number of Patients</label>
                        <input type="number" name="No_of_patients" id="No_of_patients" class="form-control" value="{{ old('No_of_patients', $doctor->No_of_patients) }}" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="image" class="form-label">Doctor's Image</label>
                        <input type="file" name="image" id="image" class="form-control">
                        @if ($doctor->image)
                            <div class="mt-2">
                                <img src="{{ asset('storage/' . $doctor->image) }}" alt="Doctor Image" width="100" class="border rounded">
                            </div>
                        @endif
                    </div>
                    <div class="col-md-12 mb-3">
                        <label for="remarks" class="form-label">Remarks</label>
                        <textarea name="remarks" id="remarks" class="form-control" rows="3">{{ old('remarks', $doctor->remarks) }}</textarea>
                    </div>
                </div>
            </div>

            <!-- Submit and Back Buttons -->
            <div class="d-flex justify-content-between">
                <button type="submit" class="btn btn-success">Update Doctor</button>
                <a href="{{ route('doctor.index') }}" class="btn btn-secondary">Back to List</a>
            </div>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
