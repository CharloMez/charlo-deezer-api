<?php

namespace Tests\App\Response;

use App\Response\ResponseJson;

class ResponseJsonTest extends \PHPUnit_Framework_TestCase
{
    public function testSend()
    {
        $response = new ResponseJson();

        $data = $response->send(array(
           'test' => 42
        ));

        $this->assertEquals('{"test":42}', $data);
    }
}