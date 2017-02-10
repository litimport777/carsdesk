<?php
use yii\bootstrap\Modal;
use frontend\assets\AppAsset;

?>

<?php

Modal::begin([
    'header' => '<h2>Signup</h2>',
	'id' => 'signup',
]);

echo 'Say hello...signup';

Modal::end();


Modal::begin([
    'header' => '<h2>Login</h2>',
	'id' => 'login',
]);

echo 'Say hello...login';

Modal::end();


$this->registerJs('
	$(".create").on("click", function(e){
		e.preventDefault();
		$("#signup").modal();
	});
	
	$(".login").on("click", function(e){
		e.preventDefault();
		$("#login").modal();
	});
');
?>