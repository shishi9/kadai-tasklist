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
    public function index()
    {
        $data = [];
        if (\Auth::check()) {
            // 認証済みの場合、認証済みユーザを取得
            $user = \Auth::user();
            // ユーザの投稿位置らを作成日時の降順で取得
            $tasks = $user->tasks()->orderBy('created_at', 'desc')->paginate(10);

    //  DD($tasks);
    
            $data = [
                'user' => $user,
                'tasks' => $tasks,
                ];
        }
            return view('welcome',$data);
        // メッセージ一覧を取得
        // $tasks = Task::all();

        // メッセージ一覧ビューでそれを表示
        // return view('tasks.index', [
        //     'tasks' => $tasks,
        // ]);
     }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        if (\Auth::check()) {
            $task = new Task;
    
            // メッセージ作成ビューを表示
            return view('tasks.create', [
                'task' => $task,
            ]);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //バリデーション
        $this->validate($request,[
            'status' => 'required|max:10',
            'content' => 'required|max:255'
            ]);

        // DD($request);
        
        // $task = Task::findOrFail($id);

        // if (\Auth::id() === $task->user_id) {
    
            // $task = new Task;
            // $task->status = $request->status;
            // $task->content = $request->content;
            // $task->save();
            
            $request->user()->tasks()->create([
                'status' => $request->status,
                'content' => $request->content,
                ]);
            return redirect('/');
        // } else {
        //     return view('welcome');
        // }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        $task = Task::findOrFail($id);

        if (\Auth::id() === $task->user_id) {
    
            return view('tasks.show',[
                'task' => $task,
                ]);
        } else {
             return redirect('/');
             
            // return view('welcome', [
            //     'tasks' => [],
            // ]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $task= Task::findOrFail($id);

        if (\Auth::id() === $task->user_id) {
            
            return view('tasks.edit',[
                'task' => $task,
                ]);
        } else {
            return view('welcome');
        }        
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //バリデーション
        $this->validate($request,[
            'status' => 'required|max:10',
            'content' => 'required|max:255',
            ]);
    
        $task = Task::findOrFail($id);

        if (\Auth::id() === $task->user_id) {
    
            $task->status = $request->status;
            $task->content = $request->content;
            $task->save();
            return redirect('/');
        } else {
            return view('welcome');
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $task = Task::findOrFail($id);

        if (\Auth::id() === $task->user_id) {
            $task->delete();
            return redirect('/');
        } else {
            return view('welcome');
        }
    }
}
