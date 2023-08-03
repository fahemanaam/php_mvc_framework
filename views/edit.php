
   <form action="/posts/update" method="post">
    <h1>Edit Post</h1>
    <?php foreach($params['edit'] as $post): ?>
    <div class="form-group">
        <label>Subject</label>
        <input type="hidden" name="id" value="<?= htmlspecialchars($post['id']); ?>">
        <input type="text" name="subject" value="<?= htmlspecialchars($post['subject']); ?>" class="form-control">
    </div>
    <div class="mb-3">
        <label>Topic</label>
        <input type="text" name="topic" value="<?= htmlspecialchars($post['topic']); ?>" class="form-control">
    </div>
    <button type="submit" class="btn btn-light">Update</button>
    <?php endforeach; ?>
</form>


