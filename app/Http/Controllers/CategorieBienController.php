<?php

namespace App\Http\Controllers;

use App\Models\CategorieBien;
use Illuminate\Http\Request;

class CategorieBienController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = CategorieBien::all();
        return $categories;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $categorie = new CategorieBien([
            'nomcategorie' => $request->input('nomcategorie'),
            'imagecategorie' => $request->input('imagecategorie')
        ]);
        $categorie->save();
        return response()->json($categorie, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $categorie = CategorieBien::find($id);
        return response()->json($categorie);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $categorie = CategorieBien::find($id);
        $categorie->update($request->all());
        return response()->json($categorie, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $categorie = CategorieBien::find($id);
        $categorie->delete();
        return response()->json('Catégorie supprimée !');
    }
}
