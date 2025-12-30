<?php

declare(strict_types=1);

use BradiNfeApi\Common\Exceptions\ValidationError;
use BradiNfeApi\Common\Result;
use BradiNfeApi\Domain\Invoices\NFe\v4_00\ValueObjects\NomeMunicipio;

/** Xml string example
 * <ide>
 *  <xMun>PORTO VELHO</xMun>
 * </ide>
 */
describe('NomeMunicipio', function () {
    describe('::parseXmlString()', function () {
        test('Should be succeed when a valid xml string is provided', function () {
            $fakeXmlString = '<ide><xMun>PORTO VELHO</xMun></ide>';
            $sut = NomeMunicipio::parseXmlString($fakeXmlString);
            expect($sut)->toBeInstanceOf(Result::class);
            expect($sut->isSuccess())->toBeTruthy();
            expect($sut->getData())->toBeInstanceOf(NomeMunicipio::class);
            expect($sut->getData()->value)->toBeString();
            expect($sut->getData()->value)->toBe('PORTO VELHO');
            expect($sut->getData()->xmlString)->toBeString();
            expect($sut->getData()->xmlString)->toBe('<xMun>PORTO VELHO</xMun>');
        });

        test('Should be fail if an empty string is provided', function () {
            $fakeXmlString = '';
            $sut = NomeMunicipio::parseXmlString($fakeXmlString);
            expect($sut)->toBeInstanceOf(Result::class);
            expect($sut->isSuccess())->toBeFalsy();
            expect($sut->getError())->toBeInstanceOf(ValidationError::class);
        });

        test('Should be return a failure Result if an object value is provided', function () {
            $fakeXmlString = new stdClass;
            $sut = NomeMunicipio::parseXmlString($fakeXmlString);
            expect($sut)->toBeInstanceOf(Result::class);
            expect($sut->isSuccess())->toBeFalsy();
            expect($sut->getError())->toBeInstanceOf(ValidationError::class);
        });

        test('Should be return a failure Result if a number value is provided', function () {
            $fakeXmlString = 11;
            $sut = NomeMunicipio::parseXmlString($fakeXmlString);
            expect($sut)->toBeInstanceOf(Result::class);
            expect($sut->isSuccess())->toBeFalsy();
            expect($sut->getError())->toBeInstanceOf(ValidationError::class);
        });

        test('Should be return a failure Result if an array value is provided', function () {
            $fakeXmlString = ['<ide><xMun>PORTO VELHO</xMun></ide>'];
            $sut = NomeMunicipio::parseXmlString($fakeXmlString);
            expect($sut)->toBeInstanceOf(Result::class);
            expect($sut->isSuccess())->toBeFalsy();
            expect($sut->getError())->toBeInstanceOf(ValidationError::class);
        });

        test('Should be return a failure Result if null given', function () {
            $fakeXmlString = null;
            $sut = NomeMunicipio::parseXmlString($fakeXmlString);
            expect($sut)->toBeInstanceOf(Result::class);
            expect($sut->isSuccess())->toBeFalsy();
            expect($sut->getError())->toBeInstanceOf(ValidationError::class);
        });

        test('Should be return a failure Result if a bool string is provided', function () {
            $fakeXmlString = true;
            $sut = NomeMunicipio::parseXmlString($fakeXmlString);
            expect($sut)->toBeInstanceOf(Result::class);
            expect($sut->isSuccess())->toBeFalsy();
            expect($sut->getError())->toBeInstanceOf(ValidationError::class);
        });

        test('Should be fail if too long xMun value is provided', function () {
            $sut = NomeMunicipio::parseXmlString('<ide><xMun>NOME MUITO LONGO PARA O CAMPO COM ESTOURO DE QUANTIDADE DE CARACTERES</xMun></ide>');
            expect($sut)->toBeInstanceOf(Result::class);
            expect($sut->isSuccess())->toBeFalsy();
            expect($sut->getError())->toBeInstanceOf(ValidationError::class);
        });
    });

    describe('::create()', function () {
        test('Should be succeed if a string up to sixty chars is provided', function () {
            $fakeTagValue = 'PORTO VELHO';
            $sut = NomeMunicipio::create(tagValue: $fakeTagValue);
            expect($sut)->toBeInstanceOf(Result::class);
            expect($sut->isSuccess())->toBeTruthy();
            expect($sut->getData())->toBeInstanceOf(NomeMunicipio::class);
            expect($sut->getData()->value)->toBeString();
            expect($sut->getData()->value)->toBe('PORTO VELHO');
            expect($sut->getData()->xmlString)->toBeString();
            expect($sut->getData()->xmlString)->toBe('<xMun>PORTO VELHO</xMun>');
        });

        test('Should be fail if an empty string is provided', function () {
            $fakeXmlString = '';
            $sut = NomeMunicipio::create($fakeXmlString);
            expect($sut->isSuccess())->toBeFalsy();
            expect($sut->getError())->toBeInstanceOf(ValidationError::class);
        });

        test('Should be fail if too long xMun value is provided', function () {
            $fakeTagValue = 'NOME MUITO LONGO PARA O CAMPO COM ESTOURO DE QUANTIDADE DE CARACTERES';
            $sut = NomeMunicipio::create(tagValue: $fakeTagValue);
            expect($sut)->toBeInstanceOf(Result::class);
            expect($sut->isSuccess())->toBeFalsy();
            expect($sut->getError())->toBeInstanceOf(ValidationError::class);
        });
    });

    describe('::validateTagValue()', function () {
        test('Should be true if provided value is a xMun', function () {
            $fakeTagValue = 'PORTO VELHO';
            $sut = NomeMunicipio::validateTagValue($fakeTagValue);
            expect($sut->isSuccess())->toBeTruthy();
        });

        test('Should be fail if a empty string is provided', function () {
            $fakeTagValue = '';
            $sut = NomeMunicipio::validateTagValue($fakeTagValue);
            expect($sut->isSuccess())->toBeFalsy();
            expect($sut->getError())->toBeInstanceOf(ValidationError::class);
        });

        test('Should be fail if a string more than sixty letters is provided', function () {
            $fakeTagValue = 'NOME MUITO LONGO PARA O CAMPO COM ESTOURO DE QUANTIDADE DE CARACTERES';
            $sut = NomeMunicipio::validateTagValue($fakeTagValue);
            expect($sut->isSuccess())->toBeFalsy();
            expect($sut->getError())->toBeInstanceOf(ValidationError::class);
        });
    });
});
