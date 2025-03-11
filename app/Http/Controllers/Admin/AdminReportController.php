<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Stock;
use Illuminate\Http\Request;

class AdminReportController extends Controller
{
    public function index()
    {
        $departments = [
            'COE' => ['ME Laboratory', 'Civil Laboratory'],
            'COS/CLA' => ['Museum c/o Prof. Marcelina Puga', 'Medical/Dental Clinic'],
            'CIT' => ['Office of the Dean'],
            'CIE' => ['Cultural Office', 'Technical Arts Department'],
            'CAFA' => ['Fine Arts Department', 'Physical Education Gym', 'TUPFA Office']
        ];

        return view('Admin.reports', compact('departments'));
    }

    public function print(Request $request)
    {
        $validated = $request->validate([
            'department' => 'required',
            'branch' => 'required',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        $stocks = Stock::where('department', $validated['department'])
            ->where('branch', $validated['branch'])
            ->whereBetween('created_at', [$validated['start_date'], $validated['end_date']])
            ->get();

        return view('admin.reports.print', compact('stocks'));
    }
}
