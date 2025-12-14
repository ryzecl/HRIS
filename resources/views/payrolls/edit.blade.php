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
                    Handle Payrolls Data
                </p>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav
                    aria-label="breadcrumb"
                    class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="index.html">Dashboard</a>
                        </li>
                        <li
                            class="breadcrumb-item"
                            aria-current="page">
                            Payrolls
                        </li>
                        <li
                            class="breadcrumb-item active"
                            aria-current="page">
                            Edit
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <section class="section">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">Edit Payroll</h5>
            </div>
            <div class="card-body">

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('payrolls.update', $payroll->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="employee_id" class="form-label">Employee</label>
                        <select name="employee_id" id="employee_id" class="form-control @error('employee_id') is-invalid @enderror" required>
                            <option value="">Select Employee</option>
                            @foreach ($employees as $employee)
                                <option value="{{ $employee->id }}" {{ $payroll->employee_id == old('employee_id', $payroll->employee_id) ? 'selected' : '' }}>{{ $employee->fullname }}</option>
                            @endforeach
                        </select>
                        @error('employee_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="salary" class="form-label">Salary</label>
                        <input type="number" class="form-control @error('salary') is-invalid @enderror" id="salary" name="salary" value="{{ old('salary', $payroll->salary) }}" required>
                        @error('salary')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="bonuses" class="form-label">Bonuses</label>
                        <input type="number" class="form-control @error('bonuses') is-invalid @enderror" id="bonuses" name="bonuses" value="{{ old('bonuses', $payroll->bonuses) }}" required>
                        @error('bonuses')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="deductions" class="form-label">Deductions</label>
                        <input type="number" class="form-control @error('deductions') is-invalid @enderror" id="deductions" name="deductions" value="{{ old('deductions', $payroll->deductions) }}" required>
                        @error('deductions')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label for="pay_date" class="form-label">Pay Date</label>
                        <input type="date" class="form-control date @error('pay_date') is-invalid @enderror" id="pay_date" name="pay_date" value="{{ old('pay_date', $payroll->pay_date) }}" required>
                        @error('pay_date')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label for="net_salary" class="form-label">Net Salary</label>
                        <input type="number" class="form-control @error('net_salary') is-invalid @enderror" id="net_salary" name="net_salary" value="{{ old('net_salary')}}" disabled>
                        @error('net_salary')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-primary">Update</button>
                    <a href="{{ route('payrolls.index') }}" class="btn btn-secondary">Back to List</a>
                </form>
            </div1
        </div>
    </section>
</div>

@endsection

@section('scripts')
    <script>
        document.getElementById('bonuses').addEventListener('input', function() {
            calculateNetSalary();
        });

        document.getElementById('deductions').addEventListener('input', function() {
            calculateNetSalary();
        });

        function calculateNetSalary() {
            const salary = parseFloat(document.getElementById('salary').value) || 0;
            const bonuses = parseFloat(document.getElementById('bonuses').value) || 0;
            const deductions = parseFloat(document.getElementById('deductions').value) || 0;
            const netSalary = salary + bonuses - deductions;
            document.getElementById('net_salary').value = netSalary.toFixed(2);
        }
    </script>
@endsection
