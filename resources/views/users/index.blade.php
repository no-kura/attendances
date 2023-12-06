@extends('layouts.app')

@section('content')
    <div class="mx-auto w-full rounded text-left">
        <h1>ユーザー一覧</h1>
    </div>
    
        <div class="text-left">
            {{-- ユーザ登録ページへのリンク --}}
            <a class="btn btn-wide btn-outline btn-error" href="{{ route('register') }}">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 7.5v3m0 0v3m0-3h3m-3 0h-3m-2.25-4.125a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zM4 19.235v-.11a6.375 6.375 0 0112.75 0v.109A12.318 12.318 0 0110.374 21c-2.331 0-4.512-.645-6.374-1.766z" />
                </svg>
            新規ユーザー登録
            </a>
        </div>
            
    {{-- ページネーションのリンク --}}
    {{ $users->links('vendor.pagination.tailwind2') }}
    
    @if (isset($users))
        <table class="table1" width="100%">
            <thead>
                <tr class="table1">
                    <th>
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 inline">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                        </svg>
                        ID
                    </th>
                    
                    <th>
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 inline">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                        </svg>
                        ユーザー名
                    </th>
                    
                    <th>
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 inline">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75" />
                        </svg>
                        メールアドレス
                    </th>
        
                    <th>
                        編集
                    </th>
                    
                    <th>
                        削除
                    </th>
                    
                     <th>
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 inline">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" />
                        </svg>
                        一覧表示設定
                    </th>
                    
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                    <tr align="center">
                        <td>{{ $user->id }}</td>
                        
                        <td>{{ $user->name }}</td>
                        
                        <td>{{ $user->email }}</td>
                        
                        <td><a class="link link-hover text-info" href="{{ route('profile.edit', $user->id) }}"><button type="submit" class="btn btn-sm btn-primary btn-outline">編集</a></td>
                        
                        <form method="POST" action="{{ route('profile.destroy', $user->id) }}" class="my-2">
                            @csrf
                            @method('delete')
                            <td><button type="submit" class="btn btn-sm btn-primary btn-outline"
                                    onclick="return confirm('{{ $user->name }} さんを削除します。よろしいですか？')">削除</button></td>
                        </form>
                        
                        <td>@include('users.follow_button')</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
@endsection
  