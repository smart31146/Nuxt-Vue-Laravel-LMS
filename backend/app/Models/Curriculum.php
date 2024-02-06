<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Curriculum extends Model
{

    protected $table = 'curriculums';

    protected $primaryKey = 'curriculum_id';

    public function categories()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

}
