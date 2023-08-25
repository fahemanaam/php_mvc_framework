<h1>Edit Post</h1>

<?php
/** @var $model Model */
/** @var $form \app\core\form\Form */

use app\core\form\TextareaField;
use app\core\Model;
?>
<?php $form = \app\core\form\Form::begin('/posts', "POST")?>
<?php echo $form->field($model, 'id')->hiddenField()?>
<?php echo $form->field($model, 'subject') ?>
<?php echo new TextareaField($model, 'topic') ?>
<button class="btn btn-primary" type="submit">Update</button>
<?php \app\core\form\Form::end()?>