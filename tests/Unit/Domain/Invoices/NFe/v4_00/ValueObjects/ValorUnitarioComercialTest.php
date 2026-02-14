<?php

declare(strict_types=1);

use BradiNfeApi\Common\Exceptions\ValidationError;
use BradiNfeApi\Common\Result;
use BradiNfeApi\Domain\Invoices\NFe\v4_00\ValueObjects\ValorUnitarioComercial;

/** Xml string example
 *
 * <vUnCom>16.0000000000</vUnCom>
 */
describe('ValorUnitarioComercial', function () {
    describe('::parseXmlString()', function () {
        test('Should be succeed when a valid xml string with a valid vUnCom value is provided', function () {
            $fakeTagValue = '16.0000000000';
            $fakeXmlString = "<vUnCom>{$fakeTagValue}</vUnCom>";
            $sut = ValorUnitarioComercial::parseXmlString($fakeXmlString);
            expect($sut)->toBeInstanceOf(Result::class);
            expect($sut->isSuccess())->toBeTruthy();
            expect($sut->getData())->toBeInstanceOf(ValorUnitarioComercial::class);
            expect($sut->getData()->value)->toBeString();
            expect($sut->getData()->value)->toBe($fakeTagValue);
            expect($sut->getData()->xmlString)->toBeString();
            expect($sut->getData()->xmlString)->toBe($fakeXmlString);
        });

        test('Should be return a failure Result if non string is provided', function ($fakeXmlString) {
            $sut = ValorUnitarioComercial::parseXmlString($fakeXmlString);
            expect($sut)->toBeInstanceOf(Result::class);
            expect($sut->isSuccess())->toBeFalsy();
            expect($sut->getError())->toBeInstanceOf(ValidationError::class);
        })->with([
            new stdClass,               // object
            1111,                       // integer
            [['<vUnCom>6.0</vUnCom>']], // array
            null,                       // null
            true,                       // boolean
            '',                         // empty string
        ]);

        test('Should be fail if a value with invalid length is provided', function (string $fakeTagValue) {
            $fakeXmlString = "<vUnCom>{$fakeTagValue}</vUnCom>";
            $sut = ValorUnitarioComercial::parseXmlString($fakeXmlString);
            expect($sut)->toBeInstanceOf(Result::class);
            expect($sut->isSuccess())->toBeFalsy();
            expect($sut->getError())->toBeInstanceOf(ValidationError::class);
        })->with([
            '16.00000000000',    // invalid decimal part length
            '100000000000.0000', // invalid integer part length
        ]);
    });

    describe('::create()', function () {
        test('Should be succeed if a valid value is provided', function () {
            $fakeTagValue = '100.0000';
            $sut = ValorUnitarioComercial::create(tagValue: $fakeTagValue);
            expect($sut)->toBeInstanceOf(Result::class);
            expect($sut->isSuccess())->toBeTruthy();
            expect($sut->getData())->toBeInstanceOf(ValorUnitarioComercial::class);
            expect($sut->getData()->value)->toBeString();
            expect($sut->getData()->value)->toBe($fakeTagValue);
            expect($sut->getData()->xmlString)->toBeString();
            expect($sut->getData()->xmlString)->toBe("<vUnCom>{$fakeTagValue}</vUnCom>");
        });

        test('Should be fail if a value with invalid length is provided', function (string $fakeTagValue) {
            $sut = ValorUnitarioComercial::create(tagValue: $fakeTagValue);
            expect($sut)->toBeInstanceOf(Result::class);
            expect($sut->isSuccess())->toBeFalsy();
            expect($sut->getError())->toBeInstanceOf(ValidationError::class);
        })->with([
            '16.00000000000',    // invalid decimal part length
            '100000000000.0000', // invalid integer part length
        ]);
    });

    describe('::validateTagValue()', function () {
        test('Should be true if a valid value is provided', function () {
            $fakeTagValue = '1000.0000';
            $sut = ValorUnitarioComercial::validateTagValue($fakeTagValue);
            expect($sut->isSuccess())->toBeTruthy();
        });

        test('Should be false if a value with invalid length is provided', function ($fakeTagValue) {
            $sut = ValorUnitarioComercial::validateTagValue($fakeTagValue);
            expect($sut->isSuccess())->toBeFalsy();
            expect($sut->getError())->toBeInstanceOf(ValidationError::class);
        })->with([
            '16.00000000000',    // invalid decimal part length
            '100000000000.0000', // invalid integer part length
        ]);
    });
});
