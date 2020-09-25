<?php

namespace App\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;

class VpicRequestService
{
    /**
     * @var Client
     */
    private $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function decodeVinCode($vinCode)
    {
        $response = $this->client->get("api/vehicles/DecodeVin/{$vinCode}?format=json",[
            'headers' => $this->header()
        ]);

        return $this->decodeResult($response);
    }

    public function getManufactures()
    {
        $response = $this->client->get("api/vehicles/getallmakes?format=json",[
            'headers' => $this->header()
        ]);

        return $this->decodeResult($response);
    }

    public function getModels($makeId)
    {
        $response = $this->client->get("/api/vehicles/getmodelsformakeid/{$makeId}?format=json",[
            'headers' => $this->header()
        ]);

        return $this->decodeResult($response);
    }

    private function header()
    {
        return [
//            'Accept' => 'application/json',
        ];
    }

    /**
     * @param Response $response
     * @throws \Exception
     */
    private function decodeResult(Response $response)
    {
        if($response->getStatusCode() != '200'){
            throw new \Exception('Request is fail');
        }

        return \GuzzleHttp\json_decode($response->getBody(), true);
    }
}
