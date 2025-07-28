<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;

class ErrorLayout extends Component
{
    public $title;
    public $subtitle;
    public $errorCode;
    public $description;
    public $errorGradient;
    public $particleGradient;
    public $buttonGradient;
    public $buttonShadow;
    public $customStyles;

    public function __construct(
        $title = null,
        $subtitle = null,
        $errorCode = '500',
        $description = null,
        $errorGradient = null,
        $particleGradient = null,
        $buttonGradient = null,
        $buttonShadow = null,
        $customStyles = null
    ) {
        $this->title = $title ?? 'Error';
        $this->subtitle = $subtitle ?? 'Something went wrong';
        $this->errorCode = $errorCode;
        $this->description = $description ?? 'An unexpected error occurred.';
        
        $this->setDefaultGradients($errorCode);
        
        $this->errorGradient = $errorGradient ?? $this->errorGradient;
        $this->particleGradient = $particleGradient ?? $this->particleGradient;
        $this->buttonGradient = $buttonGradient ?? $this->buttonGradient;
        $this->buttonShadow = $buttonShadow ?? $this->buttonShadow;
        $this->customStyles = $customStyles;
    }

    private function setDefaultGradients($errorCode)
    {
        switch ($errorCode) {
            case '404':
                $this->errorGradient = 'linear-gradient(135deg, #667eea 0%, #764ba2 100%)';
                $this->particleGradient = 'linear-gradient(45deg, #667eea, #764ba2)';
                $this->buttonGradient = 'linear-gradient(135deg, #667eea 0%, #764ba2 100%)';
                $this->buttonShadow = 'rgba(102, 126, 234, 0.3)';
                break;
            
            case '403':
                $this->errorGradient = 'linear-gradient(135deg, #f093fb 0%, #f5576c 100%)';
                $this->particleGradient = 'linear-gradient(45deg, #f093fb, #f5576c)';
                $this->buttonGradient = 'linear-gradient(135deg, #f093fb 0%, #f5576c 100%)';
                $this->buttonShadow = 'rgba(245, 87, 108, 0.3)';
                break;
            
            case '503':
                $this->errorGradient = 'linear-gradient(135deg, #ffecd2 0%, #fcb69f 100%)';
                $this->particleGradient = 'linear-gradient(45deg, #ffecd2, #fcb69f)';
                $this->buttonGradient = 'linear-gradient(135deg, #ffecd2 0%, #fcb69f 100%)';
                $this->buttonShadow = 'rgba(252, 182, 159, 0.3)';
                break;
            
            case '500':
            default:
                $this->errorGradient = 'linear-gradient(135deg, #ff6b6b 0%, #4ecdc4 100%)';
                $this->particleGradient = 'linear-gradient(45deg, #ff6b6b, #4ecdc4)';
                $this->buttonGradient = 'linear-gradient(135deg, #ff6b6b 0%, #4ecdc4 100%)';
                $this->buttonShadow = 'rgba(255, 107, 107, 0.3)';
                break;
        }
    }

    public function getFullTitle()
    {
        $siteName = setting('site_name', 'main', config('app.name'));
        return $this->title . ' - ' . $this->subtitle . ' | ' . $siteName;
    }

    public function with()
    {
        return [
            'title' => $this->title,
            'subtitle' => $this->subtitle,
            'errorCode' => $this->errorCode,
            'description' => $this->description,
            'errorGradient' => $this->errorGradient,
            'particleGradient' => $this->particleGradient,
            'buttonGradient' => $this->buttonGradient,
            'buttonShadow' => $this->buttonShadow,
            'customStyles' => $this->customStyles,
            'fullTitle' => $this->getFullTitle(),
        ];
    }

    public function render(): View
    {
        return view('errors.layout');
    }
}