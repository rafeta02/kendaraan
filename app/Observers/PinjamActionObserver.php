<?php

namespace App\Observers;

use App\Models\Pinjam;
use App\Notifications\DataChangeEmailNotification;
use Illuminate\Support\Facades\Notification;

class PinjamActionObserver
{
    public function created(Pinjam $model)
    {
        $data  = ['action' => 'created', 'model_name' => 'Pinjam'];
        $users = \App\Models\User::whereHas('roles', function ($q) { return $q->where('title', 'Admin'); })->get();
        Notification::send($users, new DataChangeEmailNotification($data));
    }

    public function updated(Pinjam $model)
    {
        $data  = ['action' => 'updated', 'model_name' => 'Pinjam'];
        $users = \App\Models\User::whereHas('roles', function ($q) { return $q->where('title', 'Admin'); })->get();
        Notification::send($users, new DataChangeEmailNotification($data));
    }
}
