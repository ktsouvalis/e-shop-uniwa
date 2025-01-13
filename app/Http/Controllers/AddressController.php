<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Address;
use Illuminate\Support\Facades\Auth;

class AddressController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:addresses,name,NULL,id,user_id,' . Auth::id(),
            'address' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'zip' => 'required|string|max:255',
        ]);

        $fullAddress = $request->address . ', ' . $request->city . ', ' . $request->zip;

        Address::create([
            'user_id' => Auth::id(),
            'name' => $request->name,
            'address' => $fullAddress,
        ]);

        return redirect()->back()->with('success', 'Address added successfully');
    }
}
