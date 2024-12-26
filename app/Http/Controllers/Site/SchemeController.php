<?php

namespace App\Http\Controllers\Site;

use App\Models\Scheme;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SchemeController extends Controller
{
    public function index(Request $request)
    {
        $validated = $request->validate([
            'search' => 'nullable|string|max:255',
            'scheme_code' => 'nullable|string|max:255',
            'adp_number' => 'nullable',
            'year' => 'nullable|integer',
        ]);

        $schemes = Scheme::when($request->query('search'), function ($query, $search) {
            $query->where(function ($q) use ($search) {
                $q->where('scheme_name', 'like', "%$search%")
                    ->orWhere('sector_name', 'like', "%$search%")
                    ->orWhere('scheme_code', 'like', "%$search%");
                });
            })
            ->when($request->query('scheme_code'), function ($query, $scheme_code) {
                $query->where('scheme_code', 'like', "%$scheme_code%");
            })
            ->when($request->query('adp_number'), function ($query, $adp_number) {
                $query->where('adp_number', 'like', "%$adp_number%");
            })
            ->when($request->query('year'), function ($query, $year) {
                $query->where('year', '=', $year);
            })
            ->paginate(10);

        return view('site.schemes.index', compact('schemes'));
    }

    public function show($slug)
    {
        $scheme = Scheme::where('uuid', $slug)->firstOrFail();

        return view('site.schemes.show', compact('scheme'));
    }
}
