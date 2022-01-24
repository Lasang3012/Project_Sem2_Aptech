<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Product extends Model
{
    use SoftDeletes,HasFactory;

    protected $dates = ['deleted_at'];
    public $timestamps = false;
    protected $fillable = [
        'product_name',
        'category_id',
        'brand_id',
        'inventory',
        'product_desc',
        'product_content',
        'product_price',
        'product_image',
        'product_status',
        'product_tags',
        'product_view',
        'price_cost'
    ];
    protected $primaryKey = 'product_id';
    protected $table = 'tbl_product';

    public function comment(){
        return $this->hasMany('App\Models\Commnet');
    }
    public function category(){
        return $this->belongsTo('App\Models\Category');
    }


}
