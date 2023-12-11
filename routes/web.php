<?php

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Symfony\Component\HttpFoundation\Response;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/




Route::get('/', function () {
    return redirect()->route('tasks.index');
});

Route::get('/tasks', function ()  {
    return view("index", [
        "tasks"=> \App\Models\Task::latest()->paginate(10)
    ]);
})->name('tasks.index');

Route::view('/tasks/create', 'create')->name('task.create');

Route::get('/tasks/{task}', function(Task $task) {
   return view('show', ['task' => $task]);
})->name('tasks.show');

Route::get('/tasks/{task}/edit', function(Task $task){
    return view('edit', ['task' => $task]);
})->name('tasks.edit');

Route::post('/task', function(Request $request) {
   $data = $request->validate([
    'title'=> 'required|max:255',
    'description'=> 'required',
    'long_description'=> 'required',
   ]);

   $task = new Task;

   $task->title = $data['title'];
   $task->description = $data['description'];
   $task->long_description = $data['long_description'];

   $task->save();

    return redirect()->route('tasks.show', ['task' => $task->id])->with('success','Task created successfully!');
})->name('tasks.store');

Route::put('/task/{task}', function(Task $task, Request $request) {
    $data = $request->validate([
     'title'=> 'required|max:255',
     'description'=> 'required',
     'long_description'=> 'required',
    ]);

    $task = Task::findOrFail($id);

    $task->title = $data['title'];
    $task->description = $data['description'];
    $task->long_description = $data['long_description'];

    $task->save();

     return redirect()->route('tasks.show', ['id' => $task->id])->with('success','Task updated successfully!');
 })->name('tasks.update');

Route::delete('/tasks/{task}', function (Task $task) {
    $task->delete();

    return redirect()->route('tasks.index')->with('success', 'Task deleted successfully');
})->name('tasks.destroy');

Route::put('tasks/{task}/toggle-complete', function(Task $task){
    $task->toggleComplete();

    return redirect()->back()->with('success', 'Task updated succesfuly');
})->name('tasks.toggle-complete');

Route::fallBack(function () {
    return redirect()->route('tasks.index');
});
