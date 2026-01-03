<?php

namespace App\Http\Livewire\Beautifier;

use Livewire\Component;

class Html extends Component
{
    public function render()
    {
        return view('livewire.beautifier.html')->extends('layouts.apps', ['title' => 'Beautifier HTML']);
    }
}
