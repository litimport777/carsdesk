<?php
namespace frontend\controllers;

use Yii;
use yii\data\Sort;
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

       $countItemInColumns = $modelModel->getCountItemInColumn();

       //
       $carsList = $makeModel->getCarsMakeList($model['make']);


       $sort = $this->getSort();

       $breadcrumbs = [
             ['label' => $model['make']],
       ];


       /*
       \yii\helpers\VarDumper::dump('actionIndex');
       \yii\helpers\VarDumper::dump('<br />');
       \yii\helpers\VarDumper::dump(Yii::$app->request->pathInfo);
       \yii\helpers\VarDumper::dump('<br />');
       \yii\helpers\VarDumper::dump($model);
       \yii\helpers\VarDumper::dump('<br />');
       \yii\helpers\VarDumper::dump($modelList);
       */


        return $this->render('index', 
            ['modelList'=>$modelList,'countItemInColumns'=>$countItemInColumns,'carsList'=>$carsList,'sort'=>$sort,'breadcrumbs'=>$breadcrumbs]
            );
     }

    public function actionModel($make, $model)
    {
        $modelModel = new ModelModel();
        $model = $modelModel->getModelNameByAlias(Yii::$app->request->pathInfo);

        if ($model === false){
            throw new  NotFoundHttpException();            
        }

        $yearModel = new YearModel();
        $yearList = $yearModel->getYearsList($model['make'], $model['model']);

        $countItemInColumns = $yearModel->getCountItemInColumn();

        //
        $carsList = $modelModel->getCarsModelList($model['make'], $model['model']);


        $sort = $this->getSort();


        $breadcrumbUrl = $modelModel->getBreadcrumbUrl($model['make']);

        $breadcrumbs = [
             ['label' => $model['make'], 'url'=> $breadcrumbUrl],
             ['label' => $model['model']],
        ];
       
       /*
       \yii\helpers\VarDumper::dump('actionModel');
       \yii\helpers\VarDumper::dump('<br />');
       \yii\helpers\VarDumper::dump(Yii::$app->request->pathInfo);
       \yii\helpers\VarDumper::dump('<br />');
       \yii\helpers\VarDumper::dump($model);
       \yii\helpers\VarDumper::dump('<br />');
       \yii\helpers\VarDumper::dump($yearList);
       */


       return $this->render('model', 
                ['yearList'=>$yearList,'countItemInColumns'=>$countItemInColumns,'carsList'=>$carsList,'sort'=>$sort,'breadcrumbs'=>$breadcrumbs]
            );
    }

    public function actionYear($make, $model, $year)
    {
        $yearModel = new YearModel();
        $model = $yearModel->getModelYearNameByAlias(Yii::$app->request->pathInfo);

        if ($model === false){
            throw new  NotFoundHttpException();            
        }

        $yearModel = new YearModel();
        $yearList = $yearModel->getYearsList($model['make'], $model['model']);

        $countItemInColumns = $yearModel->getCountItemInColumn();

        //
        $carsList = $yearModel->getCarsYearList($model['make'], $model['model'], $model['year_data']);

       
        $sort = $this->getSort();

       /*
       \yii\helpers\VarDumper::dump('actionYear');
       \yii\helpers\VarDumper::dump('<br />');
       \yii\helpers\VarDumper::dump(Yii::$app->request->pathInfo);
       \yii\helpers\VarDumper::dump('<br />');
       \yii\helpers\VarDumper::dump($model);
       \yii\helpers\VarDumper::dump('<br />');
       \yii\helpers\VarDumper::dump($yearList);
       */

       return $this->render('year', ['yearList'=> $yearList, 'countItemInColumns'=> $countItemInColumns, 'carsList' => $carsList, 'sort' => $sort]);
    }


    public function actionItem($make, $model, $year, $vin){

        $carModel = new CarModel;
        $car = $carModel->getCar($vin);

        if ($car === false){
            throw new  NotFoundHttpException();            
        }

        return $this->render('item', ['car' => $car]);
    }

    private function getSort()
    {

         $sort = new Sort([
            'attributes' => [
                
                'year' => [
                        'asc' => ['year' => SORT_ASC], // от А до Я
                        'desc' => ['year' => SORT_DESC], // от Я до А
                        'default' => SORT_DESC, // сортировка по умолчанию
                        'label' => 'Год', // название
                    ],

                 'price' => [
                            'asc' => ['price' => SORT_ASC], // от А до Я
                            'desc' => ['price' => SORT_DESC], // от Я до А
                            'default' => SORT_DESC, // сортировка по умолчанию
                            'label' => 'Цена', // название
                        ],
                    
            ],
        ]);

        return $sort;
    }
   
}