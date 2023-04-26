
<?php
/** @var $this \app\core\View */

$this->title ='Login';
?>
<h1> login</h1>
<?php
/** @var $model \app\core\DbModel */
?>

<?php $form = \app\core\form\Form::begin('', "post")?>


<?php echo $form->field($model, 'email') ?>
<?php echo $form->field($model, 'password')->passwordField()?>


<button class="btn btn-primary" type="submit">Submit </button>

<?php \app\core\form\Form::end()?>


