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
use frontend\models\CarModel;

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
	
	private $countRows = 40000;
	
	/**
     * This command echoes what you have entered as the message.
     * @param string $message the message to be echoed.
     */
    public function actionIndex()
    {
 	   $this->createIndexSitemap();
	   $this->createSitemap();
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
		$xml = '<sitemap>' . PHP_EOL;
		$xml .= '<loc>' . $this->domen  . '/sitemap1.xml</loc>' . PHP_EOL;
		$xml .= '</sitemap>' . PHP_EOL;
		
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
				$xml .= '<sitemap>' . PHP_EOL;
				$xml .= '<loc>' . $this->domen  . '/sitemap' . ($i + 1) . '.xml</loc>' . PHP_EOL;
				$xml .= '</sitemap>' . PHP_EOL;
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
		$xml = '</sitemapindex>' . PHP_EOL;
		
		return $xml;
	}
}