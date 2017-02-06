<?php

namespace frontend\models;

use Yii;
use yii\db\Query;
use yii\base\Model;
use yii\data\SqlDataProvider;
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

    public function getCountItemInColumn()
    {

        $countIems = Yii::$app->db->createCommand('SELECT COUNT(*) FROM {{tbl_models}}')->queryScalar();
        return ceil($countIems/self::COUNT_COLUMN);
    }


    public function getModelNameByAlias($alias)
    {
        return (new Query())->from('tbl_models')->where(['alias'=> $alias])->limit(1)->one();
    }

    public function getBreadcrumbUrl($make)
    {
        return Yii::$app->db->createCommand('SELECT alias FROM {{tbl_makes}} WHERE make=:make', [':make'=>$make])->queryScalar();
    }

    public function getCarsModelList($make, $model)
    {
        $count = Yii::$app->db->createCommand('
            SELECT COUNT(*) FROM {{tbl_lots_temp}} WHERE make=:make AND model=:model
        ', [':make' => $make, ':model' => $model])->queryScalar();

                      
        $provider = new SqlDataProvider([
            'sql' => "SELECT price, model, make, year,  CONCAT_WS('-',
                                                       'used',
                                                        year,
                                                        LOWER(REPLACE(REPLACE(REPLACE(make, ' ', ''), '.', ''), '-', '')),
                                                        LOWER(REPLACE(REPLACE(REPLACE(model, ' ', ''), '.', ''), '-', '')),
                                                        vin
                                                    ) AS alias  FROM {{tbl_lots_temp}} WHERE make=:make AND model=:model",
            'params' => [':make' => $make, ':model' => $model],
            'totalCount' => $count,
            'pagination' => [
                'pageSize' => 40,
            ],
            'sort' => [
                'attributes' => [
                        
                        'year' => [
                            'asc' => ['year' => SORT_ASC], // от А до Я
                            'desc' => ['year' => SORT_DESC], // от Я до А
                            'default' => SORT_DESC, // сортировка по умолчанию
                            'label' => 'Заголовок', // название
                        ],

                        'price' => [
                            'asc' => ['price' => SORT_ASC], // от А до Я
                            'desc' => ['price' => SORT_DESC], // от Я до А
                            'default' => SORT_DESC, // сортировка по умолчанию
                            'label' => 'Цена', // название
                        ],

                    ],
                ],
        ]);

        return $provider;
    }
}
