<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SectionItem extends Model
{
    use SoftDeletes;

    protected $fillable = ['title', 'description', 'image', 'section_id'];

    public function section()
    {
        return $this->belongsTo(Section::class);
    }
}
