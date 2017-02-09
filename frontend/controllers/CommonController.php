<?php
namespace frontend\controllers;

use yii;
use yii\web\Controller;
use frontend\models\CarModel;



class CommonController extends Controller
{
	protected $images_server = 1;
	//protected $hash = 'acdfb94ae167046ff1aea7419abb248c';
	//protected $images_date = '2017-01-27 16:56:37';

	public $countItemInColumnsCityData = 5;


	public function getImageUrl($num, $hash = '', $images_date = '0000-00-00 00:00:00', $small=false, $amazon=false)
	{

	    $server = null;
	    $servers = Yii::$app->params['image_servers'];
	    foreach($servers as $k=>$s) {
	        if ($k == $this->images_server)
	            $server = $s;
	            unset($s);
	    }
	    unset($servers);

	    if (!$server || ! $hash || $images_date == '0000-00-00 00:00:00')
	        return null;

	        $s = ($small) ? '_s' : '' ;
	        $hash_h = substr( $hash, 0, 2);
	        $hash_c = substr( $hash, 2, 16);
	        $s_sub_hash = md5($hash.'_'.$num.$s);
	        $s_sub_hash_c = substr($s_sub_hash, 0, 14);
	        $time = strtotime($images_date);
	        return $server['hostname'].'/'.date('Y', $time).'/'.date('m', $time).'/'.date('d', $time).'/'.$hash_h.'/'.$hash_c.'_'.$s_sub_hash_c.'.jpg';
	}


	public function getStatisticToCity()
	{
		$model = new CarModel;
		return $model->getStatisticToCity();
	}

}