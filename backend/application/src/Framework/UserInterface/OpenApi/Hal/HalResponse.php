<?php

declare(strict_types=1);

namespace App\Framework\UserInterface\OpenApi\Hal;

use App\Foundation\Parameter\Parameter;
use Attribute;
use Nelmio\ApiDocBundle\Attribute\Model;
use OpenApi\Attributes as OA;

/**
 * Documents a `application/hal+json` response: the given model, composed with its `_links`.
 */
#[Attribute(Attribute::TARGET_CLASS | Attribute::TARGET_METHOD)]
final class HalResponse extends OA\Response
{
    /**
     * @param class-string $model
     * @param array<string, array{href: string, templated?: bool}> $links
     */
    public function __construct(
        int $response,
        string $description,
        string $model,
        string $baseUrlParameter,
        array $links = [],
    ) {
        $links = array_map(
            static fn (array $link): array => [...$link, 'href' => Parameter::get($baseUrlParameter).$link['href']],
            $links,
        );

        parent::__construct(
            response: $response,
            description: $description,
            content: new OA\MediaType(
                mediaType: 'application/hal+json',
                schema: new OA\Schema(
                    allOf: [
                        new OA\Schema(ref: new Model(type: $model)),
                        new OA\Schema(properties: [new HalLinksProperty($links)]),
                    ],
                ),
            ),
        );
    }
}
