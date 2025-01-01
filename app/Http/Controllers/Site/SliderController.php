<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Slider;

class SliderController extends Controller
{
    public function showSlider($slug)
    {
        $slider = Slider::where('slug', $slug)->with(['media'])->firstOrFail();

        $sliderData = [
            'id' => $slider->id,
            'title' => $slider->title,
            'description' => $slider->description,
            'published_at' => $slider->published_at,
            'views_count' => $slider->views_count,
            'published_by' => $slider->publishedBy->designation,
            'image' => [
                'medium' => $slider->getFirstMediaUrl('sliders', 'medium'),
                'large' => $slider->getFirstMediaUrl('sliders', 'large'),
                'original' => $slider->getFirstMediaUrl('sliders')
            ],
            'comments' => $slider->comments()->whereNull('parent_id')->with('replies')->get(),
        ];

        $this->incrementViews($slider);

        return view('site.sliders.show', compact('sliderData'));
    }
}
