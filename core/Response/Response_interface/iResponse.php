<?php

namespace core\Response\Response_interface;

interface iResponse
{
    public function setHeaders();

    public function convertArray();

    public function giveResponse();
}