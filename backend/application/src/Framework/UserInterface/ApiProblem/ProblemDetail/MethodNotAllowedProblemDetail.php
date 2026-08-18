<?php

declare(strict_types=1);

namespace App\Framework\UserInterface\ApiProblem\ProblemDetail;

final readonly class MethodNotAllowedProblemDetail extends ProblemDetail
{
    private const int STATUS = 405;
    private const string TYPE = 'https://www.rfc-editor.org/rfc/rfc9110.html#name-405-method-not-allowed';
    private const string TITLE = 'Method Not Allowed';
    private const string DETAIL = 'This method is not allowed for this resource.';

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
