<?php


namespace app\Controllers;


use core\Response\ErrorResponse;
use core\Response\InfoResponse;
use core\Response\Response;
use core\Response\Response_interface\iResponse;
use Hashids\Hashids;

class BasicController
{
    public function addUrl(array $data): Response
    {
        $url = json_decode(file_get_contents('php://input'), true);

        if ($url === null) {
            return new ErrorResponse(500, "Invalid input JSON");
        }

        if (!$this->validateUrl($url)) {
            return new ErrorResponse(400, "Url is not validate");
        }

        $longUrl = $url['href'];

        $query = "INSERT INTO urlTable (longUrl) VALUES (?)";

        databaseExecute($query, $longUrl);

        $id = $this->giveId();

        $token = $this->encodeToken($id);
        if (isset($url['customToken'])) {
            $token = $url['customToken'];
        }

        $query = "UPDATE urlTable SET token = ? WHERE id = ?";

        databaseExecute($query, $token, $id);

        if (!databaseErrors()) {
            $res = [
                "message" => "Query is OK",
                "newUrl" => "$token"
            ];
            return new InfoResponse($res);
        }
        return new ErrorResponse(500, "Database error!");
    }

    public function index(array $data): iResponse
    {
        $token = $data['token'];

        $query = "SELECT longUrl FROM urlTable WHERE token = ?";

        $result = databaseExecute($query, $token);

        $resArray = mysqli_fetch_assoc($result);

        if (!empty($longUrl = $resArray['longUrl'])) {
            return new InfoResponse("redirect", ["Location" => $longUrl]);
        }

        return new ErrorResponse(500, "Unexpected url!");
    }

    private function encodeToken(int $id)
    {
        $hashids = new Hashids('profi_task', 10);
        $res = $hashids->encode($id);
        return $res;
    }

    private function validateUrl(array $urlRaw): bool
    {
        $url = parse_url($urlRaw['href']);
        if ($url['scheme'] === null || $url['host'] === null) {
            return false;
        }

        $firstCon = preg_match("/(http|https|ftp)/", $url['scheme']) ? true : false;
        $secondCon = preg_match("/^(www.|)[a-zA-Z0-9]+.(com|ru|org|net|gov|biz)$/", $url['host']) ? true : false;

        if ($firstCon && $secondCon) {
            return true;
        }
        return false;
    }

    private function giveId(): int
    {
        $query = "SELECT id FROM urlTable ORDER BY created_at DESC LIMIT 1";

        $result = databaseExecute($query);

        $resArray = mysqli_fetch_assoc($result);

        return $resArray['id'];
    }
}