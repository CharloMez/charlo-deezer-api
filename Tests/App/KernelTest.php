<?php

namespace Tests;

use App\Exception\BadRequestException;
use App\Exception\RouteNotFoundException;
use App\Kernel;

class KernelTest extends \PHPUnit_Framework_TestCase
{
    public function testConstruct()
    {
        $kernel = new Kernel($this->getRequestMock(), $this->getResponseJsonMock(), $this->getRouterMock());

        $this->assertInstanceOf(Kernel::class, $kernel);
    }

    public function testLaunch()
    {
        $router = $this->getRouterMock();
        $userController = $this->getUserControllerMock();

        $userController->expects($this->at(0))
            ->method('getUsersAction')
            ->willReturn(array());

        $router->expects($this->at(0))
            ->method('evalControllerAction');

        $router->expects($this->at(1))
            ->method('getController')
            ->willReturn($userController);

        $router->expects($this->at(2))
            ->method('getAction')
            ->willReturn('getUsersAction');

        $kernel = new Kernel($this->getRequestMock(), $this->getResponseJsonMock(), $router);

        $content = $kernel->launch();

        $this->assertEmpty($content);
    }

    public function testLaunchNotFoundException()
    {
        $router = $this->getRouterMock();
        $response = $this->getResponseJsonMock();

        $response->expects($this->any())
            ->method('send')
            ->with(array(
                'code' => 404,
                'message' => ''
            ));

        $router->expects($this->at(0))
            ->method('evalControllerAction')
            ->will($this->throwException(new RouteNotFoundException()));

        $kernel = new Kernel($this->getRequestMock(), $response, $router);

        $kernel->launch();
    }

    public function testLaunchBadRequestException()
    {
        $router = $this->getRouterMock();
        $userController = $this->getUserControllerMock();
        $response = $this->getResponseJsonMock();

        $response->expects($this->any())
            ->method('send')
            ->with(array(
                'code' => 400,
                'message' => ''
            ));

        $userController->expects($this->at(0))
            ->method('getUsersAction')
            ->will($this->throwException(new BadRequestException()));

        $router->expects($this->at(0))
            ->method('evalControllerAction');

        $router->expects($this->at(1))
            ->method('getController')
            ->willReturn($userController);

        $router->expects($this->at(2))
            ->method('getAction')
            ->willReturn('getUsersAction');

        $kernel = new Kernel($this->getRequestMock(), $response, $router);

        $kernel->launch();
    }

    public function testLaunchException()
    {
        $router = $this->getRouterMock();
        $response = $this->getResponseJsonMock();

        $response->expects($this->any())
            ->method('send')
            ->with(array(
                'code' => 500,
                'message' => ''
            ));

        $router->expects($this->at(0))
            ->method('evalControllerAction');

        $router->expects($this->at(1))
            ->method('getController')
            ->will($this->throwException(new \Exception()));

        $kernel = new Kernel($this->getRequestMock(), $response, $router);

        $kernel->launch();
    }

    private function getRequestMock()
    {
        return $this->getMockBuilder('App\Request')
            ->disableOriginalConstructor()
            ->getMock();
    }

    private function getResponseJsonMock()
    {
        return $this->getMockBuilder('App\Response\ResponseJson')
            ->disableOriginalConstructor()
            ->setMethods(array('send', 'fillResponseHeaders'))
            ->getMock();
    }

    private function getRouterMock()
    {
        return $this->getMockBuilder('App\Router')
            ->disableOriginalConstructor()
            ->setMethods(array('evalControllerAction', 'getController', 'getAction'))
            ->getMock();
    }

    private function getUserControllerMock()
    {
        return $this->getMockBuilder('Src\Controller\UserController')
            ->disableOriginalConstructor()
            ->setMethods(array('getUsersAction'))
            ->getMock();
    }
}