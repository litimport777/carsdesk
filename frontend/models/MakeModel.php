<?php

namespace frontend\models;

use Yii;
use yii\db\Query;
use yii\base\Model;
use frontend\models\CommonCarModel;

/**
 * ContactForm is the model behind the contact form.
 */
class MakeModel extends CommonCarModel
{
    
    public function getMakes()
    {

        return Yii::$app->db->createCommand('SELECT CONCAT("(", count_make, ")", " ", make) as make, alias FROM {{tbl_makes}}')
                            ->queryAll();
    }


    public function getCountItemInColumn()
    {

        $countIems = Yii::$app->db->createCommand('SELECT COUNT(*) FROM {{tbl_makes}}')->queryScalar();
        return ceil($countIems/self::COUNT_COLUMN);
    }

    public function getMakeNameByAlias($alias)
    {
        return (new Query())->from('tbl_makes')->where(['alias'=> $alias])->limit(1)->one();
    }
}
