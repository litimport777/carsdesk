<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace console\controllers;

use yii\console\Controller;
use yii\helpers\Url;
use yii\db\Schema;
use yii\db\Query;
use yii;

/**
 * This command echoes the first argument that you have entered.
 *
 * This command is provided as an example for you to learn how to create console commands.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class CheckmakeandmodelController extends Controller
{
    
    /**
     * This command echoes what you have entered as the message.
     * @param string $message the message to be echoed.
     */
    public function actionIndex()
    {
       $command = \Yii::$app->db;

       $command->createCommand()->dropTable("tbl_lots_temp")->execute();
            
       $command->createCommand("CREATE TABLE `tbl_lots_temp` 
                                SELECT *
                                FROM `tbl_lots` 
                                WHERE make != ''  AND `year` != '0' AND year != ''"
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


    }
    
}