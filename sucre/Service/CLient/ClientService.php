<?php

namespace Sucre\Service\CLient;

use App\Http\Resources\Entreprise\Client\ClientManagementResource;
use App\Models\Entreprise\Client\ClientManagement;
use Illuminate\Http\Resources\Json\JsonResource;

class ClientService
{
    public function list_all_cliensts(): JsonResource
    {
        $clients = ClientManagement::all();
        $response = ClientManagementResource::collection($clients);

        return $response;
    }
}
