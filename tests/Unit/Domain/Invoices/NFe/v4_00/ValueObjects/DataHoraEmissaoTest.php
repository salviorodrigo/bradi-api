<?php

declare(strict_types=1);

use BradiNfeApi\Common\Exceptions\ValidationError;
use BradiNfeApi\Common\Result;
use BradiNfeApi\Domain\Invoices\NFe\v4_00\ValueObjects\DataHoraEmissao;

/** Xml string example
 * <ide>
 *  <dhEmi>2025-11-14T14:02:54-04:00</dhEmi>
 * </ide>
 */
describe('DataHoraEmissao', function () {
    describe('::parseXmlString()', function () {
        test('Should be succeed when a valid xml string is provided', function () {
            $fakeXmlString = '<ide><dhEmi>2025-11-14T14:02:54-04:00</dhEmi></ide>';
            $sut = DataHoraEmissao::parseXmlString($fakeXmlString);
            expect($sut)->toBeInstanceOf(Result::class);
            expect($sut->isSuccess())->toBeTruthy();
            expect($sut->getData())->toBeInstanceOf(DataHoraEmissao::class);
            expect($sut->getData()->value)->toBeString();
            expect($sut->getData()->value)->toBe('2025-11-14T14:02:54-04:00');
            expect($sut->getData()->xmlString)->toBeString();
            expect($sut->getData()->xmlString)->toBe('<dhEmi>2025-11-14T14:02:54-04:00</dhEmi>');
        });

        test('Should be return a failure Result if an object value is provided', function () {
            $fakeXmlString = new stdClass;
            $sut = DataHoraEmissao::parseXmlString($fakeXmlString);
            expect($sut)->toBeInstanceOf(Result::class);
            expect($sut->isSuccess())->toBeFalsy();
            expect($sut->getError())->toBeInstanceOf(ValidationError::class);
        });

        test('Should be return a failure Result if a number value is provided', function () {
            $fakeXmlString = 11;
            $sut = DataHoraEmissao::parseXmlString($fakeXmlString);
            expect($sut)->toBeInstanceOf(Result::class);
            expect($sut->isSuccess())->toBeFalsy();
            expect($sut->getError())->toBeInstanceOf(ValidationError::class);
        });

        test('Should be return a failure Result if an array value is provided', function () {
            $fakeXmlString = ['<ide><dhEmi>2025-11-14T14:02:54-04:00</dhEmi></ide>'];
            $sut = DataHoraEmissao::parseXmlString($fakeXmlString);
            expect($sut)->toBeInstanceOf(Result::class);
            expect($sut->isSuccess())->toBeFalsy();
            expect($sut->getError())->toBeInstanceOf(ValidationError::class);
        });

        test('Should be return a failure Result if null given', function () {
            $fakeXmlString = null;
            $sut = DataHoraEmissao::parseXmlString($fakeXmlString);
            expect($sut)->toBeInstanceOf(Result::class);
            expect($sut->isSuccess())->toBeFalsy();
            expect($sut->getError())->toBeInstanceOf(ValidationError::class);
        });

        test('Should be return a failure Result if an empty string is provided', function () {
            $fakeXmlString = '';
            $sut = DataHoraEmissao::parseXmlString($fakeXmlString);
            expect($sut)->toBeInstanceOf(Result::class);
            expect($sut->isSuccess())->toBeFalsy();
            expect($sut->getError())->toBeInstanceOf(ValidationError::class);
        });

        test('Should be return a failure Result if a bool string is provided', function () {
            $fakeXmlString = true;
            $sut = DataHoraEmissao::parseXmlString($fakeXmlString);
            expect($sut)->toBeInstanceOf(Result::class);
            expect($sut->isSuccess())->toBeFalsy();
            expect($sut->getError())->toBeInstanceOf(ValidationError::class);
        });

        test('Should be fail if an invalid dhEmi value is provided', function () {
            $sut = DataHoraEmissao::parseXmlString('<ide><dhEmi>2025-11-14T14:02:54-0400</dhEmi></ide>');
            expect($sut)->toBeInstanceOf(Result::class);
            expect($sut->isSuccess())->toBeFalsy();
            expect($sut->getError())->toBeInstanceOf(ValidationError::class);
        });
    });

    describe('::create()', function () {
        test('Should be succeed if a valid dhEmi value is provided', function () {
            $fakeXmlString = '2025-11-14T14:02:54-04:00';
            $sut = DataHoraEmissao::create(tagValue: $fakeXmlString);
            expect($sut)->toBeInstanceOf(Result::class);
            expect($sut->isSuccess())->toBeTruthy();
            expect($sut->getData())->toBeInstanceOf(DataHoraEmissao::class);
            expect($sut->getData()->value)->toBeString();
            expect($sut->getData()->value)->toBe('2025-11-14T14:02:54-04:00');
            expect($sut->getData()->xmlString)->toBeString();
            expect($sut->getData()->xmlString)->toBe('<dhEmi>2025-11-14T14:02:54-04:00</dhEmi>');
        });

        test('Should be fail if an invalid dhEmi value is provided', function () {
            $sut = DataHoraEmissao::create('2025-11-14T14:02:54-0400');
            expect($sut)->toBeInstanceOf(Result::class);
            expect($sut->isSuccess())->toBeFalsy();
            expect($sut->getError())->toBeInstanceOf(ValidationError::class);
        });
    });

    describe('::validateTagValue()', function () {
        test('Should be true if provided value is a Mod', function () {
            $fakeTagValue = '2025-11-14T14:02:54-04:00';
            $sut = DataHoraEmissao::validateTagValue($fakeTagValue);
            expect($sut->isSuccess())->toBeTruthy();
        });

        test('Should be fail if a string whit letters is provided', function () {
            $fakeTagValue = '20AA-11-14T14:02:54-04:00';
            $sut = DataHoraEmissao::validateTagValue($fakeTagValue);
            expect($sut->isSuccess())->toBeFalsy();
            expect($sut->getError())->toBeInstanceOf(ValidationError::class);
        });

        test('Should be fail if a string fewer than twenty five letters is provided', function () {
            $fakeTagValue = '2025-11-14T14:02:54-0400';
            $sut = DataHoraEmissao::validateTagValue($fakeTagValue);
            expect($sut->isSuccess())->toBeFalsy();
            expect($sut->getError())->toBeInstanceOf(ValidationError::class);
        });

        test('Should be fail if a string more than twenty five letters is provided', function () {
            $fakeTagValue = '2025-11-14T14:02:54:542-04:00';
            $sut = DataHoraEmissao::validateTagValue($fakeTagValue);
            expect($sut->isSuccess())->toBeFalsy();
            expect($sut->getError())->toBeInstanceOf(ValidationError::class);
        });
    });
});
