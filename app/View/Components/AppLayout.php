<?php

namespace App\View\Components;

use Illuminate\View\Component;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AppLayout extends Component
{
    /**
     * Get the view / contents that represents the component.
     *
     * @return \Illuminate\View\View
     */
    public function render()
    {
        $user = User::where('id', Auth::user()->id)->get();
        
        return view('layouts.app', compact('user'));
    }
}
