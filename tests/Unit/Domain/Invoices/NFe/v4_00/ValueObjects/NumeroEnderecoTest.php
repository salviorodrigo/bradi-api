<?php

declare(strict_types=1);

use BradiNfeApi\Common\Exceptions\ValidationError;
use BradiNfeApi\Common\Result;
use BradiNfeApi\Domain\Invoices\NFe\v4_00\ValueObjects\NumeroEndereco;

/** Xml string example
 * <ide>
 *  <nro>443</nro>
 * </ide>
 */
describe('NumeroEndereco', function () {
    describe('::parseXmlString()', function () {
        test('Should be succeed when a valid xml string is provided', function () {
            $fakeXmlString = '<ide><nro>443</nro></ide>';
            $sut = NumeroEndereco::parseXmlString($fakeXmlString);
            expect($sut)->toBeInstanceOf(Result::class);
            expect($sut->isSuccess())->toBeTruthy();
            expect($sut->getData())->toBeInstanceOf(NumeroEndereco::class);
            expect($sut->getData()->value)->toBeString();
            expect($sut->getData()->value)->toBe('443');
            expect($sut->getData()->xmlString)->toBeString();
            expect($sut->getData()->xmlString)->toBe('<nro>443</nro>');
        });

        test('Should be return a failure Result if an object value is provided', function () {
            $fakeXmlString = new stdClass;
            $sut = NumeroEndereco::parseXmlString($fakeXmlString);
            expect($sut)->toBeInstanceOf(Result::class);
            expect($sut->isSuccess())->toBeFalsy();
            expect($sut->getError())->toBeInstanceOf(ValidationError::class);
        });

        test('Should be return a failure Result if a number value is provided', function () {
            $fakeXmlString = 11;
            $sut = NumeroEndereco::parseXmlString($fakeXmlString);
            expect($sut)->toBeInstanceOf(Result::class);
            expect($sut->isSuccess())->toBeFalsy();
            expect($sut->getError())->toBeInstanceOf(ValidationError::class);
        });

        test('Should be return a failure Result if an array value is provided', function () {
            $fakeXmlString = ['<ide><nro>443</nro></ide>'];
            $sut = NumeroEndereco::parseXmlString($fakeXmlString);
            expect($sut)->toBeInstanceOf(Result::class);
            expect($sut->isSuccess())->toBeFalsy();
            expect($sut->getError())->toBeInstanceOf(ValidationError::class);
        });

        test('Should be return a failure Result if null given', function () {
            $fakeXmlString = null;
            $sut = NumeroEndereco::parseXmlString($fakeXmlString);
            expect($sut)->toBeInstanceOf(Result::class);
            expect($sut->isSuccess())->toBeFalsy();
            expect($sut->getError())->toBeInstanceOf(ValidationError::class);
        });

        test('Should be return a failure Result if an empty string is provided', function () {
            $fakeXmlString = '';
            $sut = NumeroEndereco::parseXmlString($fakeXmlString);
            expect($sut)->toBeInstanceOf(Result::class);
            expect($sut->isSuccess())->toBeFalsy();
            expect($sut->getError())->toBeInstanceOf(ValidationError::class);
        });

        test('Should be return a failure Result if a bool string is provided', function () {
            $fakeXmlString = true;
            $sut = NumeroEndereco::parseXmlString($fakeXmlString);
            expect($sut)->toBeInstanceOf(Result::class);
            expect($sut->isSuccess())->toBeFalsy();
            expect($sut->getError())->toBeInstanceOf(ValidationError::class);
        });

        test('Should be fail if a non numeric value is provided', function () {
            $sut = NumeroEndereco::parseXmlString('<ide><nro>1A</nro></ide>');
            expect($sut)->toBeInstanceOf(Result::class);
            expect($sut->isSuccess())->toBeFalsy();
            expect($sut->getError())->toBeInstanceOf(ValidationError::class);
        });

        test('Should be fail if too long nro value is provided', function () {
            $sut = NumeroEndereco::parseXmlString('<ide><nro>1234567890123456798012345678901234567890123456789012345678901</nro></ide>');
            expect($sut)->toBeInstanceOf(Result::class);
            expect($sut->isSuccess())->toBeFalsy();
            expect($sut->getError())->toBeInstanceOf(ValidationError::class);
        });
    });

    describe('::create()', function () {
        test('Should be succeed if a not null string up to sixty chars is provided', function () {
            $fakeTagValue = '443';
            $sut = NumeroEndereco::create(tagValue: $fakeTagValue);
            expect($sut)->toBeInstanceOf(Result::class);
            expect($sut->isSuccess())->toBeTruthy();
            expect($sut->getData())->toBeInstanceOf(NumeroEndereco::class);
            expect($sut->getData()->value)->toBeString();
            expect($sut->getData()->value)->toBe('443');
            expect($sut->getData()->xmlString)->toBeString();
            expect($sut->getData()->xmlString)->toBe('<nro>443</nro>');
        });

        test('Should be fail if too long nro value is provided', function () {
            $fakeTagValue = '1234567890123456798012345678901234567890123456789012345678901';
            $sut = NumeroEndereco::create(tagValue: $fakeTagValue);
            expect($sut)->toBeInstanceOf(Result::class);
            expect($sut->isSuccess())->toBeFalsy();
            expect($sut->getError())->toBeInstanceOf(ValidationError::class);
        });
    });

    describe('::validateTagValue()', function () {
        test('Should be true if provided value is a nro', function () {
            $fakeTagValue = '443';
            $sut = NumeroEndereco::validateTagValue($fakeTagValue);
            expect($sut->isSuccess())->toBeTruthy();
        });

        test('Should be fail if a string with lathers is provided', function () {
            $fakeTagValue = '1A';
            $sut = NumeroEndereco::validateTagValue($fakeTagValue);
            expect($sut->isSuccess())->toBeFalsy();
            expect($sut->getError())->toBeInstanceOf(ValidationError::class);
        });

        test('Should be fail if a string more than sixty letters is provided', function () {
            $fakeTagValue = '1234567890123456798012345678901234567890123456789012345678901';
            $sut = NumeroEndereco::validateTagValue($fakeTagValue);
            expect($sut->isSuccess())->toBeFalsy();
            expect($sut->getError())->toBeInstanceOf(ValidationError::class);
        });
    });
});
