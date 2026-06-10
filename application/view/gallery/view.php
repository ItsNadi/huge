<div class="container">

    <h1><?= htmlspecialchars($this->picture->filename); ?></h1>

    <img
        src="<?= Config::get('URL'); ?>gallery/show/<?= $this->picture->id; ?>"
        class="full-image"
    >

    <br><br>

    <a href="<?= Config::get('URL'); ?>gallery/index">
        Back to Gallery
    </a>

</div>
