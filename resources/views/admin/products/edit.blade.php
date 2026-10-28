@extends('admin.layouts.app')
@section('title', 'Edit Product')

@section('content')
<form method="POST" action="{{ route('admin.products.update', $product) }}" enctype="multipart/form-data">
    @method('PUT')
    @include('admin.products._form')
</form>
@endsection
