@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-12">
            <h1 class="h3 mb-4">Edit Guardian</h1>
            
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('guardians.update', $guardian) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="first_name" class="form-label">First Name</label>
                                    <input type="text" class="form-control @error('first_name') is-invalid @enderror" 
                                           id="first_name" name="first_name" value="{{ old('first_name', $guardian->first_name) }}" required>
                                    @error('first_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="mb-3">
                                    <label for="last_name" class="form-label">Last Name</label>
                                    <input type="text" class="form-control @error('last_name') is-invalid @enderror" 
                                           id="last_name" name="last_name" value="{{ old('last_name', $guardian->last_name) }}" required>
                                    @error('last_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                           id="email" name="email" value="{{ old('email', $guardian->email) }}">
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="mb-3">
                                    <label for="phone" class="form-label">Phone</label>
                                    <input type="text" class="form-control @error('phone') is-invalid @enderror" 
                                           id="phone" name="phone" value="{{ old('phone', $guardian->phone) }}">
                                    @error('phone')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="mb-3">
                                    <label for="relationship" class="form-label">Relationship to Student</label>
                                    <select class="form-select @error('relationship') is-invalid @enderror" id="relationship" name="relationship" required>
                                        <option value="">Select relationship</option>
                                        <option value="father" {{ old('relationship', $guardian->relationship) == 'father' ? 'selected' : '' }}>Father</option>
                                        <option value="mother" {{ old('relationship', $guardian->relationship) == 'mother' ? 'selected' : '' }}>Mother</option>
                                        <option value="guardian" {{ old('relationship', $guardian->relationship) == 'guardian' ? 'selected' : '' }}>Guardian</option>
                                    </select>
                                    @error('relationship')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="address" class="form-label">Address</label>
                                    <textarea class="form-control @error('address') is-invalid @enderror" 
                                              id="address" name="address" rows="3">{{ old('address', $guardian->address) }}</textarea>
                                    @error('address')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="mb-3">
                                    <label for="student_id" class="form-label">Student</label>
                                    <select class="form-select @error('student_id') is-invalid @enderror" id="student_id" name="student_id" required>
                                        @foreach($students as $student)
                                            <option value="{{ $student->id }}" {{ old('student_id', $guardian->student_id) == $student->id ? 'selected' : '' }}>
                                                {{ $student->student_id }} - {{ $student->first_name }} {{ $student->last_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('student_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        
                        <div class="d-flex justify-content-end">
                            <a href="{{ route('guardians.index') }}" class="btn btn-secondary me-2">Cancel</a>
                            <button type="submit" class="btn btn-primary">Update Guardian</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection