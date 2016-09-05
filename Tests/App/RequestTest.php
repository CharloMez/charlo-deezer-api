<?php

namespace Tests;

use App\Request;
use App\Response\ResponseJson;
use App\Response\ResponseXml;

class RequestTest extends \PHPUnit_Framework_TestCase
{
    public function testEvalRequest()
    {
        $request = new Request();

        $_SERVER['HTTP_HOST'] = 'mon-host';
        $_SERVER['REQUEST_URI'] = '/users';
        $_SERVER['QUERY_STRING'] = '';
        $_SERVER['REQUEST_METHOD'] = 'GET';
        $_SERVER['HTTP_ACCEPT'] = 'application/json';
        $_POST = array();

        $request->evalRequest();
        $this->assertEquals('GET', $request->getMethod());
        $this->assertEquals('/users', $request->getUri());
        $this->assertEquals('application/json', $request->getAcceptHeader());
    }

    public function testData()
    {
        $request = new Request();

        $request->setData(array(
            'test' => 'data'
        ));

        $request->addData(array(
            'test2' => '<a>data2</a>'
        ));

        $this->assertEquals('data', $request->get('test'));
        $this->assertEquals('&lt;a&gt;data2&lt;/a&gt;', $request->get('test2'));
        $this->assertNull($request->get('test3'));
    }

    public function testGetResponse()
    {
        $request = new Request();

        $_SERVER['HTTP_ACCEPT'] = 'application/json';
        $request->evalRequest();
        $this->assertInstanceOf(ResponseJson::class, $request->getResponse());

        $_SERVER['HTTP_ACCEPT'] = 'application/xml';
        $request->evalRequest();
        $this->assertInstanceOf(ResponseXml::class, $request->getResponse());

        $_SERVER['HTTP_ACCEPT'] = '';
        $request->evalRequest();
        $this->assertInstanceOf(ResponseJson::class, $request->getResponse());
    }
}