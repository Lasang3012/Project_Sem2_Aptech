<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    public $timestamps = false;
    protected $fillable =[
        'post_title','post_desc','post_content','post_meta_desc','post_meta_keyword','post_status','post_image','cate_post_id','post_slug','post_view'
    ];
    protected $primaryKey = 'post_id';
    protected $table = 'tbl_post';

    public function cate_post(){
        return $this->belongsTo('App\Models\CategoryPost','cate_post_id'); // chi co thể thêm 1 bài viết trên 1 danh mục
    }
}
