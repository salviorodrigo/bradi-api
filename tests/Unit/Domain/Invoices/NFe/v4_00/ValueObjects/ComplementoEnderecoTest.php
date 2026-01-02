<?php

declare(strict_types=1);

use BradiNfeApi\Common\Exceptions\ValidationError;
use BradiNfeApi\Common\Result;
use BradiNfeApi\Domain\Invoices\NFe\v4_00\ValueObjects\ComplementoEndereco;

/** Xml string example
 * <ide>
 *  <xCpl>Esq. Rua Acai</xCpl>
 * </ide>
 */
describe('ComplementoEndereco', function () {
    describe('::parseXmlString()', function () {
        test('Should be succeed when a valid xml string is provided', function () {
            $fakeXmlString = '<ide><xCpl>Esq. Rua Acai</xCpl></ide>';
            $sut = ComplementoEndereco::parseXmlString($fakeXmlString);
            expect($sut)->toBeInstanceOf(Result::class);
            expect($sut->isSuccess())->toBeTruthy();
            expect($sut->getData())->toBeInstanceOf(ComplementoEndereco::class);
            expect($sut->getData()->value)->toBeString();
            expect($sut->getData()->value)->toBe('Esq. Rua Acai');
            expect($sut->getData()->xmlString)->toBeString();
            expect($sut->getData()->xmlString)->toBe('<xCpl>Esq. Rua Acai</xCpl>');
        });

        test('Should be succeed if an empty string is provided', function () {
            $fakeXmlString = '';
            $sut = ComplementoEndereco::parseXmlString($fakeXmlString);
            expect($sut)->toBeInstanceOf(Result::class);
            expect($sut->isSuccess())->toBeTruthy();
            expect($sut->getData())->toBeInstanceOf(ComplementoEndereco::class);
            expect($sut->getData()->value)->toBeString();
            expect($sut->getData()->value)->toBe('');
            expect($sut->getData()->xmlString)->toBeString();
            expect($sut->getData()->xmlString)->toBe('');
        });

        test('Should be succeed if null given', function () {
            $fakeXmlString = null;
            $sut = ComplementoEndereco::parseXmlString($fakeXmlString);
            expect($sut)->toBeInstanceOf(Result::class);
            expect($sut->isSuccess())->toBeTruthy();
            expect($sut->getData())->toBeInstanceOf(ComplementoEndereco::class);
            expect($sut->getData()->value)->toBeString();
            expect($sut->getData()->value)->toBe('');
            expect($sut->getData()->xmlString)->toBeString();
            expect($sut->getData()->xmlString)->toBe('');
        });

        test('Should be return a failure Result if an object value is provided', function () {
            $fakeXmlString = new stdClass;
            $sut = ComplementoEndereco::parseXmlString($fakeXmlString);
            expect($sut)->toBeInstanceOf(Result::class);
            expect($sut->isSuccess())->toBeFalsy();
            expect($sut->getError())->toBeInstanceOf(ValidationError::class);
        });

        test('Should be return a failure Result if a number value is provided', function () {
            $fakeXmlString = 11;
            $sut = ComplementoEndereco::parseXmlString($fakeXmlString);
            expect($sut)->toBeInstanceOf(Result::class);
            expect($sut->isSuccess())->toBeFalsy();
            expect($sut->getError())->toBeInstanceOf(ValidationError::class);
        });

        test('Should be return a failure Result if an array value is provided', function () {
            $fakeXmlString = ['<ide><xCpl>Esq. Rua Acai</xCpl></ide>'];
            $sut = ComplementoEndereco::parseXmlString($fakeXmlString);
            expect($sut)->toBeInstanceOf(Result::class);
            expect($sut->isSuccess())->toBeFalsy();
            expect($sut->getError())->toBeInstanceOf(ValidationError::class);
        });

        test('Should be return a failure Result if a bool string is provided', function () {
            $fakeXmlString = true;
            $sut = ComplementoEndereco::parseXmlString($fakeXmlString);
            expect($sut)->toBeInstanceOf(Result::class);
            expect($sut->isSuccess())->toBeFalsy();
            expect($sut->getError())->toBeInstanceOf(ValidationError::class);
        });

        test('Should be fail if too long xCpl value is provided', function () {
            $sut = ComplementoEndereco::parseXmlString('<ide><xCpl>COMPLEMENTO DE ENDERECO MUITO LONGO PARA O CAMPO COM ESTOURO DE QUANTIDADE DE CARACTERES</xCpl></ide>');
            expect($sut)->toBeInstanceOf(Result::class);
            expect($sut->isSuccess())->toBeFalsy();
            expect($sut->getError())->toBeInstanceOf(ValidationError::class);
        });
    });

    describe('::create()', function () {
        test('Should be succeed if a string up to sixty chars is provided', function () {
            $fakeTagValue = 'Esq. Rua Acai';
            $sut = ComplementoEndereco::create(tagValue: $fakeTagValue);
            expect($sut)->toBeInstanceOf(Result::class);
            expect($sut->isSuccess())->toBeTruthy();
            expect($sut->getData())->toBeInstanceOf(ComplementoEndereco::class);
            expect($sut->getData()->value)->toBeString();
            expect($sut->getData()->value)->toBe('Esq. Rua Acai');
            expect($sut->getData()->xmlString)->toBeString();
            expect($sut->getData()->xmlString)->toBe('<xCpl>Esq. Rua Acai</xCpl>');
        });

        test('Should be succeed if an empty string is provided', function () {
            $fakeXmlString = '';
            $sut = ComplementoEndereco::create($fakeXmlString);
            expect($sut->isSuccess())->toBeTruthy();
            expect($sut->getData())->toBeInstanceOf(ComplementoEndereco::class);
            expect($sut->getData()->value)->toBeString();
            expect($sut->getData()->value)->toBe('');
            expect($sut->getData()->xmlString)->toBeString();
            expect($sut->getData()->xmlString)->toBe('');
        });

        test('Should be fail if too long xCpl value is provided', function () {
            $fakeTagValue = 'NOME MUITO LONGO PARA O CAMPO COM ESTOURO DE QUANTIDADE DE CARACTERES';
            $sut = ComplementoEndereco::create(tagValue: $fakeTagValue);
            expect($sut)->toBeInstanceOf(Result::class);
            expect($sut->isSuccess())->toBeFalsy();
            expect($sut->getError())->toBeInstanceOf(ValidationError::class);
        });
    });

    describe('::validateTagValue()', function () {
        test('Should be true if provided value is a xCpl', function () {
            $fakeTagValue = 'Esq. Rua Acai';
            $sut = ComplementoEndereco::validateTagValue($fakeTagValue);
            expect($sut->isSuccess())->toBeTruthy();
        });

        test('Should be succeed if a empty string is provided', function () {
            $fakeTagValue = '';
            $sut = ComplementoEndereco::validateTagValue($fakeTagValue);
            expect($sut->isSuccess())->toBeTruthy();
        });

        test('Should be fail if a string more than sixty letters is provided', function () {
            $fakeTagValue = 'NOME MUITO LONGO PARA O CAMPO COM ESTOURO DE QUANTIDADE DE CARACTERES';
            $sut = ComplementoEndereco::validateTagValue($fakeTagValue);
            expect($sut->isSuccess())->toBeFalsy();
            expect($sut->getError())->toBeInstanceOf(ValidationError::class);
        });
    });
});
