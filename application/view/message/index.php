<div class="container">
    <h1>Messages</h1>

    <?php if (!empty($this->messages)) { ?>
        <?php foreach ($this->messages as $msg) { ?>
            <div>
                <b><?= $msg->sender_id ?>:</b>
                <?= $msg->message ?>
            </div>
        <?php } ?>
    <?php } else { ?>
        <p>No messages yet</p>
    <?php } ?>
</div>