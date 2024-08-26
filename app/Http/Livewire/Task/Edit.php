<?php

namespace App\Http\Livewire\Task;

use App\Models\Task;
use Livewire\Component;
use Illuminate\Support\Facades\DB;

class Edit extends Component
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
        return view('livewire.task.edit');
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

        $taskId = $this->task->id;
        $updatedData = [
            'title' => $this->task->title,
            'description' => $this->task->description,
            'status' => $this->task->status,
            // ... other fields
        ];

        DB::update('UPDATE tasks SET title = ?, description = ?, status = ? WHERE id = ?', [
            $updatedData['title'],
            $updatedData['description'],
            $updatedData['status'],
            $taskId,
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
