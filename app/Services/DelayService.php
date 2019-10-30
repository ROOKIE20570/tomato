<?php

namespace App\Serivces;

use GuzzleHttp\Client;

class DelayService
{
    public function __construct(Client $client)
    {
        $this->client = $client;
        $this->address = config('delay.address');
    }

    public function createDelayJob($topic, $id, $delay, $callback, $body)
    {
        $res = $this->client->request('POST', $this->address, ['json' => ['topic' => $topic, 'id' => $id, 'delay' => $delay, 'callback' => $callback, 'body' => $body]]);

        $jsonResult = $res->getBody()->getContents();
        return json_decode($jsonResult);
    }

    public function getDelayJob($topic, $id)
    {
        $res = $this->client->request('GET', $this->address, ['query' => ['topic' => $topic, 'id' => $id]]);
        $jsonResult = $res->getBody()->getContents();
        return json_decode($jsonResult);
    }

    public function deleteDelayJob($topic, $id)
    {
        $res = $this->client->request('DELETE', $this->address, ['query' => ['topic' => $topic, 'id' => $id]]);
        $jsonResult = $res->getBody()->getContents();
        return json_decode($jsonResult);
    }
}