<?php

namespace App\Http\Controllers;

use App\Models\Equipment;
use Illuminate\Http\Request;

class EquipmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $equipments = \App\Models\Equipment::all();

        return response()->json([
            'status' => 'success',
            'data' => $equipments
        ], 200);
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
    $request->validate([
        'name' => 'required|string|max:255',
        'description' => 'required|string',
        'stock' => 'required|integer',
    ]);

    $equipment = \App\Models\Equipment::create($request->all());

    return response()->json([
        'success' => true,
        'message' => 'Data berhasil ditambahkan',
        'data' => $equipment
    ], 201);
}

    /**
     * Display the specified resource.
     */
    public function show(Equipment $equipment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Equipment $equipment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Equipment $equipment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
public function destroy(Equipment $equipment)
{
    // Menghapus data dari database Supabase
    $equipment->delete();

    return response()->json([
        'status' => 'success',
        'message' => 'Data peralatan berhasil dihapus'
    ], 200);
}
}
