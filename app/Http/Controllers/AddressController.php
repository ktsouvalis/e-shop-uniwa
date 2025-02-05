<?php

namespace App\Http\Controllers;

use App\Models\Address;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
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
        try{
            $address = Address::create([
                'user_id' => Auth::id(),
                'name' => $request->name,
                'address' => $fullAddress,
            ]);
        } catch (\Exception $e) {
            Log::error(Auth::user()->id.' '.$e->getMessage());
            return redirect()->back()->with('failure', 'Προέκυψε σφάλμα, επικοινωνήστε με τον διαχειριστή!');
        }

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

        try{
            $address->update([
                'name' => $request->name,
                'address' => $fullAddress,
            ]);
        }
        catch (\Exception $e) {
            Log::error(Auth::user()->id.' '.$e->getMessage());
            return redirect()->back()->with('failure', 'Προέκυψε σφάλμα, επικοινωνήστε με τον διαχειριστή!');
        }

        return redirect()->route('profile')->with('success', 'Η διεύθυνση ενημερώθηκε!');
    }

    public function destroy(Address $address)
    {
        try{
            $address->delete();
        }
        catch (\Exception $e) {
            Log::error(Auth::user()->id.' '.$e->getMessage());
            return redirect()->back()->with('failure', 'Προέκυψε σφάλμα, επικοινωνήστε με τον διαχειριστή!');
        }
        return redirect()->back()->with('success', 'Η διεύθυνση διαγράφτηκε!');
    }
}
