<!doctype html>
<html class="no-js " lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Sistem Kelola Ormawa adalah platform manajemen organisasi mahasiswa berbasis web yang komprehensif dan responsif, dirancang untuk memudahkan pengelolaan keanggotaan, divisi, dan aktivitas organisasi kemahasiswaan.">
    <title>Kelola Ormawa</title>
    <link rel="icon" href="{{ asset('/favicon.ico') }}" type="image/x-icon"> <!-- Favicon-->
    <!-- project css file  -->
    <link href="{{ asset('/assets/my-task.style.min.css') }}" rel="stylesheet">
    <link href="https://unpkg.com/filepond/dist/filepond.css" rel="stylesheet" />
    <link href="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.css"
        rel="stylesheet" />
    <link href="https://unpkg.com/filepond-plugin-file-poster/dist/filepond-plugin-file-poster.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    @yield('js_head')
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <style>
        /* Custom styles untuk FilePond */
        .filepond--panel-root {
            background-color: #f8f9fa;
            border: 1px dashed #ced4da;
        }

        .filepond--drop-label {
            color: #6c757d;
        }

        .filepond--item-panel {
            background-color: #e9ecef;
        }

        .filepond--label-action {
            text-decoration-color: #0d6efd;
        }

        /* Style untuk preview file */
        .filepond--file-info-main {
            font-weight: bold;
        }
    </style>
</head>

<body>

    <div id="mytask-layout" class="theme-indigo">

        <!-- main body area -->
        @yield('content')

    </div>
</body>

</html>
