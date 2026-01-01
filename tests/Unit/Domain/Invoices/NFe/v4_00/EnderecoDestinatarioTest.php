<?php

declare(strict_types=1);

use BradiNfeApi\Common\Exceptions\ValidationError;
use BradiNfeApi\Common\Result;
use BradiNfeApi\Domain\Invoices\NFe\v4_00\EnderecoDestinatario;

/** Xml string example
 *
 * <eDest>
 * <enderDest>
 *     <xLgr>ROD DOS IMIGRANTES</xLgr>
 *     <nro>SN</nro>
 *     <xCpl>KM 7</xCpl>
 *     <xBairro>JEANNE</xBairro>
 *     <cMun>5108402</cMun>
 *     <xMun>VARZEA GRANDE</xMun>
 *     <UF>MT</UF>
 *     <CEP>78132400</CEP>
 *     <cPais>1058</cPais>
 *     <xPais>BRASIL</xPais>
 *     <fone>556536324500</fone>
 * </enderDest>
 * </eDest>
 */
describe('EnderecoDestinatario', function () {
    describe('::parseXmlString()', function () {
        test('Should be succeed when a valid xml string is provided', function () {
            $fakeXmlString = '<eDest><enderDest><xLgr>ROD DOS IMIGRANTES</xLgr><nro>SN</nro><xCpl>KM 7</xCpl><xBairro>JEANNE</xBairro><cMun>5108402</cMun><xMun>VARZEA GRANDE</xMun><UF>MT</UF><CEP>78132400</CEP><cPais>1058</cPais><xPais>BRASIL</xPais><fone>556536324500</fone></enderDest></eDest>';
            $sut = EnderecoDestinatario::parseXmlString($fakeXmlString);
            expect($sut)->toBeInstanceOf(Result::class);
            expect($sut->isSuccess())->toBeTruthy();
            expect($sut->getData())->toBeInstanceOf(EnderecoDestinatario::class);
            expect($sut->getData()->value)->toBeString();
            expect($sut->getData()->value)->toBe('');
            expect($sut->getData()->xmlString)->toBeString();
            expect($sut->getData()->xmlString)->toBe('<enderDest><xLgr>ROD DOS IMIGRANTES</xLgr><nro>SN</nro><xCpl>KM 7</xCpl><xBairro>JEANNE</xBairro><cMun>5108402</cMun><xMun>VARZEA GRANDE</xMun><UF>MT</UF><CEP>78132400</CEP><cPais>1058</cPais><xPais>BRASIL</xPais><fone>556536324500</fone></enderDest>');
        });

        test('Should be fail if xLgr tag  isn\'t provided', function () {
            $fakeXmlString = '<eDest><enderDest><nro>SN</nro><xCpl>KM 7</xCpl><xBairro>JEANNE</xBairro><cMun>5108402</cMun><xMun>VARZEA GRANDE</xMun><UF>MT</UF><CEP>78132400</CEP><cPais>1058</cPais><xPais>BRASIL</xPais><fone>556536324500</fone></enderDest></eDest>';
            $sut = EnderecoDestinatario::parseXmlString($fakeXmlString);
            expect($sut)->toBeInstanceOf(Result::class);
            expect($sut->isSuccess())->toBeFalsy();
            expect($sut->getError())->toBeInstanceOf(ValidationError::class);
        });

        test('Should be fail if nro tag  isn\'t provided', function () {
            $fakeXmlString = '<eDest><enderDest><xLgr>ROD DOS IMIGRANTES</xLgr><xCpl>KM 7</xCpl><xBairro>JEANNE</xBairro><cMun>5108402</cMun><xMun>VARZEA GRANDE</xMun><UF>MT</UF><CEP>78132400</CEP><cPais>1058</cPais><xPais>BRASIL</xPais><fone>556536324500</fone></enderDest></eDest>';
            $sut = EnderecoDestinatario::parseXmlString($fakeXmlString);
            expect($sut)->toBeInstanceOf(Result::class);
            expect($sut->isSuccess())->toBeFalsy();
            expect($sut->getError())->toBeInstanceOf(ValidationError::class);
        });

        test('Should be fail if xBairro tag  isn\'t provided', function () {
            $fakeXmlString = '<eDest><enderDest><xLgr>ROD DOS IMIGRANTES</xLgr><nro>SN</nro><xCpl>KM 7</xCpl><cMun>5108402</cMun><xMun>VARZEA GRANDE</xMun><UF>MT</UF><CEP>78132400</CEP><cPais>1058</cPais><xPais>BRASIL</xPais><fone>556536324500</fone></enderDest></eDest>';
            $sut = EnderecoDestinatario::parseXmlString($fakeXmlString);
            expect($sut)->toBeInstanceOf(Result::class);
            expect($sut->isSuccess())->toBeFalsy();
            expect($sut->getError())->toBeInstanceOf(ValidationError::class);
        });

        test('Should be fail if cMun tag  isn\'t provided', function () {
            $fakeXmlString = '<eDest><enderDest><xLgr>ROD DOS IMIGRANTES</xLgr><nro>SN</nro><xCpl>KM 7</xCpl><xBairro>JEANNE</xBairro><xMun>VARZEA GRANDE</xMun><UF>MT</UF><CEP>78132400</CEP><cPais>1058</cPais><xPais>BRASIL</xPais><fone>556536324500</fone></enderDest></eDest>';
            $sut = EnderecoDestinatario::parseXmlString($fakeXmlString);
            expect($sut)->toBeInstanceOf(Result::class);
            expect($sut->isSuccess())->toBeFalsy();
            expect($sut->getError())->toBeInstanceOf(ValidationError::class);
        });

        test('Should be fail if xMun tag  isn\'t provided', function () {
            $fakeXmlString = '<eDest><enderDest><xLgr>ROD DOS IMIGRANTES</xLgr><nro>SN</nro><xCpl>KM 7</xCpl><xBairro>JEANNE</xBairro><cMun>5108402</cMun><UF>MT</UF><CEP>78132400</CEP><cPais>1058</cPais><xPais>BRASIL</xPais><fone>556536324500</fone></enderDest></eDest>';
            $sut = EnderecoDestinatario::parseXmlString($fakeXmlString);
            expect($sut)->toBeInstanceOf(Result::class);
            expect($sut->isSuccess())->toBeFalsy();
            expect($sut->getError())->toBeInstanceOf(ValidationError::class);
        });

        test('Should be fail if UF tag  isn\'t provided', function () {
            $fakeXmlString = '<eDest><enderDest><xLgr>ROD DOS IMIGRANTES</xLgr><nro>SN</nro><xCpl>KM 7</xCpl><xBairro>JEANNE</xBairro><cMun>5108402</cMun><xMun>VARZEA GRANDE</xMun><CEP>78132400</CEP><cPais>1058</cPais><xPais>BRASIL</xPais><fone>556536324500</fone></enderDest></eDest>';
            $sut = EnderecoDestinatario::parseXmlString($fakeXmlString);
            expect($sut)->toBeInstanceOf(Result::class);
            expect($sut->isSuccess())->toBeFalsy();
            expect($sut->getError())->toBeInstanceOf(ValidationError::class);
        });

        test('Should be fail if CEP tag  isn\'t provided', function () {
            $fakeXmlString = '<eDest><enderDest><xLgr>ROD DOS IMIGRANTES</xLgr><nro>SN</nro><xCpl>KM 7</xCpl><xBairro>JEANNE</xBairro><cMun>5108402</cMun><xMun>VARZEA GRANDE</xMun><UF>MT</UF><cPais>1058</cPais><xPais>BRASIL</xPais><fone>556536324500</fone></enderDest></eDest>';
            $sut = EnderecoDestinatario::parseXmlString($fakeXmlString);
            expect($sut)->toBeInstanceOf(Result::class);
            expect($sut->isSuccess())->toBeFalsy();
            expect($sut->getError())->toBeInstanceOf(ValidationError::class);
        });
    });

    describe('::validateTagValue()', function () {
        test('Should be true if provided value is a empty string', function () {
            $fakeTagValue = '';
            $sut = EnderecoDestinatario::validateTagValue($fakeTagValue);
            expect($sut->isSuccess())->toBeTruthy();
        });

        test('Should be fail if a non empty string is provided', function () {
            $fakeTagValue = 'A';
            $sut = EnderecoDestinatario::validateTagValue($fakeTagValue);
            expect($sut->isSuccess())->toBeFalsy();
            expect($sut->getError())->toBeInstanceOf(ValidationError::class);
        });
    });
});
