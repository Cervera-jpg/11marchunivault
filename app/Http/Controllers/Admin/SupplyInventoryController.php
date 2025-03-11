<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SuppliesInventory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class SupplyInventoryController extends Controller
{
    public function create()
    {
        $units = [
            'Box', 'Piece', 'Pack', 'Ream', 'Roll', 'Bottle', 
            'Cartridges', 'Gallon', 'Litre', 'Meter', 'Pound', 'Sheet'
        ];
        
        return view('Admin.stock.supplyinventory', compact('units'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'product_name' => 'required|string|max:255',
            'quantity' => 'required|integer|min:0',
            'unit_type' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        try {
            $supply = new SuppliesInventory();
            $supply->control_code = 'SUP-' . strtoupper(Str::random(8));
            $supply->product_name = $validated['product_name'];
            $supply->quantity = $validated['quantity'];
            $supply->unit_type = $validated['unit_type'];

            if ($request->hasFile('image')) {
                $path = $request->file('image')->store('supplies', 'public');
                $supply->product_image = $path;
            }

            $supply->save();

            return redirect()->route('admin.inventory')
                           ->with('success', 'Supply item added successfully');

        } catch (\Exception $e) {
            return back()->withInput()
                        ->withErrors(['error' => 'Failed to add supply item. Please try again.']);
        }
    }

    public function index()
    {
        $supplies = SuppliesInventory::orderBy('product_name', 'asc')->paginate(200);
        return view('admin.inventory', compact('supplies'));
    }

    public function edit($id)
    {
        $supply = SuppliesInventory::findOrFail($id);
        return view('Admin.stock.editsupplies', compact('supply'));
    }

    public function update(Request $request, $id)
    {
        $supply = SuppliesInventory::findOrFail($id);
        
        $validated = $request->validate([
            'product_name' => 'required',
            'quantity' => 'required|numeric',
            'unit_type' => 'required',
            'product_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        if ($request->hasFile('product_image')) {
            // Delete old image if exists
            if ($supply->product_image) {
                Storage::disk('public')->delete($supply->product_image);
            }
            $path = $request->file('product_image')->store('supplies', 'public');
            $validated['product_image'] = $path;
        }

        $supply->update($validated);

        return redirect()->route('admin.inventory')
            ->with('success', 'Supply updated successfully');
    }

    public function destroy($id)
    {
        try {
            $supply = SuppliesInventory::findOrFail($id);
            
            // Delete image if exists
            if ($supply->product_image) {
                Storage::disk('public')->delete($supply->product_image);
            }
            
            $supply->delete();

            return redirect()->route('admin.inventory')
                           ->with('success', 'Supply item deleted successfully');

        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Failed to delete supply item. Please try again.']);
        }
    }
}
