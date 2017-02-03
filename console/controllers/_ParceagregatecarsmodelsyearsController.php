<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace console\controllers;

use yii\console\Controller;
use yii;

/**
 * This command echoes the first argument that you have entered.
 *
 * This command is provided as an example for you to learn how to create console commands.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class ParceagregatecarsmodelsyearsController extends Controller
{
    /**
     * This command echoes what you have entered as the message.
     * @param string $message the message to be echoed.
     */
    public function actionIndex()
    {
        $command = \Yii::$app->db;
		
             
        $db = Yii::$app->db;
		$transaction = $command->beginTransaction();

		try {

	        $command->createCommand()->dropTable("tbl_marks")->execute();
			$command->createCommand()->dropTable("tbl_models")->execute();
			$command->createCommand()->dropTable("tbl_models_as")->execute();
			
			$command->createCommand("CREATE TABLE `tbl_marks` 
												SELECT UPPER(make) as make, 
												LOWER(REPLACE(REPLACE(REPLACE(make, ' ', ''), '.', ''), '-', '')) AS alias, 
												COUNT(*) AS count_make 
												FROM `tbl_lots_temp` 
												WHERE make != ''  AND `year` != '0' AND year != ''



												
												GROUP BY make HAVING count_make > 30"
												)->execute();

			Yii::$app->db->createCommand()->createIndex ("tbl_marks_index_make", "tbl_marks", "make", false)->execute();
			Yii::$app->db->createCommand()->createIndex ("tbl_marks_index_alias", "tbl_marks", "alias", false)->execute();

			
			$command->createCommand("CREATE TABLE `tbl_models` 
													SELECT  UPPER(make) as make,
													UPPER(model) as model,

													CONCAT_WS('-',
														LOWER(REPLACE(REPLACE(REPLACE(make, ' ', ''), '.', ''), '-', '')),
														LOWER(REPLACE(REPLACE(REPLACE(model, ' ', ''), '.', ''), '-', ''))
													) AS alias,
													 
													COUNT(*) AS count_make 
													FROM `tbl_lots_temp`  
													WHERE make != '' AND model != ''  AND year != 0 AND year != '' 
													
													
													GROUP BY make, model HAVING count_make > 2"
												)->execute();

			Yii::$app->db->createCommand()->createIndex ("tbl_models_index_make", "tbl_models", "make", false)->execute();
			Yii::$app->db->createCommand()->createIndex ("tbl_models_index_model", "tbl_models", "model", false)->execute();
			Yii::$app->db->createCommand()->createIndex ("tbl_models_index_alias", "tbl_models", "alias", false)->execute();


			$command->createCommand("CREATE TABLE `tbl_models_as`
											SELECT UPPER(make) as make,
											UPPER(model) as model,

											year as year_data,

											CONCAT_WS('-',
														year,
														LOWER(REPLACE(REPLACE(REPLACE(make, ' ', ''), '.', ''), '-', '')),
														LOWER(REPLACE(REPLACE(REPLACE(model, ' ', ''), '.', ''), '-', ''))
													) AS alias,

											COUNT(*) AS count_make 
											FROM `tbl_lots_temp`  
											WHERE make != '' AND model != '' AND year != 0 AND year != '' 
											GROUP BY make, model, year_data"
												)->execute();


			Yii::$app->db->createCommand()->createIndex ("tbl_mod_as_index_make", "tbl_models_as", "make", false)->execute();
			Yii::$app->db->createCommand()->createIndex ("tbl_mod_as_index_model", "tbl_models_as", "model", false)->execute();
			Yii::$app->db->createCommand()->createIndex ("tbl_mod_as_index_year_data","tbl_models_as","year_data",false)->execute();
			Yii::$app->db->createCommand()->createIndex ("tbl_mod_as_index_alias", "tbl_models_as", "alias", false)->execute();


			$transaction->commit();

		} catch(\Exception $e) {
		    $transaction->rollBack();
		    throw $e;
		} catch(\Throwable $e) {
		    $transaction->rollBack();
		}

    }
}


