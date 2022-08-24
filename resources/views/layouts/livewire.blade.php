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
    <link rel="stylesheet" href="{{ asset('assets/font-awesome/css/font-awesome.min.css') }}">
    @livewireStyles
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
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
            height: 48vh;
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
            height: 42vh;
        }

        /* spinner */
        .la-ball-spin-clockwise,
        .la-ball-spin-clockwise>div {
            position: relative;
            -webkit-box-sizing: border-box;
            -moz-box-sizing: border-box;
            box-sizing: border-box;
        }

        .la-ball-spin-clockwise {
            display: block;
            font-size: 0;
            color: #fff;
        }

        .la-ball-spin-clockwise.la-dark {
            color: #333;
        }

        .la-ball-spin-clockwise>div {
            display: inline-block;
            float: none;
            background-color: currentColor;
            border: 0 solid currentColor;
        }

        .la-ball-spin-clockwise {
            width: 32px;
            height: 32px;
        }

        .la-ball-spin-clockwise>div {
            position: absolute;
            top: 50%;
            left: 50%;
            width: 8px;
            height: 8px;
            margin-top: -4px;
            margin-left: -4px;
            border-radius: 100%;
            -webkit-animation: ball-spin-clockwise 1s infinite ease-in-out;
            -moz-animation: ball-spin-clockwise 1s infinite ease-in-out;
            -o-animation: ball-spin-clockwise 1s infinite ease-in-out;
            animation: ball-spin-clockwise 1s infinite ease-in-out;
        }

        .la-ball-spin-clockwise>div:nth-child(1) {
            top: 5%;
            left: 50%;
            -webkit-animation-delay: -.875s;
            -moz-animation-delay: -.875s;
            -o-animation-delay: -.875s;
            animation-delay: -.875s;
        }

        .la-ball-spin-clockwise>div:nth-child(2) {
            top: 18.1801948466%;
            left: 81.8198051534%;
            -webkit-animation-delay: -.75s;
            -moz-animation-delay: -.75s;
            -o-animation-delay: -.75s;
            animation-delay: -.75s;
        }

        .la-ball-spin-clockwise>div:nth-child(3) {
            top: 50%;
            left: 95%;
            -webkit-animation-delay: -.625s;
            -moz-animation-delay: -.625s;
            -o-animation-delay: -.625s;
            animation-delay: -.625s;
        }

        .la-ball-spin-clockwise>div:nth-child(4) {
            top: 81.8198051534%;
            left: 81.8198051534%;
            -webkit-animation-delay: -.5s;
            -moz-animation-delay: -.5s;
            -o-animation-delay: -.5s;
            animation-delay: -.5s;
        }

        .la-ball-spin-clockwise>div:nth-child(5) {
            top: 94.9999999966%;
            left: 50.0000000005%;
            -webkit-animation-delay: -.375s;
            -moz-animation-delay: -.375s;
            -o-animation-delay: -.375s;
            animation-delay: -.375s;
        }

        .la-ball-spin-clockwise>div:nth-child(6) {
            top: 81.8198046966%;
            left: 18.1801949248%;
            -webkit-animation-delay: -.25s;
            -moz-animation-delay: -.25s;
            -o-animation-delay: -.25s;
            animation-delay: -.25s;
        }

        .la-ball-spin-clockwise>div:nth-child(7) {
            top: 49.9999750815%;
            left: 5.0000051215%;
            -webkit-animation-delay: -.125s;
            -moz-animation-delay: -.125s;
            -o-animation-delay: -.125s;
            animation-delay: -.125s;
        }

        .la-ball-spin-clockwise>div:nth-child(8) {
            top: 18.179464974%;
            left: 18.1803700518%;
            -webkit-animation-delay: 0s;
            -moz-animation-delay: 0s;
            -o-animation-delay: 0s;
            animation-delay: 0s;
        }

        .la-ball-spin-clockwise.la-sm {
            width: 16px;
            height: 16px;
        }

        .la-ball-spin-clockwise.la-sm>div {
            width: 4px;
            height: 4px;
            margin-top: -2px;
            margin-left: -2px;
        }

        .la-ball-spin-clockwise.la-2x {
            width: 64px;
            height: 64px;
        }

        .la-ball-spin-clockwise.la-2x>div {
            width: 16px;
            height: 16px;
            margin-top: -8px;
            margin-left: -8px;
        }

        .la-ball-spin-clockwise.la-3x {
            width: 96px;
            height: 96px;
        }

        .la-ball-spin-clockwise.la-3x>div {
            width: 24px;
            height: 24px;
            margin-top: -12px;
            margin-left: -12px;
        }

        /*
 * Animation
 */
        @-webkit-keyframes ball-spin-clockwise {

            0%,
            100% {
                opacity: 1;
                -webkit-transform: scale(1);
                transform: scale(1);
            }

            20% {
                opacity: 1;
            }

            80% {
                opacity: 0;
                -webkit-transform: scale(0);
                transform: scale(0);
            }
        }

        @-moz-keyframes ball-spin-clockwise {

            0%,
            100% {
                opacity: 1;
                -moz-transform: scale(1);
                transform: scale(1);
            }

            20% {
                opacity: 1;
            }

            80% {
                opacity: 0;
                -moz-transform: scale(0);
                transform: scale(0);
            }
        }

        @-o-keyframes ball-spin-clockwise {

            0%,
            100% {
                opacity: 1;
                -o-transform: scale(1);
                transform: scale(1);
            }

            20% {
                opacity: 1;
            }

            80% {
                opacity: 0;
                -o-transform: scale(0);
                transform: scale(0);
            }
        }

        @keyframes ball-spin-clockwise {

            0%,
            100% {
                opacity: 1;
                -webkit-transform: scale(1);
                -moz-transform: scale(1);
                -o-transform: scale(1);
                transform: scale(1);
            }

            20% {
                opacity: 1;
            }

            80% {
                opacity: 0;
                -webkit-transform: scale(0);
                -moz-transform: scale(0);
                -o-transform: scale(0);
                transform: scale(0);
            }
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
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <x-livewire-alert::scripts />
    <script type="text/javascript">
        Echo.channel('events')
            .listen('TaskCreate', (e) =>
                Livewire.emitTo('notification', 'refreshNotification')
            );
        Echo.channel('events')
            .listen('MentionComment', (e) =>
                Livewire.emitTo('notification', 'refreshNotification')
            );
    </script>
    <script type="text/javascript">
        // window.onbeforeunload = function() {
        //     return 'لطفا از ذخیره شدن داده های خود اطمینان حاصل کنید';
        // }
    </script>
</body>

</html>
