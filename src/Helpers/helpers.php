<?php

/**
 * 分类链接
 */
if (!function_exists('category_path')) {
    function category_path($id)
    {
        if ($id <= 0){
            return '';
        }
        return route('cms.category', $id);
    }
}


/**
 * 标签链接
 */
if (!function_exists('tag_path')) {
    function tag_path($id)
    {
        if ($id <= 0){
            return '';
        }
        return route('cms.tag', $id);
    }
}

/**
 * 文章链接
 */
if (!function_exists('post_path')) {
    function post_path($id)
    {
        if ($id <= 0){
            return '';
        }
        return route('cms.post', $id);
    }
}

/**
 * 文章链接
 */
if (!function_exists('image_path')) {
    function image_path($id)
    {
        return '/storage/' . $id;
    }
}

/**
 * 文章链接
 */
if (!function_exists('makeTreeViewJson')) {
    function makeTreeViewJson($array)
    {
        //第一步 构造数据
        $items = array();
        foreach($array as $value){
            $items[$value['id']] = ['text'  => $value['name'],'parent_id' => $value['parent_id']];
        }
        //第一步很容易就能看懂，就是构造数据，现在咱们仔细说一下第二步
        $tree = array();
        //遍历构造的数据
        foreach($items as $key => $value){
            //如果pid这个节点存在
            if(isset($items[$value['parent_id']])){
                //把当前的$value放到pid节点的son中 注意 这里传递的是引用 为什么呢？
                $items[$value['parent_id']]['nodes'][] = &$items[$key];
            }else{
                $tree[] = &$items[$key];
            }
        }
        return $tree;
    }
}
