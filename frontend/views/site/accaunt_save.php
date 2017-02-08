<?php

/* @var $this yii\web\View */

use yii\helpers\html;
use yii\helpers\url;
use yii\widgets\ActiveForm;

?>


<?php foreach($accauntdata as $value):?>
<div>
	<h2>
		<?php echo Html::a($value['make'], Url::to($value['alias'], true));?>
	</h2>
	<div><?= $value['model']; ?></div>
	<div><?= $value['year']; ?></div>
	<div><?= $value['price']; ?></div>
	<br/>
	<button data-url="<?= $value['tbl_lots_temp_id']; ?>" class="delete-car">DELETE</button>
</div>
<?php endforeach;?>

<?php

$this->registerJs('
    	
	$(".delete-car").each(function(idx, el){
        $(this).on("click", function(event){
            var id = $(this).data().url;
            sendRequestSaveData(id);
        });
    });

    function sendRequestSaveData(id){
        $.post("/site/delete-data", {"id": id}, function(data){
            var result = $.parseJSON(data);
            if(result == true){
                var current =$("[data-url=" + id + "]");
                console.log(current.parent().remove());
            }
        });
    }
')

?>