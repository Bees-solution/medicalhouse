<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Doctors List</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: Arial, sans-serif;
        }
        .doctor-card {
            border: 1px solid #ddd;
            border-radius: 10px;
            padding: 15px;
            text-align: center;
            background-color: #fff;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
        }
        .doctor-card:hover {
            transform: scale(1.05);
        }
        .doctor-image {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            object-fit: cover;
            margin-bottom: 10px;
            border: 3px solid #007bff;
        }
        .sidebar {
            background-color: #fff;
            padding: 15px;
            border-radius: 8px;
            height: fit-content;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
        }
        .specialty-box {
            display: flex;
            align-items: center;
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 10px;
            margin-bottom: 10px;
            background-color: #fff;
            cursor: pointer;
            transition: 0.3s;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
        }
        .specialty-box:hover {
            background-color: #007bff;
            color: white;
        }
        .specialty-image {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            object-fit: cover;
            margin-right: 10px;
        }
        @media (max-width: 768px) {
            .specialty-box {
                flex-direction: column;
                align-items: center;
                text-align: center;
            }
            .specialty-image {
                margin-bottom: 5px;
            }
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center mb-4 text-primary">Find Your Doctor</h1>

        <!-- Search and Filter -->
        <form action="{{ route('customer.doctor.list') }}" method="GET" class="mb-4">
            <div class="row">
                <div class="col-md-8">
                    <input type="text" name="search" class="form-control" placeholder="Search by name or specialty" value="{{ request('search') }}">
                </div>
                <div class="col-md-4">
                    <button type="submit" class="btn btn-primary w-100">Search</button>
                </div>
            </div>
        </form>

        <!-- Specialties Section -->
        <div class="row mb-4">
            <h4 class="text-center mb-3 text-secondary">Browse by Specialty</h4>
            @foreach ([
                'Cardiologist', 'Chest Physician / Pulmonologist', 'Dental Surgeon',
                'Dermatologist', 'Diabetologist & Endocrinologist', 'ENT Surgeon / Otorhinolaryngologist',
                'General Surgeon', 'Gynaecologist & Obstetrician', 'Neurosurgeon',
                'Orthodontist', 'Orthopaedic Surgeon', 'Paediatrician',
                'Psychiatrist', 'Rheumatologist', 'Sports & Exercise Medicine Physician',
                'Visiting Physician'
            ] as $specialty)
                <div class="col-md-3 col-sm-6 mb-3">
                    <div class="specialty-box text-center" onclick="window.location='{{ route('customer.doctorsBySpecialty', ['specialty' => $specialty]) }}'">
                        <img src="{{ asset('images/specialties/' . strtolower(str_replace(' ', '_', $specialty)) . '.png') }}" alt="{{ $specialty }}" class="specialty-image">
                        <span>{{ $specialty }}</span>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Doctors Display -->
        <div class="row">
            @foreach ($doctors as $doctor)
                <div class="col-md-4 col-sm-6 mb-3">
                    <div class="doctor-card">
                        <img src="{{ asset('storage/' . $doctor->image) }}" alt="Doctor Image" class="doctor-image">
                        <h4>{{ $doctor->name }}</h4>
                        <p class="text-muted">{{ $doctor->Specialty }}</p>
                        <p><strong>Fee:</strong> RS. {{ number_format($doctor->Fee, 2) }}</p>
                        <a href="{{ route('customer.doctor.view', ['id' => $doctor->Doc_id]) }}" class="btn btn-primary">Channel Now</a>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="mt-4 d-flex justify-content-center">
            {{ $doctors->links() }}
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
