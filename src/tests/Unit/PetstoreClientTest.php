<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Client\PetstoreClient;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Client\RequestException;

class PetstoreClientTest extends TestCase
{
    protected $petstoreClient;

    protected function setUp(): void
    {
        parent::setUp();
        $this->petstoreClient = new PetstoreClient();
    }

    public function testFindByStatus()
    {
        Http::fake([
            'https://petstore.swagger.io/v2/pet/findByStatus?status=available' => Http::response([
                ['id' => 1, 'name' => 'Pet 1', 'status' => 'available'],
                ['id' => 2, 'name' => 'Pet 2', 'status' => 'available']
            ], 200)
        ]);

        $response = $this->petstoreClient->findByStatus('available');
        $this->assertIsArray($response);
        $this->assertCount(2, $response);
        $this->assertEquals('Pet 1', $response[0]['name']);
    }

    public function testCreatePet()
    {
        Http::fake([
            'https://petstore.swagger.io/v2/pet' => Http::response([
                'id' => 1,
                'name' => 'New Pet',
                'status' => 'available'
            ], 200)
        ]);

        $data = [
            'name' => 'New Pet',
            'category' => ['name' => 'Category 1'],
            'photoUrls' => ['http://example.com/photo1.jpg'],
            'tags' => [['name' => 'Tag 1']],
            'status' => 'available'
        ];

        $response = $this->petstoreClient->createPet($data);
        $this->assertIsArray($response);
        $this->assertEquals('New Pet', $response['name']);
    }

    public function testGetPetById()
    {
        Http::fake([
            'https://petstore.swagger.io/v2/pet/1' => Http::response([
                'id' => 1,
                'name' => 'Pet 1',
                'status' => 'available'
            ], 200)
        ]);

        $response = $this->petstoreClient->getPetById(1);
        $this->assertIsArray($response);
        $this->assertEquals('Pet 1', $response['name']);
    }

    public function testUpdatePet()
    {
        Http::fake([
            'https://petstore.swagger.io/v2/pet' => Http::response([
                'id' => 1,
                'name' => 'Updated Pet',
                'status' => 'available'
            ], 200)
        ]);

        $data = [
            'id' => 1,
            'name' => 'Updated Pet',
            'category' => ['name' => 'Category 1'],
            'photoUrls' => ['http://example.com/photo1.jpg'],
            'tags' => [['name' => 'Tag 1']],
            'status' => 'available'
        ];

        $response = $this->petstoreClient->updatePet($data);
        $this->assertIsArray($response);
        $this->assertEquals('Updated Pet', $response['name']);
    }

    public function testDeletePet()
    {
        Http::fake([
            'https://petstore.swagger.io/v2/pet/1' => Http::response([], 200)
        ]);

        $response = $this->petstoreClient->deletePet(1);
        $this->assertIsArray($response);
        $this->assertEmpty($response);
    }

    public function testFindByStatusThrowsExceptionOnError()
    {
        Http::fake([
            'https://petstore.swagger.io/v2/pet/findByStatus?status=available' => Http::response([], 500)
        ]);

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Error fetching pets by status');

        $this->petstoreClient->findByStatus('available');
    }

    public function testCreatePetThrowsExceptionOnError()
    {
        Http::fake([
            'https://petstore.swagger.io/v2/pet' => Http::response([], 500)
        ]);

        $data = [
            'name' => 'New Pet',
            'category' => ['name' => 'Category 1'],
            'photoUrls' => ['http://example.com/photo1.jpg'],
            'tags' => [['name' => 'Tag 1']],
            'status' => 'available'
        ];

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Error creating pet');

        $this->petstoreClient->createPet($data);
    }

    public function testGetPetByIdThrowsExceptionOnError()
    {
        Http::fake([
            'https://petstore.swagger.io/v2/pet/1' => Http::response([], 500)
        ]);

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Error fetching pet by ID');

        $this->petstoreClient->getPetById(1);
    }

    public function testUpdatePetThrowsExceptionOnError()
    {
        Http::fake([
            'https://petstore.swagger.io/v2/pet' => Http::response([], 500)
        ]);

        $data = [
            'id' => 1,
            'name' => 'Updated Pet',
            'category' => ['name' => 'Category 1'],
            'photoUrls' => ['http://example.com/photo1.jpg'],
            'tags' => [['name' => 'Tag 1']],
            'status' => 'available'
        ];

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Error updating pet');

        $this->petstoreClient->updatePet($data);
    }

    public function testDeletePetThrowsExceptionOnError()
    {
        Http::fake([
            'https://petstore.swagger.io/v2/pet/1' => Http::response([], 500)
        ]);

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Error deleting pet');

        $this->petstoreClient->deletePet(1);
    }
}