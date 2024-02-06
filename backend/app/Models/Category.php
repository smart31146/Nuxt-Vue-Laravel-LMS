<?php

namespace App\Models;

use App\Models\Curriculum;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{

    protected $table = 'categories';

    protected $primaryKey = 'category_id';

    public function curriculums(){
        return $this->hasMany(Curriculum::class, 'category_id');
    }
}   
