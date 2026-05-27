<div class="container">

    <h1>Group Chat</h1>

    <section class="discussion">

        <?php foreach ($this->messages as $msg) { ?>

            <?php if ($msg->sender_id == Session::get('user_id')) { ?>

                <div class="bubble sender">
                    <?= htmlspecialchars($msg->message); ?>
                </div>

            <?php } else { ?>

                <div class="bubble recipient">
                    <b><?= htmlspecialchars($msg->user_name); ?>:</b>
                    <?= htmlspecialchars($msg->message); ?>
                </div>

            <?php } ?>

        <?php } ?>

    </section>

</div>