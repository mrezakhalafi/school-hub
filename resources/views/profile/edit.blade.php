@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-12">
            <h1 class="h3 mb-4">Edit Profile</h1>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-md-8">
            @include('profile.partials.update-profile-information-form')

            @include('profile.partials.update-password-form')

            @include('profile.partials.delete-user-form')
        </div>
    </div>
</div>
@endsection
