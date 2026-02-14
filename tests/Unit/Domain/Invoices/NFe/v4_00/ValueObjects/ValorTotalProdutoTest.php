<?php

declare(strict_types=1);

use BradiNfeApi\Common\Exceptions\ValidationError;
use BradiNfeApi\Common\Result;
use BradiNfeApi\Domain\Invoices\NFe\v4_00\ValueObjects\ValorTotalProduto;

/** Xml string example
 *
 * <vProd>1600.00</vProd>
 */
describe('ValorTotalProduto', function () {
    describe('::parseXmlString()', function () {
        test('Should be succeed when a valid xml string with a valid vProd value is provided', function () {
            $fakeTagValue = '1600.00';
            $fakeXmlString = "<vProd>{$fakeTagValue}</vProd>";
            $sut = ValorTotalProduto::parseXmlString($fakeXmlString);
            expect($sut)->toBeInstanceOf(Result::class);
            expect($sut->isSuccess())->toBeTruthy();
            expect($sut->getData())->toBeInstanceOf(ValorTotalProduto::class);
            expect($sut->getData()->value)->toBeString();
            expect($sut->getData()->value)->toBe($fakeTagValue);
            expect($sut->getData()->xmlString)->toBeString();
            expect($sut->getData()->xmlString)->toBe($fakeXmlString);
        });

        test('Should be return a failure Result if non string is provided', function ($fakeXmlString) {
            $sut = ValorTotalProduto::parseXmlString($fakeXmlString);
            expect($sut)->toBeInstanceOf(Result::class);
            expect($sut->isSuccess())->toBeFalsy();
            expect($sut->getError())->toBeInstanceOf(ValidationError::class);
        })->with([
            new stdClass,               // object
            1111,                       // integer
            [['<vProd>6.00</vProd>']], // array
            null,                       // null
            true,                       // boolean
            '',                         // empty string
        ]);

        test('Should be fail if a value with invalid length is provided', function (string $fakeTagValue) {
            $fakeXmlString = "<vProd>{$fakeTagValue}</vProd>";
            $sut = ValorTotalProduto::parseXmlString($fakeXmlString);
            expect($sut)->toBeInstanceOf(Result::class);
            expect($sut->isSuccess())->toBeFalsy();
            expect($sut->getError())->toBeInstanceOf(ValidationError::class);
        })->with([
            '1600.000',         // invalid decimal part length
            '10000000000000.00', // invalid integer part length
        ]);
    });

    describe('::create()', function () {
        test('Should be succeed if a valid value is provided', function () {
            $fakeTagValue = '1600.00';
            $sut = ValorTotalProduto::create(tagValue: $fakeTagValue);
            expect($sut)->toBeInstanceOf(Result::class);
            expect($sut->isSuccess())->toBeTruthy();
            expect($sut->getData())->toBeInstanceOf(ValorTotalProduto::class);
            expect($sut->getData()->value)->toBeString();
            expect($sut->getData()->value)->toBe($fakeTagValue);
            expect($sut->getData()->xmlString)->toBeString();
            expect($sut->getData()->xmlString)->toBe("<vProd>{$fakeTagValue}</vProd>");
        });

        test('Should be fail if a value with invalid length is provided', function (string $fakeTagValue) {
            $sut = ValorTotalProduto::create(tagValue: $fakeTagValue);
            expect($sut)->toBeInstanceOf(Result::class);
            expect($sut->isSuccess())->toBeFalsy();
            expect($sut->getError())->toBeInstanceOf(ValidationError::class);
        })->with([
            '1600.000',         // invalid decimal part length
            '10000000000000.00', // invalid integer part length
        ]);
    });

    describe('::validateTagValue()', function () {
        test('Should be true if a valid value is provided', function () {
            $fakeTagValue = '1600.00';
            $sut = ValorTotalProduto::validateTagValue($fakeTagValue);
            expect($sut->isSuccess())->toBeTruthy();
        });

        test('Should be false if a value with invalid length is provided', function ($fakeTagValue) {
            $sut = ValorTotalProduto::validateTagValue($fakeTagValue);
            expect($sut->isSuccess())->toBeFalsy();
            expect($sut->getError())->toBeInstanceOf(ValidationError::class);
        })->with([
            '1600.000',         // invalid decimal part length
            '10000000000000.00', // invalid integer part length
        ]);
    });
});
