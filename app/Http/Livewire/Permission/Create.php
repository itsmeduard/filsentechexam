<?php

namespace App\Http\Livewire\Permission;

use App\Models\Permission;
use Livewire\Component;
use Illuminate\Support\Facades\DB;

class Create extends Component
{
    public Permission $permission;

    public function mount(Permission $permission)
    {
        $this->permission = $permission;
    }

    public function render()
    {
        return view('livewire.permission.create');
    }

//    public function submit()
//    {
//        $this->validate();
//
//        $this->permission->save();
//
//        return redirect()->route('admin.permissions.index');
//    }
    public function submit()
    {
        $this->validate();

        $permissionId = $this->permission->id;
        $permissionData = [
            'title' => $this->permission->title,
            // ... other fields
        ];

        DB::insert('INSERT INTO permissions (title) VALUES (?)', [
            $permissionData['title'],
        ]);

        return redirect()->route('admin.permissions.index');
    }

    protected function rules(): array
    {
        return [
            'permission.title' => [
                'string',
                'required',
            ],
        ];
    }
}
