<div class="container">

    <!-- system feedback messages -->
    <?php $this->renderFeedbackMessages(); ?>

    <div class="login-box" style="width: 50%; display: block;">
        <h2>Create new user (Admin only)</h2>

        <!-- register form -->
        <form method="post" action="<?php echo Config::get('URL'); ?>register/register_action">

            <!-- username -->
            <input type="text"
                   pattern="[a-zA-Z0-9]{2,64}"
                   name="user_name"
                   placeholder="Username (letters/numbers, 2-64 chars)"
                   required />

            <!-- email -->
            <input type="text"
                   name="user_email"
                   placeholder="email address"
                   required />

            <!-- password -->
            <input type="password"
                   name="user_password_new"
                   pattern=".{6,}"
                   placeholder="Password (6+ characters)"
                   required
                   autocomplete="off" />

            <!-- repeat password -->
            <input type="password"
                   name="user_password_repeat"
                   pattern=".{6,}"
                   placeholder="Repeat your password"
                   required
                   autocomplete="off" />

            <!-- submit -->
            <input type="submit" value="Register User" />

        </form>

        <!-- navigation / visible button -->
        <?php if (Session::get('user_account_type') == 7): ?>
            <div style="margin-top: 15px;">
                <a href="<?php echo Config::get('URL'); ?>profile/index">
                    <button type="button">Back to Profiles</button>
                </a>
            </div>
        <?php endif; ?>

    </div>
</div>