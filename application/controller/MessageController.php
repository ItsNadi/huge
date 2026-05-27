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

    public function index($user_id = null)
    {
        $this->View->render('message/index', [
            'users' => MessageModel::getAllUsers(),
            'messages' => $user_id
                ? MessageModel::getConversation(Session::get('user_id'), $user_id)
                : []
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

    public function group($group_id)
    {
        $this->View->render('message/group', [
            'messages' => MessageModel::getGroupMessages($group_id),
            'group_id' => $group_id
        ]);
    }

    public function sendGroup($group_id, $message)
    {
        MessageModel::sendGroupMessage(
            $group_id,
            Session::get('user_id'),
            $message
        );

        Redirect::to('message/group/' . $group_id);
    }
}