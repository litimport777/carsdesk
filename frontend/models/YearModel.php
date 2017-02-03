<?php

namespace frontend\models;

use Yii;
use yii\db\Query;
use yii\base\Model;
use frontend\models\CommonCarModel;

/**
 * ContactForm is the model behind the contact form.
 */
class YearModel extends CommonCarModel
{
    
    public function getYearsList($make, $model)
    {

        return Yii::$app->db->createCommand('SELECT CONCAT("(", count_make, ")", " ", year_data, " ", make, " ", model) as name, alias 
                                            FROM {{tbl_models_as}} 
                                            WHERE make = :make AND model > :model', 
                                            [':make'=>$make, ':model'=> $model])
                            ->queryAll();
    }

    public function getModelYearNameByAlias($alias)
    {
        return (new Query())->from('tbl_models_as')->where(['alias'=> $alias])->limit(1)->one();
    }
}
