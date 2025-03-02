@extends('layouts.app')

@section('title', 'Home Page')

@section('content')
    <div class="py-8 px-4 mx-auto max-w-2xl lg:pb-16">
        @if (session()->has('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                <span class="block sm:inline">{{ session('success') }}</span>
                <span class="absolute top-0 bottom-0 right-0 px-4 py-3"></span>
            </div>
        @endif

        @if (session()->has('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                <span class="block sm:inline">{{ session('error') }}</span>
                <span class="absolute top-0 bottom-0 right-0 px-4 py-3"></span>
            </div>
            <p class="text-red-500 text-2xl">This is the home page content.</p>
        @endif
        <h2 class="mb-4 text-xl font-bold text-gray-900 pt-4 dark:text-white">Add a new product</h2>
        <form id="product-form">
            <div class="grid gap-4 sm:grid-cols-2 sm:gap-6">
                <div class="sm:col-span-2">
                    <label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Product
                        Name</label>
                    <input type="text" name="name" id="name"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                        placeholder="Type product name">
                </div>
                <div>
                    <label for="category"
                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Category</label>
                    <select id="category" name="category"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                        <option selected="">Select category</option>
                        @foreach ($categories as $key => $value)
                            <option value={{ $key }}>{{ $value }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <input type="hidden" id="images" name="images" value="{{ old('images') }}">
        </form>

        <div class="mb-3 mx-auto">
            <label for="dropzone" class="text-white">Upload Photos</label>
            <form method="post" action="{{ route('media.store') }}" enctype="multipart/form-data"
                class="dropzone !rounded-lg @error('images') is-invalid @enderror" id="dropzone">
                @csrf
                <div class="dz-message default-font text-center p-4" id="file-message">
                    <i class="fa fa-upload fa-2x text-primary mb-2"></i>
                    <h4 class="mb-2">Drag and drop your photos here</h4>
                    <h4 class="mb-2">Or click to browse files</h4>
                </div>
            </form>
        </div>

        <button type="submit" id="submit-btn"
            class="inline-flex items-center px-5 py-2.5 mt-4 sm:mt-6 text-sm font-medium text-center text-white bg-primary-700 rounded-lg focus:ring-4 focus:ring-primary-200 dark:focus:ring-primary-900 hover:bg-primary-800">
            Add product
        </button>
    </div>


@endsection

@section('scripts')
    @vite('resources/js/dropzone/config.js')
    <script>
        $('#submit-btn').on('click', function(e) {
            e.preventDefault();

            let formData = new FormData($('#product-form')[0]);
            let images = $('#images').val();
            formData.append('images', images);
            formData.append('_token', '{{ csrf_token() }}');

            $.ajax({
                url: "{{ route('product.store') }}",
                type: "POST",
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    Swal.fire({
                        title: 'Success!',
                        text: 'Product created successfully!',
                        icon: 'success',
                        confirmButtonText: 'OK'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = "{{ route('index') }}";
                        }
                    });
                },
                error: function(xhr, status, error) {
                    if (xhr.status === 422) {
                        let errors = xhr.responseJSON.errors;
                        let errorMessages = '';
                        $('.error-messages').hide();
                        $('html, body').animate({
                            scrollTop: 0
                        }, 'slow');
                        for (let field in errors) {
                            errorMessages = `<p>${errors[field].join(', ')}</p>`;
                            $('.error_' + field).html(errorMessages).show();
                        }
                    } else {
                        try {
                            const response = JSON.parse(xhr.responseText);
                            var message = response.message;
                        } catch (e) {
                            var message = ('An unexpected error occurred.');
                        }
                        Swal.fire({
                            title: 'Error!',
                            text: message,
                            icon: 'error',
                            confirmButtonText: 'OK'
                        });
                    }
                }
            });
        });
    </script>
@endsection
