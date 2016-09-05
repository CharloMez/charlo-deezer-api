<?php

namespace App;

use App\Exception\BadRequestException;
use App\Exception\RouteNotFoundException;
use App\Response\ResponseInterface;

/**
 * Class Kernel
 *
 * @package App
 */
class Kernel
{
    /**
     * @var Request
     */
    private $request;

    /**
     * @var Router
     */
    private $router;

    /**
     * @var ResponseInterface
     */
    private $response;

    /**
     * Kernel constructor.
     *
     * @param Request $request
     * @param Router $router
     */
    public function __construct(Request $request, ResponseInterface $response, Router $router)
    {
        $this->request = $request;
        $this->router = $router;
        $this->response = $response;
    }

    public function launch()
    {
        $code = 200;

        try {
            $this->router->evalControllerAction($this->request);
            $controller = $this->router->getController();
            $action = $this->router->getAction();

            $data = $controller->$action($this->request);
        } catch (RouteNotFoundException $e) {
            $code = 404;
            $data = $this->setErrorData($e->getMessage(), 404);
        } catch (BadRequestException $e) {
            $code = 400;
            $data = $this->setErrorData($e->getMessage(), 400);
        } catch (\Exception $e) {
            $code = 500;
            $data = $this->setErrorData($e->getMessage(), 500);
        }

        $this->response->fillResponseHeaders($code);

        return $this->response->send(empty($data) ? array() : $data);
    }

    /**
     * @param string $msg
     * @param int $code
     *
     * @return array
     */
    private function setErrorData($msg, $code)
    {
        return array(
            'code' => $code,
            'message' => $msg
        );
    }
}
