<?php

namespace TopSystem\TopPortal\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use TopSystem\TopAdmin\Facades\Admin;
use TopSystem\TopAdmin\Traits\Resizable;
use TopSystem\TopAdmin\Traits\Translatable;

class Post extends Model
{
    use Translatable;
    use Resizable;

    protected $translatable = ['title', 'seo_title', 'excerpt', 'body', 'slug', 'meta_description', 'meta_keywords'];

    public const PUBLISHED = 'PUBLISHED';

    protected $guarded = [];

    public function save(array $options = [])
    {
        // If no author has been assigned, assign the current user's id as the author of the post
        if (!$this->author_id && Auth::user()) {
            $this->author_id = Auth::user()->getKey();
        }

        return parent::save();
    }

    public function authorId()
    {
        return $this->belongsTo(Admin::modelClass('User'), 'author_id', 'id');
    }

    /**
     * Scope a query to only published scopes.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopePublished(Builder $query)
    {
        return $query->where('status', '=', static::PUBLISHED);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function category()
    {
        return $this->belongsTo(Admin::modelClass('Category'));
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function tag()
    {
        return $this->belongsToMany(Tag::class,TagPost::class,'tid','pid');
    }

    /**
     * 前一个
     * @return $this
     */
    public function publishedPrev(){
        return $this->where('id','<',$this->id)->first();
    }

    /**
     * 下一个
     * @return $this
     */
    public function publishedNext(){
        return $this->where('id','>',$this->id)->first();
    }

    /**
     * 获取相关文章
     * @return $this
     */
    public function publishedRelated($page= 5){
        $model = new self();
        $model = $model->where('id','!=',$this->id);
        if ($this->category_id > 0){
            $model = $model->where('category_id',$this->category_id);
        }else{
            $model = $model->where('category_id',null);
        }
        return $model->take($page)->get();
    }

    /**
     * 获取热门内容
     * @param int $page
     * @return mixed
     */
    public function publishedPopular($page= 5,$category_id=0){
        $model = new self();
        if ($category_id > 0){
            $model = $model->where('category_id',$category_id);
        }
        return $model->orderBy('post_hits','desc')->take($page)->get();
    }
}
