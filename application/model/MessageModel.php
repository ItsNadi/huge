<?php

class MessageModel
{
    public static function sendMessage($sender_id, $receiver_id, $message)
    {
        $database = DatabaseFactory::getFactory()->getConnection();

        $sql = "CALL sp_send_message(:sender_id, :receiver_id, :message)";
        $query = $database->prepare($sql);
        $query->execute([
            ':sender_id' => $sender_id,
            ':receiver_id' => $receiver_id,
            ':message' => $message
        ]);
    }

    public static function getMessages($user_id)
    {
        $database = DatabaseFactory::getFactory()->getConnection();

        $sql = "CALL sp_get_messages(:user_id)";

        $query = $database->prepare($sql);

        $query->execute([
            ':user_id' => $user_id
        ]);

        return $query->fetchAll();
    }

    public static function getUnreadCount($user_id)
{
        $database = DatabaseFactory::getFactory()->getConnection();

        $sql = "CALL sp_get_unread_count(:user_id)";

        $query = $database->prepare($sql);
        $query->execute([
            ':user_id' => $user_id
        ]);

        return $query->fetch()->cnt;
    }
    public static function getConversation($user1, $user2)
    {
        $database = DatabaseFactory::getFactory()->getConnection();

        $sql = "CALL sp_get_conversation(:user1, :user2)";

        $query = $database->prepare($sql);

        $query->execute([
            ':user1' => $user1,
            ':user2' => $user2
        ]);

        return $query->fetchAll();
    }
    public static function getAllUsers()
    {
        $database = DatabaseFactory::getFactory()->getConnection();

        $sql = "SELECT user_id, user_name
            FROM users
            ORDER BY user_name ASC";

        $query = $database->prepare($sql);
        $query->execute();

        return $query->fetchAll();
    }

        public static function sendGroupMessage($group_id, $sender_id, $message)
    {
        $database = DatabaseFactory::getFactory()->getConnection();

        $sql = "CALL sp_send_group_message(:group_id, :sender_id, :message)";

        $query = $database->prepare($sql);

        $query->execute([
            ':group_id' => $group_id,
            ':sender_id' => $sender_id,
            ':message' => $message
        ]);
    }

        public static function getGroupMessages($group_id)
    {
        $database = DatabaseFactory::getFactory()->getConnection();

        $sql = "CALL sp_get_group_messages(:group_id)";

        $query = $database->prepare($sql);

        $query->execute([
            ':group_id' => $group_id
        ]);

        return $query->fetchAll();
    }  
}