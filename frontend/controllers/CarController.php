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
use frontend\models\SearchForm;
use frontend\models\SearchAdvancedForm;

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

       $countItemInColumns = $modelModel->getCountItemInColumn($model['make']);
       //var_dump($countItemInColumns);exit;

       //
       $carsList = $makeModel->getCarsMakeList($model['make']);


       $sort = $this->getSort();

       $breadcrumbs = [
             ['label' => $model['make']],
       ];

       $modelAdvancedSearchForm = new SearchAdvancedForm();
       $makesSearch = $makeModel->getMakesToFormSearchForm();

       $modelAdvancedSearchForm->make = $model['make'];
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
            ['modelList'=>$modelList,'countItemInColumns'=>$countItemInColumns,'carsList'=>$carsList,'sort'=>$sort,
            'breadcrumbs'=>$breadcrumbs, 'modelAdvancedSearchForm'=>$modelAdvancedSearchForm,'makesSearch'=>$makesSearch]
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

        $countItemInColumns = $yearModel->getCountItemInColumn($model['make'], $model['model']);

        //
        $carsList = $modelModel->getCarsModelList($model['make'], $model['model']);


        $sort = $this->getSort();


        $breadcrumbUrl = $modelModel->getBreadcrumbMakeUrl($model['make']);

        $breadcrumbs = [
             ['label' => $model['make'], 'url'=> $breadcrumbUrl],
             ['label' => $model['model']],
        ];

        $makeModel = new MakeModel();

        $modelAdvancedSearchForm = new SearchAdvancedForm();
        $makesSearch = $makeModel->getMakesToFormSearchForm();

        $modelAdvancedSearchForm->make = $model['make'];
        $modelAdvancedSearchForm->model = $model['model'];
        $modelsSearchForm = $makeModel->getModelsToFormSearchForm($model['make']);
       
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
                ['yearList'=>$yearList,'countItemInColumns'=>$countItemInColumns,'carsList'=>$carsList,'sort'=>$sort,'breadcrumbs'=>$breadcrumbs,
                'modelAdvancedSearchForm'=>$modelAdvancedSearchForm,'makesSearch'=>$makesSearch,'modelsSearchForm'=>$modelsSearchForm]
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

        $countItemInColumns = $yearModel->getCountItemInColumn($model['make'], $model['model']);

        //
        $carsList = $yearModel->getCarsYearList($model['make'], $model['model'], $model['year_data']);

       
        $sort = $this->getSort();

        $modelModel = new ModelModel();

        $breadcrumbMakeUrl = $modelModel->getBreadcrumbMakeUrl($model['make']);
        $breadcrumbModelUrl = $modelModel->getBreadcrumbModelUrl($model['model']);

        
        $breadcrumbs = [
             ['label' => $model['make'], 'url'=> $breadcrumbMakeUrl],
             ['label' => $model['model'],'url'=> $breadcrumbModelUrl],
             ['label' => $model['year_data']]
        ];

        
        $makeModel = new MakeModel();

        $modelAdvancedSearchForm = new SearchAdvancedForm();

        $modelAdvancedSearchForm->make = $model['make'];
        $modelAdvancedSearchForm->model = $model['model'];

        $modelsSearchForm = $makeModel->getModelsToFormSearchForm($model['make']);
        $makesSearch = $makeModel->getMakesToFormSearchForm();

       /*
       \yii\helpers\VarDumper::dump('actionYear');
       \yii\helpers\VarDumper::dump('<br />');
       \yii\helpers\VarDumper::dump(Yii::$app->request->pathInfo);
       \yii\helpers\VarDumper::dump('<br />');
       \yii\helpers\VarDumper::dump($model);
       \yii\helpers\VarDumper::dump('<br />');
       \yii\helpers\VarDumper::dump($yearList);
       */

       return $this->render('year', 
                ['yearList'=>$yearList,'countItemInColumns'=>$countItemInColumns,'carsList'=>$carsList,'sort'=>$sort,'breadcrumbs'=>$breadcrumbs,
                'modelAdvancedSearchForm'=>$modelAdvancedSearchForm,'makesSearch'=>$makesSearch,'modelsSearchForm'=>$modelsSearchForm]
            );
    }


    public function actionItem($make, $model, $year, $vin){

        $carModel = new CarModel;
        $car = $carModel->getCar($vin);

        if ($car === false){
            throw new  NotFoundHttpException();            
        }

        $makeAlias = $make;
        $modelAlias = $make . '-' . $model;
        $yearAlias = $year . '-' . $make . '-' . $model;

        $yearModel = new YearModel();
        $modelData = $yearModel->getDataToBreadCrumb($yearAlias);       
        
       
        $breadcrumbs = [
             ['label' => $modelData['make'], 'url'=> '/' . $makeAlias],
             ['label' => $modelData['model'],'url'=> '/' . $modelAlias],
             ['label' => $modelData['year_data'], 'url'=> '/' . $yearAlias],
             ['label' => $car['vin']]
        ];

        return $this->render('item', ['car' => $car,'breadcrumbs'=>$breadcrumbs]);
    }

    public function actionSearch()
    {

        $result = null;

        if (Yii::$app->request->get('SearchAdvancedForm')) {
            $modelSearch = new SearchAdvancedForm();
            if($modelSearch->load(Yii::$app->request->get()) && $modelSearch->validate()){
                $result = $modelSearch->getResultSearch();
            }
        }

        if (Yii::$app->request->get('SearchForm')) {
            $modelSearch = new SearchForm();
            if($modelSearch->load(Yii::$app->request->get()) && $modelSearch->validate()){
                $result = $modelSearch->getResultSearch();
             }
        }

        $sort = $this->getSort();


        $breadcrumbs = [
             ['label' => 'Search']
        ];

        return $this->render('search', ['result' => $result,'breadcrumbs'=> $breadcrumbs,'sort'=>$sort]);
    }

    private function getSort()
    {

         $sort = new Sort([
            'attributes' => [
                
                'year' => [
                        'asc' => ['year' => SORT_ASC],
                        'desc' => ['year' => SORT_DESC],
                        'default' => SORT_DESC,
                        'label' => 'YEAR',
                    ],

                'price' => [
                        'asc' => ['price' => SORT_ASC],
                        'desc' => ['price' => SORT_DESC],
                        'default' => SORT_DESC,
                        'label' => 'PRICE',
                        ],
                    
            ],
        ]);

        return $sort;
    }
   
}
