<?php

namespace App\Response;

/**
 * Interface ResponseInterface
 *
 * @package App\Response
 */
interface ResponseInterface
{
    /**
     * @param array $data
     *
     * @return mixed
     */
    public function send(array $data = array());

    /**
     * @param int $code
     *
     * @return mixed
     */
    public function fillResponseHeaders($code = 200);
}