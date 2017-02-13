<?php

/* @var $this yii\web\View */

use yii\helpers\html;
use yii\helpers\url;
use yii\widgets\Breadcrumbs;

?>

<?php
 $this->params['breadcrumbs'] = $breadcrumbs;
?>
<br />

<div class="heading1 wow fadeIn" data-wow-duration="1s" data-wow-delay="0.1s">
    <h2>FIND A CAR</h2>
</div>

<?php echo $this->render('/_advanced_search', 
	['modelAdvancedSearchForm'=>$modelAdvancedSearchForm, 'makesSearch'=>$makesSearch,'modelSearch'=>$modelsSearchForm]);?>

<?php if(isset($result)):?>

<div class="grid_12 model-sort">
	<?php echo $sort->link('year') . ' | ' . $sort->link('price');?>
</div>


	
<?php echo $this->render('/_item', ['carsList'=>$result, 'pages'=>$pages]);?>


<?php endif;?>

<?php

$this->registerJs('

	$(".save-car").each(function(idx, el){
        $(this).on("click", function(event){
            var id = $(this).data().url;
            sendRequestSaveData(id);
        });
    });

    function sendRequestSaveData(id){
        $.post("/site/save-data", {"id": id}, function(data){
            var result = $.parseJSON(data);
            if(result == true){
                var current =$("[data-url=" + id + "]");
                current.next().show();
                current.hide();
            }
        });
    }

');
?>