<?php

declare(strict_types=1);

namespace App\Framework\UserInterface\ApiProblem\ProblemDetail;

final readonly class ValidationProblemDetail extends ProblemDetail
{
    private const int STATUS = 400;
    private const string TYPE = 'https://www.rfc-editor.org/rfc/rfc9110.html#name-400-bad-request';
    private const string TITLE = 'Validation Error';
    private const string DETAIL = 'The request cannot be processed due to the following errors.';

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
