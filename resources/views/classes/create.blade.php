@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-12">
            <h1 class="h3 mb-4">Add New Class</h1>
            
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('classes.store') }}" method="POST">
                        @csrf
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="name" class="form-label">Class Name</label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                           id="name" name="name" value="{{ old('name') }}" required>
                                    <div class="form-text">e.g., "10 IPA 1", "11 IPS 2"</div>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="mb-3">
                                    <label for="level" class="form-label">Level</label>
                                    <input type="text" class="form-control @error('level') is-invalid @enderror" 
                                           id="level" name="level" value="{{ old('level') }}" required>
                                    <div class="form-text">e.g., "10", "11", "12"</div>
                                    @error('level')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="mb-3">
                                    <label for="major" class="form-label">Major</label>
                                    <input type="text" class="form-control @error('major') is-invalid @enderror" 
                                           id="major" name="major" value="{{ old('major') }}" required>
                                    <div class="form-text">e.g., "IPA", "IPS"</div>
                                    @error('major')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="section" class="form-label">Section</label>
                                    <input type="text" class="form-control @error('section') is-invalid @enderror" 
                                           id="section" name="section" value="{{ old('section') }}">
                                    <div class="form-text">e.g., "1", "2", "A", "B" (optional)</div>
                                    @error('section')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="mb-3">
                                    <label for="teacher_id" class="form-label">Class Advisor</label>
                                    <select class="form-select @error('teacher_id') is-invalid @enderror" id="teacher_id" name="teacher_id">
                                        <option value="">Select a teacher (optional)</option>
                                        @foreach($teachers as $teacher)
                                            <option value="{{ $teacher->id }}" {{ old('teacher_id') == $teacher->id ? 'selected' : '' }}>
                                                {{ $teacher->first_name }} {{ $teacher->last_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('teacher_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="mb-3">
                                    <label for="description" class="form-label">Description</label>
                                    <textarea class="form-control @error('description') is-invalid @enderror" 
                                              id="description" name="description" rows="3">{{ old('description') }}</textarea>
                                    @error('description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        
                        <div class="d-flex justify-content-end">
                            <a href="{{ route('classes.index') }}" class="btn btn-secondary me-2">Cancel</a>
                            <button type="submit" class="btn btn-primary">Create Class</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection