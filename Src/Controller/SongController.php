<?php

namespace Src\Controller;

use App\ControllerInterface;
use App\Exception\BadRequestException;
use App\Request;
use Src\Repository\SongRepository;

/**
 * Class SongController
 *
 * @package Src\Controller
 */
class SongController implements ControllerInterface
{
    /**
     * @param Request $request
     *
     * @return array
     */
    public function getSongAction(Request $request)
    {
        $songId = $request->get('songId');
        if (empty($songId)) {
            throw new BadRequestException('Missing songId');
        }

        $songRepo = new SongRepository();
        $song = $songRepo->getSong($songId);

        if ($song === false) {
            throw new BadRequestException(sprintf('Song: %s not found', $songId));
        }

        return $song;
    }

    /**
     * @param Request $request
     *
     * @return array
     */
    public function getSongsAction(Request $request)
    {
        $songRepo = new SongRepository();
        $songs = $songRepo->getSongs();

        if ($songs === false) {
            throw new BadRequestException('An error occurred while fetching songs');
        }

        return $songs;
    }

    /**
     * @param Request $request
     *
     * @return array
     */
    public function addSongAction(Request $request)
    {
        $name = $request->get('name');
        $duration = $request->get('duration');
        if (empty($name) || empty($duration)) {
            throw new BadRequestException('Missing name or email');
        }

        $songRepo = new SongRepository();
        $result = $songRepo->addSong($name, $duration);

        if ($result === false) {
            throw new BadRequestException(sprintf('An error occurred while inserting user with name: %s, email: %s',
                $name,
                $duration
            ));
        }

        return array(
            'success' => true
        );
    }

    /**
     * @param Request $request
     *
     * @return array
     */
    public function deleteSongAction(Request $request)
    {
        $songId = $request->get('songId');
        if (empty($songId)) {
            throw new BadRequestException('Missing songId');
        }

        $songRepo = new SongRepository();
        $result = $songRepo->deleteSong($songId);

        if ($result === false) {
            throw new BadRequestException(sprintf('An error occurred while deleting songId: %s',
                $songId
            ));
        }

        return array(
            'success' => true
        );
    }
}