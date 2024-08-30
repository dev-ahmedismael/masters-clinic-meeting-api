<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\Department;
use App\Models\NavItems;
use Illuminate\Http\Request;

class NavItemsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $branches = Branch::all();
        $departments = Department::all();
        $response = [
            'branches' => $branches,
            'departments' => $departments
        ];

        return response()->json($response, 200);
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(NavItems $navItems)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(NavItems $navItems)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, NavItems $navItems)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(NavItems $navItems)
    {
        //
    }
}
