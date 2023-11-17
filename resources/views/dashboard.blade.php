@extends('layouts.app')

@section('content')
    @if (Auth::check())
        <div class="prose hero bg-base-800 mx-auto max-w-full rounded text-left">
            <h2>ようこそ {{ Auth::user()->name }} さん</h2>
        </div>
        
      
        <div class="prose mx-auto text-center">
            {{-- 勤怠表入力ページへのリンク --}}
            <div class="form-control my-10">
                <span class="block">
                    <span><a class="btn btn-wide btn-outline btn-info" href="{{ route('attendances.index') }}">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 inline">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>

                    勤怠表入力</a>
                </span>
            </div>
                
            {{-- 勤怠一覧ページへのリンク --}}
            <div class="form-control my-10">
                <span class="block">
                    <span><a class="btn btn-wide btn-outline btn-success" href="{{ route('login') }}">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 inline">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 9h3.75M15 12h3.75M15 15h3.75M4.5 19.5h15a2.25 2.25 0 002.25-2.25V6.75A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25v10.5A2.25 2.25 0 004.5 19.5zm6-10.125a1.875 1.875 0 11-3.75 0 1.875 1.875 0 013.75 0zm1.294 6.336a6.721 6.721 0 01-3.17.789 6.721 6.721 0 01-3.168-.789 3.376 3.376 0 016.338 0z" />
                        </svg>

                    勤怠一覧</a>
                </span>
            </div>
                
            {{-- ユーザー一覧ページへのリンク --}}
            <div class="form-control my-10">
                <span class="block">
                    <span><a class="btn btn-wide btn-outline btn-error" href="{{ route('users.index') }}">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 inline">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" />
                        </svg>

                    ユーザー一覧</a>
                </span>
            </div>
                
        </div>
    @else
        <div class="prose hero bg-base-800 mx-auto max-w-full rounded">
            <div class="hero-content text-center my-10">
                <div class="max-w-md mb-10">
                    <h1>勤怠管理表</h1>
                    {{-- ユーザ登録ページへのリンク --}}
                    <a class="btn btn-wide btn-outline btn-primary" href="{{ route('login') }}">ログイン</a>
                </div>
            </div>
        </div>
    @endif
@endsection