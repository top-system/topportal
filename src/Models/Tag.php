<?php

namespace TopSystem\TopPortal\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use TopSystem\TopAdmin\Traits\Translatable;

class Tag extends Model
{
    use Translatable;

    protected $translatable = ['name', 'slug'];

}
