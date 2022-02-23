<?php

namespace TopSystem\TopPortal\Listeners;

use Illuminate\Support\Facades\Log;
use TopSystem\TopAdmin\Events\BreadAdded;
use Cache;
use TopSystem\TopAdmin\Events\BreadDataAdded;
use TopSystem\TopPortal\Models\Category;

class AddDownItem
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Create a MenuItem for a given BREAD.
     *
     * @param BreadAdded $event
     *
     * @return void
     */
    public function handle(BreadDataAdded $bread)
    {
        $table = $bread->dataType->slug;
        if ($table == 'downloads'){
            $data = $bread->data;
            if (!$data->category_id){
                return true;
            }
            $cate = Category::find($data->category_id);
            if (!$cate){
                return true;
            }
            $cid = $cate->parent_id ? $cate->parent_id : $data->category_id;
            $key = 'downloads_' . $cid;
            $res = Cache::get($key);
            if ($res){
                $res = json_decode($res,true);
                if (count($res) >= 10){
                    $res = array_slice($res,9);
                }
                $res[] = $data;
                Cache::put($key,json_encode($res));
                return true;
            }
            $res = [];
            $res[] = $data;
            Cache::put($key,json_encode($res));
        }

    }
}
