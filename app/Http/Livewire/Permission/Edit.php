<?php

namespace App\Http\Livewire\Permission;

use App\Models\Permission;
use Livewire\Component;
use Illuminate\Support\Facades\DB;

class Edit extends Component
{
    public Permission $permission;

    public function mount(Permission $permission)
    {
        $this->permission = $permission;
    }

    public function render()
    {
        return view('livewire.permission.edit');
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
        $updatedData = [
            'title' => $this->permission->title,
            // ... other fields
        ];

        DB::update('UPDATE permissions SET title = ? WHERE id = ?', [
            $updatedData['title'],
            $permissionId,
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
