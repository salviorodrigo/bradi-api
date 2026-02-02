<?php

declare(strict_types=1);

use BradiNfeApi\Common\Exceptions\ValidationError;
use BradiNfeApi\Common\Result;
use BradiNfeApi\Domain\Invoices\NFe\v4_00\ValueObjects\CodigoFiscal;

/** Xml string example
 *
 * <CFOP>5405</CFOP>
 */
describe('CodigoFiscal', function () {
    describe('::parseXmlString()', function () {
        test('Should be succeed when a valid xml string with a valid CFOP value is provided', function () {
            $fakeTagValue = '1234';
            $fakeXmlString = "<CFOP>{$fakeTagValue}</CFOP>";
            $sut = CodigoFiscal::parseXmlString($fakeXmlString);
            expect($sut)->toBeInstanceOf(Result::class);
            expect($sut->isSuccess())->toBeTruthy();
            expect($sut->getData())->toBeInstanceOf(CodigoFiscal::class);
            expect($sut->getData()->value)->toBeString();
            expect($sut->getData()->value)->toBe($fakeTagValue);
            expect($sut->getData()->xmlString)->toBeString();
            expect($sut->getData()->xmlString)->toBe($fakeXmlString);
        });

        test('Should be return a failure Result if non string is provided', function ($fakeXmlString) {
            $sut = CodigoFiscal::parseXmlString($fakeXmlString);
            expect($sut)->toBeInstanceOf(Result::class);
            expect($sut->isSuccess())->toBeFalsy();
            expect($sut->getError())->toBeInstanceOf(ValidationError::class);
        })->with([
            new stdClass,               // object
            1111,                       // integer
            [['<CFOP>5405</CFOP>']],    // array
            null,                       // null
            true,                       // boolean
            '',                         // empty string
        ]);

        test('Should be fail if a value with invalid length is provided', function ($fakeXmlString) {
            $sut = CodigoFiscal::parseXmlString($fakeXmlString);
            expect($sut)->toBeInstanceOf(Result::class);
            expect($sut->isSuccess())->toBeFalsy();
            expect($sut->getError())->toBeInstanceOf(ValidationError::class);
        })->with([
            '<CFOP>123</CFOP>',   // 3 char
            '<CFOP>12345</CFOP>', // 5 chars
        ]);

        test('Should be fail if non numeric value is provided', function () {
            $fakeXmlString = '<CFOP>12AA</CFOP>';
            $sut = CodigoFiscal::parseXmlString($fakeXmlString);
            expect($sut)->toBeInstanceOf(Result::class);
            expect($sut->isSuccess())->toBeFalsy();
            expect($sut->getError())->toBeInstanceOf(ValidationError::class);
        });
    });

    describe('::create()', function () {
        test('Should be succeed if a valid value is provided', function () {
            $fakeTagValue = '0103';
            $sut = CodigoFiscal::create(tagValue: $fakeTagValue);
            expect($sut)->toBeInstanceOf(Result::class);
            expect($sut->isSuccess())->toBeTruthy();
            expect($sut->getData())->toBeInstanceOf(CodigoFiscal::class);
            expect($sut->getData()->value)->toBeString();
            expect($sut->getData()->value)->toBe($fakeTagValue);
            expect($sut->getData()->xmlString)->toBeString();
            expect($sut->getData()->xmlString)->toBe("<CFOP>{$fakeTagValue}</CFOP>");
        });

        test('Should be fail if a value with invalid length is provided', function ($fakeTagValue) {
            $sut = CodigoFiscal::create(tagValue: $fakeTagValue);
            expect($sut)->toBeInstanceOf(Result::class);
            expect($sut->isSuccess())->toBeFalsy();
            expect($sut->getError())->toBeInstanceOf(ValidationError::class);
        })->with([
            '123',   // 3 char
            '12345', // 5 chars
        ]);

        test('Should be fail if a non numeric value is provided', function () {
            $fakeTagValue = '12AA';
            $sut = CodigoFiscal::create(tagValue: $fakeTagValue);
            expect($sut)->toBeInstanceOf(Result::class);
            expect($sut->isSuccess())->toBeFalsy();
            expect($sut->getError())->toBeInstanceOf(ValidationError::class);
        });
    });

    describe('::validateTagValue()', function () {
        test('Should be true if a valid value is provided', function () {
            $fakeTagValue = '0103';
            $sut = CodigoFiscal::validateTagValue($fakeTagValue);
            expect($sut->isSuccess())->toBeTruthy();
        });

        test('Should be false if a value with invalid length is provided', function ($fakeTagValue) {
            $sut = CodigoFiscal::validateTagValue($fakeTagValue);
            expect($sut->isSuccess())->toBeFalsy();
            expect($sut->getError())->toBeInstanceOf(ValidationError::class);
        })->with([
            '123',   // 3 char
            '12345', // 5 chars
        ]);

        test('Should be false if a non numeric value with is provided', function () {
            $fakeTagValue = '12AA';
            $sut = CodigoFiscal::validateTagValue($fakeTagValue);
            expect($sut->isSuccess())->toBeFalsy();
            expect($sut->getError())->toBeInstanceOf(ValidationError::class);
        });
    });
});
