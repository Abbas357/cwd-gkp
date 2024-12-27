<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;

abstract class Controller
{
    public function slug(string $title): string {
        $new_title = implode(' ', array_slice(explode(' ', $title), 0, 5));
        return Str::slug($new_title) . '-' . substr(uniqid('', true), -6) . '-' . date('Y-m-d');
    }
}
