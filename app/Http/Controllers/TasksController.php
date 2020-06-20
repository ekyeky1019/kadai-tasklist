<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Task; //追加

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
        if (\Auth::check()) { // 認証済みの場合
            // 認証済みユーザを取得
            $user = \Auth::user();
            // task取得
            $tasks = $user->tasks()->orderBy('created_at', 'desc')->paginate(10);

            $data = [
                'user' => $user,
                'tasks' => $tasks,
            ];
        }

        // Welcomeビューでそれらを表示
        return view('welcome', $data);
    }
    

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $task = new Task;
        return view("tasks.create", [
            "task" => $task,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $this->validate($request, [
            "status" => "required|max:10",
            "content" => "required|max:255",
        ]);
        
        $request->user()->tasks()->create([
            "status" => $request->status,
            'content' => $request->content,
        ]);
        
        // 前のURLへリダイレクトさせる
        return redirect("/");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $task = \App\Task::findOrFail($id);
        
        if (\Auth::id() === $task->user_id) {
            return view("tasks.show", [
                "task" => $task,
            ]);
        }
        return redirect("/");
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $task = \App\Task::findOrFail($id);
        
        if (\Auth::id() === $task->user_id) {
            return view("tasks.edit", [
                "task" => $task,
            ]);
        }
        return redirect("/");
        
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
        //
        $this->validate($request, [
            "status" => "required|max:10",
            "content" => "required|max:255",
        ]);
        $task = \App\Task::findOrFail($id);
        
        if (\Auth::id() === $task->user_id) {
            $task->status = $request->status;
            $task->content = $request->content;
            $task->save();
        }
        
        return redirect("/");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $task = \App\Task::findOrFail($id);

        // 認証済みユーザがその投稿の所有者である場合は、投稿を削除
        if (\Auth::id() === $task->user_id) {
            $task->delete();
        }

        // 前のURLへリダイレクトさせる
        return redirect("/");
    }
}
