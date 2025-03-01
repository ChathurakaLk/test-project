@extends('layouts.app')

@section('title', 'Home Page')

@section('content')
    @if (session()->has('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
            <span class="block sm:inline">Working now.</span>
            <span class="absolute top-0 bottom-0 right-0 px-4 py-3"></span>
        </div>
    @endif

    @if (session()->has('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
            <span class="block sm:inline">Something seriously bad happened.</span>
            <span class="absolute top-0 bottom-0 right-0 px-4 py-3"></span>
        </div>
        <p class="text-red-500 text-2xl">This is the home page content.</p>
    @endif


@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            console.log("jQuery is working!");
        });
    </script>
@endsection
