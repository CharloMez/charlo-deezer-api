<?php

namespace Tests;

use App\Exception\RouteNotFoundException;
use App\Router;
use Src\Controller\UserController;

class RouterTest extends \PHPUnit_Framework_TestCase
{
    public function testEvalControllerAction()
    {
        $request = $this->getRequestMock();

        $request->expects($this->any())
            ->method('getMethod')
            ->willReturn('GET');

        $request->expects($this->any())
            ->method('getUri')
            ->willReturn('/users');

        $request->expects($this->any())
            ->method('addData');

        $router = new Router();

        $router->evalControllerAction($request);

        $this->assertInstanceOf(UserController::class, $router->getController());
        $this->assertEquals('getUsersAction', $router->getAction());
    }

    /**
     * @expectedException \App\Exception\RouteNotFoundException
     * @expectedExceptionMessage The request doesn't match any route
     */
    public function testRouteNotFoundException()
    {
        $request = $this->getRequestMock();

        $request->expects($this->any())
            ->method('getMethod')
            ->willReturn('GET');

        $request->expects($this->any())
            ->method('getUri')
            ->willReturn('/test');

        $router = new Router();

        $router->evalControllerAction($request);
    }

    private function getRequestMock()
    {
        return $this->getMockBuilder('App\Request')
            ->disableOriginalConstructor()
            ->setMethods(array('getMethod', 'getUri', 'addData'))
            ->getMock();
    }
}