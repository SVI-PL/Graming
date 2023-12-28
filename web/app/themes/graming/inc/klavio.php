<?php
require_once(__DIR__ . '/../vendor/autoload.php');

class KlavioAPI
{
    //ADD Klavion post function
    function post_klavio($url, $body)
    {
        $api_key = get_field('klaviyo_api','option');
        $client = new \GuzzleHttp\Client();
        try {
            $response = $client->request('POST', $url, [
                'body' => $body,
                'headers' => [
                    'accept' => 'application/json; charset=UTF-8',
                    'authorization' => 'Basic aW5mb0BncmFtaW5nLmNvbTpHcmFtaW5nVGVhbTIwMjQ=',
                    'content-type' => 'application/json',
                  ],
            ]);

            echo $response->getBody();
        } catch (\GuzzleHttp\Exception\RequestException $e) {
            return 'Guzzle Exception: ' . $e->getMessage();
        } catch (\Exception $e) {
            return 'Exception: ' . $e->getMessage();
        }
    }

}
