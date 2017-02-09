<?php

/* @var $this yii\web\View */

use yii\helpers\html;
use yii\helpers\url;
use yii\widgets\Breadcrumbs;

?>
<hr />

<?php
 $this->params['breadcrumbs'] = $breadcrumbs;
?>

<?php echo $this->render('/_advanced_search', 
	['modelAdvancedSearchForm'=>$modelAdvancedSearchForm, 'makesSearch'=>$makesSearch,'modelSearch'=>$modelsSearchForm]);?>

<?php if(isset($result)):?>

<?php echo $sort->link('year') . ' | ' . $sort->link('price');?>

<hr />


	
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