<?php

namespace App\View\Components;

use App\Models\Product;
use Illuminate\View\Component;

class SectionProducts extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        $products = Product::query()->where([
            'published' => true,
        ])->orderBy('updated_at', 'desc')->paginate(8);

        return view('components.section-products', compact('products'));
    }
}
