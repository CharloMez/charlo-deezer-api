<?php

namespace Src\Controller;

use App\ControllerInterface;
use App\Request;

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
        return array(
            'user' => array(
                'id' => 1,
                'name' => 'Charlo',
                'email' => 'charly.mezari@gmail.com'
            )
        );
    }

    /**
     * @param Request $request
     *
     * @return array
     */
    public function getUserSongsAction(Request $request)
    {
        return array();
    }

    /**
     * @param Request $request
     *
     * @return array
     */
    public function addUserSongAction(Request $request)
    {
        return array();
    }

    /**
     * @param Request $request
     *
     * @return array
     */
    public function delUserSongAction(Request $request)
    {
        return array();
    }
}