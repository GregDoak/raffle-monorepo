<?php

declare(strict_types=1);

namespace App\Framework\UserInterface\ApiProblem\ProblemDetail;

final readonly class ForbiddenProblemDetail extends ProblemDetail
{
    private const int STATUS = 403;
    private const string TYPE = 'https://www.rfc-editor.org/rfc/rfc9110.html#name-403-forbidden';
    private const string TITLE = 'Forbidden';
    private const string DETAIL = 'You do not have permission to access this resource.';

    public function __construct(InstanceProvider $instanceProvider, array $additionalParams = [])
    {
        parent::__construct(
            type: self::TYPE,
            status: self::STATUS,
            title: self::TITLE,
            detail: self::DETAIL,
            instanceProvider: $instanceProvider,
            additionalParams: $additionalParams,
        );
    }
}
