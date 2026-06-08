<div class="container">

    <h1>My Gallery</h1>

    <form class="gallery-upload" action="<?= Config::get('URL'); ?>gallery/upload" method="post" enctype="multipart/form-data">
        <input type="file" name="picture">
        <input type="submit" value="Upload">
    </form>

    <hr>

    <h2>My Pictures</h2>

    <?php if (!empty($this->pictures)) { ?>

        <div class="gallery-grid">

            <?php foreach ($this->pictures as $picture) { ?>

                <div class="gallery-card">

                    <img src="<?= Config::get('URL'); ?>gallery/show/<?= $picture->id; ?>" alt="picture">

                    <p><?= htmlspecialchars($picture->filename); ?></p>

                    <div class="gallery-actions">
                        <a href="<?= Config::get('URL'); ?>gallery/get/<?= $picture->id; ?>">Download</a>
                        <a href="<?= Config::get('URL'); ?>gallery/share/<?= $picture->id; ?>">Freigeben</a>
                        <a class="delete" href="<?= Config::get('URL'); ?>gallery/delete/<?= $picture->id; ?>">Löschen</a>
                    </div>

                </div>

            <?php } ?>

        </div>

    <?php } else { ?>

        <p>No pictures uploaded yet.</p>

    <?php } ?>

</div>