<h1>create new post</h1>

<?php
/** @var $model Model */

use app\core\form\TextareaField;
use app\core\Model;

?>

<?php $form = \app\core\form\Form::begin('', "post")?>

        <?php echo $form->field($model, 'subject') ?>
        <?php echo new TextareaField($model, 'topic') ?>
<?php echo $form->field($model, 'photo')->fileField() ?>

<button class="btn btn-primary" type="submit">Submit </button>

<?php \app\core\form\Form::end()?>




