@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div id="profile" class="w-50">
            <admin-profile :user="{{ auth()->user() }}"></admin-profile>
        </div>
    </div>
</div>
@endsection
