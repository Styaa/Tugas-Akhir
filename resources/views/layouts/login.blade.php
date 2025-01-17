<!doctype html>
<html class="no-js " lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Responsive Bootstrap 5 admin template and web Application ui kit.">
    <title>::My-Task::</title>
    <link rel="icon" href="{{ asset('/favicon.ico') }}" type="image/x-icon"> <!-- Favicon-->
    <!-- project css file  -->
    <link href="{{ asset('/assets/my-task.style.min.css') }}" rel="stylesheet">
</head>

<body>

    <div id="mytask-layout" class="theme-indigo">

        <!-- main body area -->
        @yield('content')

    </div>
</body>

</html>
