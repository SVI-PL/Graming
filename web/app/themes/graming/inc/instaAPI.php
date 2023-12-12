<?php
require_once(__DIR__ . '/../vendor/autoload.php');

use GuzzleHttp\Client;

class InstaAPI
{
    public static $apiKey = "Id10t0GSt97JnKj6";

    //Download insta image
    public function downloadImage(string $url, string $localPath): bool
    {
        $imageContent = file_get_contents($url);
        if ($imageContent === false) {
            return false;
        }
        return file_put_contents($localPath, $imageContent) !== false;
    }

    //Clean photo name
    public function cleanFileName($filename): string
    {
        $filename = preg_replace("/(\.jpg).*$/", '.jpg', $filename);
        $filename = preg_replace("/[^a-zA-Z0-9\_\-\.]/", '', $filename);
        return $filename;
    }

    //Get local path for image
    public function getLocalImagePath(array $item): string
    {
        $url = $item['thumbnail_resources']['src'];
        $filename = basename($url);
        $filename = $this->cleanFileName($filename);
        $localPath = get_template_directory() . '/temp/' . $filename;
        $success = $this->downloadImage($url, $localPath);
        return $success ? get_template_directory_uri() . '/temp/' . $filename : '';
    }

    public function getUserImagePath(array $item): string
    {
        $url = $item['profile_pic_url'];
        $filename = basename($url);
        $filename = $this->cleanFileName($filename);
        $localPath = get_template_directory() . '/temp/' . $filename;
        $success = $this->downloadImage($url, $localPath);
        return $success ? get_template_directory_uri() . '/temp/' . $filename : '';
    }

    //Get insta user
    public function get_user(string $account): array|string
    {
        $client = new Client();
        $auth = self::$apiKey;
        $apiEndPoint = "https://www.ensembledata.com/apis/instagram/user/info?username={$account}&token={$auth}";
        try {
            $response = $client->request('GET', $apiEndPoint, [
                'headers' => [
                    'Content-Type' => 'application/json',
                ],
            ]);
            if ($response->getStatusCode() == 200) {
                $json = json_decode($response->getBody()->getContents(), true);
                $originalArray = $json["data"];
                if ($originalArray == NULL) {
                    echo json_encode("404", JSON_PRETTY_PRINT);
                    exit;
                }
                $newArray = [];
                $newItem = [
                    'pk' => $originalArray['pk'],
                    'username' => $originalArray['username'],
                    'full_name' => $originalArray['full_name'],
                    'is_private' => $originalArray['is_private'],
                    'profile_pic_url' => $originalArray['profile_pic_url'],
                ];
                $newItem['local_image_path'] = $this->getUserImagePath($newItem);
                $newArray[] = $newItem;

                echo json_encode($newArray, JSON_PRETTY_PRINT);
                exit;
            } else {
                return "Guzzle Error: " . $response->getStatusCode();
            }
        } catch (\Exception $e) {
            return "Guzzle Error: " . $e->getMessage();
        }
    }

    //Get insta user photo
    public function get_user_photo(string $responseId): array|string
    {
        $client = new Client();
        $auth = self::$apiKey;
        $apiEndPoint = "https://www.ensembledata.com/apis/instagram/user/posts?user_id={$responseId}&depth=1&chunk_size=9&start_cursor=&alternative_method=False&token={$auth}";

        try {
            $response = $client->request('GET', $apiEndPoint, [
                'headers' => [
                    'Content-Type' => 'application/json',
                ],
            ]);
            if ($response->getStatusCode() == 200) {
                $json = json_decode($response->getBody()->getContents(), true);

                $originalArray = $json["data"]["posts"];
                $newArray = [];
                foreach ($originalArray as $item) {
                    $newItem = [
                        'typename' => $item['node']['__typename'],
                        'is_video' => $item['node']['is_video'],
                        'display_url' => $item['node']['display_url'],
                        'shortcode' => $item['node']['shortcode'],
                        'thumbnail_resources' => $item['node']['thumbnail_resources']['0'],
                    ];
                    $newItem['local_image_path'] = $this->getLocalImagePath($newItem);
                    $newArray[] = $newItem;
                }
                echo json_encode($newArray, JSON_PRETTY_PRINT);
                exit;

            } else {
                echo json_encode($response->getStatusCode(), JSON_PRETTY_PRINT);
                exit;
            }
        } catch (\Exception $e) {
            echo $e->getCode();
            exit;
        }
    }
}
