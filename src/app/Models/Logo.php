<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Logo extends Model
{
    use SoftDeletes;

    protected $fillable = ['image_url', 'link_url', 'section_id'];

    public function section()
    {
        return $this->belongsTo(Section::class);
    }
}
