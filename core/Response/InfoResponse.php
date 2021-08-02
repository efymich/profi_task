<?php

namespace core\Response;

class InfoResponse extends Response
{
    public int $responseCode = 200;
    public string $wrapper = 'data';
    public $data;
    private array $headers = [
        "Content-Type" => "application/json"
    ];

    public function __construct($data, $headers = [])
    {
        foreach ($headers as $headerKey => $headerVal) {
            $this->headers[$headerKey] = $headerVal;
        }
        $this->data = $data;
    }

    public function convertArray()
    {
        $arr = [$this->wrapper => $this->data];

        return json_encode($arr);
    }

    public function setHeaders()
    {
        foreach ($this->headers as $headerKey => $headerVal) {
            header("$headerKey:$headerVal");
        }
    }

    public function giveResponse()
    {
        $this->setHeaders();

        die($this->convertArray());
    }
}