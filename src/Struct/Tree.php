<?php


namespace Struct;


trait Tree
{

    public function tree(){

        $groups = $this->all()->toArray();
        $groups = array_column($groups, null, 'id');
        /*$func = function($groups){

        };*/
        foreach ($groups as $k => &$value){
            if($value['parent_id']){
                $groups[$value['parent_id']]['children'][] =&$value;
            }
        }
        foreach ($groups as $k => $value){
            if($value['parent_id']){
                unset($groups[$k]);
            }
        }
        return $groups;
    }

}
