<?php

namespace App\Http\Controllers;

use App\Models\Bien;
use Illuminate\Http\Request;

class BienController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $biens = Bien::with('scategories')->get();
        return $biens;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'prix' => 'required|numeric',
            'nombre_chambres' => 'required|integer',
            'surface' => 'required|numeric',
            'ville' => 'required|string',
            'adresse' => 'required|string',
            'code_postal' => 'required|string',
            'imagebien' => 'required|string',
            'type' => 'required|string',
            'scategorieID' => 'required|exists:sous_categorie_biens,id', // Assure que l'ID de la sous-catégorie existe dans la table correspondante
        ]);

        $bien = Bien::create($validatedData);
        return response()->json($bien, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $bien = Bien::find($id);
        return response()->json($bien);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Bien $bien)
    {
        $validatedData = $request->validate([
            'prix' => 'required|numeric',
            'nombre_chambres' => 'required|integer',
            'surface' => 'required|numeric',
            'ville' => 'required|string',
            'adresse' => 'required|string',
            'code_postal' => 'required|string',
            'imagebien' => 'required|string',
            'type' => 'required|string',
            'scategorieID' => 'required|exists:sous_categorie_biens,id', //
        ]);

        $bien->update($validatedData);
        return response()->json($bien, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $bien = Bien::find($id);
        $bien->delete();
        return response()->json('bien supprimé !');
    }
}
