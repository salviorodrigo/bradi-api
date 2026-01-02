<?php

declare(strict_types=1);

use BradiNfeApi\Common\Exceptions\ValidationError;
use BradiNfeApi\Common\Result;
use BradiNfeApi\Domain\Invoices\NFe\v4_00\Destinatario;

/** Xml string example
 *
 * <dest>
 * <CNPJ>16519674000137</CNPJ>
 * <xNome>MIRIAN VARZEA GRANDE AUTO POSTO LTDA</xNome>
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
 * </enderDest>>
 * <indIEDest>1</indIEDest>
 * <IE>00134608836</IE>
 * </dest>>
 */
describe('Destinatario', function () {
    describe('::parseXmlString()', function () {
        test('Should be succeed when a valid xml string is provided', function () {
            $fakeXmlString = '<dest><CNPJ>16519674000137</CNPJ><xNome>MIRIAN VARZEA GRANDE AUTO POSTO LTDA</xNome><enderDest><xLgr>ROD DOS IMIGRANTES</xLgr><nro>SN</nro><xCpl>KM 7</xCpl><xBairro>JEANNE</xBairro><cMun>5108402</cMun><xMun>VARZEA GRANDE</xMun><UF>MT</UF><CEP>78132400</CEP><cPais>1058</cPais><xPais>BRASIL</xPais><fone>556536324500</fone></enderDest>><indIEDest>1</indIEDest><IE>00134608836</IE></dest>';
            $sut = Destinatario::parseXmlString($fakeXmlString);
            expect($sut)->toBeInstanceOf(Result::class);
            expect($sut->isSuccess())->toBeTruthy();
            expect($sut->getData())->toBeInstanceOf(Destinatario::class);
            expect($sut->getData()->value)->toBeString();
            expect($sut->getData()->value)->toBe('');
            expect($sut->getData()->xmlString)->toBeString();
            expect($sut->getData()->xmlString)->toBe('<dest><CNPJ>16519674000137</CNPJ><xNome>MIRIAN VARZEA GRANDE AUTO POSTO LTDA</xNome><enderDest><xLgr>ROD DOS IMIGRANTES</xLgr><nro>SN</nro><xCpl>KM 7</xCpl><xBairro>JEANNE</xBairro><cMun>5108402</cMun><xMun>VARZEA GRANDE</xMun><UF>MT</UF><CEP>78132400</CEP><cPais>1058</cPais><xPais>BRASIL</xPais><fone>556536324500</fone></enderDest>><indIEDest>1</indIEDest><IE>00134608836</IE></dest>');
        });

        test('Should be fail if CNPJ or CPF or idEstrangeiro tag isn\'t provided', function () {
            $fakeXmlString = '<dest><xNome>MIRIAN VARZEA GRANDE AUTO POSTO LTDA</xNome><enderDest><xLgr>ROD DOS IMIGRANTES</xLgr><nro>SN</nro><xCpl>KM 7</xCpl><xBairro>JEANNE</xBairro><cMun>5108402</cMun><xMun>VARZEA GRANDE</xMun><UF>MT</UF><CEP>78132400</CEP><cPais>1058</cPais><xPais>BRASIL</xPais><fone>556536324500</fone></enderDest>><indIEDest>1</indIEDest><IE>00134608836</IE></dest>';
            $sut = Destinatario::parseXmlString($fakeXmlString);
            expect($sut)->toBeInstanceOf(Result::class);
            expect($sut->isSuccess())->toBeFalsy();
            expect($sut->getError())->toBeInstanceOf(ValidationError::class);
        });

        test('Should be fail if IndIEDest tag  isn\'t provided', function () {
            $fakeXmlString = '<dest><CNPJ>16519674000137</CNPJ><xNome>MIRIAN VARZEA GRANDE AUTO POSTO LTDA</xNome><enderDest><xLgr>ROD DOS IMIGRANTES</xLgr><nro>SN</nro><xCpl>KM 7</xCpl><xBairro>JEANNE</xBairro><cMun>5108402</cMun><xMun>VARZEA GRANDE</xMun><UF>MT</UF><CEP>78132400</CEP><cPais>1058</cPais><xPais>BRASIL</xPais><fone>556536324500</fone></enderDest>><IE>00134608836</IE></dest>';
            $sut = Destinatario::parseXmlString($fakeXmlString);
            expect($sut)->toBeInstanceOf(Result::class);
            expect($sut->isSuccess())->toBeFalsy();
            expect($sut->getError())->toBeInstanceOf(ValidationError::class);
        });
    });

    describe('::validateTagValue()', function () {
        test('Should be true if provided value is a empty string', function () {
            $fakeTagValue = '';
            $sut = Destinatario::validateTagValue($fakeTagValue);
            expect($sut->isSuccess())->toBeTruthy();
        });

        test('Should be fail if a non empty string is provided', function () {
            $fakeTagValue = 'A';
            $sut = Destinatario::validateTagValue($fakeTagValue);
            expect($sut->isSuccess())->toBeFalsy();
            expect($sut->getError())->toBeInstanceOf(ValidationError::class);
        });
    });
});
