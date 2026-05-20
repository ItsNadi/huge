<div class="container">
    <h1>Chat</h1>

    <div class="chat-container">

        <?php foreach ($this->messages as $msg) { ?>

            <?php if ($msg->sender_id == Session::get('user_id')) { ?>

                <!-- eigene Nachricht -->
                <div class="msg-right">
                    <?= $msg->message ?>
                </div>

            <?php } else { ?>

                <!-- andere Person -->
                <div class="msg-left">
                    <?= $msg->message ?>
                </div>

            <?php } ?>

        <?php } ?>

    </div>
</div>