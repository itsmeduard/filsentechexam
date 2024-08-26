<?php

namespace App\Http\Livewire\Role;

use App\Models\Permission;
use App\Models\Role;
use Livewire\Component;

class Create extends Component
{
    public Role $role;

    public array $permissions = [];

    public array $listsForFields = [];

    public function mount(Role $role)
    {
        $this->role = $role;
        $this->initListsForFields();
    }

    public function render()
    {
        return view('livewire.role.create');
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

        $roleData = [
            'title' => $this->role->title,
            // ... other fields
        ];
        $permissionIds = $this->permissions;

        DB::insert('INSERT INTO roles (title) VALUES (?)', [
            $roleData['title'],
        ]);

        $roleId = DB::getPdo()->lastInsertId(); // Get the ID of the newly inserted role

        DB::table('permission_role')->insert(
            $permissionIds->map(function ($permissionId) use ($roleId) {
                return [
                    'role_id' => $roleId,
                    'permission_id' => $permissionId,
                ];
            })->toArray()
        );

        // No need to delete existing role-permission associations for a new role

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
