<?php

declare(strict_types=1);

namespace Zekini\Generics\Components;

use Livewire\Component;

class GenericsRealtimeNotification extends Component
{
    public $notifications;

    // protected $listeners = [
    //     'realtimenotification'=> 'setNotifications'
    // ];

    public function mount()
    {
        $this->notifications = auth()->user()->unreadNotifications;

        $this->setNotifications();
    }

    public function setNotifications()
    {
        $this->notifications = auth()->user()->unreadNotifications;
    }

    public function render()
    {
        return view('zekini/laravel-generics::livewire-realtime-notif');
    }

    public function clearNotifications()
    {
        auth()->user()->notifications()->delete();

        $this->setNotifications();
    }

    
}