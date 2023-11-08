@extends('layouts.app')

@section('content')
    <div class="prose hero bg-base-200 mx-auto max-w-full rounded">
        <div class="hero-content text-center my-10">
            <div class="max-w-md mb-10">
                <h1>勤怠管理表</h2>
                {{-- ユーザ登録ページへのリンク --}}
                <a class="btn btn-wide btn-outline btn-primary" href="{{ route('login') }}">ログイン</a>
            </div>
        </div>
    </div>
@endsection