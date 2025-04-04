<?php

namespace App\Http\Controllers;

use App\Models\Apartment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class ApartmentController extends Controller
{
    public function store(Request $request)
    {
        try {
                // Validáció
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'type_id' => 'required|integer|exists:apartment_types,id', // 🔹 Ellenőrizzük az id-t
                'max_capacity' => 'required|integer|min:1',
                'description' => 'nullable|string',
                'price_per_night' => 'required|numeric|min:0',
            ]);

            $apartment = Apartment::create([
                'user_id' => Auth::id(),
                'name' => $validated['name'],
                'type_id' => $validated['type_id'], // Use the type_id directly, not type_name
                'max_capacity' => $validated['max_capacity'],
                'description' => $validated['description'] ?? null,
                'price_per_night' => $validated['price_per_night'],
            ]);

            return response()->json(['message' => 'Szállás sikeresen létrehozva!', 'apartment' => $apartment], 201);
        }
        
         catch (ValidationException $e) {
            return response()->json(['error' => 'Hiba történt a szállás létrehozása során.'], 500);
        }
    }
}
