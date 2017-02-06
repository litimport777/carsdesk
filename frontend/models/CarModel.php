<?php

namespace frontend\models;

use Yii;
use yii\db\Query;
use yii\base\Model;
use frontend\models\CommonCarModel;

/**
 * ContactForm is the model behind the contact form.
 */
class CarModel extends CommonCarModel
{
    
   public function getCarsToIndexPage()
   {
   		$db = Yii::$app->db;

   		$result = $db->cache(function ($db){
   			return $db->createCommand("SELECT  price, model, make, year,  
   														CONCAT_WS('-',
                                                       'used',
                                                        year,
                                                        LOWER(REPLACE(REPLACE(REPLACE(make, ' ', ''), '.', ''), '-', '')),
                                                        LOWER(REPLACE(REPLACE(REPLACE(model, ' ', ''), '.', ''), '-', '')),
                                                        vin
                                                    ) AS alias  FROM {{tbl_lots_temp}} 
                                                    WHERE make != '' AND model != ''  AND year != 0 AND year != '' AND vin != '' 
                                                    ORDER BY RAND() LIMIT 6")->queryAll();
   		}, 3600);
   		return $result;
   }

   public function getCar($vin)
   {
   		return (new Query())->from('tbl_lots_temp')->where(['vin'=> $vin])->limit(1)->one();
   }
}
