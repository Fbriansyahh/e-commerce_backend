<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Address;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AddressController extends Controller
{
    public function index()
    {
        $addresses = Address::where('user_id', Auth::id())->get();
        return response()->json($addresses);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'province' => 'required|string|max:100',
            'city' => 'required|string|max:100',
            'district' => 'required|string|max:100',
            'postal_code' => 'required|string|max:10',
            'street_address' => 'required|string|max:255',
            'detail' => 'nullable|string',
        ]);

        $address = Address::create([
            'user_id' => Auth::id(),
            'name' => $request->name,
            'phone' => $request->phone,
            'province' => $request->province,
            'city' => $request->city,
            'district' => $request->district,
            'postal_code' => $request->postal_code,
            'street_address' => $request->street_address,
            'detail' => $request->detail,
        ]);

        return response()->json($address, 201);
    }

    public function update(Request $request, $id)
    {
        $address = Address::where('user_id', Auth::id())->findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'province' => 'required|string|max:100',
            'city' => 'required|string|max:100',
            'district' => 'required|string|max:100',
            'postal_code' => 'required|string|max:10',
            'street_address' => 'required|string|max:255',
            'detail' => 'nullable|string',
        ]);

        $address->update($request->all());

        return response()->json($address);
    }

    public function destroy($id)
    {
        $address = Address::where('user_id', Auth::id())->findOrFail($id);
        $address->delete();

        return response()->json(['message' => 'Address deleted']);
    }
}
