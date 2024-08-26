<?php

namespace App\Http\Livewire\User;

use App\Models\Role;
use App\Models\User;
use Livewire\Component;
use Illuminate\Support\Facades\DB;

class Edit extends Component
{
    public User $user;

    public array $roles = [];

    public string $password = '';

    public array $listsForFields = [];

    public function mount(User $user)
    {
        $this->user  = $user;
        $this->roles = $this->user->roles()->pluck('id')->toArray();
        $this->initListsForFields();
    }

    public function render()
    {
        return view('livewire.user.edit');
    }

//    public function submit()
//    {
//        $this->validate();
//        $this->user->password = $this->password;
//        $this->user->save();
//        $this->user->roles()->sync($this->roles);
//
//        return redirect()->route('admin.users.index');
//    }
    public function submit()
    {
        $this->validate();

        $hashedPassword = Hash::make($this->password);
        $userId = auth()->id();
        $roleIds = $this->roles;

        DB::update('UPDATE users SET password = ? WHERE id = ?', [
            $hashedPassword,
            $userId,
        ]);

        DB::table('role_user')->insert(
            $roleIds->map(function ($roleId) use ($userId) {
                return [
                    'user_id' => $userId,
                    'role_id' => $roleId,
                ];
            })->toArray()
        );

        DB::table('role_user')->where('user_id', $userId)
            ->whereNotIn('role_id', $roleIds)
            ->delete();

        return redirect()->route('admin.users.index');
    }

    protected function rules(): array
    {
        return [
            'user.name' => [
                'string',
                'required',
            ],
            'user.email' => [
                'email:rfc',
                'required',
                'unique:users,email,' . $this->user->id,
            ],
            'password' => [
                'string',
            ],
            'roles' => [
                'required',
                'array',
            ],
            'roles.*.id' => [
                'integer',
                'exists:roles,id',
            ],
            'user.locale' => [
                'string',
                'nullable',
            ],
        ];
    }

    protected function initListsForFields(): void
    {
        $this->listsForFields['roles'] = Role::pluck('title', 'id')->toArray();
    }
}
