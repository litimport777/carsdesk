<?php

/* @var $this yii\web\View */

use yii\helpers\html;
use yii\helpers\url;

?>
<div class="site-index">
    <h1>All cars. One place. Simple Search.</h1>

    <form>

        <select>
            <option>make</option>
        </select> 

        <select>
            <option>model</option>
        </select> 

        <select>
            <option>zip</option>
        </select> 

        <button>search</button>

    </form>

    <hr />

</div>

<div>
<?php $cnt = 1;?>
<?php $cntItems = count($makes);?>

<?php foreach ($makes as $make):?>
    <?php if((($cnt - 1) % $countItemInColumns == 0) || ($cnt == 1)):?>
        <div>
    <?php endif;?>

    <?php echo Html::a($make['make'], Url::to($make['alias'], true));?>

    <?php if(($cnt % $countItemInColumns == 0) || ($cnt == $cntItems)):?>
        </div>
    <?php endif;?>
<?php $cnt++;?>
<?php endforeach;?>
</div>


<div>
    <?php foreach($carsRandom as $car): ?>
    <h2>
		<?php echo Html::a($car['make'], Url::to($car['alias'], true));?>
	</h2>
	<div><?= $car['model']; ?></div>
	<div><?= $car['year']; ?></div>
	<div><?= $car['price']; ?></div>
		
    <?php endforeach;?>
</div>
