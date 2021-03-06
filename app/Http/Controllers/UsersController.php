<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User;   //追加

class UsersController extends Controller
{
    public function index()
    {
        // ユーザ一覧をIDの降順で取得
        $users = User::orderBy('id','desc')->paginate(10);
        
        return view('users.index', [
            'users' => $users,
            ]);
    }

    public function show($id)
    {
        // id の値でユーザを検索して取得
        $user = User::findOrFail($id);
        
        // 関係するモデルの件数をロード
        $user->loadRelationshipCounts();
        
        $tasks = $user->tasks()->orderBy('created_at', 'desc')->paginate(10);

        // ユーザ詳細ビューでそれらを表示
        return view('users.show', [
            'user' => $user,
            'microposts' => $microposts,
        ]);
    }
    
}
