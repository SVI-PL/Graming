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
            $response =  $client->request('POST', $url, [
                'body' => $body,
                'headers' => [
                    'api-key' => $api_key,
                    'accept' => 'application/json',
                    'content-type' => 'application/json',
                ],
            ]);

            if ($response->getStatusCode() == 200) {
                var_dump($body);
                var_dump($response->getBody()->getContents());
            }
        } catch (\GuzzleHttp\Exception\RequestException $e) {
            return 'Guzzle Exception: ' . $e->getMessage();
        } catch (\Exception $e) {
            return 'Exception: ' . $e->getMessage();
        }
    }

}
