<?php
namespace frontend\models;

use yii;
use yii\base\Model;
use common\models\User;
use yii\db\Query;
use yii\data\ActiveDataProvider;

/**
 * Signup form
 */
class Search extends Model
{
   
   public function getResultSearch()
    {
           //var_dump($this->attributes);exit;
           $query = (new  Query())->from('tbl_lots_temp')->where("`year` != '0' AND year != '' AND vin != ''");
           $query->addSelect(["`tbl_lots_temp`.`id`", "price", "model", "make", "year", "odometer", "tbl_lots_temp_id", "hash", "images_date",
                                                       'CONCAT_WS("-",
                                                       "used",
                                                        year,
                                                        LOWER(REPLACE(REPLACE(REPLACE(make, " ", ""), ".", ""), "-", "")),
                                                        LOWER(REPLACE(REPLACE(REPLACE(model, " ", ""), ".", ""), "-", "")),
                                                        vin
                                                    ) AS alias ']);

           $query->leftJoin('user_car', '`tbl_lots_temp`.`id` = `user_car`.`tbl_lots_temp_id` AND `user_car`.`user_id` = :user_id',
                                                     [':user_id' => Yii::$app->user->id]);

           if(isset($this->make)){
                $query->andWhere(['make'=> $this->make]);
           }

           if(isset($this->model)){
                $query->andWhere(['model'=> $this->model]);
           }

           if(isset($this->zip)){
                $query->andWhere(['zip'=> $this->zip]);
           }

           if(isset($this->zip)){
                $query->andWhere(['zip'=> $this->zip]);
           }

           if(isset($this->color)){
                $query->andWhere(['exterior_color'=> static::$color_data[$this->color]]);
           }

           if(isset($this->body)){
                $query->andWhere(['cab_type'=> static::$body_data[$this->body]]);
           }           

           if(isset($this->transmission)){
                $query->andWhere(['transmission'=> static::$transmission_data[$this->transmission]]);
           }

           if(isset($this->engine)){
                $query->andWhere(['fuel'=> static::$engine_data[$this->engine]]);
           }



           if(isset($this->price_from) || isset($this->price_to)){
                if(isset($this->price_from) && isset($this->price_to)){
                     $query->andWhere(['>=', 'price', str_replace(['$', 'nomax'], ['', 9999999999],static::$price_data[$this->price_from])]);
                     $query->andWhere(['<=', 'price', str_replace(['$', 'nomax'], ['', 9999999999],static::$price_data[$this->price_to])]);
                }
                if(isset($this->price_from) && !isset($this->price_to)){
                     $query->andWhere(['>=', 'price', str_replace(['$', 'nomax'], ['', 9999999999],static::$price_data[$this->price_from])]);
                }
                if(!isset($this->price_from) && isset($this->price_to)){
                    $query->andWhere(['<=', 'price', str_replace(['$', 'nomax'], ['', 9999999999],static::$price_data[$this->price_to])]);
                }
           }

           if(isset($this->meliage_from) || isset($this->meliage_to)){
                if(isset($this->meliage_from) && isset($this->meliage_to)){
                     $query->andWhere(['>=', 'odometer', static::$meliage_data[$this->meliage_from]]);
                     $query->andWhere(['<=', 'odometer', static::$meliage_data[$this->meliage_to]]);
                }
                if(isset($this->meliage_from) && !isset($this->meliage_to)){
                    $query->andWhere(['>=', 'odometer', static::$meliage_data[$this->meliage_from]]);
                }
                if(!isset($this->meliage_from) && isset($this->meliage_to)){
                    $query->andWhere(['<=', 'odometer', static::$meliage_data[$this->meliage_to]]);
                }   
           }

           if(isset($this->year_from) || isset($this->year_to)){
                if(isset($this->year_from) && isset($this->year_to)){
                    $query->andWhere(['>=', 'year', static::$year_data[$this->year_from]]);
                    $query->andWhere(['<=', 'year', static::$year_data[$this->year_to]]);
                }
                //var_dump($this->year_from) . ' ' . var_dump(static::$year_data);exit;
                if(isset($this->year_from) && !isset($this->year_to)){
                    $query->andWhere(['>=', 'year', static::$year_data[$this->year_from]]);
                }
                if(!isset($this->year_from) && isset($this->year_to)){
                    $query->andWhere(['<=', 'year', static::$year_data[$this->year_to]]);
                }    
           }




           $provider = new ActiveDataProvider([
                'query' => $query,
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
}
