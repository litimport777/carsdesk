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
    
   const COUNT_COLUMNS_IN_ITEM_VIEW = 3;

	public static $parametrAutoName = [
				   	  "cab_type"=>"cab type",
					  "engine_make"=>"engine make",
					  "engine_size"=>"engine size",
					  "weight"=>"weight",
					  "front_tire_size"=>"front tire size",
					  "rear_tire_size"=>"rear tire size",
					  "fuel_tank_size"=>"fuel tank size",
					  "max_torque"=>"max torque",
					  "horsepower"=>"horsepower",
					  "max_horsepower"=>"max horsepower",
					  "max_rpm"=>"max rpm",
					  "transmission_make"=>"transmission make",
					  "transmission_speed"=>"transmission speed",
					  "axles"=>"axles",
					  "rear_axles"=>"rear axles",
					  "suspension"=>"suspension",
					  "wheelbase"=>"wheelbase",
					  "front_axle"=>"front axle",
					  "rear_axle"=>"rear axle",
					  "number_of_rear_axles"=>"number of rear axles",
					  "brake_type"=>"brake type",
   				];
	   


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
   		return (new Query())->from('tbl_lots_temp')
   							->addSelect(['tbl_lots_temp.id','price','model','make','year','odometer','hash','images_date',
   								'tbl_lots_temp_id','vin','count_images','fuel','transmission','exterior_color','class','category','city','state','car_id'])
   							->leftJoin('user_car', '`tbl_lots_temp`.`id` = `user_car`.`tbl_lots_temp_id` AND `user_car`.`user_id` = :user_id',
   							[':user_id' => Yii::$app->user->id])
   							->where(['vin'=> $vin])->limit(1)->one();
   }

   public function getAdditional($carId)
   {
   		$dataSql = (new \yii\db\Query())->select('additional')->from('tbl_lot_descriptions')->where(['id'=>$carId])->limit(1)->one();

   		if(! $dataSql) {
   			return false;
   		}

   		$text = $dataSql["additional"];
		$result = unserialize(gzinflate($text));
		//var_dump($result);exit;
   		if(is_array($result)){
   			return $result;
   		}else{
   			return false;
   		}
   }

   public function getAdditionalDiff($additional)
   {
	   	$newAdditional = [];
	   	foreach($additional as $key => $value){
	   	  	if(isset(self::$parametrAutoName[$key])){
					$newAdditional[$key] = $value;
			}
		}
		return $newAdditional;  	  
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
