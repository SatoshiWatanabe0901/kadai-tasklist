<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Task;

class TasksController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    
    // getでtasks/にアクセスされた場合の「一覧表示処理」
    public function index()
    {
        $data = [];
        if (\Auth::check()) { //認証済みの場合
            // 認証済みユーザを取得
            $user = \Auth::user();
            // タスクの一覧を取得
            $tasks = Task::all();

            // タスクの一覧を作成日時の降順で取得
            $tasks = Task::orderBy('id', 'desc')->paginate(5);

            $data = [
                'user' => $user,
                'tasks' => $tasks,
                ];
        }
        
        // Welcomeビューでそれらを標準
        return view('welcome', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    //  getでtasks/createにアクセスされた場合の「新規登録画面表示処理」
    public function create()
    {
        $task = new Task;
        
        //タスク作成ビューを表示
        return view('tasks.create', [
            'task' => $task,    
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    //  postでtasks/にアクセスされた場合の「新規登録処理」
    public function store(Request $request)
    {
        // バリデーション
        $request->validate([
            'status' => 'required|max:10',
            'content' => 'required|max:255',
            ]);
        
        //認証済ユーザ（閲覧者）のタスクとして作成（リクエストされた値をもとに作成）
        $request->user()->tasks()->create([
            'content' => $request->content,
            'status' => $request->status,
        ]);
        
        // 前のURLへリダイレクトさせる
        return  redirect('/');
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    //  getでtasks/(任意のid)にアクセスされた場合の「取得表示処理」
    public function show($id)
    {
        // 認証済みユーザを取得
        $user = \Auth::user();
        
        //idの値でタスクを検索して取得
        $task = Task::findOrFail($id);
        
        // 関係するモデルの件数をロード
        $user->loadRelationshipCounts();
        
        // ユーザのタスク一覧を作成日時の降順で取得
        $tasks = $user->tasks()->orderBy('created_at', 'desc')->paginate(10);
        
        
          // 認証済ユーザ（閲覧社）がそのタスクの所有者である場合は、タスクを削除
        if(\Auth::id() === $task->user_id) {
        
        // タスク詳細ビューでそれを表示
        return view('tasks.show',[
            'user'=>$user,
            'task'=>$task,
        ]);
        }
        // 前のURLへリダイレクトさせる
        return back();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    //  getでtasks/(任意のid)/editにアクセスされた場合の「更新画面表示処理」
    public function edit($id)
    {
        //idの値でメッセージを検索して取得
        $task = Task::findOrFail($id);
        
        // メッセージ編集ビューでそれを表示
        return view('tasks.edit', [
            'task' => $task,
            ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    //  putまたはpatchでtaks/(任意のid)にアクセスされた場合の「更新処理」
    public function update(Request $request, $id)
    {
        // バリデーション
        $request->validate([
            'status' => 'required|max:10',
            'content' => 'required|max:255',
            ]);
        
        //idの値でタスクを検索して取得
        $task = Task::findOrFail($id);
        
        // 認証済ユーザ（閲覧社）がそのタスクの所有者である場合は、タスクを削除
        if(\Auth::id() === $task->user_id) {
        // タスクを更新
        $task->status = $request->status;
        $task->content = $request->content;
        $task->save();
         
        }
        
        // トップページへリダイレクトさせる
        return redirect('/');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    //  deleteでtasks/(任意のid)にアクセスされた場合の「削除処理」
    public function destroy($id)
    {
        //idの値でタスクを検索して取得
        $task = Task::findOrFail($id);
        
        // 認証済ユーザ（閲覧社）がそのタスクの所有者である場合は、タスクを削除
        if(\Auth::id() === $task->user_id) {
            $task->delete();
        }
        // 前のURLへリダイレクトさせる
        return redirect('/');
        
    }
}
