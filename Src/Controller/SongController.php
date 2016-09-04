<?php

namespace Src\Controller;

use App\ControllerInterface;
use App\Request;

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
        return array();
    }
}