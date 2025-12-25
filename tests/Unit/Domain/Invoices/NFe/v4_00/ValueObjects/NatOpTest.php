<?php

declare(strict_types=1);

use BradiNfeApi\Common\Exceptions\ValidationError;
use BradiNfeApi\Common\Result;
use BradiNfeApi\Domain\Invoices\NFe\v4_00\ValueObjects\NatOp;

/** Xml string example
 * <ide>
 *  <cUF>11</cUF>
 *  <natOp>VENDA DE MERCADORIAS</natOp>
 * </ide>
 * <emit>
 *  <CNPJ>60968903000192</CNPJ>
 * </emit>
 */
describe('NatOp', function () {
    describe('::parseXmlString()', function () {
        test('Should be succeed when a valid xml string is provided', function () {
            $fakeXmlString = '<ide><natOp>VENDA DE MERCADORIAS</natOp></ide>';
            $sut = NatOp::parseXmlString($fakeXmlString);
            expect($sut)->toBeInstanceOf(Result::class);
            expect($sut->isSuccess())->toBeTruthy();
            expect($sut->getData())->toBeInstanceOf(NatOp::class);
            expect($sut->getData()->value)->toBeString();
            expect($sut->getData()->value)->toBe('VENDA DE MERCADORIAS');
            expect($sut->getData()->xmlString)->toBeString();
            expect($sut->getData()->xmlString)->toBe('<natOp>VENDA DE MERCADORIAS</natOp>');
        });

        test('Should be fail if too long natOp value is provided', function () {
            $sut = NatOp::parseXmlString('<ide><natOp>NATUREZA DE OPERACAO MUITO LONGA PARA O CAMPO COM ESTOURO DE QUANTIDADE DE CARACTERES</natOp></ide>');
            expect($sut)->toBeInstanceOf(Result::class);
            expect($sut->isSuccess())->toBeFalsy();
            expect($sut->getError())->toBeInstanceOf(ValidationError::class);
        });
    });

    describe('::create()', function () {
        test('Should be succeed if a not null string up to sixty chars is provided', function () {
            $fakeXmlString = 'VENDA DE MERCADORIAS';
            $sut = NatOp::create(tagValue: $fakeXmlString);
            expect($sut)->toBeInstanceOf(Result::class);
            expect($sut->isSuccess())->toBeTruthy();
            expect($sut->getData())->toBeInstanceOf(NatOp::class);
            expect($sut->getData()->value)->toBeString();
            expect($sut->getData()->value)->toBe('VENDA DE MERCADORIAS');
            expect($sut->getData()->xmlString)->toBeString();
            expect($sut->getData()->xmlString)->toBe('<natOp>VENDA DE MERCADORIAS</natOp>');
        });

        test('Should be fail if too long natOp value is provided', function () {
            $sut = NatOp::create('NATUREZA DE OPERACAO MUITO LONGA PARA O CAMPO COM ESTOURO DE QUANTIDADE DE CARACTERES');
            expect($sut)->toBeInstanceOf(Result::class);
            expect($sut->isSuccess())->toBeFalsy();
            expect($sut->getError())->toBeInstanceOf(ValidationError::class);
        });
    });
});
