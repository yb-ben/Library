<?php


namespace Huyibin\Struct;


class Tree
{
	

    public static function tree($data,$renames = [] ,$parentKey = 'parent_id',$childrenKey = 'nodes',$primaryKey = 'id'){

	
        $groups = array_column($data, null, $primaryKey);
		$t = [];
        foreach ($groups as $k => &$value){
            foreach ($renames as $oldname => $newname){
                if(isset($value[$oldname])){
                    $value[$newname] = $value[$oldname];
                    unset($value[$oldname]);
                }
            }
            if($value[$parentKey]){
                $groups[$value[$parentKey]][$childrenKey][] =&$value;
				$t[] = $value[$primaryKey];
			}
        }
        foreach ($t as $k => $v){

            unset($groups[$v]);
        }
        return $groups;
    }
}
