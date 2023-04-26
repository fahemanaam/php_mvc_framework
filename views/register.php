<?php
// form widget
/** @var $this \app\core\View */

$this->title ='Register';
?>
<h1> Create an account</h1>
<?php
/** @var $model \app\core\DbModel */
?>
<?php $form = \app\core\form\Form::begin('', "post")?>
    <div class="row">
        <div class="col">
            <?php echo $form->field($model, 'firstname') ?>
        </div>
        <div class="col">
    <?php echo $form->field($model, 'lastname') ?>
        </div>
    </div>
    <?php echo $form->field($model, 'email') ?>
    <?php echo $form->field($model, 'password')->passwordField()?>
    <?php echo $form->field($model, 'passwordConfirm')->passwordField() ?>
<button class="btn btn-primary" type="submit">Submit </button>
<?php \app\core\form\Form::end()?>










