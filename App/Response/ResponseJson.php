<?php

namespace App\Response;

/**
 * Class ResponseJson
 *
 * @package App\Response
 */
class ResponseJson implements ResponseInterface
{
    /**
     * @inheritdoc
     */
    public function send(array $data = array())
    {
        echo json_encode($data);
    }

    /**
     * @inheritdoc
     */
    public function fillResponseHeaders($code = 200)
    {
        header('HTTP/1.0 ' . $code);
        header('Content-Type: application/json');
    }
}