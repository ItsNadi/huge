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
}