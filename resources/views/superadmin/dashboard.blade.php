@extends('layout.app')

@section('content')
<div class="container">
    <h1>Super Admin Dashboard</h1>
    <a href="{{ route('admin.create.form') }}">Add Admin</a>
    <!-- Other dashboard content -->
</div>
@endsection
