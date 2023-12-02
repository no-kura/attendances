<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;                        // 追加
use App\Models\User;                                        // 追加
use Illuminate\Pagination\Paginator;

use Illuminate\Support\Facades\DB;
use Carbon\Carbon;


class UsersController extends Controller
{
    public function index()                                 // 追加       
    {                                                       // 追加
        // ユーザ一覧をidの昇順で取得
        $users = User::orderBy('id', 'asc')->paginate(5);

        // ユーザ一覧ビューでそれを表示
        return view('users.index', [                        // 追加
            'users' => $users,                              // 追加
        ]);                                                 // 追加
    }                                                       // 追加
    
    
    public function following($id)
    {
        $data = [];
        // idの値でユーザを検索して取得
        $user = User::findOrFail($id);

        // 関係するモデルの件数をロード
        $user->loadRelationshipCounts();

        // ユーザのフォロー一覧を取得
        $followings = $user->followings();
        
        // dd($date);
        $data = [
            'user' => $user,
            'followings' => $followings,
            ]; 
            
    
        // attendancesビューでそれらを表示
        // return view('attendances.summarys', $data);
       
        return view('attendances.summarys', [
            'user' => $user,
            'users' => $followings,
        ]);
    }
}
