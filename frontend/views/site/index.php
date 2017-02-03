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
        <h5><?php echo $car['make'];?></h5>
    <?php endforeach;?>
</div>
