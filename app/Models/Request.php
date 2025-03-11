<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Request extends Model
{
    protected $fillable = [
        'request_id',
        'control_number',
        'product_name',
        'department',
        'branch',
        'quantity',
        'price',
        'category',
        'description',
        'status',
        'remarks',
        'user_id',
        'approved_by',
        'approved_at',
        'timestamps'
    ];

    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($request) {
            // Generate request_id (YYYYMMDD-XXXX)
            $today = now();
            $dateString = $today->format('Ymd');
            
            $latest = static::whereDate('created_at', $today->toDateString())->latest()->first();
            $number = $latest ? intval(substr($latest->request_id, -4)) + 1 : 1;
            
            $request->request_id = $dateString . '-' . str_pad($number, 4, '0', STR_PAD_LEFT);
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function approver()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }
}