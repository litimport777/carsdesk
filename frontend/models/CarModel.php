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
   			return $db->createCommand('SELECT * FROM {{tbl_lots_temp}} ORDER BY RAND() LIMIT 6')->queryAll();
   		}, 3600);
   		return $result;
   }
}
