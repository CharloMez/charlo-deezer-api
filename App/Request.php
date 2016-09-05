<?php

namespace App;
use App\Response\ResponseInterface;
use App\Response\ResponseJson;
use App\Response\ResponseXml;

/**
 * Class Request
 *
 * @package App
 */
class Request
{
    /**
     * @var string
     */
    private $host;

    /**
     * @var string
     */
    private $uri;

    /**
     * @var string
     */
    private $query;

    /**
     * @var string
     */
    private $method;

    /**
     * @var string
     */
    private $accept;

    /**
     * @var array
     */
    private $data;

    /**
     * Store every needed information from $_SERVER and $_POST
     */
    public function evalRequest()
    {
        $this->host = $_SERVER['HTTP_HOST'];
        $this->uri = $_SERVER['REQUEST_URI'];
        $this->query = $_SERVER['QUERY_STRING'];
        $this->method = $_SERVER['REQUEST_METHOD'];
        $this->accept = $_SERVER['HTTP_ACCEPT'];
        $this->data = $_POST;
    }

    /**
     * @param array $data
     */
    public function setData(array $data = array())
    {
        $this->data = $data;
    }

    /**
     * @param array $data
     */
    public function addData(array $data = array())
    {
        $this->data = array_merge($this->data, $data);
    }

    /**
     * @param string $name
     *
     * @return null|string
     */
    public function get($name)
    {
        if (empty($this->data[$name])) {
            return null;
        }

        $value = htmlspecialchars($this->data[$name]);

        if (empty($value)) {
            return null;
        }

        return $value;
    }

    /**
     * @return string
     */
    public function getMethod()
    {
        return $this->method;
    }

    /**
     * @return string
     */
    public function getUri()
    {
        return $this->uri;
    }

    /**
     * @return string
     */
    public function getAcceptHeader()
    {
        return $this->accept;
    }

    /**
     * Evaluate the requested response
     * instantiate the appropriate response object
     *
     * @return ResponseInterface
     */
    public function getResponse()
    {
        $response = null;

        switch ($this->getAcceptHeader()) {
            case 'application/json':
                $response = new ResponseJson();
                break;
            case 'application/xml':
                $response = new ResponseXml();
                break;
            default:
                $response = new ResponseJson();
                break;
        }

        return $response;
    }
}