<?php


namespace app\Controllers;


class BasicController
{
    public function addUrl(array $data)
    {
        $url = json_decode(file_get_contents('php://input'), true);

//        if (!$this->validateUrl($url)) {
//            die('Url is not validate!');
//        }

        $protocol = $url['protocol'] ?? '';
        $oldHost = $url['host'];
        $oldPathName = $url['pathName'];
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
        $shortPathName = $data['shortPathName'];

        $query = "SELECT protocol,oldHost,oldPathName FROM urlTable WHERE shortPathName = ?";

        $result = databaseExecute($query, $shortPathName);

        $resArray = mysqli_fetch_assoc($result);

        $protocol = $resArray['protocol'];
        $host = $resArray['oldHost'];
        $path = $resArray['oldPathName'];
        header("Location: $protocol$host$path");
        exit;
    }

    private function giveUrlKey()
    {
        $bytes = openssl_random_pseudo_bytes(4);
        $hex = bin2hex($bytes);
        return $hex;
    }

    private function validateUrl(string $json): bool
    {
        return true;
    }
}