<?php


namespace Huyibin\ModelMethods;

trait SaveOneToMany{

    protected  function saveOneToMany(Array $data, $model,String $ref,\Closure $beforeInsert ,\Closure $updater = null,$pk = 'id'){

        if($updater){
            $model->load($ref);
            foreach($model->$ref as $r){
                $flag = 0;
                foreach($data as $k => $v){
                    if(isset($v[$pk]) && $r->$pk === $v[$pk]){
                        call_user_func_array($updater,[$r,$v,$model]);
                        unset($data[$k]);
                        $flag = 1;
                        break;
                    }
                }
                if($r->isDirty()){
                    $r->save();
                }else if(!$flag){
                    $r->delete();
                }
            }
        }
        if(!empty($data)){
            $insert = call_user_func_array($beforeInsert,[$data,$model]);
            $model->$ref()->saveAll($insert);
        }
    }
}