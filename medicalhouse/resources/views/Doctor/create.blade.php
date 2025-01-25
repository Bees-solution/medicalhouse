<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Doctor</title>
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
        <h1 class="text-center mb-4">Add Doctor</h1>

        <!-- Error Messages -->
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Add Doctor Form -->
        <form action="{{ route('doctor.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <!-- Personal Information Section -->
            <div class="form-section">
                <h2>Personal Information</h2>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" name="name" id="name" class="form-control" placeholder="Enter doctor's name" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="image" class="form-label">Profile Image</label>
                        <input type="file" name="image" id="image" class="form-control" accept="image/*" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="License" class="form-label">License</label>
                        <input type="text" name="License" id="License" class="form-control" placeholder="Enter license number" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="gender" class="form-label">Gender</label>
                        <select name="gender" id="gender" class="form-select" required>
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                            <option value="Other">Other</option>
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="dob" class="form-label">Date of Birth</label>
                        <input type="date" name="dob" id="dob" class="form-control" required>
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
                            <option value="Special">Special</option>
                            <option value="Normal">Normal</option>
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="Specialty" class="form-label">Specialty</label>
                        <input type="text" name="Specialty" id="Specialty" class="form-control" placeholder="Enter specialty" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="Qualification" class="form-label">Qualification</label>
                        <input type="text" name="Qualification" id="Qualification" class="form-control" placeholder="Enter qualification" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="Fee" class="form-label">Fee</label>
                        <input type="number" step="0.01" name="Fee" id="Fee" class="form-control" placeholder="Enter fee amount" required>
                    </div>
                </div>
            </div>

            <!-- Additional Details Section -->
            <div class="form-section">
                <h2>Additional Details</h2>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="No_of_patients" class="form-label">Number of Patients</label>
                        <input type="number" name="No_of_patients" id="No_of_patients" class="form-control" placeholder="Enter maximum number of patients" required>
                    </div>
                    <div class="col-md-12 mb-3">
                        <label for="remarks" class="form-label">Remarks</label>
                        <textarea name="remarks" id="remarks" class="form-control" rows="3" placeholder="Enter any remarks or additional details"></textarea>
                    </div>
                </div>
            </div>

            <!-- Submit Button -->
            <div class="d-flex justify-content-between">
                <button type="submit" class="btn btn-success">Add Doctor</button>
                <a href="{{ route('doctor.index') }}" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
