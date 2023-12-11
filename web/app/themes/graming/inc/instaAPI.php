<?php
require_once(__DIR__ . '/../vendor/autoload.php');

use GuzzleHttp\Client;

class InstaAPI
{
    public static $apiKey = "Id10t0GSt97JnKj6";

    public function set_user(string $account)
    {
        $client = new Client();
        $auth = self::$apiKey;
        $apiEndPoint = "https://www.ensembledata.com/apis/instagram/user/info?username={$account}&token={$auth}";
        $auth = self::$apiKey;
        try {
            $response = $client->request('GET', $apiEndPoint, [
                'headers' => [
                    'Content-Type' => 'application/json',
                ],
            ]);
            if ($response->getStatusCode() == 200) {
                return $response->getBody()->getContents();
            } else {
                return "Guzzle Error: " . $response->getStatusCode();
            }
        } catch (\Exception $e) {
            return "Guzzle Error: " . $e->getMessage();
        }
    }

    public function get_user(string $scraper, string $responseId)
    {
        $client = new Client();
        $auth = self::$apiKey;
        $apiEndPoint = "https://www.ensembledata.com/apis/instagram/user/info?username={$responseId}&token={$auth}";

        try {
            $response = $client->request('GET', $apiEndPoint, [
                'headers' => [
                    'Content-Type' => 'application/json',
                ],
            ]);

            $response->getBody()->getContents();
        } catch (\Exception $e) {
            "Guzzle Error: " . $e->getMessage();
        }
    }
}
