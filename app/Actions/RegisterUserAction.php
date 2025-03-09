<?php

namespace App\Actions;

use App\Models\Announcement;
use App\Models\Article;
use App\Models\User;
use DOMDocument;
use Illuminate\Support\Str;

class RegisterUserAction
{
    protected User $user;

    public function execute(User $user, array $data): User
    {
        $this->user = $user;
        $this->user->name = $data['name'];
        $this->user->email = $data['email'];
        $this->user->password = bcrypt($data['password']);
        $this->user->save();
        return $this->user->fresh();
    }


}
