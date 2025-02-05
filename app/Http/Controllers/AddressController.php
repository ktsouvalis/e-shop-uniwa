<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Address;
use Illuminate\Support\Facades\Auth;

class AddressController extends Controller
{
    public function store(Request $request)
    {
        $validation = $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'zip' => 'required|string|max:255',
        ]);
        if(!$validation){
            return redirect()->back()->with('failure', $validation->errors()->first());
        }
        $fullAddress = $request->address . ', ' . $request->city . ', ' . $request->zip;

        Address::create([
            'user_id' => Auth::id(),
            'name' => $request->name,
            'address' => $fullAddress,
        ]);

        return redirect()->back()->with('success', 'Η διεύθυνση προστέθηκε!');
    }

    public function edit(Address $address)
    {
        return view('edit-address', ['address' => $address]);
    }

    public function update(Request $request, Address $address)
    {
        $validation = $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'zip' => 'required|string|max:255',
        ]);
        if(!$validation){
            return redirect()->back()->with('failure', $validation->errors()->first());
        }
        $fullAddress = $request->address . ', ' . $request->city . ', ' . $request->zip;

        $address->update([
            'name' => $request->name,
            'address' => $fullAddress,
        ]);

        return redirect()->route('profile')->with('success', 'Η διεύθυνση ενημερώθηκε!');
    }

    public function destroy(Address $address)
    {
        $address->delete();

        return redirect()->back()->with('success', 'Η διεύθυνση διαγράφτηκε!');
    }
}
