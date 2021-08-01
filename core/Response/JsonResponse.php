<?php

namespace core\Response;

use core\Response\Response_interface\iResponse;

abstract class JsonResponse implements iResponse
{
    public string $description;
    public array $details;
    public int $codeType;
    public string $contentType = "application/json";

    public function __construct($codeType, $description, $details = [])
    {
        $this->codeType = $codeType;
        $this->description = $description;
        $this->details = $details;
    }

    public function formBody(): string
    {
        $arr = [
            "description" => $this->description,
            "details" => $this->details,
        ];

        return $json = json_encode($arr);
    }

    public function formHeader()
    {
        header("HTTP/1.1", true, $this->codeType);
        header("Content-type: $this->contentType");
    }
}