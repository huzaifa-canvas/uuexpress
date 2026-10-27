@extends('admin.layouts.app')
@section('title', 'Add Service')

@section('content')
<form method="POST" action="{{ route('admin.services.store') }}" enctype="multipart/form-data">
    @include('admin.services._form')
</form>
@endsection
