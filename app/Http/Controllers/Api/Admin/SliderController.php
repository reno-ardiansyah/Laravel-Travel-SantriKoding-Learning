<?php

namespace App\Http\Controllers\Api\Admin;

use App\Models\Slider;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\SliderResource;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class SliderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //get sliders
        $sliders = Slider::latest()->paginate(5);

        //return with Api Resource
        return new SliderResource(true, 'List Data Sliders', $sliders);
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
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'image'    => 'required|image|mimes:jpeg,jpg,png|max:2000',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        //upload image
        $image = $request->file('image');
        $image->storeAs('public/sliders', $image->hashName());

        //create slider
        $slider = Slider::create([
            'image' => $image->hashName(),
            'user_id'   => auth()->guard('api')->user()->id,
        ]);

        if ($slider) {
            //return success with Api Resource
            return new SliderResource(true, 'Data Slider Berhasil Disimpan!', $slider);
        }

        //return failed with Api Resource
        return new SliderResource(false, 'Data Slider Gagal Disimpan!', null);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Slider $slider)
    {
        //remove image
        Storage::disk('local')->delete('public/sliders/' . basename($slider->image));

        if ($slider->delete()) {
            //return success with Api Resource
            return new SliderResource(true, 'Data Slider Berhasil Dihapus!', null);
        }

        //return failed with Api Resource
        return new SliderResource(false, 'Data Slider Gagal Dihapus!', null);
    }
}
