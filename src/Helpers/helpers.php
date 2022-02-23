<?php

if (!function_exists('categories')) {
    function categories($parent_id=null)
    {
        return TopSystem\TopPortal\Models\Category::where('parent_id',$parent_id)->get();
    }
}

if (!function_exists('downloads')) {
    function downloads($wheres = [], $orders = [])
    {
         $model = new TopSystem\TopPortal\Models\Download();
         if (isset($wheres['category_id'])){
             $model = $model->where('category_id',$wheres['category_id']);
         }elseif (isset($wheres['name'])){
             $model = $model->where('name', 'like', '%'.$wheres['name'].'%');
         }elseif (isset($wheres['res_system'])){
             $model = $model->where('res_system', $wheres['res_system']);
         }

         if (isset($orders['created_at'])){
             $model = $model->orderBy('created_at','desc');
         }elseif (isset($orders['hits'])){
             $model = $model->orderBy('hits','desc');
         }
         return $model->get();
    }
}

if (!function_exists('tags')) {
    function tags($conditions)
    {
        $model = new TopSystem\TopPortal\Models\Download();
        if (isset($conditions['category_id'])){
            $model = $model->where('category_id',$conditions['category_id']);
        }
        return $model->get();
    }
}

if (!function_exists('banners')) {
    function banners($conditions = [])
    {
        $model = new TopSystem\TopPortal\Models\Banner();
        return $model->get();
    }
}

if (!function_exists('links')) {
    function links($conditions = [])
    {
        $model = new TopSystem\TopPortal\Models\Link();
        return $model->get();
    }
}
