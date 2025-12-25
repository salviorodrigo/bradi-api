<?php

declare(strict_types=1);

use BradiNfeApi\Common\Exceptions\ValidationError;
use BradiNfeApi\Common\Result;
use BradiNfeApi\Domain\Invoices\NFe\v4_00\ValueObjects\Mod;

/** Xml string example
 * <ide>
 *  <mod>55</mod>
 * </ide>
 */
describe('Mod', function () {
    describe('::parseXmlString()', function () {
        test('Should be succeed when a valid xml string is provided', function () {
            $fakeXmlString = '<ide><mod>55</mod></ide>';
            $sut = Mod::parseXmlString($fakeXmlString);
            expect($sut)->toBeInstanceOf(Result::class);
            expect($sut->isSuccess())->toBeTruthy();
            expect($sut->getData())->toBeInstanceOf(Mod::class);
            expect($sut->getData()->value)->toBeString();
            expect($sut->getData()->value)->toBe('55');
            expect($sut->getData()->xmlString)->toBeString();
            expect($sut->getData()->xmlString)->toBe('<mod>55</mod>');
        });

        test('Should be fail if an invalid mod value is provided', function () {
            $fakeXmlString = '<ide><mod>10</mod></ide>';
            $sut = Mod::parseXmlString($fakeXmlString);
            expect($sut)->toBeInstanceOf(Result::class);
            expect($sut->isSuccess())->toBeFalsy();
            expect($sut->getError())->toBeInstanceOf(ValidationError::class);
        });
    });

    describe('::create()', function () {
        test('Should be succeed if a valid mod value is provided', function () {
            $fakeTagValue = '65';
            $sut = Mod::create(tagValue: $fakeTagValue);
            expect($sut)->toBeInstanceOf(Result::class);
            expect($sut->isSuccess())->toBeTruthy();
            expect($sut->getData())->toBeInstanceOf(Mod::class);
            expect($sut->getData()->value)->toBeString();
            expect($sut->getData()->value)->toBe('65');
            expect($sut->getData()->xmlString)->toBeString();
            expect($sut->getData()->xmlString)->toBe('<mod>65</mod>');
        });

        test('Should be fail if an invalid mod value is provided', function () {
            $fakeTagValue = '85';
            $sut = Mod::create(tagValue: $fakeTagValue);
            expect($sut)->toBeInstanceOf(Result::class);
            expect($sut->isSuccess())->toBeFalsy();
            expect($sut->getError())->toBeInstanceOf(ValidationError::class);
        });
    });
});
