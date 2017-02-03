<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace console\controllers;

use yii\console\Controller;
use GuzzleHttp\Client;
use yii\helpers\Url;
use yii\db\Schema;
use yii;

/**
 * This command echoes the first argument that you have entered.
 *
 * This command is provided as an example for you to learn how to create console commands.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class ParcecommercialtrucktraderController extends Controller
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

        Yii::$app->db->createCommand()->dropTable("tbl_parse_model")->execute(); 
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

    }
}