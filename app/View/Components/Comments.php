<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Comments extends Component
{
    public $comments;
    public $modelType;
    public $modelId;

    public function __construct($comments, $modelType, $modelId)
    {
        $this->comments = $comments;
        $this->modelType = $modelType;
        $this->modelId = $modelId;
    }

    public function render()
    {
        return view('components.comments');
    }
}
