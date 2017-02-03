<?php

namespace frontend\models;

use Yii;
use yii\db\Query;
use yii\base\Model;
use frontend\models\CommonCarModel;

/**
 * ContactForm is the model behind the contact form.
 */
class ModelModel extends CommonCarModel
{
    
    const COUNT_MAKE_MODEL = 2;

    public function getModels($make)
    {

        return Yii::$app->db->createCommand('SELECT CONCAT("(", count_make, ")", " ", model) as model, alias 
                                            FROM {{tbl_models}} 
                                            WHERE make = :make AND count_make > :count_make', 
                                            [':make'=>$make, ':count_make'=> self::COUNT_MAKE_MODEL])
                            ->queryAll();
    }


    public function getModelNameByAlias($alias)
    {
        return (new Query())->from('tbl_models')->where(['alias'=> $alias])->limit(1)->one();
    }
}
