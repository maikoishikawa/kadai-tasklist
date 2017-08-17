<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

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
        /*$tasks = Task::all();
        
        return view('tasks.index', [ //どのviewファイルで表示するか
                'tasks' => $tasks, //viewに渡す時の名前→$tasksになる
            ]);*/
        
        $data = [];
        if(\Auth::check()){
            $user = \Auth::user();
            $tasks = $user->tasks()->orderBy('created_at', 'desc')->paginate(10);
            $data = [
                'tasks' => $tasks,
                ];
        }
        return view('tasks.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $task = new Task;
        
        return view('tasks.create',[
                'task' => $task,
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

        $this->validate($request,[
                'status' => 'required|max:10',
                'content' => 'required|max:255',
            ]);

        $task = new Task;
        $task->status = $request->status;
        // $request から content を取り出して、新規作成したタスクに代入し保存
        $task->content = $request->content;
        $task->user_id = \Auth::user()->id;
        $task->save();
        
        return redirect('/');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $task = Task::find($id);
        
        if (\Auth::user()->id === $task->user_id ) {
        return view('tasks.show', [
                'task' => $task,
            ]);
        }
        return redirect()->back();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $task = Task::find($id);

        if (\Auth::user()->id === $task->user_id ) {
            return view('tasks.edit',[
                    'task' => $task,
                ]);
        }
        return redirect()->back();
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
        $this->validate($request,[
                'status' => 'required|max:10',
                'content' => 'required|max:255',
            ]);

        $task = Task::find($id);
        
        if (\Auth::user()->id === $task->user_id ) {
            $task->status = $request->status;
            $task->content = $request->content;
            $task->save();
        }
        return redirect('/');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $task = Task::find($id);
        
        if (\Auth::user()->id === $task->user_id ) {
        $task->delete();
        }
        return redirect('/');
    }
}
