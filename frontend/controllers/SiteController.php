<?php
namespace frontend\controllers;

use Yii;
use yii\helpers\VarDumper;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use frontend\models\SignupForm;
use frontend\models\ContactForm;
use frontend\models\MakeModel;
use frontend\models\CarModel;
use frontend\models\SearchForm;
use frontend\models\AccauntForm;
use common\models\News;

/**
 * Site controller
 */
class SiteController extends CommonController
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout', 'signup', 'accaunt', 'accaunt-save'],
                'rules' => [
                    [
                        'actions' => ['signup'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['logout', 'accaunt', 'accaunt-save'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        $makeModel = new MakeModel;

        $makes = $makeModel->getMakes();
        $countItemInColumns = $makeModel->getCountItemInColumn();

        $carModel = new CarModel;
        $carsRandom = $carModel->getCarsToIndexPage();
        
        $model = new SearchForm();
        $makesSearch = $makeModel->getMakesToFormSearchForm();

        $newsList = null;
        $countNewsItemInColumns = null;

        $news = new News;
        $newsList = $news->getNewsToIndexPage();
        $countNewsItemInColumns = ceil(count($newsList)/News::COUNT_COLUMN_NEWS_IN_INDEX_PAGE);
        
        //VarDumper::dump($countNewsItemInColumns);Yii::$app->end();

        return $this->render('index', 
                ['makes'=>$makes,'countItemInColumns'=>$countItemInColumns,'carsRandom'=>$carsRandom,'model'=>$model,
                'makesSearch'=>$makesSearch, 'newsList'=>$newsList, 'countNewsItemInColumns' => $countNewsItemInColumns]
            );
    }

    /**
     * Logs in a user.
     *
     * @return mixed
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        } else {
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Logs out the current user.
     *
     * @return mixed
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return mixed
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail(Yii::$app->params['adminEmail'])) {
                Yii::$app->session->setFlash('success', 'Thank you for contacting us. We will respond to you as soon as possible.');
            } else {
                Yii::$app->session->setFlash('error', 'There was an error sending your message.');
            }

            return $this->refresh();
        } else {
            return $this->render('contact', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Displays about page.
     *
     * @return mixed
     */
    public function actionAbout()
    {
        return $this->render('about');
    }

    /**
     * Signs user up.
     *
     * @return mixed
     */
    public function actionSignup()
    {
        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post())) {
            if ($user = $model->signup()) {
                if (Yii::$app->getUser()->login($user)) {
                    return $this->goHome();
                }
            }
        }

        return $this->render('signup', [
            'model' => $model,
        ]);
    }

    /**
     * Requests password reset.
     *
     * @return mixed
     */
    public function actionRequestPasswordReset()
    {
        $model = new PasswordResetRequestForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', 'Check your email for further instructions.');

                return $this->goHome();
            } else {
                Yii::$app->session->setFlash('error', 'Sorry, we are unable to reset password for the provided email address.');
            }
        }

        return $this->render('requestPasswordResetToken', [
            'model' => $model,
        ]);
    }

    /**
     * Resets password.
     *
     * @param string $token
     * @return mixed
     * @throws BadRequestHttpException
     */
    public function actionResetPassword($token)
    {
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidParamException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->session->setFlash('success', 'New password saved.');

            return $this->goHome();
        }

        return $this->render('resetPassword', [
            'model' => $model,
        ]);
    }


    public function actionNews(){

    }

    
    public function actionAccaunt()
    {
        $accauntModel = new AccauntForm;
        
        if (Yii::$app->request->post()) {
            if($accauntModel->load(Yii::$app->request->post()) && $accauntModel->validate()){
                
                //\yii\helpers\VarDumper::dump(Yii::$app->request->post());Yii::$app->end();
                Yii::$app->db->createCommand()->update('user',
                ['username'=>Yii::$app->request->post('AccauntForm')['username'],'email'=>Yii::$app->request->post('AccauntForm')['email']],
                'id=:id',[':id'=>Yii::$app->user->id])->execute();
            }else {
                $this->redirect('/accaunt');
            }
        }

        $accauntData = null;
        $accauntData = AccauntForm::find()->where(['id'=>Yii::$app->user->id])->one();
        
        return $this->render('accaunt',['accauntdata'=>$accauntData]);
    }

    public function actionAccauntSave()
    {
        $accauntModel = new AccauntForm;
                
        $accauntData = null;
        $accauntData = $accauntModel->getAccauntSaveData(Yii::$app->user->id);

        return $this->render('accaunt_save',['accauntdata'=>$accauntData]);
    }


    public function actionGetmodels()
    {
        $request = Yii::$app->request;
        if($request->isPost && $request->isAjax){
            $param = $request->post('make'); 

            $makeModel = new MakeModel;
            $result = $makeModel->getModelsToFormSearchForm($param);
            echo json_encode($result); Yii::$app->end();
        }
    }

    public function actionSaveData()
    {
        $request = Yii::$app->request;
        if($request->isPost && $request->isAjax){
            $param = $request->post('id'); 

            $accauntModel = new AccauntForm;
            $result = $accauntModel->setSaveData($param);
            echo json_encode((bool)$result); Yii::$app->end();
        }
    }

    public function actionDeleteData()
    {
        $request = Yii::$app->request;
        if($request->isPost && $request->isAjax){
            $param = $request->post('id'); 

            $accauntModel = new AccauntForm;
            $result = $accauntModel->deleteData($param);
            echo json_encode((bool)$result); Yii::$app->end();
        }
    }
}
