<?php

namespace Sucre\Service\Entreprise\Arrival;

use App\Http\Requests\Entreprise\Arrival\ArrivalStoreRequest;
use App\Http\Requests\Entreprise\Arrival\ArrivalUpdateRequest;
use App\Models\Entreprise\Stock\ArrivalManagement;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

/**
 * Class ArrivalService
 *
 * Handles the management of arrivals in the system.
 *
 * @author RANDRIANARISOA <maheninarandrianarisoa@gmail.com>
 * @copyright 2024 RANDRIANARISOA
 */
class ArrivalService
{
   /**
     * List all arrivals with pagination.
     *
     * @return JsonResponse
     */
    public function listArrivals(): JsonResponse
    {
        $arrivals = ArrivalManagement::orderBy('created_at', 'desc')
            ->where('status', ArrivalManagement::STATUS_VALID)
            ->paginate(10);

        // Return the paginated results directly
        return response()->json($arrivals);
    }

    /**
     * Show details of a specific arrival.
     *
     * @param string $arrivalId The ID of the arrival to retrieve.
     * @return JsonResponse
     */
    public function showOneArrival(string $arrivalId): JsonResponse
    {
        $arrival = ArrivalManagement::find($arrivalId);

        if (!$arrival) {
            return $this->notFoundResponse();
        }

        // Renvoie la réponse sous la clé 'data'
        return response()->json(['data' => $arrival], Response::HTTP_OK);
    }


    /**
     * Store a new arrival.
     *
     * @param ArrivalStoreRequest $request The request containing arrival data.
     * @return JsonResponse
     */
    public function storeNewArrival(ArrivalStoreRequest $request): JsonResponse
    {
        // Extract the arrival date from validated data
        $validatedData = $request->validated();

        if (!$this->isValidArrivalDate($validatedData['arrival_date'])) {
            return response()->json(['message' => 'The date doesn\'t match'], Response::HTTP_BAD_REQUEST);
        }

        $data = [
            'label_name' => $validatedData['label_name'],
            'arrival_date' => $validatedData['arrival_date'],
            'bag_price' => $validatedData['bag_price'],
            'status' => ArrivalManagement::STATUS_VALID,
            'type_rice_id' => $validatedData['type_rice_id'], // Add type_rice_id
        ];

        $arrival = ArrivalManagement::create($data);
        return response()->json(['message' => 'Created', 'data' => $arrival], Response::HTTP_CREATED);
    }

    /**
     * Update an existing arrival.
     *
     * @param string $arrivalId The ID of the arrival to update.
     * @param ArrivalUpdateRequest $request The request containing updated arrival data.
     * @return JsonResponse
     */
    public function updateArrival(string $arrivalId, ArrivalUpdateRequest $request): JsonResponse
    {
        $arrival = ArrivalManagement::find($arrivalId);

        // Check if arrival is not found
        if (!$arrival) {
            return $this->notFoundResponse();
        }

        // Check if the status is invalid
        if ($arrival->status === ArrivalManagement::STATUS_INVALID) {
            return $this->notFoundResponse();
        }

        // Update the arrival with validated data
        $arrival->update($request->validated());
        return response()->json(['message' => 'Updated', 'data' => $arrival], Response::HTTP_OK);
    }

    /**
     * Mark an arrival as deleted (invalid).
     *
     * @param string $arrivalId The ID of the arrival to delete.
     * @return JsonResponse
     */
    public function deleteArrival(string $arrivalId): JsonResponse
    {
        $arrival = ArrivalManagement::find($arrivalId);

        if (!$arrival) {
            return $this->notFoundResponse();
        }

        $arrival->update(['status' => ArrivalManagement::STATUS_INVALID]);
        return response()->json(['message' => 'Deleted'], Response::HTTP_OK);
    }

    /**
     * Verify if the arrival date is not in the past.
     *
     * @param string $date The date to check.
     * @return bool Returns true if the date is valid (not past), false otherwise.
     */
    private function isValidArrivalDate(string $date): bool
    {
        $arrivalDate = Carbon::parse($date);
        return !$arrivalDate->isPast();
    }

    /**
     * Generate a not found response.
     *
     * @return JsonResponse
     */
    private function notFoundResponse(): JsonResponse
    {
        return response()->json(['message' => 'Arrival not found'], Response::HTTP_NOT_FOUND);
    }
}
