<?php


namespace Struct;


trait Tree
{

    public function tree($parentKey = 'parent_id',$childrenKey = 'children'){

        $groups = array_column($this->all()->toArray(), null, 'id');
		$t = [];
        foreach ($groups as $k => &$value){
            if($value[$parentKey]){
                $groups[$value[$parentKey]][$childrenKey][] =&$value;
            $t[] = $value['id'];
			}
        }
        foreach ($t as $k => $v){
                unset($groups[$v]);
            }
        return $groups;
    }

}
