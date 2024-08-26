<?php

namespace App\Http\Livewire\User;

use App\Models\Role;
use App\Models\User;
use Livewire\Component;

class Create extends Component
{
    public User $user;

    public array $roles = [];

    public string $password = '';

    public array $listsForFields = [];

    public function mount(User $user)
    {
        $this->user = $user;
        $this->initListsForFields();
    }

    public function render()
    {
        return view('livewire.user.create');
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
    use Illuminate\Support\Facades\DB;

    public function submit()
    {
        $this->validate();

        $hashedPassword = Hash::make($this->password);
        $userId = auth()->id();
        $roleIds = $this->roles;

        DB::insert('INSERT INTO users (password) VALUES (?) WHERE id = ?', [
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
                'unique:users,email',
            ],
            'password' => [
                'string',
                'required',
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
