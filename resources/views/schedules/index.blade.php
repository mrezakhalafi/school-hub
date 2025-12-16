@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="h3">Schedule for {{ $class->name }}</h1>
                <a href="{{ route('classes.index') }}" class="btn btn-secondary">Back to Classes</a>
            </div>
            
            <!-- Schedule Table -->
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered text-center">
                            <thead class="table-dark">
                                <tr>
                                    <th>Time</th>
                                    @foreach($days as $day)
                                        <th>{{ $day }}</th>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($hours as $hour)
                                    <tr>
                                        <th class="align-middle">{{ $hour }}:00</th>
                                        @foreach($days as $day)
                                            <td class="p-1" style="min-width: 120px;">
                                                @if(isset($scheduleGrid[$day][$hour]) && $scheduleGrid[$day][$hour])
                                                    @php $schedule = $scheduleGrid[$day][$hour]; @endphp
                                                    <div class="card mb-1 bg-light">
                                                        <div class="card-body p-2">
                                                            <div class="fw-bold">{{ $schedule->subject }}</div>
                                                            <div class="small text-muted">
                                                                @if($schedule->teacher)
                                                                    {{ $schedule->teacher->first_name }} {{ $schedule->teacher->last_name }}
                                                                @else
                                                                    No Teacher
                                                                @endif
                                                            </div>
                                                            @if(Auth::user()->isAdmin())
                                                                <div class="mt-1">
                                                                    <a href="{{ route('schedules.edit', [$class->id, $schedule->id]) }}" 
                                                                       class="btn btn-sm btn-warning btn-sm">Edit</a>
                                                                    <form action="{{ route('schedules.destroy', [$class->id, $schedule->id]) }}" 
                                                                          method="POST" class="d-inline">
                                                                        @csrf
                                                                        @method('DELETE')
                                                                        <button type="submit" class="btn btn-sm btn-danger" 
                                                                                onclick="return confirm('Are you sure you want to delete this schedule?')">
                                                                            Delete
                                                                        </button>
                                                                    </form>
                                                                </div>
                                                            @endif
                                                        </div>
                                                    </div>
                                                @else
                                                    @if(Auth::user()->isAdmin())
                                                        <a href="{{ route('schedules.create', $class->id) }}?day={{ $day }}&hour={{ $hour }}" 
                                                           class="btn btn-sm btn-outline-primary w-100">Add</a>
                                                    @else
                                                        <span class="text-muted">-</span>
                                                    @endif
                                                @endif
                                            </td>
                                        @endforeach
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    
                    @if(Auth::user()->isAdmin())
                        <div class="mt-3">
                            <a href="{{ route('schedules.create', $class->id) }}" class="btn btn-primary">
                                <i class="fas fa-plus"></i> Add New Schedule
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection