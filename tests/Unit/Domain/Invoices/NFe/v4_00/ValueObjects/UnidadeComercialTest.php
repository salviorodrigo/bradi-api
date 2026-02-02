<?php

declare(strict_types=1);

use BradiNfeApi\Common\Exceptions\ValidationError;
use BradiNfeApi\Common\Result;
use BradiNfeApi\Domain\Invoices\NFe\v4_00\ValueObjects\UnidadeComercial;

/** Xml string example
 *
 * <uCom>UN</uCom>
 */
describe('UnidadeComercial', function () {
    describe('::parseXmlString()', function () {
        test('Should be succeed when a valid xml string with a valid uCom value is provided', function () {
            $fakeTagValue = 'UN';
            $fakeXmlString = "<uCom>{$fakeTagValue}</uCom>";
            $sut = UnidadeComercial::parseXmlString($fakeXmlString);
            expect($sut)->toBeInstanceOf(Result::class);
            expect($sut->isSuccess())->toBeTruthy();
            expect($sut->getData())->toBeInstanceOf(UnidadeComercial::class);
            expect($sut->getData()->value)->toBeString();
            expect($sut->getData()->value)->toBe($fakeTagValue);
            expect($sut->getData()->xmlString)->toBeString();
            expect($sut->getData()->xmlString)->toBe($fakeXmlString);
        });

        test('Should be return a failure Result if non string is provided', function ($fakeXmlString) {
            $sut = UnidadeComercial::parseXmlString($fakeXmlString);
            expect($sut)->toBeInstanceOf(Result::class);
            expect($sut->isSuccess())->toBeFalsy();
            expect($sut->getError())->toBeInstanceOf(ValidationError::class);
        })->with([
            new stdClass,               // object
            1111,                       // integer
            [['<uCom>UN</uCom>']],    // array
            null,                       // null
            true,                       // boolean
            '',                         // empty string
        ]);

        test('Should be fail if a value with invalid length is provided', function () {
            $fakeXmlString = '<uCom>UNIDADE</uCom>';
            $sut = UnidadeComercial::parseXmlString($fakeXmlString);
            expect($sut)->toBeInstanceOf(Result::class);
            expect($sut->isSuccess())->toBeFalsy();
            expect($sut->getError())->toBeInstanceOf(ValidationError::class);
        });
    });

    describe('::create()', function () {
        test('Should be succeed if a valid value is provided', function () {
            $fakeTagValue = 'UN';
            $sut = UnidadeComercial::create(tagValue: $fakeTagValue);
            expect($sut)->toBeInstanceOf(Result::class);
            expect($sut->isSuccess())->toBeTruthy();
            expect($sut->getData())->toBeInstanceOf(UnidadeComercial::class);
            expect($sut->getData()->value)->toBeString();
            expect($sut->getData()->value)->toBe($fakeTagValue);
            expect($sut->getData()->xmlString)->toBeString();
            expect($sut->getData()->xmlString)->toBe("<uCom>{$fakeTagValue}</uCom>");
        });

        test('Should be fail if a value with invalid length is provided', function () {
            $fakeTagValue = 'UNIDADE';
            $sut = UnidadeComercial::create(tagValue: $fakeTagValue);
            expect($sut)->toBeInstanceOf(Result::class);
            expect($sut->isSuccess())->toBeFalsy();
            expect($sut->getError())->toBeInstanceOf(ValidationError::class);
        });
    });

    describe('::validateTagValue()', function () {
        test('Should be true if a valid value is provided', function () {
            $fakeTagValue = 'UN';
            $sut = UnidadeComercial::validateTagValue($fakeTagValue);
            expect($sut->isSuccess())->toBeTruthy();
        });

        test('Should be false if a value with invalid length is provided', function () {
            $fakeTagValue = 'UNIDADE';
            $sut = UnidadeComercial::validateTagValue($fakeTagValue);
            expect($sut->isSuccess())->toBeFalsy();
            expect($sut->getError())->toBeInstanceOf(ValidationError::class);
        });
    });
});
