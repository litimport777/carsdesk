<?php
namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use frontend\models\MakeModel;
use frontend\models\ModelModel;
use frontend\models\YearModel;
use frontend\models\CarModel;

/**
 * Site controller
 */
class CarController extends Controller
{
    

    public function actionIndex($make)
    {
       $makeModel = new MakeModel();
       $model = $makeModel->getMakeNameByAlias(Yii::$app->request->pathInfo);

       if ($model === false){
            throw new  NotFoundHttpException();            
       }

       $modelModel = new ModelModel();
       $modelList = $modelModel->getModels($model['make']);

       \yii\helpers\VarDumper::dump('actionIndex');
       \yii\helpers\VarDumper::dump('<br />');
       \yii\helpers\VarDumper::dump(Yii::$app->request->pathInfo);
       \yii\helpers\VarDumper::dump('<br />');
       \yii\helpers\VarDumper::dump($model);
       \yii\helpers\VarDumper::dump('<br />');
       \yii\helpers\VarDumper::dump($modelList);
       
        //return $this->render('index', ['makes'=> $makes, 'countItemInColumns'=> $countItemInColumns , 'carsRandom'=> $carsRandom]);
     }

    public function actionModel($make, $model)
    {
        $modelModel = new ModelModel();
        $model = $modelModel->getModelNameByAlias(Yii::$app->request->pathInfo);

        if ($model === false){
            throw new  NotFoundHttpException();            
        }

        $yearModel = new YearModel();
        $yearList = $yearModel->getYearsList($model['make'], $model['make']);

       \yii\helpers\VarDumper::dump('actionModel');
       \yii\helpers\VarDumper::dump('<br />');
       \yii\helpers\VarDumper::dump(Yii::$app->request->pathInfo);
       \yii\helpers\VarDumper::dump('<br />');
       \yii\helpers\VarDumper::dump($model);
       \yii\helpers\VarDumper::dump('<br />');
       \yii\helpers\VarDumper::dump($yearList);

       //return $this->render('index', ['makes'=> $makes, 'countItemInColumns'=> $countItemInColumns , 'carsRandom'=> $carsRandom]);
    }

    public function actionYear($make, $model, $year)
    {
        $yearModel = new YearModel();
        $model = $yearModel->getModelYearNameByAlias(Yii::$app->request->pathInfo);

        if ($model === false){
            throw new  NotFoundHttpException();            
        }

        $yearModel = new YearModel();
        $yearList = $yearModel->getYearsList($model['make'], $model['make']);

       \yii\helpers\VarDumper::dump('actionYear');
       \yii\helpers\VarDumper::dump('<br />');
       \yii\helpers\VarDumper::dump(Yii::$app->request->pathInfo);
       \yii\helpers\VarDumper::dump('<br />');
       \yii\helpers\VarDumper::dump($model);
       \yii\helpers\VarDumper::dump('<br />');
       \yii\helpers\VarDumper::dump($yearList);

       //return $this->render('index', ['makes'=> $makes, 'countItemInColumns'=> $countItemInColumns , 'carsRandom'=> $carsRandom]);
    }

   
}
