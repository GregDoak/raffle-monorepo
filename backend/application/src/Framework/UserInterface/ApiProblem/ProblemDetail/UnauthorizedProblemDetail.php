<?php

declare(strict_types=1);

namespace App\Framework\UserInterface\ApiProblem\ProblemDetail;

final readonly class UnauthorizedProblemDetail extends ProblemDetail
{
    private const int STATUS = 401;
    private const string TYPE = 'https://www.rfc-editor.org/rfc/rfc9110.html#name-401-unauthorized';
    private const string TITLE = 'Unauthorized';
    private const string DETAIL = 'You are not authorized to access this page.';

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
