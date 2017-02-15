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
use yii\db\Query;
use yii;
use frontend\models\MakeModel;
use frontend\models\CarModel;
use common\models\News;

/**
 * This command echoes the first argument that you have entered.
 *
 * This command is provided as an example for you to learn how to create console commands.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class CreatesmController extends Controller
{
    
    private $domen = 'http://car.dev';
	
	private $countRows = 10000;
	
	/**
     * This command echoes what you have entered as the message.
     * @param string $message the message to be echoed.
     */
    public function actionIndex()
    {
 	   $this->createIndexSitemap();
	   $this->createSitemap();
	   $this->createItemSitemap();
    }
	
	
	//
	private function createItemSitemap()
	{
		
		$result =   Yii::$app->db->createCommand('SELECT COUNT(*)
										FROM `tbl_lots_temp` INNER JOIN `tbl_makes`
										ON `tbl_lots_temp`.`make` = `tbl_makes`.`make`
										')->queryScalar();
										
		$count  =   ceil($result/$this->countRows);
						
			
		for($i=1; $i <= $count; $i++){
			unlink(Yii::getAlias('@frontend/web/sitemap' . ($i + 1) . '.xml'));
		}			
		
		
		$xml = '';
		$query = (new Query)->select(["CONCAT_WS('-',
									   'used',
										year,
										LOWER(REPLACE(REPLACE(REPLACE(tbl_lots_temp.make, ' ', ''), '.', ''), '-', '')),
										LOWER(REPLACE(REPLACE(REPLACE(model, ' ', ''), '.', ''), '-', '')),
										vin
										) AS alias"])->from('tbl_lots_temp')
										->innerJoin('tbl_makes','tbl_lots_temp.make = tbl_makes.make');
		$cnt = 1;
		$fileNum = 2;
		
		$fp = fopen(Yii::getAlias('@frontend/web/sitemap' . $fileNum . '.xml'), 'a');
		fwrite($fp,$this->beginXmlSitemap());
		fclose($fp);
		
		foreach($query->each() as $value){
			
			$xml .= '		<url><loc>' . $this->domen  . '/' . $value['alias'] . '</loc></url>' . PHP_EOL;
			
			if(($cnt % 100) == 0){
				$fp = fopen(Yii::getAlias('@frontend/web/sitemap' . $fileNum . '.xml'), 'a');
				fwrite($fp,$xml);
				fclose($fp);
				$xml = '';
			}
			
			if(($cnt % $this->countRows) == 0){
				
				$fp = fopen(Yii::getAlias('@frontend/web/sitemap' . $fileNum . '.xml'), 'a');
				fwrite($fp,$this->endXmlSitemap());
				fclose($fp);
				
				$fileNum++;
				
				$fp = fopen(Yii::getAlias('@frontend/web/sitemap' . $fileNum . '.xml'), 'a');
				fwrite($fp,$this->beginXmlSitemap());
				fclose($fp);
			}
						
						
			$cnt++;
		}
		
		$fp = fopen(Yii::getAlias('@frontend/web/sitemap' . $fileNum . '.xml'), 'a');
		fwrite($fp,$this->endXmlSitemap());
		fclose($fp);
	}
	
	
	//
	private function createSitemap()
	{
		unlink(Yii::getAlias('@frontend/web/sitemap1.xml'));
		
		$fp = fopen(Yii::getAlias('@frontend/web/sitemap1.xml'), 'a');
		fwrite($fp,$this->beginXmlSitemap());
		fclose($fp);		
		
		$fp = fopen(Yii::getAlias('@frontend/web/sitemap1.xml'), 'a');
		fwrite($fp,$this->middleGenerateSitemap());
		fclose($fp);

		$fp = fopen(Yii::getAlias('@frontend/web/sitemap1.xml'), 'a');
		fwrite($fp,$this->newsGenerateSitemap());
		fclose($fp);
		
		$fp = fopen(Yii::getAlias('@frontend/web/sitemap1.xml'), 'a');
		fwrite($fp,$this->makesGenerateSitemap());
		fclose($fp);
		
		$fp = fopen(Yii::getAlias('@frontend/web/sitemap1.xml'), 'a');
		fwrite($fp,$this->modelsGenerateSitemap());
		fclose($fp);
		
		$fp = fopen(Yii::getAlias('@frontend/web/sitemap1.xml'), 'a');
		fwrite($fp,$this->yearsGenerateSitemap());
		fclose($fp);
		
		$fp = fopen(Yii::getAlias('@frontend/web/sitemap1.xml'), 'a');
		fwrite($fp,$this->generateCitySitemap());
		fclose($fp);		
		
		$fp = fopen(Yii::getAlias('@frontend/web/sitemap1.xml'), 'a');
		fwrite($fp,$this->endXmlSitemap());
		fclose($fp);
	}
	
	
	private function middleGenerateSitemap()
	{
		$xml  = '';
		$xml .= '		<url><loc>' . $this->domen . '</loc></url>' . PHP_EOL;
		$xml .= '		<url><loc>' . $this->domen  . '/car/search' . '</loc></url>' . PHP_EOL;
		$xml .= '		<url><loc>' . $this->domen  . '/news' . '</loc></url>' . PHP_EOL;
		return $xml;
	}
	
	private function newsGenerateSitemap()
	{
		$xml = '';
		foreach((new News)->getNewsToNewsPage() as $value){
			$xml .= '		<url><loc>' . $this->domen  . '/news/' . $value['id'] . '</loc></url>' . PHP_EOL;
		} 
		return $xml;
	}
	
	private function makesGenerateSitemap()
	{
		$xml = '';
		foreach((new MakeModel)->getMakes() as $value){
			$xml .= '		<url><loc>' . $this->domen  . '/' . $value['alias'] . '</loc></url>' . PHP_EOL;
		} 
		return $xml;
	}
	
	private function modelsGenerateSitemap()
	{
		$xml = '';
		$query = (new Query)->from('tbl_models');
		foreach($query->each() as $value){
			$xml .= '		<url><loc>' . $this->domen  . '/' . $value['alias'] . '</loc></url>' . PHP_EOL;
		}
		return $xml;
	}
	
	private function yearsGenerateSitemap()
	{
		$xml = '';
		$query = (new Query)->from('tbl_models_as');
		foreach($query->each() as $value){
			$xml .= '		<url><loc>' . $this->domen  . '/' . $value['alias'] . '</loc></url>' . PHP_EOL;
		} 
		return $xml;
	}
	
	private function generateCitySitemap()
	{
		$xml = '';
		foreach((new CarModel)->getStatisticToCity() as $value){
			$xml .= '		<url><loc>' . $this->domen  . '/' . strtolower(str_replace(' ','-',$value['city'])) . '</loc></url>' . PHP_EOL;
		} 
		return $xml;		
	}
	
	//
	private function beginXmlSitemap()
	{
		$xml  = '<?xml version="1.0" encoding="UTF-8"?>' . PHP_EOL;
		$xml .= '	<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . PHP_EOL;
		
		return $xml;
	}
	
	private function endXmlSitemap()
	{
		$xml = '	</urlset>' . PHP_EOL;
		
		return $xml;
	}	
	
	
	
	////////////////////////////////////
	private function createIndexSitemap()
	{
		$xml  = $this->beginXmlIndexSitemap();
		
		$xml .= $this->middleIndexSitemap();
		
		$xml .= $this->middleGenerateIndexSitemap();
		
		$xml .= $this->endXmlIndexSitemap();
		
		file_put_contents(Yii::getAlias('@frontend/web/sitemapindex.xml'),$xml);
	}	
	
	
	//
	private function middleIndexSitemap()
	{
		$xml = '		<sitemap>' . PHP_EOL;
		$xml .= '			<loc>' . $this->domen  . '/sitemap1.xml</loc>' . PHP_EOL;
		$xml .= '		</sitemap>' . PHP_EOL;
		
		return $xml;		
	}
	
	
	//
	private function middleGenerateIndexSitemap()
	{
			$result =   Yii::$app->db->createCommand('SELECT COUNT(*)
										FROM `tbl_lots_temp` INNER JOIN `tbl_makes`
										ON `tbl_lots_temp`.`make` = `tbl_makes`.`make`
										')->queryScalar();
										
			$count  =   ceil($result/$this->countRows);
			
			$xml = '';
			
			for($i=1; $i <= $count; $i++){
				$xml .= '		<sitemap>' . PHP_EOL;
				$xml .= '			<loc>' . $this->domen  . '/sitemap' . ($i + 1) . '.xml</loc>' . PHP_EOL;
				$xml .= '		</sitemap>' . PHP_EOL;
			}			
			
			return $xml;
	}
	
	
	//
	private function beginXmlIndexSitemap()
	{
		$xml  = '<?xml version="1.0" encoding="UTF-8"?>' . PHP_EOL;
		$xml .= '	<sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . PHP_EOL;
		
		return $xml;
	}
	
	private function endXmlIndexSitemap()
	{
		$xml = '	</sitemapindex>' . PHP_EOL;
		
		return $xml;
	}
}