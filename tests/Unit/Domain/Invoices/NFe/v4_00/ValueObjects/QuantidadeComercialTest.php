<?php

declare(strict_types=1);

use BradiNfeApi\Common\Exceptions\ValidationError;
use BradiNfeApi\Common\Result;
use BradiNfeApi\Domain\Invoices\NFe\v4_00\ValueObjects\QuantidadeComercial;

/** Xml string example
 *
 * <qCom>100.0000</qCom>
 */
describe('QuantidadeComercial', function () {
    describe('::parseXmlString()', function () {
        test('Should be succeed when a valid xml string with a valid uCom value is provided', function () {
            $fakeTagValue = '100.0000';
            $fakeXmlString = "<qCom>{$fakeTagValue}</qCom>";
            $sut = QuantidadeComercial::parseXmlString($fakeXmlString);
            expect($sut)->toBeInstanceOf(Result::class);
            expect($sut->isSuccess())->toBeTruthy();
            expect($sut->getData())->toBeInstanceOf(QuantidadeComercial::class);
            expect($sut->getData()->value)->toBeString();
            expect($sut->getData()->value)->toBe($fakeTagValue);
            expect($sut->getData()->xmlString)->toBeString();
            expect($sut->getData()->xmlString)->toBe($fakeXmlString);
        });

        test('Should be return a failure Result if non string is provided', function ($fakeXmlString) {
            $sut = QuantidadeComercial::parseXmlString($fakeXmlString);
            expect($sut)->toBeInstanceOf(Result::class);
            expect($sut->isSuccess())->toBeFalsy();
            expect($sut->getError())->toBeInstanceOf(ValidationError::class);
        })->with([
            new stdClass,               // object
            1111,                       // integer
            [['<qCom>100.0000</qCom>']], // array
            null,                       // null
            true,                       // boolean
            '',                         // empty string
        ]);

        test('Should be fail if a value with invalid length is provided', function (string $fakeTagValue) {
            $fakeXmlString = "<qCom>{$fakeTagValue}</qCom>";
            $sut = QuantidadeComercial::parseXmlString($fakeXmlString);
            expect($sut)->toBeInstanceOf(Result::class);
            expect($sut->isSuccess())->toBeFalsy();
            expect($sut->getError())->toBeInstanceOf(ValidationError::class);
        })->with([
            '100.00000',        // invalid decimal part length
            '100000000000.0000', // invalid integer part length
        ]);
    });

    describe('::create()', function () {
        test('Should be succeed if a valid value is provided', function () {
            $fakeTagValue = '100.0000';
            $sut = QuantidadeComercial::create(tagValue: $fakeTagValue);
            expect($sut)->toBeInstanceOf(Result::class);
            expect($sut->isSuccess())->toBeTruthy();
            expect($sut->getData())->toBeInstanceOf(QuantidadeComercial::class);
            expect($sut->getData()->value)->toBeString();
            expect($sut->getData()->value)->toBe($fakeTagValue);
            expect($sut->getData()->xmlString)->toBeString();
            expect($sut->getData()->xmlString)->toBe("<qCom>{$fakeTagValue}</qCom>");
        });

        test('Should be fail if a value with invalid length is provided', function (string $fakeTagValue) {
            $sut = QuantidadeComercial::create(tagValue: $fakeTagValue);
            expect($sut)->toBeInstanceOf(Result::class);
            expect($sut->isSuccess())->toBeFalsy();
            expect($sut->getError())->toBeInstanceOf(ValidationError::class);
        })->with([
            '100.00000',        // invalid decimal part length
            '100000000000.0000', // invalid integer part length
        ]);
    });

    describe('::validateTagValue()', function () {
        test('Should be true if a valid value is provided', function () {
            $fakeTagValue = '1000.0000';
            $sut = QuantidadeComercial::validateTagValue($fakeTagValue);
            expect($sut->isSuccess())->toBeTruthy();
        });

        test('Should be false if a value with invalid length is provided', function ($fakeTagValue) {
            $sut = QuantidadeComercial::validateTagValue($fakeTagValue);
            expect($sut->isSuccess())->toBeFalsy();
            expect($sut->getError())->toBeInstanceOf(ValidationError::class);
        })->with([
            '100.00000',        // invalid decimal part length
            '100000000000.0000', // invalid integer part length
        ]);
    });
});
