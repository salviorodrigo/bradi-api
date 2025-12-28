<?php

declare(strict_types=1);

use BradiNfeApi\Common\Exceptions\ValidationError;
use BradiNfeApi\Common\Result;
use BradiNfeApi\Domain\Invoices\NFe\v4_00\ValueObjects\DataHoraSaidaEntrada;

/** Xml string example
 * <ide>
 *  <dhSaiEnt>2020-05-20T11:00:54-03:00</dhSaiEnt>
 * </ide>
 */
describe('DataHoraSaidaEntrada', function () {
    describe('::parseXmlString()', function () {
        test('Should be succeed when a valid xml string is provided', function () {
            $fakeXmlString = '<ide><dhSaiEnt>2020-05-20T11:00:54-03:00</dhSaiEnt></ide>';
            $sut = DataHoraSaidaEntrada::parseXmlString($fakeXmlString);
            expect($sut)->toBeInstanceOf(Result::class);
            expect($sut->isSuccess())->toBeTruthy();
            expect($sut->getData())->toBeInstanceOf(DataHoraSaidaEntrada::class);
            expect($sut->getData()->value)->toBeString();
            expect($sut->getData()->value)->toBe('2020-05-20T11:00:54-03:00');
            expect($sut->getData()->xmlString)->toBeString();
            expect($sut->getData()->xmlString)->toBe('<dhSaiEnt>2020-05-20T11:00:54-03:00</dhSaiEnt>');
        });

        test('Should be return a failure Result if an object value is provided', function () {
            $fakeXmlString = new stdClass;
            $sut = DataHoraSaidaEntrada::parseXmlString($fakeXmlString);
            expect($sut)->toBeInstanceOf(Result::class);
            expect($sut->isSuccess())->toBeFalsy();
            expect($sut->getError())->toBeInstanceOf(ValidationError::class);
        });

        test('Should be return a failure Result if a number value is provided', function () {
            $fakeXmlString = 11;
            $sut = DataHoraSaidaEntrada::parseXmlString($fakeXmlString);
            expect($sut)->toBeInstanceOf(Result::class);
            expect($sut->isSuccess())->toBeFalsy();
            expect($sut->getError())->toBeInstanceOf(ValidationError::class);
        });

        test('Should be return a failure Result if an array value is provided', function () {
            $fakeXmlString = ['<ide><dhSaiEnt>2020-05-20T11:00:54-03:00</dhSaiEnt></ide>'];
            $sut = DataHoraSaidaEntrada::parseXmlString($fakeXmlString);
            expect($sut)->toBeInstanceOf(Result::class);
            expect($sut->isSuccess())->toBeFalsy();
            expect($sut->getError())->toBeInstanceOf(ValidationError::class);
        });

        test('Should be return a failure Result if null given', function () {
            $fakeXmlString = null;
            $sut = DataHoraSaidaEntrada::parseXmlString($fakeXmlString);
            expect($sut)->toBeInstanceOf(Result::class);
            expect($sut->isSuccess())->toBeFalsy();
            expect($sut->getError())->toBeInstanceOf(ValidationError::class);
        });

        test('Should be return a failure Result if an empty string is provided', function () {
            $fakeXmlString = '';
            $sut = DataHoraSaidaEntrada::parseXmlString($fakeXmlString);
            expect($sut)->toBeInstanceOf(Result::class);
            expect($sut->isSuccess())->toBeFalsy();
            expect($sut->getError())->toBeInstanceOf(ValidationError::class);
        });

        test('Should be return a failure Result if a bool string is provided', function () {
            $fakeXmlString = true;
            $sut = DataHoraSaidaEntrada::parseXmlString($fakeXmlString);
            expect($sut)->toBeInstanceOf(Result::class);
            expect($sut->isSuccess())->toBeFalsy();
            expect($sut->getError())->toBeInstanceOf(ValidationError::class);
        });

        test('Should be fail if an invalid dhEmi value is provided', function () {
            $sut = DataHoraSaidaEntrada::parseXmlString('<ide><dhSaiEnt>2020-05-20T11:00:54-0300</dhSaiEnt></ide>');
            expect($sut)->toBeInstanceOf(Result::class);
            expect($sut->isSuccess())->toBeFalsy();
            expect($sut->getError())->toBeInstanceOf(ValidationError::class);
        });
    });

    describe('::create()', function () {
        test('Should be succeed if a valid dhEmi value is provided', function () {
            $fakeXmlString = '2020-05-20T11:00:54-03:00';
            $sut = DataHoraSaidaEntrada::create(tagValue: $fakeXmlString);
            expect($sut)->toBeInstanceOf(Result::class);
            expect($sut->isSuccess())->toBeTruthy();
            expect($sut->getData())->toBeInstanceOf(DataHoraSaidaEntrada::class);
            expect($sut->getData()->value)->toBeString();
            expect($sut->getData()->value)->toBe('2020-05-20T11:00:54-03:00');
            expect($sut->getData()->xmlString)->toBeString();
            expect($sut->getData()->xmlString)->toBe('<dhSaiEnt>2020-05-20T11:00:54-03:00</dhSaiEnt>');
        });

        test('Should be fail if an invalid dhEmi value is provided', function () {
            $sut = DataHoraSaidaEntrada::create('2025-11-14T14:02:54-0400');
            expect($sut)->toBeInstanceOf(Result::class);
            expect($sut->isSuccess())->toBeFalsy();
            expect($sut->getError())->toBeInstanceOf(ValidationError::class);
        });
    });

    describe('::validateTagValue()', function () {
        test('Should be true if provided value is a Mod', function () {
            $fakeTagValue = '2020-05-20T11:00:54-03:00';
            $sut = DataHoraSaidaEntrada::validateTagValue($fakeTagValue);
            expect($sut->isSuccess())->toBeTruthy();
        });

        test('Should be fail if a string whit letters is provided', function () {
            $fakeTagValue = '20AA-11-14T14:02:54-04:00';
            $sut = DataHoraSaidaEntrada::validateTagValue($fakeTagValue);
            expect($sut->isSuccess())->toBeFalsy();
            expect($sut->getError())->toBeInstanceOf(ValidationError::class);
        });

        test('Should be fail if a string fewer than twenty five letters is provided', function () {
            $fakeTagValue = '2025-11-14T14:02:54-0400';
            $sut = DataHoraSaidaEntrada::validateTagValue($fakeTagValue);
            expect($sut->isSuccess())->toBeFalsy();
            expect($sut->getError())->toBeInstanceOf(ValidationError::class);
        });

        test('Should be fail if a string more than twenty five letters is provided', function () {
            $fakeTagValue = '2025-11-14T14:02:54:542-04:00';
            $sut = DataHoraSaidaEntrada::validateTagValue($fakeTagValue);
            expect($sut->isSuccess())->toBeFalsy();
            expect($sut->getError())->toBeInstanceOf(ValidationError::class);
        });
    });
});
