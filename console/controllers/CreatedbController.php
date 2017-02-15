<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace console\controllers;

use yii\console\Controller;
use yii\db\Query;
use yii\db\Schema;
use yii\helpers\Url;
use GuzzleHttp\Client;
use yii;

/**
 * This command echoes the first argument that you have entered.
 *
 * This command is provided as an example for you to learn how to create console commands.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class CreatedbController extends Controller
{
    
	private $startParseUrl = 'http://www.commercialtrucktrader.com/Gettiledata/selectoptions/refreshPowerSearchOptions';
    /**
     * This command echoes what you have entered as the message.
     * @param string $message the message to be echoed.
     */
    public function actionIndex()
    {
        $client = new Client(['verify' => false]);

        $resultRequest = $client->request('GET', $this->startParseUrl);
        $body = $resultRequest->getBody();

        $json = json_decode($body, true);
        

        Yii::$app->db->createCommand()->dropForeignKey('tbl_parse_model_fk_make_id', '`tbl_parse_model`')->execute();

        Yii::$app->db->createCommand()->dropTable("tbl_parse_make")->execute();
        Yii::$app->db->createCommand()->createTable("tbl_parse_make", ['id' => Schema::TYPE_PK, 'name' => Schema::TYPE_STRING])
        											->execute();

        Yii::$app->db->createCommand()->createIndex ("tbl_parse_make_index_name", "tbl_parse_make", "name", false)->execute();

        
        foreach ($json['make'] as $value){
        	if(!empty($value['id']) && !empty($value['name'])){
        		Yii::$app->db->createCommand()->insert('tbl_parse_make', ['id' => $value['id'], 'name' =>  $value['name']])
        									  ->execute();
        	}
        }


        Yii::$app->db->createCommand()->dropTable("tbl_parse_model")->execute();
        Yii::$app->db->createCommand()->createTable("tbl_parse_model", 
        	['id' => Schema::TYPE_INTEGER, 'name' => Schema::TYPE_STRING, 'make_id' => Schema::TYPE_INTEGER])->execute();

        Yii::$app->db->createCommand()->createIndex ("tbl_parse_model_unique_index", "tbl_parse_model", "id", false)->execute();
        Yii::$app->db->createCommand()->createIndex ("tbl_parse_model_make_id", "tbl_parse_model", "make_id", false)->execute();
        Yii::$app->db->createCommand()->createIndex ("tbl_parse_model_name", "tbl_parse_model", "name", false)->execute();

        Yii::$app->db->createCommand()
        	->addForeignKey('tbl_parse_model_fk_make_id', 'tbl_parse_model', 'make_id', 'tbl_parse_make', 'id', 'CASCADE', 'CASCADE')
        	->execute();

        foreach ($json['makeModel'] as $value){
        	if(!empty($value['id']) && !empty($value['name']) && !empty($value['make']['id'])){
        		Yii::$app->db->createCommand()->insert('tbl_parse_model', 
        												['id'=>$value['id'],'name'=>$value['name'],'make_id'=>$value['make']['id']])
        									  ->execute();
        	}
        }

        $this->checkMakeAndModelTable();

    }


    private function checkMakeAndModelTable()
    {
       $command = \Yii::$app->db;

       $command->createCommand()->dropTable("tbl_lots_temp")->execute();
            
       $command->createCommand("CREATE TABLE `tbl_lots_temp` 
                                SELECT *
                                FROM `tbl_lots_new` 
                                WHERE make != ''  AND `year` != '0' AND year != '' AND vin != '' AND count_images != 0"
                                )->execute();

       $command->createCommand()->addPrimaryKey('pk_tbl_lots_temp', 'tbl_lots_temp', 'id')->execute();

       Yii::$app->db->createCommand()->createIndex ("idx_make_tbl_lots_temp", "tbl_lots_temp", "make", false)->execute();
       Yii::$app->db->createCommand()->createIndex ("idx_model_tbl_lots_temp", "tbl_lots_temp", "model", false)->execute();
       Yii::$app->db->createCommand()->createIndex ("idx_year_tbl_lots_temp", "tbl_lots_temp", "year", false)->execute();
       Yii::$app->db->createCommand()->createIndex ("idx_zip_tbl_lots_temp", "tbl_lots_temp", "zip", false)->execute();

      
       $query = (new Query)->select('id, (TRIM(UPPER(make))) as make, (TRIM(UPPER(model))) as model')->from('tbl_lots_temp');
       
       $counterInner = '';
       foreach ($query->batch() as $rows) {
            foreach ($rows as $row) {
                //
                print '---' . $counterInner  . PHP_EOL;

                /*$counterInner++;
                if ($counterInner == 10000) {
                    exit;
                }
                */

                $parseString = \explode(' ', $row['model']);
                $countWords = \count($parseString);

               
                if ($countWords == 1 || $countWords == 0) {
                    continue;
                }


                
                if ($countWords == 5) {
                    
                   
                    $concatStringFour = $parseString[0] . ' ' . $parseString[1] . ' ' . $parseString[2] . ' ' . $parseString[3]
                                        . ' ' . $parseString[4];

                    $updateResultFour =  $command->createCommand("
                                                SELECT `tbl_parse_model`.`name`
                                                FROM `tbl_parse_make` 
                                                INNER JOIN `tbl_parse_model` 
                                                ON `tbl_parse_make`.`id`=`tbl_parse_model`.`make_id`  
                                                AND `tbl_parse_make`.`name`=:make

                                                WHERE `tbl_parse_model`.`name`=:model
                                                LIMIT 1
                                                ", [':make'=>$row['make'],':model' => $concatStringFour])->queryOne();


                    
                    if ($concatStringFour === $updateResultFour['name']) {
                       
                        continue;
                    }

                }
                


                if ($countWords == 4) {
                    
                   
                    $concatStringThree = $parseString[0] . ' ' . $parseString[1] . ' ' . $parseString[2] . ' ' . $parseString[3];
                    $updateResultThree =  $command->createCommand("
                                                SELECT `tbl_parse_model`.`name`
                                                FROM `tbl_parse_make` 
                                                INNER JOIN `tbl_parse_model` 
                                                ON `tbl_parse_make`.`id`=`tbl_parse_model`.`make_id`  
                                                AND `tbl_parse_make`.`name`=:make

                                                WHERE `tbl_parse_model`.`name`=:model
                                                LIMIT 1
                                                ", [':make'=>$row['make'],':model' => $concatStringThree])->queryOne();


                    
                    if ($concatStringThree === $updateResultThree['name']) {
                       
                        continue;
                    }

                }



                if ($countWords == 3) {
                    
                   
                    $concatStringTwo = $parseString[0] . ' ' . $parseString[1] . ' ' . $parseString[2];
                    $updateResultTwo =  $command->createCommand("
                                                SELECT `tbl_parse_model`.`name`
                                                FROM `tbl_parse_make` 
                                                INNER JOIN `tbl_parse_model` 
                                                ON `tbl_parse_make`.`id`=`tbl_parse_model`.`make_id`  
                                                AND `tbl_parse_make`.`name`=:make

                                                WHERE `tbl_parse_model`.`name`=:model
                                                LIMIT 1
                                                ", [':make'=>$row['make'],':model' => $concatStringTwo])->queryOne();


                    
                    if ($concatStringTwo === $updateResultTwo['name']) {
                       
                        continue;
                    }

                }
               

                if ($countWords == 2) {
                    $concatStringOne = $parseString[0] . ' ' . $parseString[1];
                    $updateResultOne =  $command->createCommand("
                                                SELECT `tbl_parse_model`.`name`
                                                FROM `tbl_parse_make` 
                                                INNER JOIN `tbl_parse_model` 
                                                ON `tbl_parse_make`.`id`=`tbl_parse_model`.`make_id`  AND `tbl_parse_make`.`name`=:make
                                                WHERE `tbl_parse_model`.`name`=:model
                                                LIMIT 1
                                                ", [':make'=>$row['make'],':model' => $concatStringOne])->queryOne();


                    if ($concatStringOne === $updateResultOne['name']) {
                        
                        continue;
                    }


                    //var_dump($concatStringOne);
                    //var_dump($updateResultOne);
                    //exit;
                }
                //exit('count === 2');


                Yii::$app->db->createCommand()->update('tbl_lots_temp', 
                                                    ['model'=>$parseString[0]], 'id = :id', [':id'=> $row['id']])
                                          ->execute();

            }
        }

        $this->createAgregateTable();

    }



    private function createAgregateTable()
    {
        $command = \Yii::$app->db;
        
             
        $db = Yii::$app->db;
        $transaction = $command->beginTransaction();

        try {

            $command->createCommand()->dropTable("tbl_makes")->execute();
            $command->createCommand()->dropTable("tbl_models")->execute();
            $command->createCommand()->dropTable("tbl_models_as")->execute();
            
            $command->createCommand("CREATE TABLE `tbl_makes` 
                                                SELECT UPPER(make) as make, 
                                                LOWER(REPLACE(REPLACE(REPLACE(make, ' ', ''), '.', ''), '-', '')) AS alias, 
                                                COUNT(*) AS count_make 
                                                FROM `tbl_lots_temp` 
                                                WHERE make != ''  AND `year` != '0' AND year != '' AND vin != ''



                                                
                                                GROUP BY make HAVING count_make > 30"
                                                )->execute();

            Yii::$app->db->createCommand()->createIndex ("tbl_marks_index_make", "tbl_makes", "make", false)->execute();
            Yii::$app->db->createCommand()->createIndex ("tbl_marks_index_alias", "tbl_makes", "alias", false)->execute();

            
            $command->createCommand("CREATE TABLE `tbl_models` 
                                                    SELECT  UPPER(make) as make,
                                                    UPPER(model) as model,

                                                    CONCAT_WS('-',
                                                        LOWER(REPLACE(REPLACE(REPLACE(make, ' ', ''), '.', ''), '-', '')),
                                                        LOWER(REPLACE(REPLACE(REPLACE(model, ' ', ''), '.', ''), '-', ''))
                                                    ) AS alias,
                                                     
                                                    COUNT(*) AS count_make 
                                                    FROM `tbl_lots_temp`  
                                                    WHERE make != '' AND model != ''  AND year != 0 AND year != '' AND vin != ''
                                                    
                                                    
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
                                            WHERE make != '' AND model != '' AND year != 0 AND year != '' AND vin != ''

											AND id NOT IN (
											
												SELECT id
												FROM `tbl_lots_temp`  
												WHERE make != '' AND model != ''  AND year != 0 AND year != '' AND vin != ''                                                    
												GROUP BY make, model HAVING (COUNT(*) = 1 OR  COUNT(*) = 2)
											
											)
											
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

/*

SELECT id FROM `tbl_lots_temp` WHERE make != '' AND model != '' AND year != 0 AND year != '' GROUP BY make, model HAVING (COUNT(*) = 1 OR COUNT(*) = 2) ORDER BY `tbl_lots_temp`.`id` ASC */