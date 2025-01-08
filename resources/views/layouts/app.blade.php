<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"></script>

        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>

        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
        <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
        <style>
            .dataTables_length select {
                padding-right: 30px !important;
                padding-left: 10px !important;
            }
        </style>

    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100">
            @include('layouts.navigation')

            <!-- Page Heading -->
            @isset($header)
                <header class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <!-- Page Content -->
            <main>
                @if (isset($slot))
                    {{ $slot }}
                @endif
                <div>
                    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                        <nav class="navbar navbar-ligh pt-4 px-0 d-flex">
                            <span class="navbar-brand mb-0 h1">@yield('title')</span>
                            <div>
                                @yield('action-btn')
                            </div>
                        </nav>
                        <hr class="border-2 border-top pb-5 border-secondary"/>
                        @if(session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif
                        @if(session('failed'))
                            <div class="alert alert-danger">
                                {{ session('failed') }}
                            </div>
                        @endif
                        @yield('content')
                    </div>
                </div>
            </main>
        </div>
        <div class="modal fade" id="commonModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel"></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="body">
                    </div>
                </div>
            </div>
        </div>
        <script>
            $(document).on(
                "click",
                'a[data-ajax-popup="true"], button[data-ajax-popup="true"]',
                function () {
                    var title = $(this).data("title");
                    var size = $(this).data("size") == "" ? "md" : $(this).data("size");
                    var url = $(this).data("url");
                    $("#commonModal .modal-title").html(title);
                    $("#commonModal .modal-dialog").addClass("modal-" + size);
                    $.ajax({
                        url: url,
                        success: function (data) {
                            $("#commonModal .body").html(data);
                            $("#commonModal").modal("show");
                        },
                        error: function (data) {
                            data = data.responseJSON;
                        },
                    });
                }
            );
        </script>

        <script>
            $(document).ready(function() {
                $('#dataTable').DataTable({
                    "pageLength": 5,
                    "lengthMenu": [5, 10, 25, 50],
                    "ordering": true,
                    "searching": true,
                    "paging": true
                });
            });
        </script>

        @stack('script')

    </body>
</html>
