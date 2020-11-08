<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TasklistsController extends Controller
{
    public function index()
    {
        $data = [];
        if (\Auth::check()) {
            
            $user = \Auth::user();
            $tasklists = $user->tasklists()->orderBy('created_at', 'desc')->paginate(10);
            
            $data = [
                'user' => $user,
                'tasklists' => $tasklists,
                ];
        }
        
        return view('welcome', $data);
    }
    
    public function store(Request $request)
    {
        // バリデーション
        $request->validate([
            'content' => 'require|max:255',
            ]);
        // 認証済みユーザ（閲覧者）のタスクとして作成（リクエストされた値をもとに作成）
        $request->user()->tasklists()->create([
            'content'=> $request->content,
            ]);
            
        // 前のURLへリダイレクトさせる
        return back();
    }
    
    public function destroy($id)
    {
        // idの値でタスクを検索して取得
        $tasklist = \App\Tasklist::findOrFail($id);
        
        // 認証済みユーザ（閲覧者）がそのタスクの所有者である場合は、投稿を削除
        if (\Auth::id() === $tasklist->user_id) {
            $tasklist->delete();
        }
        
        // 前のURLへリダイレクトさせる
        return back();
    }
    
}
