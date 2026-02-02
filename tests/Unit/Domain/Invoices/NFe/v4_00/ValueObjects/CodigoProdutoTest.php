<?php

declare(strict_types=1);

use BradiNfeApi\Common\Exceptions\ValidationError;
use BradiNfeApi\Common\Result;
use BradiNfeApi\Domain\Invoices\NFe\v4_00\ValueObjects\CodigoProduto;

/** Xml string example
 *
 * <cProd>000200020A</cProd>
 */
describe('CodigoProduto', function () {
    describe('::parseXmlString()', function () {
        test('Should be succeed when a valid xml string is provided', function () {
            $fakeXmlString = '<cProd>000200020A</cProd>';
            $sut = CodigoProduto::parseXmlString($fakeXmlString);
            expect($sut)->toBeInstanceOf(Result::class);
            expect($sut->isSuccess())->toBeTruthy();
            expect($sut->getData())->toBeInstanceOf(CodigoProduto::class);
            expect($sut->getData()->value)->toBeString();
            expect($sut->getData()->value)->toBe('000200020A');
            expect($sut->getData()->xmlString)->toBeString();
            expect($sut->getData()->xmlString)->toBe('<cProd>000200020A</cProd>');
        });

        test('Should be return a failure Result if an object value is provided', function () {
            $fakeXmlString = new stdClass;
            $sut = CodigoProduto::parseXmlString($fakeXmlString);
            expect($sut)->toBeInstanceOf(Result::class);
            expect($sut->isSuccess())->toBeFalsy();
            expect($sut->getError())->toBeInstanceOf(ValidationError::class);
        });

        test('Should be return a failure Result if a number value is provided', function () {
            $fakeXmlString = 11;
            $sut = CodigoProduto::parseXmlString($fakeXmlString);
            expect($sut)->toBeInstanceOf(Result::class);
            expect($sut->isSuccess())->toBeFalsy();
            expect($sut->getError())->toBeInstanceOf(ValidationError::class);
        });

        test('Should be return a failure Result if an array value is provided', function () {
            $fakeXmlString = ['<cProd>000200020A</cP'];
            $sut = CodigoProduto::parseXmlString($fakeXmlString);
            expect($sut)->toBeInstanceOf(Result::class);
            expect($sut->isSuccess())->toBeFalsy();
            expect($sut->getError())->toBeInstanceOf(ValidationError::class);
        });

        test('Should be return a failure Result if null given', function () {
            $fakeXmlString = null;
            $sut = CodigoProduto::parseXmlString($fakeXmlString);
            expect($sut)->toBeInstanceOf(Result::class);
            expect($sut->isSuccess())->toBeFalsy();
            expect($sut->getError())->toBeInstanceOf(ValidationError::class);
        });

        test('Should be return a failure Result if an empty string is provided', function () {
            $fakeXmlString = '';
            $sut = CodigoProduto::parseXmlString($fakeXmlString);
            expect($sut)->toBeInstanceOf(Result::class);
            expect($sut->isSuccess())->toBeFalsy();
            expect($sut->getError())->toBeInstanceOf(ValidationError::class);
        });

        test('Should be return a failure Result if a bool string is provided', function () {
            $fakeXmlString = true;
            $sut = CodigoProduto::parseXmlString($fakeXmlString);
            expect($sut)->toBeInstanceOf(Result::class);
            expect($sut->isSuccess())->toBeFalsy();
            expect($sut->getError())->toBeInstanceOf(ValidationError::class);
        });

        test('Should be fail if a too short value is provided', function () {
            $sut = CodigoProduto::parseXmlString('<cProd>A</cP');
            expect($sut)->toBeInstanceOf(Result::class);
            expect($sut->isSuccess())->toBeFalsy();
            expect($sut->getError())->toBeInstanceOf(ValidationError::class);
        });

        test('Should be fail if too long cProd value is provided', function () {
            $sut = CodigoProduto::parseXmlString('<cProd>NOME DE CodigoProduto MUITO GRANDE PARA ESTE CAMPO CAUSANDO ESTOURO DE DADOS</cProd>');
            expect($sut)->toBeInstanceOf(Result::class);
            expect($sut->isSuccess())->toBeFalsy();
            expect($sut->getError())->toBeInstanceOf(ValidationError::class);
        });
    });

    describe('::create()', function () {
        test('Should be succeed if a not null string up to sixty chars is provided', function () {
            $fakeTagValue = '000200020A';
            $sut = CodigoProduto::create(tagValue: $fakeTagValue);
            expect($sut)->toBeInstanceOf(Result::class);
            expect($sut->isSuccess())->toBeTruthy();
            expect($sut->getData())->toBeInstanceOf(CodigoProduto::class);
            expect($sut->getData()->value)->toBeString();
            expect($sut->getData()->value)->toBe('000200020A');
            expect($sut->getData()->xmlString)->toBeString();
            expect($sut->getData()->xmlString)->toBe('<cProd>000200020A</cProd>');
        });

        test('Should be fail if too long cProd value is provided', function () {
            $fakeTagValue = 'NOME DE CodigoProduto MUITO GRANDE PARA ESTE CAMPO CAUSANDO ESTOURO DE DADOS';
            $sut = CodigoProduto::create(tagValue: $fakeTagValue);
            expect($sut)->toBeInstanceOf(Result::class);
            expect($sut->isSuccess())->toBeFalsy();
            expect($sut->getError())->toBeInstanceOf(ValidationError::class);
        });
    });

    describe('::validateTagValue()', function () {
        test('Should be true if provided value is a cProd', function () {
            $fakeTagValue = '000200020A';
            $sut = CodigoProduto::validateTagValue($fakeTagValue);
            expect($sut->isSuccess())->toBeTruthy();
        });

        test('Should be fail if a string more than sixty letters is provided', function () {
            $fakeTagValue = 'NOME DE CodigoProduto MUITO GRANDE PARA ESTE CAMPO CAUSANDO ESTOURO DE DADOS';
            $sut = CodigoProduto::validateTagValue($fakeTagValue);
            expect($sut->isSuccess())->toBeFalsy();
            expect($sut->getError())->toBeInstanceOf(ValidationError::class);
        });

        test('Should be fail if an empty string  is provided', function () {
            $fakeTagValue = '';
            $sut = CodigoProduto::validateTagValue($fakeTagValue);
            expect($sut->isSuccess())->toBeFalsy();
            expect($sut->getError())->toBeInstanceOf(ValidationError::class);
        });
    });
});
