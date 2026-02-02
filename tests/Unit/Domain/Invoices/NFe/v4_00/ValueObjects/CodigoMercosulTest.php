<?php

declare(strict_types=1);

use BradiNfeApi\Common\Exceptions\ValidationError;
use BradiNfeApi\Common\Result;
use BradiNfeApi\Domain\Invoices\NFe\v4_00\ValueObjects\CodigoMercosul;

/** Xml string example
 *
 * <NCM>84152010</NCM>
 */
describe('CodigoMercosul', function () {
    describe('::parseXmlString()', function () {
        test('Should be succeed when a valid xml string with a valid NCM value is provided', function (string $fakeXmlValue, string $fakeXmlString) {
            $sut = CodigoMercosul::parseXmlString($fakeXmlString);
            expect($sut)->toBeInstanceOf(Result::class);
            expect($sut->isSuccess())->toBeTruthy();
            expect($sut->getData())->toBeInstanceOf(CodigoMercosul::class);
            expect($sut->getData()->value)->toBeString();
            expect($sut->getData()->value)->toBe($fakeXmlValue);
            expect($sut->getData()->xmlString)->toBeString();
            expect($sut->getData()->xmlString)->toBe($fakeXmlString);
        })->with([
            ['00', '<NCM>00</NCM>'],               // double zero
            ['84152010', '<NCM>84152010</NCM>'],   // numeric with 8 digits
        ]);

        test('Should be return a failure Result if non string is provided', function ($fakeXmlString) {
            $sut = CodigoMercosul::parseXmlString($fakeXmlString);
            expect($sut)->toBeInstanceOf(Result::class);
            expect($sut->isSuccess())->toBeFalsy();
            expect($sut->getError())->toBeInstanceOf(ValidationError::class);
        })->with([
            new stdClass,               // object
            11111111,                   // integer
            [['<NCM>84152010</NCM>']],  // array
            null,                       // null
            true,                       // boolean
            '',                         // empty string
        ]);

        test('Should be fail if a value with invalid length is provided', function ($fakeXmlString) {
            $sut = CodigoMercosul::parseXmlString($fakeXmlString);
            expect($sut)->toBeInstanceOf(Result::class);
            expect($sut->isSuccess())->toBeFalsy();
            expect($sut->getError())->toBeInstanceOf(ValidationError::class);
        })->with([
            '<NCM>1</NCM>',         // 1 char
            '<NCM>123</NCM>',       // 3 char
            '<NCM>1234567</NCM>',   // 7 char
            '<NCM>123456789</NCM>', // 9 chars
        ]);

        test('Should be fail if a provided value has to chars and was not 00 (doble zero)', function () {
            $fakeXmlString = '<NCM>11</NCM>';
            $sut = CodigoMercosul::parseXmlString($fakeXmlString);
            expect($sut)->toBeInstanceOf(Result::class);
            expect($sut->isSuccess())->toBeFalsy();
            expect($sut->getError())->toBeInstanceOf(ValidationError::class);
        });

        test('Should be fail if non numeric value is provided', function () {
            $fakeXmlString = '<NCM>123456AA</NCM>';
            $sut = CodigoMercosul::parseXmlString($fakeXmlString);
            expect($sut)->toBeInstanceOf(Result::class);
            expect($sut->isSuccess())->toBeFalsy();
            expect($sut->getError())->toBeInstanceOf(ValidationError::class);
        });
    });

    describe('::create()', function () {
        test('Should be succeed if a valid value is provided', function ($fakeTagValue) {
            $sut = CodigoMercosul::create(tagValue: $fakeTagValue);
            expect($sut)->toBeInstanceOf(Result::class);
            expect($sut->isSuccess())->toBeTruthy();
            expect($sut->getData())->toBeInstanceOf(CodigoMercosul::class);
            expect($sut->getData()->value)->toBeString();
            expect($sut->getData()->value)->toBe($fakeTagValue);
            expect($sut->getData()->xmlString)->toBeString();
            expect($sut->getData()->xmlString)->toBe("<NCM>{$fakeTagValue}</NCM>");
        })->with([
            '00',        // 2 chars
            '12345678',  // numeric with 8 chars
        ]);

        test('Should be fail if a value with invalid length is provided', function ($fakeTagValue) {
            $sut = CodigoMercosul::create(tagValue: $fakeTagValue);
            expect($sut)->toBeInstanceOf(Result::class);
            expect($sut->isSuccess())->toBeFalsy();
            expect($sut->getError())->toBeInstanceOf(ValidationError::class);
        })->with([
            '1',         // 1 char
            '123',       // 3 char
            '1234567',   // 7 char
            '123456789', // 9 chars
        ]);

        test('Should be fail if a non numeric value is provided', function () {
            $fakeTagValue = '123456AA';
            $sut = CodigoMercosul::create(tagValue: $fakeTagValue);
            expect($sut)->toBeInstanceOf(Result::class);
            expect($sut->isSuccess())->toBeFalsy();
            expect($sut->getError())->toBeInstanceOf(ValidationError::class);
        });
    });

    describe('::validateTagValue()', function () {
        test('Should be true if a valid value is provided', function ($fakeTagValue) {
            $sut = CodigoMercosul::validateTagValue($fakeTagValue);
            expect($sut->isSuccess())->toBeTruthy();
        })->with([
            '00',        // 2 chars
            '12345678',  // numeric with 8 chars
        ]);

        test('Should be false if a value with invalid length is provided', function ($fakeTagValue) {
            $sut = CodigoMercosul::validateTagValue($fakeTagValue);
            expect($sut->isSuccess())->toBeFalsy();
            expect($sut->getError())->toBeInstanceOf(ValidationError::class);
        })->with([
            '1',         // 1 char
            '123',       // 3 char
            '1234567',   // 7 char
            '123456789', // 9 chars
        ]);

        test('Should be false if a non numeric value with is provided', function () {
            $fakeTagValue = '123456AA';
            $sut = CodigoMercosul::validateTagValue($fakeTagValue);
            expect($sut->isSuccess())->toBeFalsy();
            expect($sut->getError())->toBeInstanceOf(ValidationError::class);
        });
    });
});
