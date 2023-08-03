<?php

use app\models\PostForm;
/** @var $this \app\core\View */

$this->title ='Posts';?>

<a class="nav-link" href="/post">Add New Post</a>

<table class="table">
  <thead>
    <tr>
      <th scope="col">Subject</th>
      <th scope="col">Topic</th>
      <th scope="col">Action</th>
    </tr>
  </thead>
  <tbody>

  <?php foreach ($params['posts'] as $item): ?>

    <tr>
        <td><?php echo $item['subject']?></td>
        <td><?php echo  $item['topic']?></td>
        <td>



            <a href="?id=<?php echo $item['id']; ?>" type="button" class="btn btn-success btn-sm">View</a>
            <a href="/posts/edit/<?php echo $item['id']; ?>" type="button" class="btn btn-primary btn-sm">
                Edit
                <input type="hidden" name="id" value="<?= $item['id']; ?>">
            </a>

            <a href="/posts/<?=$item['id']?>" class="btn btn-danger btn-sm" onclick="return confirm('Delete this?');">
                Delete
                <input type="hidden" name="id" value="<?= $item['id']; ?>">
            </a>
<!--            <form style="display: inline-block" method="post" action="/Controllers/PostController">-->
<!--                <input type="hidden" name="id" value="--><?php //echo $item['id']?><!--">-->
<!--                <button type="submit" class="btn btn-danger btn-sm">Delete</button>-->
<!--            </form>-->


        </td>

    </tr>




  <?php endforeach?>
  </tbody>
</table>


