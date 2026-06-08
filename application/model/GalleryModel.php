<?php

class GalleryModel
{
    public static function addPicture($owner_id, $filename)
    {
        $database = DatabaseFactory::getFactory()->getConnection();

        $sql = "INSERT INTO user_pictures (owner_id, filename, shared)
                VALUES (:owner_id, :filename, 0)";

        $query = $database->prepare($sql);

        $query->execute([
            ':owner_id' => $owner_id,
            ':filename' => $filename
        ]);
    }
    
    public static function getPictures($owner_id)
    {
        $database = DatabaseFactory::getFactory()->getConnection();

        $sql = "SELECT * FROM user_pictures
                WHERE owner_id = :owner_id";

        $query = $database->prepare($sql);

        $query->execute([
            ':owner_id' => $owner_id
        ]);

        return $query->fetchAll();
    }
    
    public static function getPictureById($picture_id, $user_id)
    {
        $database = DatabaseFactory::getFactory()->getConnection();

        $sql = "SELECT * FROM user_pictures
                WHERE id = :picture_id
                AND owner_id = :user_id
                LIMIT 1";

        $query = $database->prepare($sql);

        $query->execute([
            ':picture_id' => $picture_id,
            ':user_id' => $user_id
        ]);

        return $query->fetch();
    }
    
    public static function sharePicture($picture_id, $user_id)
    {
        $database = DatabaseFactory::getFactory()->getConnection();

        $sql = "UPDATE user_pictures
                SET shared = 1
                WHERE id = :picture_id
                AND owner_id = :user_id";

        $query = $database->prepare($sql);

        $query->execute([
            ':picture_id' => $picture_id,
            ':user_id' => $user_id
        ]);
    }
    public static function deletePicture($picture_id, $user_id)
    {
        $database = DatabaseFactory::getFactory()->getConnection();

        $sql = "DELETE FROM user_pictures
                WHERE id = :picture_id
                AND owner_id = :user_id";

        $query = $database->prepare($sql);

        $query->execute([
            ':picture_id' => $picture_id,
            ':user_id' => $user_id
        ]);
    }
}