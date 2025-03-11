<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class Stock extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_name',
        'department',
        'branch',
        'quantity',
        'price',
        'category',
        'description',
        'control_number'
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($stock) {
            $stock->control_number = static::generateControlNumber();
        });
    }

    protected static function generateControlNumber()
    {
        $prefix = 'STK';
        $year = date('Y');
        $month = date('m');
        
        // Get the last stock entry
        $lastStock = static::orderBy('id', 'desc')->first();
        
        if ($lastStock) {
            // Extract the numeric part and increment
            $lastNumber = intval(substr($lastStock->control_number, -4));
            $newNumber = str_pad($lastNumber + 1, 4, '0', STR_PAD_LEFT);
        } else {
            $newNumber = '0001';
        }

        return "{$prefix}{$year}{$month}{$newNumber}";
    }

    public function getQrCodeAttribute()
    {
        // Generate QR code that includes essential product information
        $data = [
            'id' => $this->id,
            'name' => $this->product_name,
            'category' => $this->category,
            'department' => $this->department,
            'control_number' => $this->control_number,
            'price' => $this->price,
            'quantity' => $this->quantity
        ];
        
        return QrCode::size(50)->generate(json_encode($data));
    }

    public function editHistories()
    {
        return $this->hasMany(StockEditHistory::class);
    }
}