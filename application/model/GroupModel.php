<?php

class GroupModel
{
    public static function getAllGroups()
    {
        $database = DatabaseFactory::getFactory()->getConnection();

        $sql = "SELECT * FROM groups";
        $query = $database->prepare($sql);
        $query->execute();

        return $query->fetchAll();
    }
}