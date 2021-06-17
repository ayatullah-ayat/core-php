<?php include_once APPROOT . '/views/inc/header.php'; ?>
<h2>index page <?= $data['title']; ?></h2>

<?php foreach($data['posts'] as $post) { ?>
    <p><?= $post->name; ?></p>
<?php } ?>
<?php include_once APPROOT . '/views/inc/footer.php'; ?>