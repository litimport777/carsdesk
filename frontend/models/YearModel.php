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
class YearModel extends CommonCarModel
{
    
    public function getYearsList($make, $model)
    {

        return Yii::$app->db->createCommand('SELECT CONCAT("(", count_make, ")", " ", year_data, " ", make, " ", model) as name, alias 
                                            FROM {{tbl_models_as}} 
                                            WHERE make = :make AND model = :model', 
                                            [':make'=>$make, ':model'=> $model])
                            ->queryAll();
    }

    public function getCountItemInColumn()
    {

        $countIems = Yii::$app->db->createCommand('SELECT COUNT(*) FROM {{tbl_models_as}}')->queryScalar();
        return ceil($countIems/self::COUNT_COLUMN);
    }

    public function getModelYearNameByAlias($alias)
    {
        return (new Query())->from('tbl_models_as')->where(['alias'=> $alias])->limit(1)->one();
    }

    public function getCarsYearList($make, $model, $year)
    {
    	$count = Yii::$app->db->createCommand('
            SELECT COUNT(*) FROM {{tbl_lots_temp}} WHERE make=:make AND model=:model AND year=:year
        ', [':make' => $make, ':model' => $model, ':year' => $year])->queryScalar();

                      
        $provider = new SqlDataProvider([
            'sql' => "SELECT  price, model, make, year, CONCAT_WS('-',
                                                       'used',
                                                        year,
                                                        LOWER(REPLACE(REPLACE(REPLACE(make, ' ', ''), '.', ''), '-', '')),
                                                        LOWER(REPLACE(REPLACE(REPLACE(model, ' ', ''), '.', ''), '-', '')),
                                                        vin
                                                    ) AS alias  FROM {{tbl_lots_temp}} WHERE make=:make AND model=:model AND year=:year",
            'params' => [':make' => $make, ':model' => $model, ':year' => $year],
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

    public function getDataToBreadCrumb($alias)
    {
    	return Yii::$app->db->createCommand('SELECT * FROM {{tbl_models_as}} WHERE alias=:alias LIMIT 1', [':alias'=>$alias])->queryOne();
    }
}
