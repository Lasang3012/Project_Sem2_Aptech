<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoryPost extends Model
{
    public $timestamps = false;
    protected $fillable =[
        'cate_post_name','cate_post_desc','cate_post_status','cate_post_slug'
    ];
    protected $primaryKey = 'cate_post_id';
    protected $table = 'tbl_category_post';

    public function post(){
      return  $this->hasMany(Post::class,'cate_post_id','cate_post_id'); // quan hệ 1 nhìu , 1 danh mục có thể nhìu bài viết
    }
}
