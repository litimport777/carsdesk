<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\NewsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'News';
$this->params['breadcrumbs'][] = $this->title;
?>

<?php

$this->registerCss('
.news-index .grid-view table tbody tr td:nth-child(2){
	width: 400px !important;
}
');

?>
<div class="news-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create News', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            
            'name' => [
				'attribute' => 'name',
				'format'=>'text',
				'options'=>['style' => 'width: 200px'],
			],
            'data' => [
				'attribute' => 'data',
				'filter'=> false,
				//'format'=>'text',
				'options'=>['style' => 'width: 400px'],
			],
            'img' =>[
				'attribute' => 'img',
				'filter'=> false,
				'options'=>['style' => 'width: 300px'],
			],

            ['class' => 'yii\grid\ActionColumn', 'template'=>'{update}{delete}', 'options'=>['style' => 'width: 30px']],
        ],
    ]); ?>
</div>
