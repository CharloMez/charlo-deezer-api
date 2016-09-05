<?php

namespace App\Response;

/**
 * Class ResponseXml
 *
 * @package App\Response
 */
class ResponseXml implements ResponseInterface
{
    /**
     * @inheritdoc
     */
    public function send(array $data = array())
    {
        $xml = new \SimpleXMLElement('<root/>');

        $xml = $this->arrayToXml($data, $xml);

        return $xml->asXML();
    }

    /**
     * @inheritdoc
     */
    public function fillResponseHeaders($code = 200)
    {
        header('HTTP/1.0 ' . $code);
        header('Content-Type: application/xml');
    }

    /**
     * @param array $data
     * @param \SimpleXMLElement $xml
     *
     * @return \SimpleXMLElement
     */
    private function arrayToXml(array $data, \SimpleXMLElement $xml)
    {
        foreach ($data as $key => $value) {
            is_array($value)
                ? $this->arrayToXml($value, $xml->addChild($key))
                : $xml->addChild($key, $value);
        }

        return $xml;
    }
}