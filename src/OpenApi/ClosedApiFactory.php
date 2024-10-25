<?php

namespace App\OpenApi;

use ApiPlatform\OpenApi\Factory\OpenApiFactoryInterface;
use ApiPlatform\OpenApi\Model\Operation;
use ApiPlatform\OpenApi\Model\PathItem;
use ApiPlatform\OpenApi\OpenApi;
use Symfony\Component\HttpFoundation\Response;

class ClosedApiFactory implements OpenApiFactoryInterface
{
    private OpenApiFactoryInterface $decorated;

    public function __construct(OpenApiFactoryInterface $decorated)
    {
        $this->decorated = $decorated;
    }

    public function __invoke(array $context = []): OpenApi
    {
        $openApi = ($this->decorated)($context);

        // Parcourir les chemins et fermer ceux qui ne sont pas sous /api
        foreach ($openApi->getPaths()->getPaths() as $path => $pathItem) {
            if (!str_starts_with($path, '/api')) {
                // Fermer l'endpoint
                $pathItem->withPost(
                    (new Operation())
                        ->withOperationId('closed_endpoint')
                        ->withTags(['Closed'])
                        ->withResponses([
                            Response::HTTP_FORBIDDEN => [
                                'description' => 'This endpoint is currently closed.',
                                'content' => [
                                    'application/json' => [
                                        'schema' => [
                                            'type' => 'object',
                                            'properties' => [
                                                'error' => [
                                                    'type' => 'string',
                                                    'example' => 'This endpoint is currently closed.',
                                                ],
                                            ],
                                        ],
                                    ],
                                ],
                            ],
                        ])
                        ->withSummary('This endpoint is currently closed.')
                );
            }
        }

        return $openApi;
    }
}
