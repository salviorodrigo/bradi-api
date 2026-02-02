<?php

declare(strict_types=1);

use BradiNfeApi\Common\Exceptions\ValidationError;
use BradiNfeApi\Common\Result;
use BradiNfeApi\Domain\Invoices\NFe\v4_00\ValueObjects\CodigoSubstituicaoTributaria;

/** Xml string example
 *
 * <CEST>0103600</CEST>
 */
describe('CodigoSubstituicaoTributaria', function () {
    describe('::parseXmlString()', function () {
        test('Should be succeed when a valid xml string with a valid NCM value is provided', function () {
            $fakeTagValue = '0103600';
            $fakeXmlString = "<CEST>{$fakeTagValue}</CEST>";
            $sut = CodigoSubstituicaoTributaria::parseXmlString($fakeXmlString);
            expect($sut)->toBeInstanceOf(Result::class);
            expect($sut->isSuccess())->toBeTruthy();
            expect($sut->getData())->toBeInstanceOf(CodigoSubstituicaoTributaria::class);
            expect($sut->getData()->value)->toBeString();
            expect($sut->getData()->value)->toBe($fakeTagValue);
            expect($sut->getData()->xmlString)->toBeString();
            expect($sut->getData()->xmlString)->toBe($fakeXmlString);
        });

        test('Should be return a failure Result if non string is provided', function ($fakeXmlString) {
            $sut = CodigoSubstituicaoTributaria::parseXmlString($fakeXmlString);
            expect($sut)->toBeInstanceOf(Result::class);
            expect($sut->isSuccess())->toBeFalsy();
            expect($sut->getError())->toBeInstanceOf(ValidationError::class);
        })->with([
            new stdClass,               // object
            11111111,                   // integer
            [['<CEST>0103600</CEST>']],  // array
            null,                       // null
            true,                       // boolean
            '',                         // empty string
        ]);

        test('Should be fail if a value with invalid length is provided', function ($fakeXmlString) {
            $sut = CodigoSubstituicaoTributaria::parseXmlString($fakeXmlString);
            expect($sut)->toBeInstanceOf(Result::class);
            expect($sut->isSuccess())->toBeFalsy();
            expect($sut->getError())->toBeInstanceOf(ValidationError::class);
        })->with([
            '<NCM>123456</NCM>',   // 6 char
            '<NCM>12345678</NCM>', // 8 chars
        ]);

        test('Should be fail if non numeric value is provided', function () {
            $fakeXmlString = '<NCM>12345AA</NCM>';
            $sut = CodigoSubstituicaoTributaria::parseXmlString($fakeXmlString);
            expect($sut)->toBeInstanceOf(Result::class);
            expect($sut->isSuccess())->toBeFalsy();
            expect($sut->getError())->toBeInstanceOf(ValidationError::class);
        });
    });

    describe('::create()', function () {
        test('Should be succeed if a valid value is provided', function () {
            $fakeTagValue = '0103600';
            $sut = CodigoSubstituicaoTributaria::create(tagValue: $fakeTagValue);
            expect($sut)->toBeInstanceOf(Result::class);
            expect($sut->isSuccess())->toBeTruthy();
            expect($sut->getData())->toBeInstanceOf(CodigoSubstituicaoTributaria::class);
            expect($sut->getData()->value)->toBeString();
            expect($sut->getData()->value)->toBe($fakeTagValue);
            expect($sut->getData()->xmlString)->toBeString();
            expect($sut->getData()->xmlString)->toBe("<CEST>{$fakeTagValue}</CEST>");
        });

        test('Should be fail if a value with invalid length is provided', function ($fakeTagValue) {
            $sut = CodigoSubstituicaoTributaria::create(tagValue: $fakeTagValue);
            expect($sut)->toBeInstanceOf(Result::class);
            expect($sut->isSuccess())->toBeFalsy();
            expect($sut->getError())->toBeInstanceOf(ValidationError::class);
        })->with([
            '123456',   // 6 char
            '12345678', // 8 chars
        ]);

        test('Should be fail if a non numeric value is provided', function () {
            $fakeTagValue = '12345AA';
            $sut = CodigoSubstituicaoTributaria::create(tagValue: $fakeTagValue);
            expect($sut)->toBeInstanceOf(Result::class);
            expect($sut->isSuccess())->toBeFalsy();
            expect($sut->getError())->toBeInstanceOf(ValidationError::class);
        });
    });

    describe('::validateTagValue()', function () {
        test('Should be true if a valid value is provided', function () {
            $fakeTagValue = '0103600';
            $sut = CodigoSubstituicaoTributaria::validateTagValue($fakeTagValue);
            expect($sut->isSuccess())->toBeTruthy();
        });

        test('Should be false if a value with invalid length is provided', function ($fakeTagValue) {
            $sut = CodigoSubstituicaoTributaria::validateTagValue($fakeTagValue);
            expect($sut->isSuccess())->toBeFalsy();
            expect($sut->getError())->toBeInstanceOf(ValidationError::class);
        })->with([
            '123456',   // 6 char
            '12345678', // 8 chars
        ]);

        test('Should be false if a non numeric value with is provided', function () {
            $fakeTagValue = '12345AA';
            $sut = CodigoSubstituicaoTributaria::validateTagValue($fakeTagValue);
            expect($sut->isSuccess())->toBeFalsy();
            expect($sut->getError())->toBeInstanceOf(ValidationError::class);
        });
    });
});
