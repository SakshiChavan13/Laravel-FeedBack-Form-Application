<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* --- GLOBAL --- */
        body {
            background: #f5f7fb;
            font-family: "Figtree", sans-serif;
            color: #333;
        }

        /* --- NAVIGATION BAR --- */
        .navbar-custom {
            background: #1f2937;
            /* Dark grey/navy */
            border-bottom: 1px solid #374151;
            height: 70px;
            display: flex;
            align-items: center;
            padding: 0 40px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.3);
        }

        .navbar-custom .nav-title {
            font-size: 22px;
            font-weight: 600;
            color: #f1f5f9;
            /* Light text */
            margin-right: 50px;
        }

        .navbar-custom .nav-links a {
            font-size: 16px;
            margin-right: 25px;
            font-weight: 500;
            color: #cbd5e1;
            /* Light grey text */
            text-decoration: none;
            transition: 0.3s;
        }

        .navbar-custom .nav-links a:hover {
            color: #6366f1;
            /* Indigo hover */
        }

        .navbar-custom .nav-user {
            margin-left: auto;
            font-weight: 500;
            font-size: 16px;
            color: #f3f4f6;
        }

        .navbar-custom .logout-btn {
            color: #f87171;
            margin-left: 20px;
            font-weight: 500;
            text-decoration: none;
        }

        .navbar-custom .logout-btn:hover {
            color: #ef4444;
        }

        .logout-btn:hover {
            color: #b91c1c;
        }

        /* --- PAGE HEADER (if exists) --- */
        header.bg-white.shadow {
            background: #ffffff;
            padding: 25px 40px;
            border-bottom: 1px solid #e7e7e7;
        }

        /* --- CONTENT WRAPPER --- */
        main {
            padding: 30px 50px;
        }

        /* --- TABLE STYLING --- */
        .table-modern {
            background: #ffffff;
            border-radius: 10px;
            overflow: hidden;
            border: 1px solid #e1e4e8;
        }

        .table-modern thead {
            background: #f8fafc;
            color: #1e293b;
            font-weight: 600;
        }

        .table-modern tbody tr {
            transition: 0.25s;
        }

        .table-modern tbody tr:hover {
            background: #f3f4f6;
        }

        /* Action links */
        .table-action {
            color: #4f46e5;
            font-weight: 500;
            text-decoration: none;
        }

        .table-action:hover {
            color: #4338ca;
        }

        /* --- BUTTONS OVERRIDE --- */
        .btn-primary {
            background-color: #4f46e5 !important;
            border: none !important;
        }

        .btn-primary:hover {
            background-color: #4338ca !important;
        }

        .btn-danger {
            background-color: #ef4444 !important;
            border: none !important;
        }

        .btn-danger:hover {
            background-color: #dc2626 !important;
        }

        /* --- MODALS --- */
        .modal-content {
            border-radius: 12px;
            padding: 5px;
        }
    </style>


    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"></script>
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

            @yield('content')
            @stack('scripts')
        </main>
    </div>
</body>

</html>