<?php

class MessageController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        Auth::checkAuthentication();
    }
    public function send($receiver_id, $message)
    {
        MessageModel::sendMessage(
            Session::get('user_id'),
            $receiver_id,
            $message
        );

        Redirect::to('message/index');
    }

    public function index()
    {
        $this->View->render('message/index', [
            'messages' => MessageModel::getMessages(Session::get('user_id')),
            'unreadCount' => MessageModel::getUnreadCount(Session::get('user_id'))
        ]);
    }

    public function chat($user_id)
    {
        $this->View->render('message/chat', [
            'messages' => MessageModel::getConversation(
                Session::get('user_id'),
                $user_id
            )
        ]);
    }
}