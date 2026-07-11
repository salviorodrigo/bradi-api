<?php

declare(strict_types=1);

use BradiApi\Domain\Common\Protocols\ApiError;
use BradiApi\Domain\Common\ValueObjects\Result;
use BradiApi\Domain\Xml\ValueObjects\Attribute;
use BradiApi\Tests\Doubles\Domain\Invoices\NFe\FakeDFeAttribute;
use BradiApi\Tests\TestCase;

describe('DFeAttribute', function () {
    beforeEach(function () {
        /** @var TestCase $this */
        $this->sut = new FakeDFeAttribute('infNFe');
    });

    describe('::parseFromXmlElement()', function () {
        test('Should succeed extracting value from xml tag attribute', function () {
            $attribute = new Attribute('fakeAttr', 'ABC123', 'infNFe');
            $sutResponse = $this->sut->parseFromXmlElement($attribute);

            expect($sutResponse)->toBeInstanceOf(Result::class);
            if ($sutResponse->isFailure()) {
                $this->fail(json_encode($sutResponse->getError()));
            }

            expect($sutResponse->getData())->toBeInstanceOf(FakeDFeAttribute::class);
            expect($sutResponse->getData()->value)->toBe('ABC123');
            expect((string) $sutResponse->getData())->toBe('fakeAttr="ABC123"');
        });

        test('Should fail when parent tag does not match', function () {
            $attribute = new Attribute('fakeAttr', 'ABC123', 'wrongParentTag');
            $sutResponse = $this->sut->parseFromXmlElement($attribute);

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
