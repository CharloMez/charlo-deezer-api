<?php

namespace Src\Repository;

use App\Database\Repositories;

/**
 * Class UserRepository
 *
 * @package Src\Repository
 */
class UserRepository extends Repositories
{
    /**
     * @param int $userId
     *
     * @return array|bool
     */
    public function getUser($userId)
    {
        $query = 'SELECT * FROM user WHERE user_id = :userId';

        $bind = array(
            ':userId' => $userId,
        );

        $user = $this->fetch($query, $bind);

        return $user;
    }

    /**
     * @return array|bool
     */
    public function getUsers()
    {
        $query = 'SELECT * FROM user';

        $users = $this->fetchAll($query);

        return $users;
    }

    /**
     * @param int $userId
     *
     * @return array|bool
     */
    public function getUserSongs($userId)
    {
        $query = 'SELECT s.* FROM song as s' .
            ' LEFT JOIN user_song_list as us on us.song_id = s.song_id' .
            ' WHERE us.user_id = :userId';

        $bind = array(
            ':userId' => $userId,
        );

        $songs = $this->fetchAll($query, $bind);

        return $songs;
    }

    /**
     * @param int $userId
     * @param int $songId
     */
    public function addUserSong($userId, $songId)
    {
        $query = 'INSERT INTO user_song_list (user_id, song_id) VALUES (:userId, :songId)';

        $bind = array(
            ':userId' => $userId,
            ':songId' => $songId
        );

        return $this->execute($query, $bind);
    }

    /**
     * @param int $userId
     * @param int $songId
     */
    public function deleteUserSong($userId, $songId)
    {
        $query = 'DELETE FROM user_song_list WHERE user_id = :userId AND song_id = :songId';

        $bind = array(
            ':userId' => $userId,
            ':songId' => $songId
        );

        return $this->execute($query, $bind);
    }

    /**
     * @param string $name
     * @param int $email
     *
     * @return bool
     */
    public function addUser($name, $email)
    {
        $query = 'INSERT INTO user (name, email) VALUES (:name, :email)';

        $bind = array(
            ':name' => $name,
            ':email' => $email
        );

        return $this->execute($query, $bind);
    }

    /**
     * @param int $userId
     *
     * @return bool
     */
    public function deleteUser($userId)
    {
        $query = 'DELETE FROM user WHERE user_id = :userId';

        $bind = array(
            ':userId' => $userId
        );

        return $this->execute($query, $bind);
    }
}