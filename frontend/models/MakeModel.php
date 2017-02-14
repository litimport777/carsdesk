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
            'sql' => "SELECT `tbl_lots_temp`.`id`, price, model, make, year, odometer, hash, images_date, tbl_lots_temp_id, count_images,
                                                            CONCAT_WS('-',
                                                           'used',
                                                            year,
                                                            LOWER(REPLACE(REPLACE(REPLACE(make, ' ', ''), '.', ''), '-', '')),
                                                            LOWER(REPLACE(REPLACE(REPLACE(model, ' ', ''), '.', ''), '-', '')),
                                                            vin
                                                        ) AS alias FROM {{tbl_lots_temp}} 

                                                        LEFT JOIN {{user_car}}   
                                                        ON `tbl_lots_temp`.`id` = `user_car`.`tbl_lots_temp_id` 
                                                        AND `user_car`.`user_id` = :user_id


                                                        WHERE make=:make",
            'params' => [':make' => $make, ':user_id' => Yii::$app->user->id],
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

    public function getMakesToFormSearchForm()
    {
        $result =  Yii::$app->db->createCommand('SELECT make FROM {{tbl_makes}}')->queryColumn();
        return array_combine($result, $result);
    }

    public function getModelsToFormSearchForm($param)
    {
        $result =  Yii::$app->db->createCommand('SELECT model FROM {{tbl_models}} WHERE make = :make', [':make'=>$param])->queryColumn();
        return array_combine($result, $result);
    }
}
