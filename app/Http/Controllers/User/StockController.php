<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Stock;
use Illuminate\Http\Request;

class StockController extends Controller
{
    public function index(Request $request)
    {
        $departments = Stock::distinct('department')->pluck('department');
        
        $stocks = Stock::when($request->department, function($query, $department) {
            return $query->where('department', $department);
        })->get();
    
        return view('user.tables', compact('stocks', 'departments'));
    }
}