<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class Category extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    public $timestamps = false;
    protected $fillable =[
        'category_name','category_desc','category_status','category_slug'
    ];
    protected $primaryKey = 'category_id';
    protected $table = 'tbl_category_product';
    public function products(){
        return $this->hasMany(Product::class,'category_id','category_id');
    }
}
