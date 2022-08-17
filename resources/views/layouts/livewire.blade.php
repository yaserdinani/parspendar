<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css"
        integrity="sha384-zCbKRCUGaJDkqS1kPbPd7TveP5iyJE0EjAuZQTgFLD2ylzuqKfdKlfG/eSrtxUkn" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet"
        href="http://babakhani.github.io/PersianWebToolkit/beta/lib/persian-datepicker/dist/css/persian-datepicker.css">
    <script src="https://code.jquery.com/jquery-2.2.4.min.js"></script>
    <script src="http://babakhani.github.io/PersianWebToolkit/beta/lib/persian-date/dist/persian-date.js"></script>
    <title>@yield('title') - پارس پندار</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="{{asset('assets/font-awesome/css/font-awesome.min.css')}}">
    @livewireStyles
    <style>
        .tasks-container-header {
            background-color: orange;
            height: 6vh;
            border-top-left-radius: 8px;
            border-top-right-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            color: #fff;
        }

        .tasks-container-header select {
            background-color: inherit;
            color: #fff;
            border: none;
            width: auto;
        }

        .tasks-header-right {
            display: flex;
            align-items: center;
            gap: 5%;
            width: 45%;
            justify-content: flex-end;
        }

        .tasks-items-container {
            overflow: hidden;
            overflow-y: scroll;
            height: 38vh;
        }

        .tasks-items-content {
            border-bottom: 1px solid #ccc;
        }

        .tasks-item-top {
            display: flex;
            justify-content: space-between;
            align-items: center;
            color: #000;
        }

        .tasks-item-top-left {
            width: 70%;
            display: flex;
            align-items: center;
            gap: 3%;
        }

        .square {
            width: 15px;
            height: 15px;
            border-radius: 1px;
        }

        .today-square {
            background-color: orange;
        }

        .yesterday-square {
            background-color: red;
        }

        .tomorrow-square {
            background-color: purple;
        }

        .label-high {
            background-color: #EF7C8E;
            color: red;
        }

        .tasks-item-bottom {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .events-container {
            width: 100%;
            background-color: #fff;
            border-radius: 8px;
            height: 45vh;
        }

        .events-container-header {
            background-color: #101482;
            height: 6vh;
            color: #fff;
            border-top-left-radius: 8px;
            border-top-right-radius: 8px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .events-items-container {
            overflow: hidden;
            overflow-y: scroll;
            height: 38vh;
        }

        .events-items-contents {
            color: #000;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .event-item-right {
            display: flex;
            flex-direction: column;
            width: 70%;
        }

        .sell-team {
            background-color: orange;
        }

        .programmer-team {
            background-color: purple;
        }

        .event-title {
            display: flex;
            align-items: center;
            width: inherit;
            gap: 5%;
        }
    </style>
</head>

<body>
    <livewire:components.navbar />
    <div class="container-fluid mt-2">
        {{ $slot }}
    </div>
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js"
        integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-fQybjgWLrvvRgtW6bFlB7jaZrFsaBXjsOMm/tB9LTS58ONXgqbR9W8oWht/amnpF" crossorigin="anonymous">
    </script>
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="http://babakhani.github.io/PersianWebToolkit/beta/lib/persian-datepicker/dist/js/persian-datepicker.js">
    </script>
    @livewireScripts
    @stack('scripts')
</body>

</html>
