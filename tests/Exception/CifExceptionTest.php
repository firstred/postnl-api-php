<?php

declare(strict_types=1);

namespace Firstred\PostNL\Tests\Exception;

use Firstred\PostNL\Exception\CifException;
use Monolog\Test\TestCase;
use PHPUnit\Framework\Attributes\TestDox;

#[TestDox(text: 'The CifException object')]
class CifExceptionTest extends TestCase
{
    #[TestDox(text: 'Test creating a CifException with a single error')]
    public function testSingleError(): void
    {
        $exception = new CifException(message: 'A test exception', code: 400);

        $this->assertEquals(expected: 'A test exception', actual: $exception->getMessage());
        $this->assertEquals(expected: 400, actual: $exception->getCode());
        $this->assertEquals(expected: [
            [
                'message'     => 'A test exception',
                'description' => 'A test exception',
                'code'        => 400,
            ],
        ], actual: $exception->getMessagesDescriptionsAndCodes());
    }

    #[TestDox(text: 'Test creating a CifException with multiple errors')]
    public function testMultipleError(): void
    {
        $exceptionData = [
            [
                'message'     => 'First exception',
                'description' => 'First description',
                'code'        => 400,
            ],
            [
                'message'     => 'Second exception',
                'description' => 'First description',
                'code'        => 401,
            ],
        ];
        $exception = new CifException(message: $exceptionData, code: 0);

        $this->assertEquals(expected: 'First exception (First description)', actual: $exception->getMessage());
        $this->assertEquals(expected: 400, actual: $exception->getCode());
        $this->assertEquals(expected: $exceptionData, actual: $exception->getMessagesDescriptionsAndCodes());
    }
}
