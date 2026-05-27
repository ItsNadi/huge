<?php

class MessageModel
{
    public static function sendMessage($sender_id, $receiver_id, $message)
    {
        $database = DatabaseFactory::getFactory()->getConnection();

        $sql = "INSERT INTO messages (sender_id, receiver_id, message)
                VALUES (:sender_id, :receiver_id, :message)";

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

        $sql = "SELECT * FROM messages
            WHERE sender_id = :user_id OR receiver_id = :user_id
            ORDER BY id DESC";

        $query = $database->prepare($sql);
        $query->execute([':user_id' => $user_id]);

        return $query->fetchAll();
    }

    public static function getUnreadCount($user_id)
    {
        $database = DatabaseFactory::getFactory()->getConnection();

        $sql = "SELECT COUNT(*) AS cnt
            FROM messages
            WHERE receiver_id = :user_id
            AND is_read = 0";

        $query = $database->prepare($sql);
        $query->execute([
            ':user_id' => $user_id
        ]);

        return $query->fetch()->cnt;
    }
    public static function getConversation($user1, $user2)
    {
        $database = DatabaseFactory::getFactory()->getConnection();

        $sql = "SELECT * FROM messages
            WHERE (sender_id = :user1 AND receiver_id = :user2)
               OR (sender_id = :user2 AND receiver_id = :user1)
            ORDER BY id ASC";

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

        $sql = "INSERT INTO group_messages (group_id, sender_id, message)
            VALUES (:group_id, :sender_id, :message)";

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

        $sql = "SELECT group_messages.*, users.user_name
            FROM group_messages
            JOIN users ON group_messages.sender_id = users.user_id
            WHERE group_messages.group_id = :group_id
            ORDER BY group_messages.id ASC";

        $query = $database->prepare($sql);

        $query->execute([
            ':group_id' => $group_id
        ]);

        return $query->fetchAll();
    }
}