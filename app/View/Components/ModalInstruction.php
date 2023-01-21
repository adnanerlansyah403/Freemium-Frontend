<?php

namespace App\View\Components;

use Illuminate\View\Component;

class ModalInstruction extends Component
{

    public $triggerModal;
    public $teks;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($triggerModal = null, $teks = null)
    {
        $this->triggerModal = $triggerModal;
        $this->teks = $teks;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.modal-instruction');
    }
}
