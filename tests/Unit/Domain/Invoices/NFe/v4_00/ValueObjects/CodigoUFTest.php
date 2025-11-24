<?php

declare(strict_types=1);

use BradiNfeApi\Common\Exceptions\ValidationError;
use BradiNfeApi\Common\Result;
use BradiNfeApi\Domain\Invoices\NFe\v4_00\ValueObjects\CodigoUF;

/** Xml string example
 * <ide>
 *  <cUF>11</cUF>
 * </ide>
 * <emit>
 *  <CNPJ>60968903000192</CNPJ>
 * </emit>
 */
describe('CodigoUF', function () {
    describe('::parseXmlString()', function () {
        test('Should be return a Result object with himself when a valid xml string is provided', function () {
            $fakeXmlString = '<ide><cUF>11</cUF></ide>';
            $sut = CodigoUF::parseXmlString($fakeXmlString);
            expect($sut)->toBeInstanceOf(Result::class);
            expect($sut->isSuccess())->toBeTruthy();
            expect($sut->getData())->toBeInstanceOf(CodigoUF::class);
            expect($sut->getData()->value)->toBeString();
            expect($sut->getData()->value)->toBe('11');
            expect($sut->getData()->xmlString)->toBeString();
            expect($sut->getData()->xmlString)->toBe('<cUF>11</cUF>');
        });
    });

    describe('::parseXmlString()', function () {
        test('Should be return a failure Result if an object value is provided', function () {
            $fakeXmlString = new stdClass;
            $sut = CodigoUF::parseXmlString($fakeXmlString);
            expect($sut)->toBeInstanceOf(Result::class);
            expect($sut->isSuccess())->toBeFalsy();
            expect($sut->getError())->toBeInstanceOf(ValidationError::class);
        });
    });

    describe('::parseXmlString()', function () {
        test('Should be return a failure Result if a number value is provided', function () {
            $fakeXmlString = 11;
            $sut = CodigoUF::parseXmlString($fakeXmlString);
            expect($sut)->toBeInstanceOf(Result::class);
            expect($sut->isSuccess())->toBeFalsy();
            expect($sut->getError())->toBeInstanceOf(ValidationError::class);
        });
    });

    describe('::parseXmlString()', function () {
        test('Should be return a failure Result if an array value is provided', function () {
            $fakeXmlString = ['<ide><cUF>11</cUF></ide>'];
            $sut = CodigoUF::parseXmlString($fakeXmlString);
            expect($sut)->toBeInstanceOf(Result::class);
            expect($sut->isSuccess())->toBeFalsy();
            expect($sut->getError())->toBeInstanceOf(ValidationError::class);
        });
    });

    describe('::parseXmlString()', function () {
        test('Should be return a failure Result if null given', function () {
            $fakeXmlString = null;
            $sut = CodigoUF::parseXmlString($fakeXmlString);
            expect($sut)->toBeInstanceOf(Result::class);
            expect($sut->isSuccess())->toBeFalsy();
            expect($sut->getError())->toBeInstanceOf(ValidationError::class);
        });
    });

    describe('::parseXmlString()', function () {
        test('Should be return a failure Result if an empty string is provided', function () {
            $fakeXmlString = '';
            $sut = CodigoUF::parseXmlString($fakeXmlString);
            expect($sut)->toBeInstanceOf(Result::class);
            expect($sut->isSuccess())->toBeFalsy();
            expect($sut->getError())->toBeInstanceOf(ValidationError::class);
        });
    });

    describe('::parseXmlString()', function () {
        test('Should be return a failure Result if a bool string is provided', function () {
            $fakeXmlString = true;
            $sut = CodigoUF::parseXmlString($fakeXmlString);
            expect($sut)->toBeInstanceOf(Result::class);
            expect($sut->isSuccess())->toBeFalsy();
            expect($sut->getError())->toBeInstanceOf(ValidationError::class);
        });
    });
});
