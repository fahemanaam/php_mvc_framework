<?php
use app\models\PostForm;
/** @var $this \app\core\View */

$this->title ='home';
?>
<h2>Welcome <?php echo $name ?></h2>

<table class="table">
  <thead>
    <tr>
      <th scope="col">Subject</th>
      <th scope="col">Topic</th>
      <th scope="col">Action</th>
    </tr>
  </thead>
  <tbody>
  <?php $post = new PostForm();
  foreach ($post->read() as $item): ?>

    <tr>
        <td><?php echo $item['subject']?></td>
        <td><?php echo  $item['topic']?></td>
        <td>



            <a href="?id=<?php  $item['id']; ?>" type="button" class="btn btn-success btn-sm">View</a>

            <a href="?id=<?php echo $item['id']; ?>" type="button" class="btn btn-primary btn-sm">Edit</a>



            <a href="?id=<?php echo $item['id']; ?>" type="button"   data-id="<?php echo $item['id'];  ?>"  class="btn btn-danger btn-sm">Delete</a>

        </td>

    </tr>




  <?php endforeach?>
  </tbody>
</table>


