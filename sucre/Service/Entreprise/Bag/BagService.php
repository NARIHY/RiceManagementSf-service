<?php

namespace Sucre\Service\Entreprise\Bag;

use App\Http\Requests\Entreprise\Bag\BagStoreRequest;
use App\Http\Requests\Entreprise\Bag\BagUpdateRequest;
use App\Models\Entreprise\Stock\BagManagement;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

/**
 * Class BagService
 *
 * This service handles operations related to bag management, including
 * listing, retrieving, creating, updating, and deleting bags.
 *
 * @package Sucre\Service\Entreprise\Bag
 * @author RANDRIANARISOA <maheninarandrianarisoa@gmail.com>
 * @copyright 2024 RANDRIANARISOA
 */
class BagService
{
    /**
     * Retrieve a paginated list of bags.
     *
     * This method returns a JSON response containing a paginated list
     * of bags. Each page contains a maximum of 10 bags.
     *
     * @return JsonResponse
     */
    public function listBags(): JsonResponse
    {
        $bags = BagManagement::paginate(10);
        return response()->json($bags);
    }

    /**
     * Retrieve a bag by its ID.
     *
     * This method returns a JSON response containing the details of the
     * specified bag if found. If the bag does not exist, a not found
     * message is returned.
     *
     * @param int $bagId The ID of the bag to retrieve.
     * @return JsonResponse
     */
    public function getBagById(int $bagId): JsonResponse
    {
        $bag = BagManagement::find($bagId);

        if (!$bag) {
            return response()->json(['message' => 'Bag not found'], Response::HTTP_NOT_FOUND);
        }

        return response()->json($bag);
    }

    /**
     * Store a new bag.
     *
     * This method creates a new bag based on the validated data from
     * the request. A success message along with the newly created bag
     * is returned.
     *
     * @param BagStoreRequest $request The request containing the bag data.
     * @return JsonResponse
     */
    public function storeBag(BagStoreRequest $request): JsonResponse
    {
        $bag = BagManagement::create($request->validated());

        return response()->json(['message' => 'Bag created successfully', 'bag' => $bag], Response::HTTP_CREATED);
    }

    /**
     * Update an existing bag by its ID.
     *
     * This method updates the details of a specified bag using the
     * validated data from the request. If the bag is not found, a
     * not found message is returned.
     *
     * @param BagUpdateRequest $request The request containing the updated bag data.
     * @param int $bagId The ID of the bag to update.
     * @return JsonResponse
     */
    public function updateBag(BagUpdateRequest $request, int $bagId): JsonResponse
    {
        $bag = BagManagement::find($bagId);

        if (!$bag) {
            return response()->json(['message' => 'Bag not found'], Response::HTTP_NOT_FOUND);
        }

        $bag->update($request->validated());

        return response()->json(['message' => 'Bag updated successfully'], Response::HTTP_OK);
    }

    /**
     * Delete a bag by its ID.
     *
     * This method deletes the specified bag. If the bag is not found,
     * a not found message is returned. A success message is returned
     * upon successful deletion.
     *
     * @param int $bagId The ID of the bag to delete.
     * @return JsonResponse
     */
    public function deleteBag(int $bagId): JsonResponse
    {
        $bag = BagManagement::find($bagId);

        if (!$bag) {
            return response()->json(['message' => 'Bag not found'], Response::HTTP_NOT_FOUND);
        }

        $bag->delete();

        return response()->json(['message' => 'Bag deleted successfully'], Response::HTTP_NO_CONTENT);
    }
}
