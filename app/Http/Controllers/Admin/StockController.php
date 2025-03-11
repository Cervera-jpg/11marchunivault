<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Stock;
use App\Models\StockEditHistory;
use Illuminate\Http\Request;

class StockController extends Controller
{
    public function index()
    {
        $stocks = Stock::latest()->paginate(10);
        return view('admin.tables', compact('stocks'));
    }

    public function create()
    {
        $departments = [
            'COE' => [
                'ME Laboratory',
                'Civil Laboratory'
            ],
            'COS/CLA' => [
                'Museum c/o Prof. Marcelina Puga',
                'Medical/Dental Clinic'
            ],
            'CIT' => [
                'Office of the Dean'
            ],
            'CIE' => [
                'Cultural Office',
                'Technical Arts Department'
            ],
            'CAFA' => [
                'Fine Arts Department',
                'Physical Education Gym',
                'TUPFA Office'
            ]
        ];
        return view('admin.stock.create', compact('departments'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'product_name' => 'required|string|max:255',
            'quantity' => 'required|integer',
            'price' => 'required|numeric',
            'department' => 'required',
            'branch' => 'required',
            'category' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        if ($request->hasFile('image')) {
            // Store the file and get the exact filename
            $file = $request->file('image');
            $filename = $file->store('stock-images', 'public');
            
            // Store the exact path
            $validated['description'] = $filename;
            
            // Debug log
            \Log::info('Stored image path: ' . $filename);
        }

        Stock::create($validated);

        return redirect()->route('admin.tables')->with('success', 'Stock added successfully');
    }

    public function edit($id)
    {
        $stock = Stock::findOrFail($id);
        return view('admin.stock.editstock', compact('stock'));
    }

    public function update(Request $request, $id)
    {
        $stock = Stock::findOrFail($id);
        
        $validated = $request->validate([
            'product_name' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'department' => 'required|string|max:255',
            'control_number' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'quantity' => 'required|integer|min:0',
            'edit_reason' => 'required|string|min:5',
        ]);

        // Track changes
        $changes = [];
        $fieldsToUpdate = [
            'product_name',
            'category',
            'department',
            'control_number',
            'price',
            'quantity'
        ];

        foreach ($fieldsToUpdate as $field) {
            if ($stock->$field != $validated[$field]) {
                $changes[$field] = [
                    'old' => $stock->$field,
                    'new' => $validated[$field]
                ];
            }
        }

        // Only create history if there are actual changes
        if (!empty($changes)) {
            // Create edit history
            StockEditHistory::create([
                'stock_id' => $stock->id,
                'changes' => json_encode($changes),
                'reason' => $validated['edit_reason'],
                'edited_by' => auth()->id()
            ]);

            // Update the stock with new values
            $stock->update([
                'product_name' => $validated['product_name'],
                'category' => $validated['category'],
                'department' => $validated['department'],
                'control_number' => $validated['control_number'],
                'price' => $validated['price'],
                'quantity' => $validated['quantity']
            ]);

            return redirect()->route('tables')->with('success', 'Stock updated successfully!');
        }

        return redirect()->route('tables')->with('info', 'No changes were made to the stock.');
    }

    public function destroy($id)
    {
        try {
            $stock = Stock::findOrFail($id);
            $stock->delete();
            
            return redirect()->route('stock.index')
                ->with('success', 'Stock deleted successfully');
        } catch (\Exception $e) {
            return redirect()->route('stock.index')
                ->with('error', 'Error deleting stock');
        }
    }

    public function inventory()
    {
        $stocks = Stock::orderBy('created_at', 'desc')->paginate(10);
        return view('admin.inventory', compact('stocks'));
    }
}