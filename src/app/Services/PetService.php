<?php

namespace App\Services;

use App\Client\PetstoreClient;

class PetService
{
    protected $client;

    public function __construct(PetstoreClient $client)
    {
        $this->client = $client;
    }

    public function createPet(array $data)
    {
        $photoUrls = explode(',', $data['photoUrls']);
        $tags = explode(',', $data['tags']);


        $petData = [
            'name' => $data['name'],
            'category' => [
                'name' => $data['category']['name']
            ],
            'photoUrls' => $photoUrls,
            'tags' => array_map(function ($tag) {
                return ['name' => trim($tag)];
            }, $tags),
            'status' => $data['status']
        ];

        return $this->client->createPet($petData);
    }

    public function updatePet(array $data)
    {
      
        $photoUrls = $data['photoUrls'];  
        $tags = $data['tags'];         

       
        $petData = [
            'id' => $data['id'],  
            'name' => $data['name'],
            'category' => [
                'id' => $data['category']['id'] ?? null,
                'name' => $data['category']['name']
            ],
            'photoUrls' => $photoUrls,
            'tags' => array_map(function ($tag) {
                return [
                    'id' => $tag['id'] ?? null,
                    'name' => $tag['name']
                ];
            }, $tags),
            'status' => $data['status']
        ];

        return $this->client->updatePet($petData);
    }
}