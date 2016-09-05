<?php

namespace Tests\App\Response;

use App\Response\ResponseXml;

class ResponseXmlTest extends \PHPUnit_Framework_TestCase
{
    public function testSend()
    {
        $response = new ResponseXml();

        $data = $response->send(array(
           'test' => 42
        ));

        $this->assertContains('<root><test>42</test></root>', $data);
    }
}