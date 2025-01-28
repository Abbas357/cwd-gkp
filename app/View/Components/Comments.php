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
    public $commentsAllowed;

    public function __construct($comments, $modelType, $modelId)
    {
        $this->comments = $comments;
        $this->modelType = $modelType;
        $this->modelId = $modelId;
        $this->commentsAllowed = $this->checkCommentsAllowed();
    }

    protected function checkCommentsAllowed()
    {
        $modelClass = 'App\\Models\\' . $this->modelType;
        
        if (!class_exists($modelClass)) {
            return false;
        }

        $model = $modelClass::find($this->modelId);

        if ($model && isset($model->comments_allowed)) {
            return $model->comments_allowed == 1;
        }

        return false;
    }

    public function render()
    {
        return view('components.comments');
    }
}
