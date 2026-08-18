<?php

declare(strict_types=1);

namespace App\Framework\UserInterface\ApiProblem\ProblemDetail;

final readonly class InternalServerErrorProblemDetail extends ProblemDetail
{
    private const int STATUS = 500;
    private const string TYPE = 'https://www.rfc-editor.org/rfc/rfc9110.html#name-500-internal-server-error';
    private const string TITLE = 'Internal Server Error';
    private const string DETAIL = 'An error has occurred while processing your request, please try again.';

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
