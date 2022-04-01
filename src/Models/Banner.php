<?php

namespace TopSystem\TopPortal\Models;

use Illuminate\Database\Eloquent\Model;
use TopSystem\TopAdmin\Facades\Admin;
use TopSystem\TopAdmin\Traits\Translatable;

class Banner extends Model
{
    use Translatable;

    protected $table = 'banners';

    protected $fillable = ['title', 'url', 'order', 'logo', 'status'];

}
