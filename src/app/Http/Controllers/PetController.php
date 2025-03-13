<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Client\PetstoreClient;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\StorePetRequest;
use App\Http\Requests\UpdatePetRequest;

use App\Services\PetService;

class PetController extends Controller
{
    private $client;
    private $petService;

    public function __construct(
        PetstoreClient $client, 
        PetService $petService,
    ){
        $this->client = $client;
        $this->petService = $petService;
    }

    public function index(Request $request)
    {
        try {
        
            $validator = Validator::make($request->all(), [
                'status' => 'nullable|in:available,pending,sold',
                'sort_by' => 'nullable|in:id,name',
                'sort_order' => 'nullable|in:asc,desc',
            ]);

            if ($validator->fails()) {
                return redirect()->route('pets.index')
                                ->withErrors($validator)
                                ->withInput();
            }

            $status = $request->query('status', 'available');
            $sortBy = $request->query('sort_by', 'id');
            $sortOrder = $request->query('sort_order', 'asc');

            $pets = $this->client->findByStatus($status);

        
            usort($pets, function($a, $b) use ($sortBy, $sortOrder) {
                $valueA = $a[$sortBy] ?? null;
                $valueB = $b[$sortBy] ?? null;

                if ($sortOrder == 'asc') {
                    return $valueA <=> $valueB;
                } else {
                    return $valueB <=> $valueA;
                }
            });

        
            $perPage = 10; 
            $currentPage = $request->query('page', 1);
            $offset = ($currentPage - 1) * $perPage;
            $paginatedPets = array_slice($pets, $offset, $perPage);
            $totalPages = ceil(count($pets) / $perPage);

            return view('pets.index', compact('paginatedPets', 'status', 'sortBy', 'sortOrder', 'totalPages', 'currentPage'));
        } catch (\Exception $e) {
            return view('pets.index')->with('error', $e->getMessage());
        }
    }

    
    public function create()
    {
        return view('pets.create');
    }

    public function store(StorePetRequest $request)
    {
        try {
            $validated = $request->validated();

            $response = $this->petService->createPet($petData);
            return redirect()->route('pets.index')->with('success', 'Pet added successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function edit($id)
    {
        try {
            $pet = $this->client->getPetById($id);
            return view('pets.edit', compact('pet'));
        } catch (\Exception $e) {
            return redirect()->route('pets.index')->with('error', $e->getMessage());
        }
    }

    public function update(UpdatePetRequest $request, $id)
    {
        try {
            $data = $request->validated();
            $data['id'] = $id; 

            $this->petService->updatePet($data);

            return redirect()->route('pets.index')->with('success', 'Pet updated successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function show($id)
    {
        try {
            $pet = $this->client->getPetById($id);
            return view('pets.show', compact('pet'));
        } catch (\Exception $e) {
            return redirect()->route('pets.index')->with('error', $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $response = $this->client->deletePet($id);
            return redirect()->route('pets.index')->with('success', 'Pet deleted successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}