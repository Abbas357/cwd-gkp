<?php

namespace App\Http\Controllers;

use App\Models\Posting;
use App\Http\Requests\StorePostingRequest;
use App\Http\Requests\UpdatePostingRequest;

class PostingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePostingRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Posting $posting)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Posting $posting)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePostingRequest $request, Posting $posting)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Posting $posting)
    {
        //
    }
}
