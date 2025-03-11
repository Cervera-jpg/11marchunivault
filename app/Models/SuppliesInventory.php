<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SuppliesInventory extends Model
{
    use HasFactory;

    protected $table = 'supplies_inventory';

    protected $fillable = [
        'control_code',
        'product_name',
        'quantity',
        'unit_type',
        'product_image'
    ];
}