<?php

namespace App\View\Components;

use Illuminate\View\Component;

class LinkButton extends Component
{
    public $type;
    public $href;

    /**
     * Create a new component instance.
     *
     * @param string $type (primary, secondary, danger)
     * @param string $href
     * @return void
     */
    public function __construct($type = 'primary', $href = '#')
    {
        $this->type = $type;
        $this->href = $href;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.link-button');
    }
}