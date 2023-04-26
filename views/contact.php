<h1> contact us</h1>

<?php
/** @var $model Model */

use app\core\form\TextareaField;
use app\core\Model;
?>

<?php $form = \app\core\form\Form::begin('', "post")?>
<div class="row">
    <div class="col">
        <?php echo $form->field($model, 'subject') ?>
    </div>

    <div class="col">
        <?php echo $form->field($model, 'email') ?>
    </div>
    </div>
    <?php echo new Textareafield($model, 'topic') ?>

<button class="btn btn-primary" type="submit">Submit </button>
<?php \app\core\form\Form::end()?>
