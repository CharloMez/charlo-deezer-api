<?php

namespace Src\Repository;

use App\Database\Repositories;

/**
 * Class SongRepository
 *
 * @package Src\Repository
 */
class SongRepository extends Repositories
{
    /**
     * @param int $songId
     *
     * @return mixed
     */
    public function getSong($songId)
    {
        $query = 'SELECT * FROM song WHERE song_id = :songId';

        $bind = array(
            ':songId' => $songId,
        );

        $song = $this->fetch($query, $bind);

        return $song;
    }

    /**
     * @return mixed
     */
    public function getSongs()
    {
        $query = 'SELECT * FROM song';

        $song = $this->fetchAll($query);

        return $song;
    }

    /**
     * @param string $name
     * @param int $duration
     *
     * @return bool
     */
    public function addSong($name, $duration)
    {
        $query = 'INSERT INTO song (name, duration) VALUES (:name, :duration)';

        $bind = array(
            ':name' => $name,
            ':duration' => $duration
        );

        return $this->execute($query, $bind);
    }

    /**
     * @param int $songId
     *
     * @return bool
     */
    public function deleteSong($songId)
    {
        $query = 'DELETE FROM song WHERE song_id = :songId';

        $bind = array(
            ':songId' => $songId
        );

        return $this->execute($query, $bind);
    }
}