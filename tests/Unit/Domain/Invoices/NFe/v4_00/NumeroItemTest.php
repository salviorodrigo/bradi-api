<?php

declare(strict_types=1);

use BradiNfeApi\Domain\Common\Protocols\ApiError;
use BradiNfeApi\Domain\Common\ValueObjects\Result;
use BradiNfeApi\Domain\Invoices\NFe\v4_00\NumeroItem;
use BradiNfeApi\Domain\Xml\ValueObjects\Attribute;
use BradiNfeApi\Tests\TestCase;

describe('NumeroItem', function () {
    beforeEach(function () {
        /** @var TestCase $this */
        $this->sut = new NumeroItem('infItem');
    });

    describe('::parseFromXmlElement()', function () {
        test('Should succeed extracting nItem attribute with valid value :value', function (string $value) {
            $attribute = new Attribute('nItem', $value, 'infItem');
            $sutResponse = $this->sut->parseFromXmlElement($attribute);

            expect($sutResponse)->toBeInstanceOf(Result::class);
            if ($sutResponse->isFailure()) {
                $this->fail(json_encode($sutResponse->getError()));
            }

            expect($sutResponse->getData())->toBeInstanceOf(NumeroItem::class);
            expect($sutResponse->getData()->value)->toBe($value);
            expect((string) $sutResponse->getData())->toBe(sprintf('nItem="%s"', $value));
        })->with([
            '1',
            '500',
            '990',
        ]);

        test('Should fail when parent tag does not match', function () {
            $attribute = new Attribute('nItem', '10', 'wrongParentTag');
            $sutResponse = $this->sut->parseFromXmlElement($attribute);
            expect($sutResponse)->toBeInstanceOf(Result::class);
            if ($sutResponse->isSuccess()) {
                $this->fail(json_encode($sutResponse->getData()));
            }

            expect($sutResponse->getError())->toBeInstanceOf(ApiError::class);
        });

        test('Should fail when nItem is outside allowed range or not numeric :value', function (string $value) {
            $attribute = new Attribute('nItem', $value, 'infItem');
            $sutResponse = $this->sut->parseFromXmlElement($attribute);
            expect($sutResponse)->toBeInstanceOf(Result::class);
            if ($sutResponse->isSuccess()) {
                $this->fail(json_encode($sutResponse->getData()));
            }

            expect($sutResponse->getError())->toBeInstanceOf(ApiError::class);
        })->with([
            '0',
            '991',
            'ABC',
        ]);
    });

    describe('::__construct()', function () {
        test('Should throw if parentFieldURI is empty', function () {
            expect(fn () => new NumeroItem(''))
                ->toThrow(RuntimeException::class);
        });
    });
});
