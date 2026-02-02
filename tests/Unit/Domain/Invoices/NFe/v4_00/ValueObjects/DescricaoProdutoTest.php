<?php

declare(strict_types=1);

use BradiNfeApi\Common\Exceptions\ValidationError;
use BradiNfeApi\Common\Result;
use BradiNfeApi\Domain\Invoices\NFe\v4_00\ValueObjects\DescricaoProduto;

/** Xml string example
 *
 * <xProd>DESCRICAO PRODUTO VALIDA</xProd>
 */
describe('DescricaoProduto', function () {
    describe('::parseXmlString()', function () {
        test('Should be succeed when a valid xml string with a valid xProd value is provided', function () {
            $fakeTagValue = 'DESCRICAO PRODUTO VALIDA';
            $fakeXmlString = "<xProd>{$fakeTagValue}</xProd>";
            $sut = DescricaoProduto::parseXmlString($fakeXmlString);
            expect($sut)->toBeInstanceOf(Result::class);
            expect($sut->isSuccess())->toBeTruthy();
            expect($sut->getData())->toBeInstanceOf(DescricaoProduto::class);
            expect($sut->getData()->value)->toBeString();
            expect($sut->getData()->value)->toBe($fakeTagValue);
            expect($sut->getData()->xmlString)->toBeString();
            expect($sut->getData()->xmlString)->toBe($fakeXmlString);
        });

        test('Should be return a failure Result if non valid string is provided', function ($fakeXmlString) {
            $sut = DescricaoProduto::parseXmlString($fakeXmlString);
            expect($sut)->toBeInstanceOf(Result::class);
            expect($sut->isSuccess())->toBeFalsy();
            expect($sut->getError())->toBeInstanceOf(ValidationError::class);
        })->with([
            new stdClass,                   // object
            11111111,                       // integer
            [['<xProd>SEM GTIN</xProd>']],    // array
            null,                           // null
            true,                           // boolean
            '',                             // empty string
        ]);

        test('Should be fail if a too long value is provided', function () {
            $fakeTagValue = str_repeat('A', 121);
            $fakeXmlString = "<xProd>{$fakeTagValue}</xProd>";
            $sut = DescricaoProduto::parseXmlString($fakeXmlString);
            expect($sut)->toBeInstanceOf(Result::class);
            expect($sut->isSuccess())->toBeFalsy();
            expect($sut->getError())->toBeInstanceOf(ValidationError::class);
        });
    });

    describe('::create()', function () {
        test('Should be succeed if a valid value is provided', function () {
            $fakeTagValue = 'DESCRICAO PRODUTO VALIDA';
            $sut = DescricaoProduto::create(tagValue: $fakeTagValue);
            expect($sut)->toBeInstanceOf(Result::class);
            expect($sut->isSuccess())->toBeTruthy();
            expect($sut->getData())->toBeInstanceOf(DescricaoProduto::class);
            expect($sut->getData()->value)->toBeString();
            expect($sut->getData()->value)->toBe($fakeTagValue);
            expect($sut->getData()->xmlString)->toBeString();
            expect($sut->getData()->xmlString)->toBe("<xProd>{$fakeTagValue}</xProd>");
        });

        test('Should be fail if a too long value is provided', function () {
            $fakeTagValue = str_repeat('A', 121);
            $sut = DescricaoProduto::create(tagValue: $fakeTagValue);
            expect($sut)->toBeInstanceOf(Result::class);
            expect($sut->isSuccess())->toBeFalsy();
            expect($sut->getError())->toBeInstanceOf(ValidationError::class);
        });
    });

    describe('::validateTagValue()', function () {
        test('Should be true if a valid value is provided', function () {
            $fakeTagValue = 'DESCRICAO PRODUTO VALIDA';
            $sut = DescricaoProduto::validateTagValue($fakeTagValue);
            expect($sut->isSuccess())->toBeTruthy();
        });

        test('Should be false if a value with invalid length is provided', function ($fakeTagValue) {
            $sut = DescricaoProduto::validateTagValue($fakeTagValue);
            expect($sut->isSuccess())->toBeFalsy();
            expect($sut->getError())->toBeInstanceOf(ValidationError::class);
        })->with([
            '',                     // empty string
            str_repeat('A', 121),   // 121 chars
        ]);
    });
});
