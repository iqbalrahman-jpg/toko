@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Preview PDF</h1>
    <iframe src="{{ asset('storage/file1.pdf') }}" width="100%" height="600px"></iframe>
</div>
@endsection
