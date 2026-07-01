<?php

/**
 * Class CaptchaModel
 *
 * This model class handles the Google reCAPTCHA check.
 */
class CaptchaModel
{
    /**
     * Checks Google reCAPTCHA response.
     *
     * @return bool success of captcha check
     */
    public static function checkCaptcha()
    {
        if (empty($_POST['g-recaptcha-response'])) {
            return false;
        }

        $secretKey = Config::get('RECAPTCHA_SECRET_KEY');
        $captchaResponse = $_POST['g-recaptcha-response'];

        $verifyUrl = 'https://www.google.com/recaptcha/api/siteverify';

        $data = array(
            'secret' => $secretKey,
            'response' => $captchaResponse,
            'remoteip' => $_SERVER['REMOTE_ADDR']
        );

        $options = array(
            'http' => array(
                'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
                'method'  => 'POST',
                'content' => http_build_query($data)
            )
        );

        $context = stream_context_create($options);
        $result = file_get_contents($verifyUrl, false, $context);

        if ($result === false) {
            return false;
        }

        $resultData = json_decode($result);

        return isset($resultData->success) && $resultData->success === true;
    }
}