<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Table extends Component
{
    public $headers;
    public $rows;
    public $actions;

    /**
     * Create a new component instance.
     */
    public function __construct($headers = [], $rows = [], $actions = null)
    {
        $this->headers = $headers;
        $this->rows = $rows;
        $this->actions = $actions;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.table');
    }
}
