<?php

declare(strict_types=1);

use BradiNfeApi\Common\Exceptions\ValidationError;
use BradiNfeApi\Common\Result;
use BradiNfeApi\Domain\Invoices\NFe\v4_00\ValueObjects\CodigoMunFG;

/** Xml string example
 * <ide>
 *  <cMunFG>1100205</cMunFG>
 * </ide>
 */
describe('CodigoMunFG', function () {
    describe('::parseXmlString()', function () {
        test('Should be succeed when a valid xml string is provided', function () {
            $fakeXmlString = '<ide><cMunFG>1100205</cMunFG></ide>';
            $sut = CodigoMunFG::parseXmlString($fakeXmlString);
            expect($sut)->toBeInstanceOf(Result::class);
            expect($sut->isSuccess())->toBeTruthy();
            expect($sut->getData())->toBeInstanceOf(CodigoMunFG::class);
            expect($sut->getData()->value)->toBeString();
            expect($sut->getData()->value)->toBe('1100205');
            expect($sut->getData()->xmlString)->toBeString();
            expect($sut->getData()->xmlString)->toBe('<cMunFG>1100205</cMunFG>');
        });

        test('Should be return a failure Result if an object value is provided', function () {
            $fakeXmlString = new stdClass;
            $sut = CodigoMunFG::parseXmlString($fakeXmlString);
            expect($sut)->toBeInstanceOf(Result::class);
            expect($sut->isSuccess())->toBeFalsy();
            expect($sut->getError())->toBeInstanceOf(ValidationError::class);
        });

        test('Should be return a failure Result if a number value is provided', function () {
            $fakeXmlString = 11;
            $sut = CodigoMunFG::parseXmlString($fakeXmlString);
            expect($sut)->toBeInstanceOf(Result::class);
            expect($sut->isSuccess())->toBeFalsy();
            expect($sut->getError())->toBeInstanceOf(ValidationError::class);
        });

        test('Should be return a failure Result if an array value is provided', function () {
            $fakeXmlString = ['<ide><cMunFG>1100205</cMunFG></ide>'];
            $sut = CodigoMunFG::parseXmlString($fakeXmlString);
            expect($sut)->toBeInstanceOf(Result::class);
            expect($sut->isSuccess())->toBeFalsy();
            expect($sut->getError())->toBeInstanceOf(ValidationError::class);
        });

        test('Should be return a failure Result if null given', function () {
            $fakeXmlString = null;
            $sut = CodigoMunFG::parseXmlString($fakeXmlString);
            expect($sut)->toBeInstanceOf(Result::class);
            expect($sut->isSuccess())->toBeFalsy();
            expect($sut->getError())->toBeInstanceOf(ValidationError::class);
        })->skip();

        test('Should be return a failure Result if an empty string is provided', function () {
            $fakeXmlString = '';
            $sut = CodigoMunFG::parseXmlString($fakeXmlString);
            expect($sut)->toBeInstanceOf(Result::class);
            expect($sut->isSuccess())->toBeFalsy();
            expect($sut->getError())->toBeInstanceOf(ValidationError::class);
        });

        test('Should be return a failure Result if a bool string is provided', function () {
            $fakeXmlString = true;
            $sut = CodigoMunFG::parseXmlString($fakeXmlString);
            expect($sut)->toBeInstanceOf(Result::class);
            expect($sut->isSuccess())->toBeFalsy();
            expect($sut->getError())->toBeInstanceOf(ValidationError::class);
        });

        test('Should be fail if an invalid value is provided', function () {
            $fakeXmlString = '<ide><cMunFG>1100204</cMunFG></ide>';
            $sut = CodigoMunFG::parseXmlString($fakeXmlString);
            expect($sut)->toBeInstanceOf(Result::class);
            expect($sut->isSuccess())->toBeFalsy();
            expect($sut->getError())->toBeInstanceOf(ValidationError::class);
        });
    });

    describe('::create()', function () {
        test('Should be succeed if a valid value is provided', function () {
            $fakeTagValue = '1100205';
            $sut = CodigoMunFG::create(tagValue: $fakeTagValue);
            expect($sut)->toBeInstanceOf(Result::class);
            expect($sut->isSuccess())->toBeTruthy();
            expect($sut->getData())->toBeInstanceOf(CodigoMunFG::class);
            expect($sut->getData()->value)->toBeString();
            expect($sut->getData()->value)->toBe('1100205');
            expect($sut->getData()->xmlString)->toBeString();
            expect($sut->getData()->xmlString)->toBe('<cMunFG>1100205</cMunFG>');
        });

        test('Should be fail if an invalid value is provided', function () {
            $fakeTagValue = '1100204';
            $sut = CodigoMunFG::create(tagValue: $fakeTagValue);
            expect($sut)->toBeInstanceOf(Result::class);
            expect($sut->isSuccess())->toBeFalsy();
            expect($sut->getError())->toBeInstanceOf(ValidationError::class);
        });
    });

    describe('::validateTagValue()', function () {
        test('Should be true if provided value is valid', function () {
            $fakeTagValue = '1100205';
            $sut = CodigoMunFG::validateTagValue($fakeTagValue);
            expect($sut)->toBeTruthy();
        });

        test('Should be false if provided value is invalid', function () {
            $fakeTagValue = '1100204';
            $sut = CodigoMunFG::validateTagValue($fakeTagValue);
            expect($sut)->toBeFalsy();
        });

        test('Should be fail if a string whit letters is provided', function () {
            $fakeTagValue = '1100205A';
            $sut = CodigoMunFG::validateTagValue($fakeTagValue);
            expect($sut)->toBeFalsy();
        });

        test('Should be fail if a string more than seven letters is provided', function () {
            $fakeTagValue = '11002055';
            $sut = CodigoMunFG::validateTagValue($fakeTagValue);
            expect($sut)->toBeFalsy();
        });

        test('Should be fail if a string less than seven letters is provided', function () {
            $fakeTagValue = '110020';
            $sut = CodigoMunFG::validateTagValue($fakeTagValue);
            expect($sut)->toBeFalsy();
        });
    });
});
