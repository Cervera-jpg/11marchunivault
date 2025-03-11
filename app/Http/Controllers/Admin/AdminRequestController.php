<?php

namespace App\Http\Controllers\Admin;

use App\Models\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request as HttpRequest;
use Illuminate\Support\Facades\Auth;

class AdminRequestController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('check.role:admin');
    }

    public function index()
    {
        $requests = Request::with(['user', 'approver'])
                         ->latest('created_at')
                         ->get();
                         
        return view('Admin.adminviewreq', compact('requests'));
    }

    public function updateStatus(HttpRequest $request, $id)
    {
        try {
            $stockRequest = \App\Models\Request::findOrFail($id);

            $validated = $request->validate([
                'status' => 'required|in:approved,rejected',
                'remarks' => 'required|string|max:255'
            ]);

            $affected = \DB::table('requests')
                ->where('id', $id)
                ->update([
                    'status' => $validated['status'],
                    'remarks' => $validated['remarks'],
                    'approved_by' => Auth::id(),
                    'approved_at' => now()
                ]);

            if ($affected) {
                // If request is approved, redirect to stock creation form with data
                if ($validated['status'] === 'approved') {
                    return redirect()->route('admin.stocks.create')->with([
                        'success' => 'Request approved successfully.',
                        'request_data' => [
                            'product_name' => $stockRequest->product_name,
                            'quantity' => $stockRequest->quantity,
                            'price' => $stockRequest->price,
                            'department' => $stockRequest->department,
                            'branch' => $stockRequest->branch,
                            'category' => $stockRequest->category,
                            // Add any other fields you need to pass
                        ]
                    ]);
                }

                // If rejected, just go back with success message
                return redirect()->back()->with('success', 'Request has been rejected successfully.');
            }

            return redirect()->back()->with('error', 'Failed to update request status.');

        } catch (\Exception $e) {
            \Log::error('Error in update:', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return redirect()->back()->with('error', 'Error: ' . $e->getMessage());
        }
    }

    public function approve(Request $request)
    {
        return $this->updateStatus($request, [
            'status' => 'approved',
            'remarks' => request('remarks')
        ]);
    }

    public function reject(Request $request)
    {
        return $this->updateStatus($request, [
            'status' => 'rejected',
            'remarks' => request('remarks')
        ]);
    }
}
