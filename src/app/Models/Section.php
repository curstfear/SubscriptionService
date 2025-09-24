<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Section extends Model
{
    use SoftDeletes;
    protected $fillable = ['name', 'title', 'description', 'image_url', 'link', 'order', 'page_id'];

    public function page()
    {
        return $this->belongsTo(Page::class);
    }

    public function items()
    {
        return $this->hasMany(SectionItem::class);
    }

    public function logos()
    {
        return $this->hasMany(Logo::class);
    }

    public function plans()
    {
        return $this->hasMany(Plan::class);
    }
}
