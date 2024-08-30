<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use Illuminate\Http\Request;

class DoctorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Doctor::with(['branch', 'department', 'user'])->get();
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

        $doctor = Doctor::create($request->all());
        if ($request->hasFile('image')) {
            $doctor->addMediaFromRequest('image')->toMediaCollection('doctor-image', 'media')->getUrl();
        }
        $doctor->load('media');
        return response()->json(['message' => 'تم إضافة الطبيب بنجاح.'], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(Doctor $doctor)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Doctor $doctor)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Doctor $doctor)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Doctor::destroy($id);
        $doctors = Doctor::all();
        return response()->json(['message' => 'تم حذف الطبيب بنجاح.', 'doctors' => $doctors], 200);
    }
}
