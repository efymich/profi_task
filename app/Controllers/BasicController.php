<?php


namespace app\Controllers;


class BasicController
{
    public function addUrl(string $json) {

        $urlArr = $this->validateUrl($json);

        $query = "";

        databaseExecute($query,);

    }

    public function giveShortUrl() {

    }

    private function validateUrl(string $json):array {

    $url = json_decode($json,true);


    return $url;

    }

}