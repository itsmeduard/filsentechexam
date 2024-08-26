<?php

namespace App\Http\Livewire\Role;

use App\Models\Permission;
use App\Models\Role;
use Livewire\Component;

class Edit extends Component
{
    public Role $role;

    public array $permissions = [];

    public array $listsForFields = [];

    public function mount(Role $role)
    {
        $this->role        = $role;
        $this->permissions = $this->role->permissions()->pluck('id')->toArray();
        $this->initListsForFields();
    }

    public function render()
    {
        return view('livewire.role.edit');
    }

//    public function submit()
//    {
//        $this->validate();
//
//        $this->role->save();
//        $this->role->permissions()->sync($this->permissions);
//
//        return redirect()->route('admin.roles.index');
//    }
    public function submit()
    {
        $this->validate();

        $roleId = $this->role->id;
        $updatedData = [
            'title' => $this->role->title,
            // ... other fields
        ];
        $permissionIds = $this->permissions;

        DB::update('UPDATE roles SET title = ? WHERE id = ?', [
            $updatedData['title'],
            $roleId,
        ]);

        DB::table('permission_role')->insert(
            $permissionIds->map(function ($permissionId) use ($roleId) {
                return [
                    'role_id' => $roleId,
                    'permission_id' => $permissionId,
                ];
            })->toArray()
        );

        DB::table('permission_role')->where('role_id', $roleId)
            ->whereNotIn('permission_id', $permissionIds)
            ->delete();

        return redirect()->route('admin.roles.index');
    }

    protected function rules(): array
    {
        return [
            'role.title' => [
                'string',
                'required',
            ],
            'permissions' => [
                'required',
                'array',
            ],
            'permissions.*.id' => [
                'integer',
                'exists:permissions,id',
            ],
        ];
    }

    protected function initListsForFields(): void
    {
        $this->listsForFields['permissions'] = Permission::pluck('title', 'id')->toArray();
    }
}
