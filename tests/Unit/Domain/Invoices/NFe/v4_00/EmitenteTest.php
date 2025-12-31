<?php

declare(strict_types=1);

use BradiNfeApi\Common\Exceptions\ValidationError;
use BradiNfeApi\Common\Result;
use BradiNfeApi\Domain\Invoices\NFe\v4_00\Emitente;

/** Xml string example
 *
 * <emit>
 * <CNPJ>16519674000137</CNPJ>
 * <xNome>MIRIAN VARZEA GRANDE AUTO POSTO LTDA</xNome>
 * <xFant>MIRIAN VARZEA GRANDE</xFant>
 * <enderEmit>
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
 * </enderEmit>
 * <IE>00134608836</IE>
 * <IM>34037</IM>
 * <CNAE>4731800</CNAE>
 * <CRT>3</CRT>
 * </emit>
 */
describe('Emitente', function () {
    describe('::parseXmlString()', function () {
        test('Should be succeed when a valid xml string is provided', function () {
            $fakeXmlString = '<emit><CNPJ>16519674000137</CNPJ><xNome>MIRIAN VARZEA GRANDE AUTO POSTO LTDA</xNome><xFant>MIRIAN VARZEA GRANDE</xFant><enderEmit><xLgr>ROD DOS IMIGRANTES</xLgr><nro>SN</nro><xCpl>KM 7</xCpl><xBairro>JEANNE</xBairro><cMun>5108402</cMun><xMun>VARZEA GRANDE</xMun><UF>MT</UF><CEP>78132400</CEP><cPais>1058</cPais><xPais>BRASIL</xPais><fone>556536324500</fone></enderEmit><IE>00134608836</IE><IM>34037</IM><CNAE>4731800</CNAE><CRT>3</CRT></emit>';
            $sut = Emitente::parseXmlString($fakeXmlString);
            expect($sut)->toBeInstanceOf(Result::class);
            expect($sut->isSuccess())->toBeTruthy();
            expect($sut->getData())->toBeInstanceOf(Emitente::class);
            expect($sut->getData()->value)->toBeString();
            expect($sut->getData()->value)->toBe('');
            expect($sut->getData()->xmlString)->toBeString();
            expect($sut->getData()->xmlString)->toBe('<emit><CNPJ>16519674000137</CNPJ><xNome>MIRIAN VARZEA GRANDE AUTO POSTO LTDA</xNome><xFant>MIRIAN VARZEA GRANDE</xFant><enderEmit><xLgr>ROD DOS IMIGRANTES</xLgr><nro>SN</nro><xCpl>KM 7</xCpl><xBairro>JEANNE</xBairro><cMun>5108402</cMun><xMun>VARZEA GRANDE</xMun><UF>MT</UF><CEP>78132400</CEP><cPais>1058</cPais><xPais>BRASIL</xPais><fone>556536324500</fone></enderEmit><IE>00134608836</IE><IM>34037</IM><CNAE>4731800</CNAE><CRT>3</CRT></emit>');
        });

        test('Should be fail if CNPJ tag  isn\'t provided', function () {
            $fakeXmlString = '<emit><xNome>MIRIAN VARZEA GRANDE AUTO POSTO LTDA</xNome><xFant>MIRIAN VARZEA GRANDE</xFant><enderEmit><xLgr>ROD DOS IMIGRANTES</xLgr><nro>SN</nro><xCpl>KM 7</xCpl><xBairro>JEANNE</xBairro><cMun>5108402</cMun><xMun>VARZEA GRANDE</xMun><UF>MT</UF><CEP>78132400</CEP><cPais>1058</cPais><xPais>BRASIL</xPais><fone>556536324500</fone></enderEmit><IE>00134608836</IE><IM>34037</IM><CNAE>4731800</CNAE><CRT>3</CRT></emit>';
            $sut = Emitente::parseXmlString($fakeXmlString);
            expect($sut)->toBeInstanceOf(Result::class);
            expect($sut->isSuccess())->toBeFalsy();
            expect($sut->getError())->toBeInstanceOf(ValidationError::class);
        });

        test('Should be fail if xNome tag  isn\'t provided', function () {
            $fakeXmlString = '<emit><CNPJ>16519674000137</CNPJ><xFant>MIRIAN VARZEA GRANDE</xFant><enderEmit><xLgr>ROD DOS IMIGRANTES</xLgr><nro>SN</nro><xCpl>KM 7</xCpl><xBairro>JEANNE</xBairro><cMun>5108402</cMun><xMun>VARZEA GRANDE</xMun><UF>MT</UF><CEP>78132400</CEP><cPais>1058</cPais><xPais>BRASIL</xPais><fone>556536324500</fone></enderEmit><IE>00134608836</IE><IM>34037</IM><CNAE>4731800</CNAE><CRT>3</CRT></emit>';
            $sut = Emitente::parseXmlString($fakeXmlString);
            expect($sut)->toBeInstanceOf(Result::class);
            expect($sut->isSuccess())->toBeFalsy();
            expect($sut->getError())->toBeInstanceOf(ValidationError::class);
        });

        test('Should be fail if endEmit tag  isn\'t provided', function () {
            $fakeXmlString = '<emit><CNPJ>16519674000137</CNPJ><xNome>MIRIAN VARZEA GRANDE AUTO POSTO LTDA</xNome><xFant>MIRIAN VARZEA GRANDE</xFant><IE>00134608836</IE><IM>34037</IM><CNAE>4731800</CNAE><CRT>3</CRT></emit>';
            $sut = Emitente::parseXmlString($fakeXmlString);
            expect($sut)->toBeInstanceOf(Result::class);
            expect($sut->isSuccess())->toBeFalsy();
            expect($sut->getError())->toBeInstanceOf(ValidationError::class);
        });

        test('Should be fail if IE tag  isn\'t provided', function () {
            $fakeXmlString = '<emit><CNPJ>16519674000137</CNPJ><xNome>MIRIAN VARZEA GRANDE AUTO POSTO LTDA</xNome><xFant>MIRIAN VARZEA GRANDE</xFant><enderEmit><xLgr>ROD DOS IMIGRANTES</xLgr><nro>SN</nro><xCpl>KM 7</xCpl><xBairro>JEANNE</xBairro><cMun>5108402</cMun><xMun>VARZEA GRANDE</xMun><UF>MT</UF><CEP>78132400</CEP><cPais>1058</cPais><xPais>BRASIL</xPais><fone>556536324500</fone></enderEmit><IM>34037</IM><CNAE>4731800</CNAE><CRT>3</CRT></emit>';
            $sut = Emitente::parseXmlString($fakeXmlString);
            expect($sut)->toBeInstanceOf(Result::class);
            expect($sut->isSuccess())->toBeFalsy();
            expect($sut->getError())->toBeInstanceOf(ValidationError::class);
        });
    });

    describe('::validateTagValue()', function () {
        test('Should be true if provided value is a empty string', function () {
            $fakeTagValue = '';
            $sut = Emitente::validateTagValue($fakeTagValue);
            expect($sut->isSuccess())->toBeTruthy();
        });

        test('Should be fail if a non empty string is provided', function () {
            $fakeTagValue = 'A';
            $sut = Emitente::validateTagValue($fakeTagValue);
            expect($sut->isSuccess())->toBeFalsy();
            expect($sut->getError())->toBeInstanceOf(ValidationError::class);
        });
    });
});
