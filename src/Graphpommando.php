<?php

declare(strict_types = 1);

namespace Graphpommando;

final class Graphpommando
{
    private QueryBuilder $queryBuilder;
    private EntityHydrator $entityHydrator;

    public function __construct(
        private string $apiEndpoint,
        private \GuzzleHttp\ClientInterface $httpClient,
    )
    {
        $this->queryBuilder = new QueryBuilder();
        $this->entityHydrator = new EntityHydrator();
    }

    public function request(Operation $operation, array $variableValues, array $additionalHeaders = []) : Entity
    {
        $additionalHeaders['Content-Type'] = 'application/json';

        $response = $this->httpClient->request('POST', $this->apiEndpoint, [
            \GuzzleHttp\RequestOptions::HEADERS => $additionalHeaders,
            \GuzzleHttp\RequestOptions::BODY => \Infinityloop\Utils\Json::fromNative((object) [
                'operation' => $this->queryBuilder->build($operation),
                'variables' => $variableValues,
            ])->toString(),
        ]);

        return $this->entityHydrator->hydrate($operation->getEntityClass(), $response->getBody()->getContents());
    }
}
