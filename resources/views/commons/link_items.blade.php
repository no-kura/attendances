@if (Auth::check())

     {{-- 勤怠表入力ページへのリンク --}}
    <li><a class="link link-hover" href="{{ route('login') }}">ホーム</a></li>

    {{-- 勤怠表入力ページへのリンク --}}
    <li><a class="link link-hover" href="{{ route('attendances.index') }}">勤怠入力</a></li>
    
     {{-- 勤怠一覧ページへのリンク --}}
    <li><a class="link link-hover " href="{{ route('summarys.index') }}">勤怠一覧</a></li>
    
     {{-- ユーザ一覧ページへのリンク --}}
    <li><a class="link link-hover" href="{{ route('users.index') }}">ユーザー一覧</a></li>
  
    {{-- ログアウトへのリンク --}}
    <li><a class="link link-hover" href="#" onclick="event.preventDefault();this.closest('form').submit();">Logout</a></li>
@else
    {{-- ログインページへのリンク --}}
    <li><a class="link link-hover" href="{{ route('login') }}">Login</a></li>
@endif
