<?php

class RegisterController extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Only admin can access user creation form
     */
    public function index()
    {
        if (Session::get('user_account_type') != 7) {
            Redirect::to('login/index');
            return;
        }

        $this->View->render('register/index');
    }

    /**
     * Only admin can create users
     */
    public function register_action()
    {
        if (Session::get('user_account_type') != 7) {
            Redirect::to('login/index');
            return;
        }

        $registration_successful = RegistrationModel::registerNewUser();

        if ($registration_successful) {
            Redirect::to('profile/index');
        } else {
            Redirect::to('register/index');
        }
    }

    /**
     * Disabled verification (not needed anymore)
     */
    public function verify($user_id, $user_activation_verification_code)
    {
        Redirect::to('login/index');
    }
}