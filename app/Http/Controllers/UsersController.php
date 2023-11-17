<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;                        // 追加
use App\Models\User;                                        // 追加
use Illuminate\Pagination\Paginator;


class UsersController extends Controller
{
      public function index()                                 // 追加       
    {                                                       // 追加
        // ユーザ一覧をidの昇順で取得
        $users = User::orderBy('id', 'asc')->paginate(5);
    
        // 追加

        // ユーザ一覧ビューでそれを表示
        return view('users.index', [                        // 追加
            'users' => $users,                              // 追加
        ]);                                                 // 追加
    }                                                       // 追加
    
    public function show($id)                               // 追加
    {                                                       // 追加
    }                                                       // 追加
    
    
    
    
    
}
