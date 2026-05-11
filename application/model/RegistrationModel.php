<?php

class RegistrationModel
{
    public static function registerNewUser()
    {
        $user_name = strip_tags(Request::post('user_name'));
        $user_email = strip_tags(Request::post('user_email'));
        $user_password_new = Request::post('user_password_new');
        $user_password_repeat = Request::post('user_password_repeat');

        $validation_result = self::registrationInputValidation(
            $user_name,
            $user_password_new,
            $user_password_repeat,
            $user_email
        );

        if (!$validation_result) {
            return false;
        }

        $user_password_hash = password_hash($user_password_new, PASSWORD_DEFAULT);

        if (UserModel::doesUsernameAlreadyExist($user_name)) {
            Session::add('feedback_negative', Text::get('FEEDBACK_USERNAME_ALREADY_TAKEN'));
            return false;
        }

        if (UserModel::doesEmailAlreadyExist($user_email)) {
            Session::add('feedback_negative', Text::get('FEEDBACK_USER_EMAIL_ALREADY_TAKEN'));
            return false;
        }

        // NO EMAIL VERIFICATION
        $user_activation_hash = null;

        if (!self::writeNewUserToDatabase(
            $user_name,
            $user_password_hash,
            $user_email,
            time(),
            $user_activation_hash
        )) {
            Session::add('feedback_negative', Text::get('FEEDBACK_ACCOUNT_CREATION_FAILED'));
            return false;
        }

        $user_id = UserModel::getUserIdByUsername($user_name);

        if (!$user_id) {
            Session::add('feedback_negative', Text::get('FEEDBACK_UNKNOWN_ERROR'));
            return false;
        }

        // USER DIRECTLY ACTIVE
        $database = DatabaseFactory::getFactory()->getConnection();
        $sql = "UPDATE users SET user_active = 1 WHERE user_id = :user_id";
        $query = $database->prepare($sql);
        $query->execute([':user_id' => $user_id]);

        Session::add('feedback_positive', Text::get('FEEDBACK_ACCOUNT_SUCCESSFULLY_CREATED'));
        return true;
    }

    public static function registrationInputValidation($user_name, $user_password_new, $user_password_repeat, $user_email)
    {
        if (
            self::validateUserName($user_name)
            AND self::validateUserEmail($user_email)
            AND self::validateUserPassword($user_password_new, $user_password_repeat)
        ) {
            return true;
        }

        return false;
    }

    public static function validateUserName($user_name)
    {
        if (empty($user_name)) {
            Session::add('feedback_negative', Text::get('FEEDBACK_USERNAME_FIELD_EMPTY'));
            return false;
        }

        if (!preg_match('/^[a-zA-Z0-9]{2,64}$/', $user_name)) {
            Session::add('feedback_negative', Text::get('FEEDBACK_USERNAME_DOES_NOT_FIT_PATTERN'));
            return false;
        }

        return true;
    }

    public static function validateUserEmail($user_email)
    {
        if (empty($user_email)) {
            Session::add('feedback_negative', Text::get('FEEDBACK_EMAIL_FIELD_EMPTY'));
            return false;
        }

        if (!filter_var($user_email, FILTER_VALIDATE_EMAIL)) {
            Session::add('feedback_negative', Text::get('FEEDBACK_EMAIL_DOES_NOT_FIT_PATTERN'));
            return false;
        }

        return true;
    }

    public static function validateUserPassword($user_password_new, $user_password_repeat)
    {
        if (empty($user_password_new) OR empty($user_password_repeat)) {
            Session::add('feedback_negative', Text::get('FEEDBACK_PASSWORD_FIELD_EMPTY'));
            return false;
        }

        if ($user_password_new !== $user_password_repeat) {
            Session::add('feedback_negative', Text::get('FEEDBACK_PASSWORD_REPEAT_WRONG'));
            return false;
        }

        if (strlen($user_password_new) < 6) {
            Session::add('feedback_negative', Text::get('FEEDBACK_PASSWORD_TOO_SHORT'));
            return false;
        }

        return true;
    }

    public static function writeNewUserToDatabase($user_name, $user_password_hash, $user_email, $user_creation_timestamp, $user_activation_hash)
    {
        $database = DatabaseFactory::getFactory()->getConnection();

        $sql = "INSERT INTO users 
                (user_name, user_password_hash, user_email, user_creation_timestamp, user_activation_hash, user_provider_type)
                VALUES 
                (:user_name, :user_password_hash, :user_email, :user_creation_timestamp, :user_activation_hash, :user_provider_type)";

        $query = $database->prepare($sql);
        $query->execute([
            ':user_name' => $user_name,
            ':user_password_hash' => $user_password_hash,
            ':user_email' => $user_email,
            ':user_creation_timestamp' => $user_creation_timestamp,
            ':user_activation_hash' => $user_activation_hash,
            ':user_provider_type' => 'DEFAULT'
        ]);

        return $query->rowCount() == 1;
    }

    public static function rollbackRegistrationByUserId($user_id)
    {
        $database = DatabaseFactory::getFactory()->getConnection();

        $query = $database->prepare("DELETE FROM users WHERE user_id = :user_id");
        $query->execute([':user_id' => $user_id]);
    }

    public static function sendVerificationEmail($user_id, $user_email, $user_activation_hash)
    {
        return true;
    }

    public static function verifyNewUser($user_id, $user_activation_verification_code)
    {
        return true;
    }
}