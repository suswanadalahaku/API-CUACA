<?php

namespace App\Http\Controllers;

use App\Models\FavoriteLocation;
use Illuminate\Http\Request;

class FavoriteLocationController extends Controller
{
    public function index()
    {
        $locations = FavoriteLocation::all();
        return view('index', compact('locations'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'country' => 'nullable|string|max:255',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'notes' => 'nullable|string'
        ]);

        FavoriteLocation::create($validated);

        return redirect()->back()->with('success', 'Location added successfully!');
    }

    public function update(Request $request, FavoriteLocation $location)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'country' => 'nullable|string|max:255',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'notes' => 'nullable|string'
        ]);

        $location->update($validated);

        return redirect()->back()->with('success', 'Location updated successfully!');
    }

    public function destroy(FavoriteLocation $location)
    {
        $location->delete();
        return redirect()->back()->with('success', 'Location deleted successfully!');
    }
}