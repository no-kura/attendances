<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="utf-8">
        <title>Attendances</title>
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link rel="stylesheet" href="{{ asset('css/style.css') }}">
        @vite('resources/css/app.css')
    </head>

    <body>
            {{-- ナビゲーションバー --}}
            @include('commons.navbar')
            
            {{-- エラーメッセージ --}}
            @include('commons.error_messages')

            @yield('content')
        
    </body>
</html>