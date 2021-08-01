<?php

namespace core\Response;

class InfoResponse extends JsonResponse
{

    public function __construct($codeType = 200, $description = "Query complete!", $details = [])
    {
        parent::__construct($codeType, $description);
        $this->details = $details;
    }
}