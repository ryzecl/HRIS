@extends('layouts.dashboard')

@section('content')

    <header class="mb-3">
        <a href="#" class="burger-btn d-block d-xl-none">
            <i class="bi bi-justify fs-3"></i>
        </a>
    </header>

    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>Roles</h3>
                    <p class="text-subtitle text-muted">
                        Handle Presences Data
                    </p>
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="index.html">Dashboard</a>
                            </li>
                            <li class="breadcrumb-item" aria-current="page">
                                Presences
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">
                                New
                            </li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <section class="section">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Create Presence</h5>
                </div>
                <div class="card-body">

                    {{-- HR FORM --}}

                    @if (session('role') == 'HR')
                        <form action="{{ route('presences.store') }}" method="POST">
                            @csrf

                            <div class="mb-3">
                                <label for="employee_id" class="form-label">Employee</label>
                                <select name="employee_id" id="employee_id"
                                    class="form-control @error('employee_id') is-invalid @enderror" required>
                                    <option value="">Select Employee</option>
                                    @foreach ($employees as $employee)
                                        <option value="{{ $employee->id }}">{{ $employee->fullname }}</option>
                                    @endforeach
                                </select>
                                @error('employee_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="check_in" class="form-label">Check In</label>
                                <input type="date" class="form-control datetime @error('check_in') is-invalid @enderror"
                                    id="check_in" name="check_in" required>
                                @error('check_in')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="check_out" class="form-label">Check Out</label>
                                <input type="date" class="form-control datetime @error('check_out') is-invalid @enderror"
                                    id="check_out" name="check_out" required>
                                @error('check_out')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="date" class="form-label">Date</label>
                                <input type="date" class="form-control date @error('check_out') is-invalid @enderror"
                                    id="date" name="date" required>
                                @error('date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="status" class="form-label">Status</label>
                                <select name="status" id="status"
                                    class="form-control @error('status') is-invalid @enderror" required>
                                    <option value="">Select Status</option>
                                    <option value="present" {{ old('status') == 'present' ? 'selected' : '' }}>Present
                                    </option>
                                    <option value="absent" {{ old('status') == 'absent' ? 'selected' : '' }}>Absent</option>
                                    <option value="leave" {{ old('status') == 'leave' ? 'selected' : '' }}>Leave</option>
                                </select>
                                @error('status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <button type="submit" class="btn btn-primary">Submit</button>
                            <a href="{{ route('presences.index') }}" class="btn btn-secondary">Back to List</a>
                        </form>
                    @else
                        {{-- EMPLOYEE FORM --}}

                        <form action="{{ route('presences.store') }}" method="POST">
                            @csrf

                            <div class="mb-3"><b>Note</b> : Mohon izinkan akses lokasi, supaya presensi diterima</div>

                            <div class="mb-3">
                                <label for="latitude" class="form-label">Latitude</label>
                                <input type="text" class="form-control @error('latitude') is-invalid @enderror"
                                    id="latitude" name="latitude" required>
                            </div>

                            <div class="mb-3">
                                <label for="longitude" class="form-label">Longitude</label>
                                <input type="text" class="form-control @error('longitude') is-invalid @enderror"
                                    id="longitude" name="longitude" required>

                            </div>

                            <div class="mb-3">
                                <iframe width="500" height="300" frameborder="0" scrolling="no" marginheight="0"
                                    marginwidth="0" allowfullscreen></iframe>
                            </div>

                            <button type="submit" class="btn btn-primary" disabled id="btn-present">Present</button>
                        </form>
                    @endif

                </div>
            </div>
        </section>
    </div>

@endsection

@section('scripts')
    <script>
        const iframe = document.querySelector('iframe');
        const officeLat = -6.342437
        const officeLon = 107.344687
        const treshold = 1

        navigator.geolocation.getCurrentPosition(function(position) {
            const lat = position.coords.latitude
            const lon = position.coords.longitude

            // Update iframe dengan lokasi
            iframe.src = `https://www.google.com/maps?q=${lat},${lon}&output=embed`
        })

        document.addEventListener('DOMContentLoaded', (event) => {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(function(position) {
                    const lat = position.coords.latitude
                    const lon = position.coords.longitude

                    document.getElementById('latitude').value = lat
                    document.getElementById('longitude').value = lon

                    // Update iframe dengan lokasi
                    iframe.src = `https://www.google.com/maps?q=${lat},${lon}&output=embed`

                    // Compare lokasi sekarang dengan lokasi kantor
                    const distance = Math.sqrt(Math.pow(lat - officeLat, 2) + Math.pow(lon - officeLon, 2))

                    if (distance <= treshold) {
                        alert('Kamu berada di kantor, selamat bekerja!')
                        document.getElementById('btn-present').removeAttribute('disabled')
                    } else {
                        alert('Kamu terlalu jauh dari kantor, silahkan kembali ke kantor!')
                    }
                }, function(error) {
                    alert('Tidak dapat mengakses lokasi: ' + error.message)
                })
            } else {
                alert('Browser tidak mendukung Geolocation')
            }
        })
    </script>
@endsection
