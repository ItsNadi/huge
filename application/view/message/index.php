<div class="container">

    <h1>Messages</h1>

    <div style="display:flex; gap:20px;">

        <!-- LINKS: User Liste -->
        <div style="width:30%; border-right:1px solid #ccc;">

            <h3>User</h3>

            <?php foreach ($this->users as $user) { ?>
                <?php if ($user->user_id != Session::get('user_id')) { ?>

                    <a href="<?= Config::get('URL'); ?>message/index/<?= $user->user_id; ?>">
                        <?= $user->user_name; ?>
                    </a>
                    <br>

                <?php } ?>
            <?php } ?>

        </div>

        <!-- RECHTS: Chat -->
        <div style="width:70%;">

            <h3>Chat</h3>

            <?php if (!empty($this->messages)) { ?>

                <section class="discussion">

                    <?php foreach ($this->messages as $msg) { ?>

                        <?php if ($msg->sender_id == Session::get('user_id')) { ?>

                            <div class="bubble sender">
                                <?= htmlspecialchars($msg->message); ?>
                            </div>

                        <?php } else { ?>

                            <div class="bubble recipient">
                                <?= htmlspecialchars($msg->message); ?>
                            </div>

                        <?php } ?>

                    <?php } ?>

                </section>

            <?php } else { ?>
                <p>Select a user to start chat</p>
            <?php } ?>

        </div>

    </div>

</div>