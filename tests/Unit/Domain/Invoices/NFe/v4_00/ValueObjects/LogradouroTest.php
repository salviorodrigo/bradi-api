<?php

declare(strict_types=1);

use BradiNfeApi\Common\Exceptions\ValidationError;
use BradiNfeApi\Common\Result;
use BradiNfeApi\Domain\Invoices\NFe\v4_00\ValueObjects\Logradouro;

/** Xml string example
 * <ide>
 *  <xLgr>R ACAI</xLgr>
 * </ide>
 */
describe('Logradouro', function () {
    describe('::parseXmlString()', function () {
        test('Should be succeed when a valid xml string is provided', function () {
            $fakeXmlString = '<ide><xLgr>R ACAI</xLgr></ide>';
            $sut = Logradouro::parseXmlString($fakeXmlString);
            expect($sut)->toBeInstanceOf(Result::class);
            expect($sut->isSuccess())->toBeTruthy();
            expect($sut->getData())->toBeInstanceOf(Logradouro::class);
            expect($sut->getData()->value)->toBeString();
            expect($sut->getData()->value)->toBe('R ACAI');
            expect($sut->getData()->xmlString)->toBeString();
            expect($sut->getData()->xmlString)->toBe('<xLgr>R ACAI</xLgr>');
        });

        test('Should be return a failure Result if an object value is provided', function () {
            $fakeXmlString = new stdClass;
            $sut = Logradouro::parseXmlString($fakeXmlString);
            expect($sut)->toBeInstanceOf(Result::class);
            expect($sut->isSuccess())->toBeFalsy();
            expect($sut->getError())->toBeInstanceOf(ValidationError::class);
        });

        test('Should be return a failure Result if a number value is provided', function () {
            $fakeXmlString = 11;
            $sut = Logradouro::parseXmlString($fakeXmlString);
            expect($sut)->toBeInstanceOf(Result::class);
            expect($sut->isSuccess())->toBeFalsy();
            expect($sut->getError())->toBeInstanceOf(ValidationError::class);
        });

        test('Should be return a failure Result if an array value is provided', function () {
            $fakeXmlString = ['<ide><xLgr>R ACAI</xLgr></ide>'];
            $sut = Logradouro::parseXmlString($fakeXmlString);
            expect($sut)->toBeInstanceOf(Result::class);
            expect($sut->isSuccess())->toBeFalsy();
            expect($sut->getError())->toBeInstanceOf(ValidationError::class);
        });

        test('Should be return a failure Result if null given', function () {
            $fakeXmlString = null;
            $sut = Logradouro::parseXmlString($fakeXmlString);
            expect($sut)->toBeInstanceOf(Result::class);
            expect($sut->isSuccess())->toBeFalsy();
            expect($sut->getError())->toBeInstanceOf(ValidationError::class);
        });

        test('Should be return a failure Result if an empty string is provided', function () {
            $fakeXmlString = '';
            $sut = Logradouro::parseXmlString($fakeXmlString);
            expect($sut)->toBeInstanceOf(Result::class);
            expect($sut->isSuccess())->toBeFalsy();
            expect($sut->getError())->toBeInstanceOf(ValidationError::class);
        });

        test('Should be return a failure Result if a bool string is provided', function () {
            $fakeXmlString = true;
            $sut = Logradouro::parseXmlString($fakeXmlString);
            expect($sut)->toBeInstanceOf(Result::class);
            expect($sut->isSuccess())->toBeFalsy();
            expect($sut->getError())->toBeInstanceOf(ValidationError::class);
        });

        test('Should be fail if too short xLgr value is provided', function () {
            $sut = Logradouro::parseXmlString('<ide><xLgr>A</xLgr></ide>');
            expect($sut)->toBeInstanceOf(Result::class);
            expect($sut->isSuccess())->toBeFalsy();
            expect($sut->getError())->toBeInstanceOf(ValidationError::class);
        });

        test('Should be fail if too long xLgr value is provided', function () {
            $sut = Logradouro::parseXmlString('<ide><xLgr>LOGRADOURO MUITO LONGO PARA O CAMPO COM ESTOURO DE QUANTIDADE DE CARACTERES</xLgr></ide>');
            expect($sut)->toBeInstanceOf(Result::class);
            expect($sut->isSuccess())->toBeFalsy();
            expect($sut->getError())->toBeInstanceOf(ValidationError::class);
        });
    });

    describe('::create()', function () {
        test('Should be succeed if a not null string up to sixty chars is provided', function () {
            $fakeTagValue = 'R ACAI';
            $sut = Logradouro::create(tagValue: $fakeTagValue);
            expect($sut)->toBeInstanceOf(Result::class);
            expect($sut->isSuccess())->toBeTruthy();
            expect($sut->getData())->toBeInstanceOf(Logradouro::class);
            expect($sut->getData()->value)->toBeString();
            expect($sut->getData()->value)->toBe('R ACAI');
            expect($sut->getData()->xmlString)->toBeString();
            expect($sut->getData()->xmlString)->toBe('<xLgr>R ACAI</xLgr>');
        });

        test('Should be fail if too long xLgr value is provided', function () {
            $fakeTagValue = 'LOGRADOURO MUITO LONGO PARA O CAMPO COM ESTOURO DE QUANTIDADE DE CARACTERES';
            $sut = Logradouro::create(tagValue: $fakeTagValue);
            expect($sut)->toBeInstanceOf(Result::class);
            expect($sut->isSuccess())->toBeFalsy();
            expect($sut->getError())->toBeInstanceOf(ValidationError::class);
        });
    });

    describe('::validateTagValue()', function () {
        test('Should be true if provided value is a xLgr', function () {
            $fakeTagValue = 'R ACAI';
            $sut = Logradouro::validateTagValue($fakeTagValue);
            expect($sut->isSuccess())->toBeTruthy();
        });

        test('Should be fail if a string less than two chars is provided', function () {
            $fakeTagValue = 'A';
            $sut = Logradouro::validateTagValue($fakeTagValue);
            expect($sut->isSuccess())->toBeFalsy();
            expect($sut->getError())->toBeInstanceOf(ValidationError::class);
        });

        test('Should be fail if a string more than sixty letters is provided', function () {
            $fakeTagValue = 'LOGRADOURO MUITO LONGO PARA O CAMPO COM ESTOURO DE QUANTIDADE DE CARACTERES';
            $sut = Logradouro::validateTagValue($fakeTagValue);
            expect($sut->isSuccess())->toBeFalsy();
            expect($sut->getError())->toBeInstanceOf(ValidationError::class);
        });
    });
});
