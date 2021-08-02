<?php

namespace core\Response;


class ErrorResponse extends Response
{
    public int $responseCode;
    public string $wrapper = 'data';
    public $data;
    private array $headers = [
        "Content-type" => "text/html"
    ];


    public function __construct($responseCode, $data, $headers = [])
    {
        $this->responseCode = $responseCode;
        foreach ($headers as $headerKey => $headerVal) {
            $this->headers[$headerKey] = $headerVal;
        }
        $this->data = $data;
    }

    public function convertArray()
    {
        if (gettype($this->data) === "string") {
            return $this->data;
        }
        if (gettype($this->data) === "array") {
            $res = '';
            foreach ($this->data as $key => $val) {
                $res .= "$key : $val \n";
            }
            return $res;
        }
        return "$this->wrapper : null";
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