<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Http\Controllers\PetController;
use App\Client\PetstoreClient;
use App\Services\PetService;
use Illuminate\Http\Request;
use Mockery;
use App\Http\Requests\StorePetRequest;
use App\Http\Requests\UpdatePetRequest;

class PetControllerTest extends TestCase
{
    protected $petController;
    protected $mockClient;
    protected $mockService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->mockClient = Mockery::mock(PetstoreClient::class);
        $this->mockService = Mockery::mock(PetService::class);
        $this->petController = new PetController($this->mockClient, $this->mockService);
    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }

    public function testIndex()
    {
        $request = Request::create('/pets', 'GET', [
            'status' => 'available',
            'sort_by' => 'name',
            'sort_order' => 'asc'
        ]);

        $pets = [
            ['id' => 1, 'name' => 'Pet 1', 'status' => 'available'],
            ['id' => 2, 'name' => 'Pet 2', 'status' => 'available']
        ];

        $this->mockClient->shouldReceive('findByStatus')
                         ->with('available')
                         ->andReturn($pets);

        $response = $this->petController->index($request);

        $this->assertViewHas('paginatedPets'); // Sprawdź, czy widok zawiera dane
    }

    public function testStore()
    {
        $request = new StorePetRequest([
            'name' => 'New Pet',
            'category' => ['name' => 'Category 1'],
            'photoUrls' => 'http://example.com/photo1.jpg,http://example.com/photo2.jpg',
            'tags' => 'Tag 1,Tag 2',
            'status' => 'available'
        ]);

        $petData = [
            'name' => 'New Pet',
            'category' => ['name' => 'Category 1'],
            'photoUrls' => ['http://example.com/photo1.jpg', 'http://example.com/photo2.jpg'],
            'tags' => [['name' => 'Tag 1'], ['name' => 'Tag 2']],
            'status' => 'available'
        ];

        $this->mockService->shouldReceive('createPet')
                          ->with($petData)
                          ->andReturn($petData);

        $response = $this->petController->store($request);

        $this->assertEquals(302, $response->getStatusCode());
        $this->assertTrue(session()->has('success')); // Sprawdź, czy sesja zawiera komunikat
    }

    public function testEdit()
    {
        $pet = ['id' => 1, 'name' => 'Pet 1', 'status' => 'available'];

        $this->mockClient->shouldReceive('getPetById')
                         ->with(1)
                         ->andReturn($pet);

        $response = $this->petController->edit(1);

        $this->assertViewHas('pet', $pet); // Sprawdź, czy widok zawiera dane
    }

    public function testUpdate()
    {
        $request = new UpdatePetRequest([
            'name' => 'Updated Pet',
            'category' => ['name' => 'Category 1'],
            'photoUrls' => ['http://example.com/photo1.jpg', 'http://example.com/photo2.jpg'],
            'tags' => [['name' => 'Tag 1'], ['name' => 'Tag 2']],
            'status' => 'available'
        ]);

        $petData = [
            'id' => 1,
            'name' => 'Updated Pet',
            'category' => ['name' => 'Category 1'],
            'photoUrls' => ['http://example.com/photo1.jpg', 'http://example.com/photo2.jpg'],
            'tags' => [['name' => 'Tag 1'], ['name' => 'Tag 2']],
            'status' => 'available'
        ];

        $this->mockService->shouldReceive('updatePet')
                          ->with($petData)
                          ->andReturn($petData);

        $response = $this->petController->update($request, 1);

        $this->assertEquals(302, $response->getStatusCode());
        $this->assertTrue(session()->has('success')); // Sprawdź, czy sesja zawiera komunikat
    }

    public function testDestroy()
    {
        $this->mockClient->shouldReceive('deletePet')
                         ->with(1)
                         ->andReturn(true);

        $response = $this->petController->destroy(1);

        $this->assertEquals(302, $response->getStatusCode());
        $this->assertTrue(session()->has('success')); // Sprawdź, czy sesja zawiera komunikat
    }
}