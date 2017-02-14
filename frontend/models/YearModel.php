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

    public function getCountItemInColumn($make, $model)
    {

        $countIems = Yii::$app->db->createCommand('SELECT COUNT(*) 
        										  FROM {{tbl_models_as}} 
        										  WHERE make = :make AND model = :model'
        										, [':make'=>$make, ':model'=> $model])->queryScalar();
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
            'sql' => "SELECT  `tbl_lots_temp`.`id`, price, model, make, year, odometer, hash, images_date, tbl_lots_temp_id, count_images,
            											CONCAT_WS('-',
                                                       'used',
                                                        year,
                                                        LOWER(REPLACE(REPLACE(REPLACE(make, ' ', ''), '.', ''), '-', '')),
                                                        LOWER(REPLACE(REPLACE(REPLACE(model, ' ', ''), '.', ''), '-', '')),
                                                        vin
                                                    ) AS alias  FROM {{tbl_lots_temp}} 

                                                    LEFT JOIN {{user_car}}   
                                                    ON `tbl_lots_temp`.`id` = `user_car`.`tbl_lots_temp_id` 
                                                    AND `user_car`.`user_id` = :user_id

                                                    WHERE make=:make AND model=:model AND year=:year",
            'params' => [':make' => $make, ':model' => $model, ':year' => $year, ':user_id' => Yii::$app->user->id],
            'totalCount' => $count,
            'pagination' => [
                'pageSize' => Yii::$app->params['frontendCatalogPageSize'],
            ],
            'sort' => [
                'attributes' => [
                        
                        'year' => [
                            'asc' => ['year' => SORT_ASC], 
                            'desc' => ['year' => SORT_DESC], 
                            'default' => SORT_DESC, 
                         ],

                        'price' => [
                            'asc' => ['price' => SORT_ASC], 
                            'desc' => ['price' => SORT_DESC], 
                            'default' => SORT_DESC, 
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
