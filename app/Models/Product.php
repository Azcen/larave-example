<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Product extends Model
{

    use HasFactory;

    const MXN = 1;
    const USD = 2;

    protected $guard_name ='api';

    protected $appends = ['currency_code', 'status'];

    protected $fillable = [
        'product_name',
        'slug',
        'img_url',
        'quantity',
        'unit_price',
        'currency'
    ];

    public function getModelLabel()
    {
        return $this->column;
    }

    public function getCurrencyCodeAttribute()
    {
        switch ($this->credit_amount_status) {
            case self::MXN:
                return __('messages.mxn');
            case self::USD:
                return __('messages.usd');
            default:
                return __('messages.not_found');
        }
    }

    public function getStatusAttribute()
    {
       return $this->quantity ? __('messages.stock') : __('messages.out_of_stock');
    }

    public function setSlugAttribute($value) 
    {
        $slug = Str::of($value)->slug('-');
        $counter = self::where('product_name', $value)->count();
        if($counter > 0) {
            $this->attributes['slug'] = $slug . '-' . $counter;
        } else {
            $this->attributes['slug'] = $slug;
        }
    }
}
