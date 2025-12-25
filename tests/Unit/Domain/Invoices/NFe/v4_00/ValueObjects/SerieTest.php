<?php

declare(strict_types=1);

use BradiNfeApi\Common\Exceptions\ValidationError;
use BradiNfeApi\Common\Result;
use BradiNfeApi\Domain\Invoices\NFe\v4_00\ValueObjects\Serie;

/** Xml string example
 * <ide>
 *  <serie>0</serie>
 * </ide>
 */
describe('Serie', function () {
    describe('::parseXmlString()', function () {
        test('Should be succeed when a valid xml string is provided', function () {
            $fakeXmlString = '<ide><serie>0</serie></ide>';
            $sut = Serie::parseXmlString($fakeXmlString);
            expect($sut)->toBeInstanceOf(Result::class);
            expect($sut->isSuccess())->toBeTruthy();
            expect($sut->getData())->toBeInstanceOf(Serie::class);
            expect($sut->getData()->value)->toBeString();
            expect($sut->getData()->value)->toBe('0');
            expect($sut->getData()->xmlString)->toBeString();
            expect($sut->getData()->xmlString)->toBe('<serie>0</serie>');
        });

        test('Should be fail if an invalid serie value is provided', function () {
            $fakeXmlString = '<ide><serie>970</serie></ide>';
            $sut = Serie::parseXmlString($fakeXmlString);
            expect($sut)->toBeInstanceOf(Result::class);
            expect($sut->isSuccess())->toBeFalsy();
            expect($sut->getError())->toBeInstanceOf(ValidationError::class);
        });
    });

    describe('::create()', function () {
        test('Should be succeed if a valid serie value is provided', function () {
            $tagValue = '0';
            $sut = Serie::create(tagValue: $tagValue);
            expect($sut)->toBeInstanceOf(Result::class);
            expect($sut->isSuccess())->toBeTruthy();
            expect($sut->getData())->toBeInstanceOf(Serie::class);
            expect($sut->getData()->value)->toBeString();
            expect($sut->getData()->value)->toBe('0');
            expect($sut->getData()->xmlString)->toBeString();
            expect($sut->getData()->xmlString)->toBe('<serie>0</serie>');
        });

        test('Should be fail if an invalid serie value is provided', function () {
            $tagValue = '970';
            $sut = Serie::create(tagValue: $tagValue);
            expect($sut)->toBeInstanceOf(Result::class);
            expect($sut->isSuccess())->toBeFalsy();
            expect($sut->getError())->toBeInstanceOf(ValidationError::class);
        });
    });
});
