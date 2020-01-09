<?php


namespace Struct;


trait Tree
{

    public function tree($parentKey = 'parent_id',$childrenKey = 'children'){

        $groups = $this->all()->toArray();
        $groups = array_column($groups, null, 'id');

        foreach ($groups as $k => &$value){
            if($value[$parentKey]){
                $groups[$value[$parentKey]][$childrenKey][] =&$value;
            }
        }
        foreach ($groups as $k => $value){
            if($value[$parentKey]){
                unset($groups[$k]);
            }
        }
        return $groups;
    }

}
