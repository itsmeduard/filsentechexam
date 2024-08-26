<?php

namespace App\Http\Livewire\Task;

use App\Models\Task;
use Livewire\Component;
use Illuminate\Support\Facades\DB;

class Create extends Component
{
    public Task $task;

    public array $listsForFields = [];

    public function mount(Task $task)
    {
        $this->task = $task;
        $this->initListsForFields();
    }

    public function render()
    {
        return view('livewire.task.create');
    }

//    public function submit()
//    {
//        $this->validate();
//
//        $this->task->save();
//
//        return redirect()->route('admin.tasks.index');
//    }
    public function submit()
    {
        $this->validate();

        $taskData = [
            'title' => $this->task->title,
            'description' => $this->task->description,
            'status' => $this->task->status,
            // ... other fields
        ];

        DB::insert('INSERT INTO tasks (title, description, status) VALUES (?, ?, ?)', [
            $taskData['title'],
            $taskData['description'],
            $taskData['status'],
        ]);

        return redirect()->route('admin.tasks.index');
    }

    protected function rules(): array
    {
        return [
            'task.title' => [
                'string',
                'required',
            ],
            'task.description' => [
                'string',
                'nullable',
            ],
            'task.status' => [
                'nullable',
                'in:' . implode(',', array_keys($this->listsForFields['status'])),
            ],
        ];
    }

    protected function initListsForFields(): void
    {
        $this->listsForFields['status'] = $this->task::STATUS_SELECT;
    }
}
