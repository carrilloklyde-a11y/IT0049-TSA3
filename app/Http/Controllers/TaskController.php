<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class TaskController extends Controller
{
    public function today()
    {
        $tasks = Task::forToday()->chronological()->get();

        return view('today', compact('tasks'));
    }

    public function index()
    {
        // The full list deliberately has no date or status filter.
        $tasks = Task::chronological()->get();

        return view('tasks.index', compact('tasks'));
    }

    public function create(Request $request)
    {
        $returnTo = $request->query('from') === 'today' ? 'today' : 'tasks';

        return view('tasks.form', ['task' => new Task(['task_date' => today(), 'status' => 'pending']), 'returnTo' => $returnTo]);
    }

    public function store(Request $request)
    {
        Task::create($this->validatedTask($request));

        return redirect()->route($request->input('return_to') === 'today' ? 'today' : 'tasks.index')->with('success', 'A little progress starts here. Task added.');
    }

    public function edit(Request $request, Task $task)
    {
        return view('tasks.form', ['task' => $task, 'returnTo' => $request->query('from') === 'today' ? 'today' : 'tasks']);
    }

    public function update(Request $request, Task $task)
    {
        $task->update($this->validatedTask($request));

        return redirect()->route($request->input('return_to') === 'today' ? 'today' : 'tasks.index')->with('success', 'Task updated. You’re all set.');
    }

    public function status(Request $request, Task $task)
    {
        $data = $request->validate(['status' => ['required', Rule::in(['pending', 'completed'])], 'return_to' => ['nullable', Rule::in(['today', 'tasks'])]]);
        $task->update(['status' => $data['status']]);

        return redirect()->route(($data['return_to'] ?? '') === 'today' ? 'today' : 'tasks.index')->with('success', $data['status'] === 'completed' ? 'One more thing done. Nicely brewed!' : 'Task moved back to pending.');
    }

    public function destroy(Request $request, Task $task)
    {
        $request->validate(['return_to' => ['nullable', Rule::in(['today', 'tasks'])]]);
        $task->delete();

        return redirect()->route($request->input('return_to') === 'today' ? 'today' : 'tasks.index')->with('success', 'Task removed from your list.');
    }

    private function validatedTask(Request $request): array
    {
        if (is_string($request->input('title'))) {
            $request->merge(['title' => trim($request->input('title'))]);
        }

        return $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'task_date' => ['required', 'date_format:Y-m-d'],
            'status' => ['required', Rule::in(['pending', 'completed'])],
        ]);
    }
}
