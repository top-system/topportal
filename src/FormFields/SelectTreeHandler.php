<?php

namespace TopSystem\TopPortal\FormFields;

use TopSystem\TopAdmin\FormFields\AbstractHandler;

class SelectTreeHandler extends AbstractHandler
{
    protected $codename = 'select_tree';

    public function createContent($row, $dataType, $dataTypeContent, $options)
    {
        return view('admin::formfields.select_tree', [
            'row'             => $row,
            'options'         => $options,
            'dataType'        => $dataType,
            'dataTypeContent' => $dataTypeContent,
        ]);
    }
}
