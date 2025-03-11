<?php

namespace App\Http\Controllers\User;

use App\Models\Request;
use App\Models\SuppliesInventory;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request as HttpRequest;
use Illuminate\Support\Facades\Auth;

class UserRequestController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('check.role:user');
    }

    public function create()
    {
        $departments = [
            'COE' => [
                'Electrical Engineering',
                'Electronics Communication Engineering',
                'Mechanical Engineering',
                'Civil Engineering',
                'COE Office of the Dean'
            ],
            'COS' => [
                'Mathematics Department',
                'Physics Department',
                'Chemistry Department',
                'Computer Studies Department',
                'COS Office of the Dean'
            ],
            'CLA' => [
                'Languages Department',
                'Entrepreneurship and Management Department',
                'Social Science Department',
                'Physical Education',
                'CLA Office of the Dean'
            ],
            'CIT' => [
                'Basic Industrial Technology',
                'Civil Engineering Technology',
                'Electrical Engineering Technology',    
                'Mechanical Engineering Technology',
                'Food and Apparel Technology',
                'Graphic Arts and Printing Technology',
                'Power Plant Engineering Technology',
                'Student Teaching',
                'Electronics Engineering Technology',
                'CIT Office of the Dean'
            ],
            'CIE' => [
                'Cultural Office',
                'Technical Arts Department',
                'Student Teaching',
                'Technical Arts',
                'Home Economics',
                'Professional Industrial Education',    
                'CIE Office of the Dean'

            ],
            'CAFA' => [
                'Architecture Department',
                'Fine Arts Department',
                'Graphics Department',
                'CAFA Office of the Dean'
            ],
            'ADMINISTRATION' => [
                'Vice President - Research and Extention',
                'Vice President - Administration and Finance',
                'Vice President - Academic Affairs',
                'Vice President - Planning, Development and Special Concerns',
                'Office of the President'
            ],
            'CENTER' => [
                'Integrated Research and Training Center'
            ],
            'SUPPORT SERVICES' => [
                'University Registrar',
                'University Medical and Dental Clinic',
                'Industrial Relations and Job Placement Office',
                'University Information Techonology Center',
                'University Library'
            ]
        ];

        $supplies = SuppliesInventory::select('id', 'product_name', 'quantity', 'unit_type')
            ->orderBy('product_name')
            ->get();

        return view('User.requests.createreq', compact('departments', 'supplies'));
    }

    public function store(HttpRequest $request)
    {
        $request->validate([
            'department' => 'required|string|max:255',
            'branch' => 'required|string|max:255',
            'purpose' => 'required|string|max:1000',
            'items' => 'required|array|min:1',
            'items.*.product_name' => 'required|string|max:255',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.category' => 'required|string|max:255',
            'items.*.remarks' => 'nullable|string|max:255',
        ]);

        // Generate a unique request ID for this batch
        $requestId = 'REQ-' . date('Ymd') . '-' . str_pad(rand(1, 999), 3, '0', STR_PAD_LEFT);

        // Create the requests for each item
        foreach ($request->items as $item) {
            $stockRequest = new Request();
            $stockRequest->fill([
                'request_id' => $requestId,
                'product_name' => $item['product_name'],
                'quantity' => $item['quantity'],
                'category' => $item['category'],
                'remarks' => $item['remarks'] ?? null,
                'department' => $request->department,
                'branch' => $request->branch,
                'purpose' => $request->purpose,
            ]);
            $stockRequest->user_id = Auth::id();
            $stockRequest->status = 'pending';
            $stockRequest->save();
        }

        return redirect()->route('user.requests.viewrequests')
            ->with('success', 'Stock request created successfully! Request ID: ' . $requestId);
    }

    public function index()
    {
        // Only show requests belonging to the current user
        $requests = Request::where('user_id', Auth::id())
                         ->latest('created_at')
                         ->get();
                         
        return view('User.requests.viewrequests', compact('requests'));
    }
}