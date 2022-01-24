<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Brand extends Model
 {
     use SoftDeletes,HasFactory;
     protected $dates = ['deleted_at'];
    public $timestamps = false;
    protected $fillable =[
          'brand_name','brand_desc','brand_status','brand_slug'
    ];
    protected $primaryKey = 'brand_id';
    protected $table = 'tbl_brand';

    public function products(){
        return $this->hasMany(Product::class,'brand_id','brand_id');
    }
}
