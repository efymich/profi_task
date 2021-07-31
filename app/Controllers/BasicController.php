<?php


namespace app\Controllers;


class BasicController
{
    public function addUrl(array $data)
    {
        $urlRaw = json_decode(file_get_contents('php://input'), true);

        $url = parse_url($urlRaw['href']) ?? die();
        if (!$this->validateUrl($url)) {
            die('Url is not validate!');
        }

        $protocol = $url['scheme'];
        $oldHost = $url['host'];
        if ($url['query'] !== null) {
            $oldPathName = $url['path'] . "?" . $url['query'];
        } else {
            $oldPathName = $url['path'];
        }
        if ($url['customPathName']) {
            $shortPathName = $url['customPathName'];
        } else {
            $shortPathName = $this->giveUrlKey();
        }


        $query = "INSERT INTO urlTable (protocol,oldHost,oldPathName,shortPathName) VALUES (?,?,?,?)";

        databaseExecute($query, $protocol, $oldHost, $oldPathName, $shortPathName);

        if (!databaseErrors()) {
            echo 'Url was added';
        }
    }

    public function index(array $data)
    {
        $shortPathName = $data['token'];

        $query = "SELECT protocol,oldHost,oldPathName FROM urlTable WHERE shortPathName = ?";

        $result = databaseExecute($query, $shortPathName);

        $resArray = mysqli_fetch_assoc($result);

        $protocol = $resArray['protocol'];
        $host = $resArray['oldHost'];
        $path = $resArray['oldPathName'];
        header("Location: $protocol://$host$path");
        exit;
    }

    private function giveUrlKey()
    {
        $bytes = openssl_random_pseudo_bytes(4);
        $hex = bin2hex($bytes);
        return $hex;
    }

    private function validateUrl(array $url): bool
    {
        if ($url['scheme'] === null || $url['host'] === null) {
            return false;
        }

        $firstCon = preg_match("/(http|https|ftp)/", $url['scheme']) ? true : false;
        $secondCon = preg_match("/^(www.|)[a-zA-Z0-9]+.(com|ru|org|net|gov|biz)$/", $url['host']) ? true : false;
//        $thirdCon = preg_match("/\/.*\/$/",$url["path"]) ? true : false;

        if ($firstCon && $secondCon) {
            return true;
        }
        return false;
    }
}