<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User;
use App\Task;

class UsersController extends Controller
{
    public function index()
    {
        //ユーザ一覧をidの降順で取得
        $users = User::orderBy('id', 'desc')->paginate(10);
        
        //ユーザ一覧ビューでそれを表示
        return view('users.index', [
            'users' => $users,
            ]);
    }
    
    public function show($id)
    {
        // idの値でタスクを検索して取得
        $task = Task::findOrFail($id);
        
        // ユーザ詳細ビューでそれを表示
        return view('tasks.show', [
            'task' => $task,
        ]);
    }
}
