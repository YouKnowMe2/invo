<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $tasks = Task::where('user_id',Auth::user()->id)->with('client')->latest();

        if( !empty($request->client_id)){
            $tasks = $tasks->where('client_id',$request->client_id);

        }

        if( !empty($request->price)){
            $tasks = $tasks->where('price','<=',$request->price);

        }
        if( !empty($request->status)){
            $tasks = $tasks->where('status',$request->status);

        }



        $tasks= $tasks->paginate(10)->withQueryString();

        $clients = Client::where('user_id',Auth::user()->id)->get();
        $prices = Task::where('user_id',Auth::user()->id)->get();
        return view('task.index',[
            'tasks' => $tasks,
            'clients' =>  $clients,
            'prices' => $prices
        ]);
    }

    public function infoValidate(Request $request){
        return $request->validate([
            'name'  => ['required', 'max:255', 'string'],
            'slug'  => ['required', 'max:255', 'string'],
            'price'  => ['required', 'integer'],
            'description'  => ['required', 'string'],
            'status'  => ['max:255', 'string'],
            'client_id'  => ['required', 'max:255','not_in:none'],
        ]);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('task.create')->with([
            'clients'  => Client::all()
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
        $this->infoValidate($request);

        Task::create([
            'name' => $request->name,
            'price' => $request->price,
            'slug' => $request->slug,
            'description'  => $request->description,
            'client_id'  => $request->client_id,
            'user_id'  => Auth::user()->id,
        ]);

        return redirect()->route('task.index')->with('success','Task has been created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function show(Task $task)
    {
        return view('task.show')->with([
           'task' => $task
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function edit(Task $task)
    {
        return view('task.edit',)->with([
            'task' => $task,
            'clients' => Client::all()
        ]);    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Task $task)
    {
        $this->infoValidate($request);
        $task = Task::findOrFail($task->id);

        $task->update([
            'name' => $request->name,
            'price' => $request->price,
            'slug' => $request->slug,
            'description'  => $request->description,
            'client_id'  => $request->client_id,

        ]);

        return redirect()->route('task.index')->with('success','Task has been updated successfully');

    }

    public function status(Task $task){

       $task->update([
           'status' => 'complete'
       ]);
       return back()->with('success','Task has been completed');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function destroy(Task $task)
    {
        $task->delete();
        return back()->with('success','Task has been deleted successfully');
    }


}
