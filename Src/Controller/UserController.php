<?php

namespace Src\Controller;

use App\ControllerInterface;
use App\Exception\BadRequestException;
use App\Request;
use Src\Repository\UserRepository;

/**
 * Class UserController
 *
 * @package Src\Controller
 */
class UserController implements ControllerInterface
{
    /**
     * @param Request $request
     *
     * @return array
     */
    public function getUserAction(Request $request)
    {
        $userId = $request->get('userId');
        if (empty($userId)) {
            throw new BadRequestException('Missing userId');
        }

        $userRepo = new UserRepository();
        $user = $userRepo->getUser($userId);

        if ($user === false) {
            throw new BadRequestException(sprintf('User: %s not found', $userId));
        }

        return $user;
    }

    /**
     * @param Request $request
     *
     * @return array
     */
    public function getUsersAction(Request $request)
    {
        $userRepo = new UserRepository();
        $users = $userRepo->getUsers();

        if ($users === false) {
            throw new BadRequestException('An error occurred while fetching users');
        }

        return $users;
    }

    /**
     * @param Request $request
     *
     * @return array
     */
    public function addUserAction(Request $request)
    {
        $name = $request->get('name');
        $email = $request->get('email');
        if (empty($name) || empty($email)) {
            throw new BadRequestException('Missing name or email');
        }

        $userRepo = new UserRepository();
        $result = $userRepo->addUser($name, $email);

        if ($result === false) {
            throw new BadRequestException(sprintf('An error occurred while inserting user with name: %s, email: %s',
                $name,
                $email
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
    public function deleteUserAction(Request $request)
    {
        $userId = $request->get('userId');
        if (empty($userId)) {
            throw new BadRequestException('Missing userId');
        }

        $userRepo = new UserRepository();
        $result = $userRepo->deleteUser($userId);

        if ($result === false) {
            throw new BadRequestException(sprintf('An error occurred while deleting userId: %s',
                $userId
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
    public function getUserSongsAction(Request $request)
    {
        $userId = $request->get('userId');
        if (empty($userId)) {
            throw new BadRequestException('Missing userId');
        }

        $userRepo = new UserRepository();
        $songs = $userRepo->getUserSongs($userId);

        if ($songs === false) {
            throw new BadRequestException(sprintf('User: %s not found', $userId));
        }

        return $songs;
    }

    /**
     * @param Request $request
     *
     * @return array
     */
    public function addUserSongAction(Request $request)
    {
        $userId = $request->get('userId');
        $songId = $request->get('songId');
        if (empty($userId) || empty($songId)) {
            throw new BadRequestException('Missing userId or songId');
        }

        $userRepo = new UserRepository();
        $result = $userRepo->addUserSong($userId, $songId);

        if ($result === false) {
            throw new BadRequestException(sprintf('An error occurred while inserting songId: %s on userId: %s',
                $songId,
                $userId
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
    public function deleteUserSongAction(Request $request)
    {
        $userId = $request->get('userId');
        $songId = $request->get('songId');
        if (empty($userId) || empty($songId)) {
            throw new BadRequestException('Missing userId or songId');
        }

        $userRepo = new UserRepository();
        $result = $userRepo->deleteUserSong($userId, $songId);

        if ($result === false) {
            throw new BadRequestException(sprintf('An error occurred while deleting songId: %s on userId: %s',
                $songId,
                $userId
            ));
        }

        return array(
            'success' => true
        );
    }
}