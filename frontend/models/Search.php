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
           var_dump($this->attributes);exit;
           $query = (new  Query())->from('tbl_lots_temp')->where("`year` != '0' AND year != '' AND vin != ''");
           $query->addSelect(["*", 'CONCAT_WS("-",
                                                       "used",
                                                        year,
                                                        LOWER(REPLACE(REPLACE(REPLACE(make, " ", ""), ".", ""), "-", "")),
                                                        LOWER(REPLACE(REPLACE(REPLACE(model, " ", ""), ".", ""), "-", "")),
                                                        vin
                                                    ) AS alias ']);

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
                
                }
                if(isset($this->price_from) && !isset($this->price_to)){
                
                }
                if(!isset($this->price_from) && isset($this->price_to)){
                
                }
           }

           if(isset($this->meliage_from) || isset($this->meliage_to)){
                if(isset($this->meliage_from) && isset($this->meliage_to)){
                
                }
                if(isset($this->meliage_from) && !isset($this->meliage_to)){
                
                }
                if(!isset($this->meliage_from) && isset($this->meliage_to)){
                
                }   
           }

           if(isset($this->year_from) || isset($this->year_to)){
                if(isset($this->year_from) && isset($this->year_to)){
                
                }
                if(isset($this->year_from) && !isset($this->year_to)){
                
                }
                if(!isset($this->year_from) && isset($this->year_to)){
                
                }    
           }




           $provider = new ActiveDataProvider([
                'query' => $query,
                'pagination' => [
                    'pageSize' => 40,
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
