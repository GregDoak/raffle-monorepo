<?php

declare(strict_types=1);

namespace App\Framework\UserInterface\OpenApi\ApiProblem\ProblemDetail;

use Attribute;
use Nelmio\ApiDocBundle\Attribute\Model;
use OpenApi\Attributes as OA;

#[Attribute(Attribute::TARGET_CLASS | Attribute::TARGET_METHOD)]
final class ValidationErrorResponse extends OA\Response
{
    public function __construct()
    {
        parent::__construct(
            response: 400,
            description: 'Validation Error',
            content: new OA\MediaType(
                mediaType: 'application/problem+json',
                schema: new OA\Schema(ref: new Model(type: ProblemDetailResponse::class)),
            ),
        );
    }
}
