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
            <td><?php echo isset($item['subject']) ? $item['subject'] : ''; ?></td>
            <td><?php echo isset($item['topic']) ? $item['topic'] : ''; ?></td>
            <td>
                <?php if (isset($item['id'])): ?>
                    <a href="?id=<?php echo $item['id']; ?>" type="button" class="btn btn-success btn-sm">View</a>
                    <a href="/edit/<?php echo $item['id']; ?>" type="button" class="btn btn-primary btn-sm">
                        Edit
                        <input type="hidden" name="id" value="<?= $item['id']; ?>">
                    </a>
                    <a href="/<?=$item['id']?>" class="btn btn-danger btn-sm" onclick="return confirm('Delete this?');">
                        Delete
                        <input type="hidden" name="id" value="<?= $item['id']; ?>">
                    </a>
                    <form class="mt-6" method="POST" action="/posts/<?= $item['id']; ?>">
                        <input type="hidden" name="_method" value="DELETE">
                        <input type="hidden" name="id" value="<?= $item['id'] ?>">
                        <button class="btn btn-danger btn-sm">Delete</button>
                    </form>

                <?php endif; ?>
            </td>
        </tr>

    <?php endforeach; ?>
    </tbody>
</table>


