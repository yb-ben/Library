<?php


namespace Struct;


trait Tree
{
	
	protected $treeParentKey = 'parent_id';
	protected $treeChildrenKey = 'nodes';
	protected $treePrimaryKey = 'id';

    public function tree($parentKey = null,$childrenKey = null,$primaryKey = null){

		$parentKey = $parentKey?:$this->treeParentKey;
		$childrenKey = $childrenKey?:$this->treeChildrenKey;
		$primaryKey = $primaryKey?:$this->treePrimaryKey;
	
        $groups = array_column($this->all()->toArray(), null, $primaryKey);
		$t = [];
        foreach ($groups as $k => &$value){
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
