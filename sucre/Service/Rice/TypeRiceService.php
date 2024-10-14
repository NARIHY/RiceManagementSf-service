<?php

namespace Sucre\Service\Rice;

use App\Http\Requests\Entreprise\Rice\TypeRiceStoreRequest;
use App\Http\Requests\Entreprise\Rice\TypeRiceUpdateRequest;
use App\Http\Resources\Entreprise\Rice\TypeRiceManagementResource;
use App\Models\Entreprise\Rice\TypeRiceManagement;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Response;

/**
 * Class TypeRiceService
 *
 * This service class handles the business logic related to rice types.
 * It provides methods to list, create, update, and retrieve rice type records.
 *
 * @package \Sucre\Service\Rice
 * @author RANDRIANARISOA <maheninarandrianarisoa@gmail.com>
 * @copyright 2024 RANDRIANARISOA
 */
class TypeRiceService
{
    /**
     * Retrieves a paginated list of rice types.
     *
     * @return JsonResource A paginated collection of rice types wrapped in a resource.
     */
    public function list_type_rice(): JsonResource
    {
        $typeRice = TypeRiceManagement::all();
        return TypeRiceManagementResource::collection($typeRice);
    }

    /**
     * Stores a new rice type in the database.
     *
     * @param TypeRiceStoreRequest $request The validated request containing rice type data.
     * @return JsonResponse A response indicating success or conflict if the rice type already exists.
     */
    public function store_type_rice(TypeRiceStoreRequest $request): JsonResponse
    {
        if ($this->find_type_rice_existing($request->validated('type_rice'))) {
            return response()->json(['message' => 'This type of rice is already in the database'], Response::HTTP_CONFLICT);
        }

        $typeRice = TypeRiceManagement::create($request->validated());
        $response = new TypeRiceManagementResource($typeRice);

        return response()->json(['message' => 'Type rice created', 'data' => $response], Response::HTTP_OK);
    }

    /**
     * Updates an existing rice type.
     *
     * @param TypeRiceUpdateRequest $request The validated request containing updated rice type data.
     * @param string $typeRiceId The ID of the rice type to update.
     * @return JsonResponse A response indicating success or an error if the rice type is not found.
     */
    public function update_type_rice(TypeRiceUpdateRequest $request, string $typeRiceId): JsonResponse
    {
        $typeRice = TypeRiceManagement::find($typeRiceId);

        if (!$typeRice) {
            return response()->json(['message' => 'Undefined'], Response::HTTP_NOT_FOUND);
        }

        $typeRice->update($request->validated());
        return response()->json(['message' => 'Type rice updated'], Response::HTTP_OK);
    }

    /**
     * Retrieves a specific rice type by ID.
     *
     * @param string $typeRiceId The ID of the rice type to retrieve.
     * @return JsonResource|JsonResponse A resource representing the rice type or an error if not found.
     */
    public function show_type_rice(string $typeRiceId): JsonResource | JsonResponse
    {
        $typeRice = TypeRiceManagement::find($typeRiceId);

        if (!$typeRice) {
            return response()->json(['message' => 'Undefined'], Response::HTTP_NOT_FOUND);
        }

        return new TypeRiceManagementResource($typeRice);
    }

   /**
     * Deletes an existing rice type from the database.
     *
     * @param string $typeRiceId The ID of the rice type to delete.
     * @return JsonResponse A response indicating success or an error if the rice type is not found.
     */
    public function delete_type_rice(string $typeRiceId): JsonResponse
    {
        $typeRice = TypeRiceManagement::find($typeRiceId);

        if (!$typeRice) {
            return response()->json(['message' => 'Undefined'], Response::HTTP_NOT_FOUND);
        }

        $typeRice->delete();

        return response()->json(['message' => 'Deleted successfully'], Response::HTTP_OK);
    }


    /**
     * Checks if a rice type already exists in the database.
     *
     * @param string $typeRice The rice type to check for existence.
     * @return bool Returns true if the rice type exists, false otherwise.
     */
    private function find_type_rice_existing(string $typeRice): bool
    {
        return TypeRiceManagement::where('type_rice', $typeRice)->exists();
    }
}
