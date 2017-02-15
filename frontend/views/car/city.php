<?php

/* @var $this yii\web\View */

use yii\helpers\html;
use yii\helpers\url;
use yii\widgets\Breadcrumbs;

?>


<?php
 $this->params['breadcrumbs'] = $breadcrumbs;
?>


<?php echo $this->render('/_advanced_search', 
	['modelAdvancedSearchForm'=>$modelAdvancedSearchForm, 'makesSearch'=>$makesSearch]);?>
	
<div class="grid_12 model-sort">
	<?php echo $sort->link('year') . ' | ' . $sort->link('price');?>
</div>

<?php echo $this->render('/_item', ['carsList'=>$cityList, 'pages'=>$pages]);?>