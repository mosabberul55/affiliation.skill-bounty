<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSliderRequest;
use App\Http\Requests\UpdateSliderRequest;
use App\Http\Resources\SliderResource;
use App\Models\Slider;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class SliderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sliders = Slider::latest()->get(['id', 'title', 'image']);

        return Inertia::render('Sliders', [
            'sliders' => $sliders
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSliderRequest $request)
    {
        $slider = Slider::create([
            'image' => $request->file('image')->store('sliders', 'public'),
        ]);

        return response()->json([
            'status' => 'success',
            'successMessage' => 'Slider created successfully',
            'slider' => $slider
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Slider $slider)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Slider $slider)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSliderRequest $request, Slider $slider)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Slider $slider)
    {
        //unlink the image
        $image = explode('/', $slider->image);
        $imageRelativePath = end($image);
        Storage::disk('public')->delete('sliders/' . $imageRelativePath);
        $slider->delete();
        return response()->json([
            'status' => 'success',
            'successMessage' => 'Slider deleted successfully',
            'slider' => $slider
        ]);
    }
}
