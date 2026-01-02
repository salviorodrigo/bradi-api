<?php

declare(strict_types=1);

use BradiNfeApi\Common\Exceptions\ValidationError;
use BradiNfeApi\Common\Result;
use BradiNfeApi\Domain\Invoices\NFe\v4_00\ValueObjects\NomeFantasia;

/** Xml string example
 * <ide>
 *  <xFant>Brasil Redes</xFant>
 * </ide>
 */
describe('NomeFantasia', function () {
    describe('::parseXmlString()', function () {
        test('Should be succeed when a valid xml string is provided', function () {
            $fakeXmlString = '<ide><xFant>Brasil Redes</xFant></ide>';
            $sut = NomeFantasia::parseXmlString($fakeXmlString);
            expect($sut)->toBeInstanceOf(Result::class);
            expect($sut->isSuccess())->toBeTruthy();
            expect($sut->getData())->toBeInstanceOf(NomeFantasia::class);
            expect($sut->getData()->value)->toBeString();
            expect($sut->getData()->value)->toBe('Brasil Redes');
            expect($sut->getData()->xmlString)->toBeString();
            expect($sut->getData()->xmlString)->toBe('<xFant>Brasil Redes</xFant>');
        });

        test('Should be succeed if an empty string is provided', function () {
            $fakeXmlString = '';
            $sut = NomeFantasia::parseXmlString($fakeXmlString);
            expect($sut)->toBeInstanceOf(Result::class);
            expect($sut->isSuccess())->toBeTruthy();
            expect($sut->getData())->toBeInstanceOf(NomeFantasia::class);
            expect($sut->getData()->value)->toBeString();
            expect($sut->getData()->value)->toBe('');
            expect($sut->getData()->xmlString)->toBeString();
            expect($sut->getData()->xmlString)->toBe('');
        });

        test('Should be succeed if null given', function () {
            $fakeXmlString = null;
            $sut = NomeFantasia::parseXmlString($fakeXmlString);
            expect($sut)->toBeInstanceOf(Result::class);
            expect($sut->isSuccess())->toBeTruthy();
            expect($sut->getData())->toBeInstanceOf(NomeFantasia::class);
            expect($sut->getData()->value)->toBeString();
            expect($sut->getData()->value)->toBe('');
            expect($sut->getData()->xmlString)->toBeString();
            expect($sut->getData()->xmlString)->toBe('');
        });

        test('Should be return a failure Result if an object value is provided', function () {
            $fakeXmlString = new stdClass;
            $sut = NomeFantasia::parseXmlString($fakeXmlString);
            expect($sut)->toBeInstanceOf(Result::class);
            expect($sut->isSuccess())->toBeFalsy();
            expect($sut->getError())->toBeInstanceOf(ValidationError::class);
        });

        test('Should be return a failure Result if a number value is provided', function () {
            $fakeXmlString = 11;
            $sut = NomeFantasia::parseXmlString($fakeXmlString);
            expect($sut)->toBeInstanceOf(Result::class);
            expect($sut->isSuccess())->toBeFalsy();
            expect($sut->getError())->toBeInstanceOf(ValidationError::class);
        });

        test('Should be return a failure Result if an array value is provided', function () {
            $fakeXmlString = ['<ide><xFant>Brasil Redes</xFant></ide>'];
            $sut = NomeFantasia::parseXmlString($fakeXmlString);
            expect($sut)->toBeInstanceOf(Result::class);
            expect($sut->isSuccess())->toBeFalsy();
            expect($sut->getError())->toBeInstanceOf(ValidationError::class);
        });

        test('Should be return a failure Result if a bool string is provided', function () {
            $fakeXmlString = true;
            $sut = NomeFantasia::parseXmlString($fakeXmlString);
            expect($sut)->toBeInstanceOf(Result::class);
            expect($sut->isSuccess())->toBeFalsy();
            expect($sut->getError())->toBeInstanceOf(ValidationError::class);
        });

        test('Should be fail if too long xFant value is provided', function () {
            $sut = NomeFantasia::parseXmlString('<ide><xFant>NOME MUITO LONGO PARA O CAMPO COM ESTOURO DE QUANTIDADE DE CARACTERES</xFant></ide>');
            expect($sut)->toBeInstanceOf(Result::class);
            expect($sut->isSuccess())->toBeFalsy();
            expect($sut->getError())->toBeInstanceOf(ValidationError::class);
        });
    });

    describe('::create()', function () {
        test('Should be succeed if a string up to sixty chars is provided', function () {
            $fakeTagValue = 'Brasil Redes';
            $sut = NomeFantasia::create(tagValue: $fakeTagValue);
            expect($sut)->toBeInstanceOf(Result::class);
            expect($sut->isSuccess())->toBeTruthy();
            expect($sut->getData())->toBeInstanceOf(NomeFantasia::class);
            expect($sut->getData()->value)->toBeString();
            expect($sut->getData()->value)->toBe('Brasil Redes');
            expect($sut->getData()->xmlString)->toBeString();
            expect($sut->getData()->xmlString)->toBe('<xFant>Brasil Redes</xFant>');
        });

        test('Should be succeed if an empty string is provided', function () {
            $fakeXmlString = '';
            $sut = NomeFantasia::create($fakeXmlString);
            expect($sut->isSuccess())->toBeTruthy();
            expect($sut->getData())->toBeInstanceOf(NomeFantasia::class);
            expect($sut->getData()->value)->toBeString();
            expect($sut->getData()->value)->toBe('');
            expect($sut->getData()->xmlString)->toBeString();
            expect($sut->getData()->xmlString)->toBe('');
        });

        test('Should be fail if too long xFant value is provided', function () {
            $fakeTagValue = 'NOME MUITO LONGO PARA O CAMPO COM ESTOURO DE QUANTIDADE DE CARACTERES';
            $sut = NomeFantasia::create(tagValue: $fakeTagValue);
            expect($sut)->toBeInstanceOf(Result::class);
            expect($sut->isSuccess())->toBeFalsy();
            expect($sut->getError())->toBeInstanceOf(ValidationError::class);
        });
    });

    describe('::validateTagValue()', function () {
        test('Should be true if provided value is a xFant', function () {
            $fakeTagValue = 'Brasil Redes';
            $sut = NomeFantasia::validateTagValue($fakeTagValue);
            expect($sut->isSuccess())->toBeTruthy();
        });

        test('Should be succeed if a empty string is provided', function () {
            $fakeTagValue = '';
            $sut = NomeFantasia::validateTagValue($fakeTagValue);
            expect($sut->isSuccess())->toBeTruthy();
        });

        test('Should be fail if a string more than sixty letters is provided', function () {
            $fakeTagValue = 'NOME MUITO LONGO PARA O CAMPO COM ESTOURO DE QUANTIDADE DE CARACTERES';
            $sut = NomeFantasia::validateTagValue($fakeTagValue);
            expect($sut->isSuccess())->toBeFalsy();
            expect($sut->getError())->toBeInstanceOf(ValidationError::class);
        });
    });
});
