<?php

/* @var $this yii\web\View */

use yii\helpers\html;
use yii\helpers\url;
use yii\widgets\ActiveForm;

?>


<?php foreach($accauntdata as $value):?>

<h2>
	<?php echo Html::a($value['make'], Url::to($value['alias'], true));?>
</h2>
<div><?= $value['model']; ?></div>
<div><?= $value['year']; ?></div>
<div><?= $value['price']; ?></div>

<?php endforeach;?>