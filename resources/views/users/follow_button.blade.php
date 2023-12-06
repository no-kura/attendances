
    @if (Auth::user()->is_following($user->id))
        {{-- アンフォローボタンのフォーム --}}
        <form method="POST" action="{{ route('user.unfollow', $user->id) }}">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-sm btn-error btn-outline" 
                onclick="return confirm('{{ $user->name }}さん の登録を解除します。よろしいですか？')">解除</button>
        </form>
    @else
        {{-- フォローボタンのフォーム --}}
        <form method="POST" action="{{ route('user.follow', $user->id) }}">
            @csrf
            <button type="submit" class="btn btn-sm btn-primary btn-outline">登録</button>
        </form>
    @endif

