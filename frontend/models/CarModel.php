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
   			return $db->createCommand("SELECT  `tbl_lots_temp`.`id`, price, model, make, year, 'odometer', hash, images_date, tbl_lots_temp_id, 
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

                                                    WHERE make != '' AND model != ''  AND year != 0 AND year != '' AND vin != '' 
                                                    ORDER BY RAND() LIMIT 6", [':user_id' => Yii::$app->user->id])->queryAll();
   		}, 3600);
   		return $result;
   }

   public function getCar($vin)
   {
   		return (new Query())->from('tbl_lots_temp')->where(['vin'=> $vin])->limit(1)->one();
   }

   public function getStatisticToCity()
   {
   		$db = Yii::$app->db;
   		$result = $db->cache(function ($db){
	   		return Yii::$app->db->createCommand('SELECT `tbl_lots_temp`.`city`, COUNT(*) as `cnt` 
												FROM `tbl_lots_temp` INNER JOIN `tbl_makes`
												ON `tbl_lots_temp`.`make` = `tbl_makes`.`make`
												GROUP BY `tbl_lots_temp`.`city`  
												ORDER BY `cnt`  DESC LIMIT 20')->queryAll();
	   		}, 3600);
   		return $result;
   }
}
