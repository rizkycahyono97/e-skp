<?php

namespace App\View\Components\tables;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class tableShow extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        // public string $title,
        public array $fields = [],
    )
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.tables.table-show');
    }
}
