<?php

namespace App\Client;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\Client\RequestException;

class PetstoreClient
{
    protected $baseUrl;

    public function __construct()
    {
        $this->baseUrl = 'https://petstore.swagger.io/v2';
    }

    public function findByStatus($status)
    {
        try {
            $response = Http::get("{$this->baseUrl}/pet/findByStatus", ['status' => $status]);
            $response->throw();
            return $response->json();
        } catch (RequestException $e) {
            throw new \Exception('Error fetching pets by status: ' . $e->getMessage());
        }
    }

    public function createPet($data)
    {
        try {
            $response = Http::post("{$this->baseUrl}/pet", $data);
            $response->throw();
            return $response->json();
        } catch (RequestException $e) {
            throw new \Exception('Error creating pet: ' . $e->getMessage());
        }
    }

    public function getPetById($id)
    {
        try {
            $response = Http::get("{$this->baseUrl}/pet/{$id}");
            $response->throw();
            return $response->json();
        } catch (RequestException $e) {
            throw new \Exception('Error fetching pet by ID: ' . $e->getMessage());
        }
    }

    public function updatePet($data)
    {
        try {
            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
            ])->put("{$this->baseUrl}/pet", $data);
            $response->throw();
            return $response->json();
        } catch (RequestException $e) {
            throw new \Exception('Error updating pet: ' . $e->getMessage());
        }
    }

    public function deletePet($id)
    {
        try {
            $response = Http::delete("{$this->baseUrl}/pet/{$id}");
            $response->throw();
            return $response->json();
        } catch (RequestException $e) {
            throw new \Exception('Error deleting pet: ' . $e->getMessage());
        }
    }
}