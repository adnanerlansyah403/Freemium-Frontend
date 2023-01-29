<?php

namespace App\Http\Livewire\User;

use Livewire\Component;

class EditArticle extends Component
{
    public $editing_process = false;
    public function render()
    {
        return view('livewire.user.edit-article');
    }
}
