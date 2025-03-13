<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Services\PetService;
use App\Client\PetstoreClient;
use Mockery;

class PetServiceTest extends TestCase
{
    protected $petService;
    protected $mockClient;

    protected function setUp(): void
    {
        parent::setUp();
        $this->mockClient = Mockery::mock(PetstoreClient::class);
        $this->petService = new PetService($this->mockClient);
    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }

    public function testCreatePet()
    {
        $data = [
            'name' => 'New Pet',
            'category' => ['name' => 'Category 1'],
            'photoUrls' => 'http://example.com/photo1.jpg,http://example.com/photo2.jpg',
            'tags' => 'Tag 1,Tag 2',
            'status' => 'available'
        ];

        $expectedPetData = [
            'name' => 'New Pet',
            'category' => ['name' => 'Category 1'],
            'photoUrls' => ['http://example.com/photo1.jpg', 'http://example.com/photo2.jpg'],
            'tags' => [['name' => 'Tag 1'], ['name' => 'Tag 2']],
            'status' => 'available'
        ];

        $this->mockClient->shouldReceive('createPet')
                        ->with($expectedPetData)
                        ->andReturn($expectedPetData);

        $result = $this->petService->createPet($data);

        $this->assertIsArray($result); // Sprawdzenie, że wynik to tablica
        $this->assertEquals($expectedPetData, $result);
    }


    public function testUpdatePet()
    {
        $data = [
            'id' => 1,
            'name' => 'Updated Pet',
            'category' => ['id' => 1, 'name' => 'Category 1'],
            'photoUrls' => ['http://example.com/photo1.jpg', 'http://example.com/photo2.jpg'],
            'tags' => [['id' => 1, 'name' => 'Tag 1'], ['name' => 'Tag 2']],
            'status' => 'available'
        ];

        $expectedPetData = [
            'id' => 1,
            'name' => 'Updated Pet',
            'category' => ['id' => 1, 'name' => 'Category 1'],
            'photoUrls' => ['http://example.com/photo1.jpg', 'http://example.com/photo2.jpg'],
            'tags' => [['id' => 1, 'name' => 'Tag 1'], ['id' => null, 'name' => 'Tag 2']],
            'status' => 'available'
        ];

        $this->mockClient->shouldReceive('updatePet')
                         ->with($expectedPetData)
                         ->andReturn($expectedPetData);

        $result = $this->petService->updatePet($data);

        $this->assertEquals($expectedPetData, $result);
    }
}