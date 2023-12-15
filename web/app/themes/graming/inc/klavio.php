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
            $client->request('POST', $url, [
                'body' => $body,
                'headers' => [
                    'Authorization' => $api_key,
                    'accept' => 'application/json',
                    'content-type' => 'application/json',
                    'revision' => '2023-10-15',
                ],
            ]);
        } catch (\GuzzleHttp\Exception\RequestException $e) {
            return 'Guzzle Exception: ' . $e->getMessage();
        } catch (\Exception $e) {
            return 'Exception: ' . $e->getMessage();
        }
    }

}
