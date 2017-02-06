<?php

namespace frontend\models;

use Yii;
use yii\data\Sort;
use yii\db\Query;
use yii\base\Model;
use yii\data\SqlDataProvider;
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

    public function getCarsMakeList($make)
    {
        $count = Yii::$app->db->createCommand('
            SELECT COUNT(*) FROM {{tbl_lots_temp}} WHERE make=:make
        ', [':make' => $make])->queryScalar();

                      
        
       

        $provider = new SqlDataProvider([
            'sql' => "SELECT price, model, make, year,  CONCAT_WS('-',
                                                           'used',
                                                            year,
                                                            LOWER(REPLACE(REPLACE(REPLACE(make, ' ', ''), '.', ''), '-', '')),
                                                            LOWER(REPLACE(REPLACE(REPLACE(model, ' ', ''), '.', ''), '-', '')),
                                                            vin
                                                        ) AS alias FROM {{tbl_lots_temp}} WHERE make=:make",
            'params' => [':make' => $make],
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