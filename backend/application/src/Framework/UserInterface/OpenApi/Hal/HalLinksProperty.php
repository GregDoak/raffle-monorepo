<?php

declare(strict_types=1);

namespace App\Framework\UserInterface\OpenApi\Hal;

use OpenApi\Attributes as OA;
use OpenApi\Undefined;

final class HalLinksProperty extends OA\Property
{
    /** @param array<string, array{href: string, templated?: bool}> $example */
    public function __construct(array $example = [])
    {
        parent::__construct(
            property: '_links',
            description: 'HAL links for this resource, keyed by relation name.',
            type: 'object',
            example: $example === [] ? Undefined::UNDEFINED : $example,
            nullable: true,
            additionalProperties: new OA\AdditionalProperties(
                properties: [
                    new OA\Property(
                        property: 'href',
                        description: 'The target URI, or a URI template when `templated` is true.',
                        type: 'string',
                        example: '/api/resource/id',
                    ),
                    new OA\Property(
                        property: 'templated',
                        description: 'Whether `href` is a URI template (RFC 6570) requiring variable expansion.',
                        type: 'boolean',
                        example: false,
                    ),
                ],
                type: 'object',
            ),
        );
    }
}
