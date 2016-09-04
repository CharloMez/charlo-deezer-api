<?php

namespace App;

use App\Exception\BadRequestException;
use App\Exception\RouteNotFoundException;
use App\Response\ResponseInterface;
use App\Response\ResponseJson;
use App\Response\ResponseXml;

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
     */
    public function __construct()
    {
        $this->request = new Request();
        $this->router = new Router();
    }

    public function launch()
    {
        $code = 200;

        try {
            $this->request->evalRequest();

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

        $this->instantiateResponse();
        $this->response->fillResponseHeaders($code);
        $this->response->send(empty($data) ? array() : $data);
    }

    /**
     * @param $e
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

    /**
     * Evaluate the requested response
     * instantiate the appropriate response object
     */
    private function instantiateResponse()
    {
        switch ($this->request->getAcceptHeader()) {
            case 'application/json':
                $this->response = new ResponseJson();
                break;
            case 'application/xml':
                $this->response = new ResponseXml();
                break;
            default:
                $this->response = new ResponseJson();
                break;
        }
    }
}