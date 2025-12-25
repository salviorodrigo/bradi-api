<?php

declare(strict_types=1);

use BradiNfeApi\Common\Exceptions\ValidationError;
use BradiNfeApi\Common\Result;
use BradiNfeApi\Domain\Invoices\NFe\v4_00\ValueObjects\CodigoNF;

/** Xml string example
 * <ide>
 *  <cNF>83427844</cNF>
 * </ide>
 */
describe('CodigoNF', function () {
    describe('::parseXmlString()', function () {
        test('Should be return a Result object with himself when a valid xml string is provided', function () {
            $fakeXmlString = '<ide><cUF>11</cUF><cNF>83427844</cNF></ide>';
            $sut = CodigoNF::parseXmlString($fakeXmlString);
            expect($sut)->toBeInstanceOf(Result::class);
            expect($sut->isSuccess())->toBeTruthy();
            expect($sut->getData())->toBeInstanceOf(CodigoNF::class);
            expect($sut->getData()->value)->toBeString();
            expect($sut->getData()->value)->toBe('83427844');
            expect($sut->getData()->xmlString)->toBeString();
            expect($sut->getData()->xmlString)->toBe('<cNF>83427844</cNF>');
        });

        test('Should be return a failure Result if an object value is provided', function () {
            $fakeXmlString = new stdClass;
            $sut = CodigoNF::parseXmlString($fakeXmlString);
            expect($sut)->toBeInstanceOf(Result::class);
            expect($sut->isSuccess())->toBeFalsy();
            expect($sut->getError())->toBeInstanceOf(ValidationError::class);
        });

        test('Should be return a failure Result if a number value is provided', function () {
            $fakeXmlString = 11;
            $sut = CodigoNF::parseXmlString($fakeXmlString);
            expect($sut)->toBeInstanceOf(Result::class);
            expect($sut->isSuccess())->toBeFalsy();
            expect($sut->getError())->toBeInstanceOf(ValidationError::class);
        });

        test('Should be return a failure Result if an array value is provided', function () {
            $fakeXmlString = ['<ide><cUF>11</cUF><cNF>83427844</cNF></ide>'];
            $sut = CodigoNF::parseXmlString($fakeXmlString);
            expect($sut)->toBeInstanceOf(Result::class);
            expect($sut->isSuccess())->toBeFalsy();
            expect($sut->getError())->toBeInstanceOf(ValidationError::class);
        });

        test('Should be return a failure Result if null given', function () {
            $fakeXmlString = null;
            $sut = CodigoNF::parseXmlString($fakeXmlString);
            expect($sut)->toBeInstanceOf(Result::class);
            expect($sut->isSuccess())->toBeFalsy();
            expect($sut->getError())->toBeInstanceOf(ValidationError::class);
        });

        test('Should be return a failure Result if an empty string is provided', function () {
            $fakeXmlString = '';
            $sut = CodigoNF::parseXmlString($fakeXmlString);
            expect($sut)->toBeInstanceOf(Result::class);
            expect($sut->isSuccess())->toBeFalsy();
            expect($sut->getError())->toBeInstanceOf(ValidationError::class);
        });

        test('Should be return a failure Result if a bool string is provided', function () {
            $fakeXmlString = true;
            $sut = CodigoNF::parseXmlString($fakeXmlString);
            expect($sut)->toBeInstanceOf(Result::class);
            expect($sut->isSuccess())->toBeFalsy();
            expect($sut->getError())->toBeInstanceOf(ValidationError::class);
        });

        test('Should be fail if a string fewer than eight letters is provided', function () {
            $fakeXmlString = '<cNF>0000001</cNF>';
            $sut = CodigoNF::parseXmlString($fakeXmlString);
            expect($sut)->toBeInstanceOf(Result::class);
            expect($sut->isSuccess())->toBeFalsy();
            expect($sut->getError())->toBeInstanceOf(ValidationError::class);
        });

        test('Should be fail if an invalid cNF is provided', function () {
            $fakeXmlString = '<cNF>000000001</cNF>';
            $sut = CodigoNF::parseXmlString($fakeXmlString);
            expect($sut)->toBeInstanceOf(Result::class);
            expect($sut->isSuccess())->toBeFalsy();
            expect($sut->getError())->toBeInstanceOf(ValidationError::class);
        });
    });

    describe('::create()', function () {
        test('Should be return a Result object with a valid cNF value when a tag value isn\'t provided', function () {
            $sut = CodigoNF::create();
            expect($sut)->toBeInstanceOf(Result::class);
            expect($sut->isSuccess())->toBeTruthy();
            expect($sut->getData())->toBeInstanceOf(CodigoNF::class);
            expect($sut->getData()->value)->toBeString();
            expect(preg_match('/^(?!0{8})[0-9]{8}$/', $sut->getData()->value))->toBeTruthy();
            expect((CodigoNF::parseXmlString($sut->getData()->xmlString))->isSuccess())->toBeTruthy();
        });

        test('Should be return a Result object with success if a valid cNF value is provided', function () {
            $fakeTagValue = '83427844';
            $sut = CodigoNF::create($fakeTagValue);
            expect($sut)->toBeInstanceOf(Result::class);
            expect($sut->isSuccess())->toBeTruthy();
            expect($sut->getData())->toBeInstanceOf(CodigoNF::class);
            expect($sut->getData()->value)->toBeString();
            expect(preg_match('/^(?!0{8})[0-9]{8}$/', $sut->getData()->value))->toBeTruthy();
            expect((CodigoNF::parseXmlString($sut->getData()->xmlString))->isSuccess())->toBeTruthy();
        });

        test('Should be fail if an invalid cNF value is provided', function () {
            $fakeTagValue = '8342784';
            $sut = CodigoNF::create($fakeTagValue);
            expect($sut)->toBeInstanceOf(Result::class);
            expect($sut->isSuccess())->toBeFalsy();
            expect($sut->getError())->toBeInstanceOf(ValidationError::class);
        });

        test('Should be fail if attributes is provided', function () {
            $fakeTagValue = '8342784';
            $fakeAttributes = ['fakeAttribute' => 'fakeAttributeValue'];
            $sut = CodigoNF::create(tagValue: $fakeTagValue, attributes: $fakeAttributes);
            expect($sut)->toBeInstanceOf(Result::class);
            expect($sut->isSuccess())->toBeFalsy();
            expect($sut->getError())->toBeInstanceOf(ValidationError::class);
        });

        test('Should be fail if elements is provided', function () {
            $fakeTagValue = '8342784';
            $fakeElements = ['fakeElement'];
            $sut = CodigoNF::create(tagValue: $fakeTagValue, elements: $fakeElements);
            expect($sut)->toBeInstanceOf(Result::class);
            expect($sut->isSuccess())->toBeFalsy();
            expect($sut->getError())->toBeInstanceOf(ValidationError::class);
        });
    });

    describe('::validateTagValue()', function () {
        test('Should be true if provided value is a cNF', function () {
            $fakeTagValue = '83427844';
            $sut = CodigoNF::validateTagValue($fakeTagValue);
            expect($sut)->toBeTruthy();
        });

        test('Should be fail if a string whit letters is provided', function () {
            $fakeTagValue = 'ABC00000';
            $sut = CodigoNF::validateTagValue($fakeTagValue);
            expect($sut)->toBeFalsy();
        });

        test('Should be fail if a zero string is provided', function () {
            $fakeTagValue = '00000000';
            $sut = CodigoNF::validateTagValue($fakeTagValue);
            expect($sut)->toBeFalsy();
        });

        test('Should be fail if a string fewer than eight letters is provided', function () {
            $fakeTagValue = '0000001';
            $sut = CodigoNF::validateTagValue($fakeTagValue);
            expect($sut)->toBeFalsy();
        });

        test('Should be fail if a string more than eight letters is provided', function () {
            $fakeTagValue = '000000001';
            $sut = CodigoNF::validateTagValue($fakeTagValue);
            expect($sut)->toBeFalsy();
        });
    });
});
