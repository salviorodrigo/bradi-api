<?php

declare(strict_types=1);

use BradiNfeApi\Domain\Common\Protocols\ApiError;
use BradiNfeApi\Domain\Common\ValueObjects\Result;
use BradiNfeApi\Tests\Doubles\Domain\Invoices\NFe\FakeDFeAttribute;
use BradiNfeApi\Tests\TestCase;

describe('DFeAttribute', function () {
    beforeEach(function () {
        /** @var TestCase $this */
        $this->sut = new FakeDFeAttribute('infNFe');
    });

    describe('::parse()', function () {
        test('Should succeed extracting value from xml tag attribute', function () {
            $candidate = '<infNFe fakeAttr="ABC123" versao="4.00"></infNFe>';
            $sutResponse = $this->sut->parse($candidate);

            expect($sutResponse)->toBeInstanceOf(Result::class);
            if ($sutResponse->isFailure()) {
                $this->fail(json_encode($sutResponse->getError()));
            }

            expect($sutResponse->getData())->toBeInstanceOf(FakeDFeAttribute::class);
            expect($sutResponse->getData()->value)->toBe('ABC123');
            expect((string) $sutResponse->getData())->toBe('fakeAttr="ABC123"');
        });

        test('Should fail when data type is not string', function () {
            $sutResponse = $this->sut->parse(['fakeAttr' => 'ABC123']);

            expect($sutResponse)->toBeInstanceOf(Result::class);
            if ($sutResponse->isSuccess()) {
                $this->fail(json_encode($sutResponse->getData()));
            }

            expect($sutResponse->getError())->toBeInstanceOf(ApiError::class);
        });
    });

    describe('::__toString()', function () {
        test('Should throw if attribute value was not initialized', function () {
            expect(fn () => (string) new FakeDFeAttribute('infNFe'))
                ->toThrow(RuntimeException::class);
        });
    });
});
