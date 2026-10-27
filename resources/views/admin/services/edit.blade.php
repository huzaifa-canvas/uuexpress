@extends('admin.layouts.app')
@section('title', 'Edit Service')

@section('content')
<form method="POST" action="{{ route('admin.services.update', $service) }}" enctype="multipart/form-data">
    @method('PUT')
    @include('admin.services._form')
</form>
@endsection
