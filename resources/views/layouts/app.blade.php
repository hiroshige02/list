<!DOCTYPE html>
<html lang="{{ config('app.locale','ja') }}">
    <head>
        <meta charset="UTF-8">
        {{--
            <link href="{{ mix('/css/app.css') }}" rel="stylesheet">
        mix-manifest.json内のパスが/public/css/app.cssに変更できるまで不使用
            --}}
            <link rel="stylesheet" href="/public/css/app.css">
            <link rel="stylesheet" href="/public/css/make.css">
            {{-- icon導入のため --}}
            <link href="https://cdn.jsdelivr.net/npm/@mdi/font@5.x/css/materialdesignicons.min.css" rel="stylesheet">
            <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ $title }}</title>
    </head>

    <body>
        <div class="body-container">
            <div class="title-container">
                <h1>{{ $title }}</h1>
            </div>
            {{-- ログイン画面のリンク --}}

            <div class="login-icon">
                <a href="/login">
                    <img class="login-link" src="/storage/app/public/img/display/login.jpg">
                </a>
            </div>

            @yield('contents')

            <div style="width:70px; height:70px;">
            </div>
        </div>

        <script src="/public/js/app.js"></script>
        <script src="/public/js/maintenance.js"></script>
    </body>
</html>


