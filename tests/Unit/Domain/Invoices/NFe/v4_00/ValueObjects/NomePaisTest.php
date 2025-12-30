<?php

declare(strict_types=1);

use BradiNfeApi\Common\Exceptions\ValidationError;
use BradiNfeApi\Common\Result;
use BradiNfeApi\Domain\Invoices\NFe\v4_00\ValueObjects\NomePais;

/** Xml string example
 * <ide>
 *  <xPais>BRASIL</xPais>
 * </ide>
 */
describe('NomePais', function () {
    describe('::parseXmlString()', function () {
        test('Should be succeed when a valid xml string is provided', function () {
            $fakeXmlString = '<ide><xPais>BRASIL</xPais></ide>';
            $sut = NomePais::parseXmlString($fakeXmlString);
            expect($sut)->toBeInstanceOf(Result::class);
            expect($sut->isSuccess())->toBeTruthy();
            expect($sut->getData())->toBeInstanceOf(NomePais::class);
            expect($sut->getData()->value)->toBeString();
            expect($sut->getData()->value)->toBe('BRASIL');
            expect($sut->getData()->xmlString)->toBeString();
            expect($sut->getData()->xmlString)->toBe('<xPais>BRASIL</xPais>');
        });

        test('Should be succeed if an empty string is provided', function () {
            $fakeXmlString = '';
            $sut = NomePais::parseXmlString($fakeXmlString);
            expect($sut)->toBeInstanceOf(Result::class);
            expect($sut->isSuccess())->toBeTruthy();
            expect($sut->getData())->toBeInstanceOf(NomePais::class);
            expect($sut->getData()->value)->toBeString();
            expect($sut->getData()->value)->toBe('');
            expect($sut->getData()->xmlString)->toBeString();
            expect($sut->getData()->xmlString)->toBe('');
        });

        test('Should be return a failure Result if an object value is provided', function () {
            $fakeXmlString = new stdClass;
            $sut = NomePais::parseXmlString($fakeXmlString);
            expect($sut)->toBeInstanceOf(Result::class);
            expect($sut->isSuccess())->toBeFalsy();
            expect($sut->getError())->toBeInstanceOf(ValidationError::class);
        });

        test('Should be return a failure Result if a number value is provided', function () {
            $fakeXmlString = 11;
            $sut = NomePais::parseXmlString($fakeXmlString);
            expect($sut)->toBeInstanceOf(Result::class);
            expect($sut->isSuccess())->toBeFalsy();
            expect($sut->getError())->toBeInstanceOf(ValidationError::class);
        });

        test('Should be return a failure Result if an array value is provided', function () {
            $fakeXmlString = ['<ide><xPais>BRASIL</xPais></ide>'];
            $sut = NomePais::parseXmlString($fakeXmlString);
            expect($sut)->toBeInstanceOf(Result::class);
            expect($sut->isSuccess())->toBeFalsy();
            expect($sut->getError())->toBeInstanceOf(ValidationError::class);
        });

        test('Should be return a failure Result if null given', function () {
            $fakeXmlString = null;
            $sut = NomePais::parseXmlString($fakeXmlString);
            expect($sut)->toBeInstanceOf(Result::class);
            expect($sut->isSuccess())->toBeFalsy();
            expect($sut->getError())->toBeInstanceOf(ValidationError::class);
        });

        test('Should be return a failure Result if a bool string is provided', function () {
            $fakeXmlString = true;
            $sut = NomePais::parseXmlString($fakeXmlString);
            expect($sut)->toBeInstanceOf(Result::class);
            expect($sut->isSuccess())->toBeFalsy();
            expect($sut->getError())->toBeInstanceOf(ValidationError::class);
        });

        test('Should be fail if too long xPais value is provided', function () {
            $sut = NomePais::parseXmlString('<ide><xPais>NOME MUITO LONGO PARA O CAMPO COM ESTOURO DE QUANTIDADE DE CARACTERES</xPais></ide>');
            expect($sut)->toBeInstanceOf(Result::class);
            expect($sut->isSuccess())->toBeFalsy();
            expect($sut->getError())->toBeInstanceOf(ValidationError::class);
        });
    });

    describe('::create()', function () {
        test('Should be succeed if a string up to sixty chars is provided', function () {
            $fakeTagValue = 'BRASIL';
            $sut = NomePais::create(tagValue: $fakeTagValue);
            expect($sut)->toBeInstanceOf(Result::class);
            expect($sut->isSuccess())->toBeTruthy();
            expect($sut->getData())->toBeInstanceOf(NomePais::class);
            expect($sut->getData()->value)->toBeString();
            expect($sut->getData()->value)->toBe('BRASIL');
            expect($sut->getData()->xmlString)->toBeString();
            expect($sut->getData()->xmlString)->toBe('<xPais>BRASIL</xPais>');
        });

        test('Should be succeed if an empty string is provided', function () {
            $fakeXmlString = '';
            $sut = NomePais::create($fakeXmlString);
            expect($sut->isSuccess())->toBeTruthy();
            expect($sut->getData())->toBeInstanceOf(NomePais::class);
            expect($sut->getData()->value)->toBeString();
            expect($sut->getData()->value)->toBe('');
            expect($sut->getData()->xmlString)->toBeString();
            expect($sut->getData()->xmlString)->toBe('');
        });

        test('Should be fail if too long xPais value is provided', function () {
            $fakeTagValue = 'NOME MUITO LONGO PARA O CAMPO COM ESTOURO DE QUANTIDADE DE CARACTERES';
            $sut = NomePais::create(tagValue: $fakeTagValue);
            expect($sut)->toBeInstanceOf(Result::class);
            expect($sut->isSuccess())->toBeFalsy();
            expect($sut->getError())->toBeInstanceOf(ValidationError::class);
        });
    });

    describe('::validateTagValue()', function () {
        test('Should be true if provided value is a xPais', function () {
            $fakeTagValue = 'BRASIL';
            $sut = NomePais::validateTagValue($fakeTagValue);
            expect($sut->isSuccess())->toBeTruthy();
        });

        test('Should be succeed if a empty string is provided', function () {
            $fakeTagValue = '';
            $sut = NomePais::validateTagValue($fakeTagValue);
            expect($sut->isSuccess())->toBeTruthy();
        });

        test('Should be fail if a string more than sixty letters is provided', function () {
            $fakeTagValue = 'NOME MUITO LONGO PARA O CAMPO COM ESTOURO DE QUANTIDADE DE CARACTERES';
            $sut = NomePais::validateTagValue($fakeTagValue);
            expect($sut->isSuccess())->toBeFalsy();
            expect($sut->getError())->toBeInstanceOf(ValidationError::class);
        });
    });
});
