<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ApiKey;
use Illuminate\Support\Facades\Auth;

class ApiKeyController extends Controller
{
    /**
     * Store a newly created API key.
     */
    public function store()
    {
        $apiKey = ApiKey::create([
            'user_id' => Auth::id(),
            'api_key' => bin2hex(random_bytes(32)), // Generates a random API key
        ]);

        return redirect()->back()->with('success', 'API key generated: ' . $apiKey->api_key);
    }

    /**
     * Remove the specified API key.
     */
    public function destroy($id)
    {
        $key = ApiKey::where('id', $id)->where('user_id', Auth::id())->first();

        if (!$key) {
            return response()->json(['message' => 'API key not found'], 404);
        }

        $key->delete();
        return response()->json(['message' => 'API key deleted successfully']);
    }
}