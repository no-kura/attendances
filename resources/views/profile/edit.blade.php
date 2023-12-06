@extends('layouts.app')
@section('content')

    <div class="prose mx-auto text-center form-control my-4">
        <h2>ユーザー登録編集（{{ $user->name }}さん）</h2>
    </div>

{{--
    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>
--}}

{{-- ユーザー名・メルアド編集--}}
    <form method="post" action="{{ route('profile.update', $user->id) }}" class="mt-6 space-y-6 w-1/2">
        @csrf
        @method('put')

        <div>
            <x-input-label for="name" :value="__('ユーザー名')" />
            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $user->name)" required autofocus autocomplete="name" />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        <div>
            <x-input-label for="email" :value="__('メールアドレス')" />
            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $user->email)" required autocomplete="username" />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />

        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('登録情報更新') }}</x-primary-button>
{{--
            @if (session('status') === 'profile-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600"
                >{{ __('Saved.') }}</p>
            @endif
--}}
        </div>
    </form>
@endsection