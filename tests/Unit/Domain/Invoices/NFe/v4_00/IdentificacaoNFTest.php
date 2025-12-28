<?php

declare(strict_types=1);

use BradiNfeApi\Common\Exceptions\ValidationError;
use BradiNfeApi\Common\Result;
use BradiNfeApi\Domain\Invoices\NFe\v4_00\IdentificacaoNF;

/** Xml string example
 *
 * <infNFe Id="NFe11251102393780000293550030005188581546834922" versao="4.00">
 *  <ide>
 *   <cUF>11</cUF>
 *   <cNF>54683492</cNF>
 *   <natOp>VENDA DE MERCADORIA</natOp>
 *   <mod>55</mod>
 *   <serie>3</serie>
 *   <nNF>518858</nNF>
 *   <dhEmi>2025-11-14T07:45:00-04:00</dhEmi>
 *   <dhSaiEnt>2025-11-14T07:45:00-04:00</dhSaiEnt>
 *   <tpNF>1</tpNF>
 *   <idDest>1</idDest>
 *   <cMunFG>1100205</cMunFG>
 *   <tpImp>1</tpImp>
 *   <tpEmis>1</tpEmis>
 *   <cDV>2</cDV>
 *   <tpAmb>1</tpAmb>
 *   <finNFe>1</finNFe>
 *   <indFinal>1</indFinal>
 *   <indPres>1</indPres>
 *   <procEmi>0</procEmi>
 *   <verProc>12.1.2310</verProc>
 * </ide>
 * </infNFe>
 */
describe('IdentificacaoNF', function () {
    describe('::parseXmlString()', function () {
        test('Should be succeed when a valid xml string is provided', function () {
            $fakeXmlString = '<infNFe Id="NFe11251102393780000293550030005188581546834922" versao="4.00"><ide><cUF>11</cUF><cNF>54683492</cNF><natOp>VENDA DE COMBUSTIVEL/ VENDA DE MERC. ADQ./ VENDA LUBRIFICANT</natOp><mod>55</mod><serie>3</serie><nNF>518858</nNF><dhEmi>2025-11-14T07:45:00-04:00</dhEmi><dhSaiEnt>2025-11-14T07:45:00-04:00</dhSaiEnt><tpNF>1</tpNF><idDest>1</idDest><cMunFG>1100205</cMunFG><tpImp>1</tpImp><tpEmis>1</tpEmis><cDV>2</cDV><tpAmb>1</tpAmb><finNFe>1</finNFe><indFinal>1</indFinal><indPres>1</indPres><procEmi>0</procEmi><verProc>12.1.2310</verProc></ide></infNFe>';
            $sut = IdentificacaoNF::parseXmlString($fakeXmlString);
            expect($sut)->toBeInstanceOf(Result::class);
            expect($sut->isSuccess())->toBeTruthy();
            expect($sut->getData())->toBeInstanceOf(IdentificacaoNF::class);
            expect($sut->getData()->value)->toBeString();
            expect($sut->getData()->value)->toBe('');
            expect($sut->getData()->xmlString)->toBeString();
            expect($sut->getData()->xmlString)->toBe('<ide><cUF>11</cUF><cNF>54683492</cNF><natOp>VENDA DE COMBUSTIVEL/ VENDA DE MERC. ADQ./ VENDA LUBRIFICANT</natOp><mod>55</mod><serie>3</serie><nNF>518858</nNF><dhEmi>2025-11-14T07:45:00-04:00</dhEmi><dhSaiEnt>2025-11-14T07:45:00-04:00</dhSaiEnt><tpNF>1</tpNF><idDest>1</idDest><cMunFG>1100205</cMunFG><tpImp>1</tpImp><tpEmis>1</tpEmis><cDV>2</cDV><tpAmb>1</tpAmb><finNFe>1</finNFe><indFinal>1</indFinal><indPres>1</indPres><procEmi>0</procEmi><verProc>12.1.2310</verProc></ide>');
        });

        test('Should be fail if cUF tag  isn\'t provided', function () {
            $fakeXmlString = '<infNFe Id="NFe11251102393780000293550030005188581546834922" versao="4.00"><ide><cNF>54683492</cNF><natOp>VENDA DE COMBUSTIVEL/ VENDA DE MERC. ADQ./ VENDA LUBRIFICANT</natOp><mod>55</mod><serie>3</serie><nNF>518858</nNF><dhEmi>2025-11-14T07:45:00-04:00</dhEmi><dhSaiEnt>2025-11-14T07:45:00-04:00</dhSaiEnt><tpNF>1</tpNF><idDest>1</idDest><cMunFG>1100205</cMunFG><tpImp>1</tpImp><tpEmis>1</tpEmis><cDV>2</cDV><tpAmb>1</tpAmb><finNFe>1</finNFe><indFinal>1</indFinal><indPres>1</indPres><procEmi>0</procEmi><verProc>12.1.2310</verProc></ide></infNFe>';
            $sut = IdentificacaoNF::parseXmlString($fakeXmlString);
            expect($sut)->toBeInstanceOf(Result::class);
            expect($sut->isSuccess())->toBeFalsy();
            expect($sut->getError())->toBeInstanceOf(ValidationError::class);
        });

        test('Should be fail if cNF tag  isn\'t provided', function () {
            $fakeXmlString = '<infNFe Id="NFe11251102393780000293550030005188581546834922" versao="4.00"><ide><cUF>11</cUF><natOp>VENDA DE COMBUSTIVEL/ VENDA DE MERC. ADQ./ VENDA LUBRIFICANT</natOp><mod>55</mod><serie>3</serie><nNF>518858</nNF><dhEmi>2025-11-14T07:45:00-04:00</dhEmi><dhSaiEnt>2025-11-14T07:45:00-04:00</dhSaiEnt><tpNF>1</tpNF><idDest>1</idDest><cMunFG>1100205</cMunFG><tpImp>1</tpImp><tpEmis>1</tpEmis><cDV>2</cDV><tpAmb>1</tpAmb><finNFe>1</finNFe><indFinal>1</indFinal><indPres>1</indPres><procEmi>0</procEmi><verProc>12.1.2310</verProc></ide></infNFe>';
            $sut = IdentificacaoNF::parseXmlString($fakeXmlString);
            expect($sut)->toBeInstanceOf(Result::class);
            expect($sut->isSuccess())->toBeFalsy();
            expect($sut->getError())->toBeInstanceOf(ValidationError::class);
        });

        test('Should be fail if natOp tag  isn\'t provided', function () {
            $fakeXmlString = '<infNFe Id="NFe11251102393780000293550030005188581546834922" versao="4.00"><ide><cUF>11</cUF><cNF>54683492</cNF><mod>55</mod><serie>3</serie><nNF>518858</nNF><dhEmi>2025-11-14T07:45:00-04:00</dhEmi><dhSaiEnt>2025-11-14T07:45:00-04:00</dhSaiEnt><tpNF>1</tpNF><idDest>1</idDest><cMunFG>1100205</cMunFG><tpImp>1</tpImp><tpEmis>1</tpEmis><cDV>2</cDV><tpAmb>1</tpAmb><finNFe>1</finNFe><indFinal>1</indFinal><indPres>1</indPres><procEmi>0</procEmi><verProc>12.1.2310</verProc></ide></infNFe>';
            $sut = IdentificacaoNF::parseXmlString($fakeXmlString);
            expect($sut)->toBeInstanceOf(Result::class);
            expect($sut->isSuccess())->toBeFalsy();
            expect($sut->getError())->toBeInstanceOf(ValidationError::class);
        });

        test('Should be fail if mod tag  isn\'t provided', function () {
            $fakeXmlString = '<infNFe Id="NFe11251102393780000293550030005188581546834922" versao="4.00"><ide><cUF>11</cUF><cNF>54683492</cNF><natOp>VENDA DE COMBUSTIVEL/ VENDA DE MERC. ADQ./ VENDA LUBRIFICANT</natOp><serie>3</serie><nNF>518858</nNF><dhEmi>2025-11-14T07:45:00-04:00</dhEmi><dhSaiEnt>2025-11-14T07:45:00-04:00</dhSaiEnt><tpNF>1</tpNF><idDest>1</idDest><cMunFG>1100205</cMunFG><tpImp>1</tpImp><tpEmis>1</tpEmis><cDV>2</cDV><tpAmb>1</tpAmb><finNFe>1</finNFe><indFinal>1</indFinal><indPres>1</indPres><procEmi>0</procEmi><verProc>12.1.2310</verProc></ide></infNFe>';
            $sut = IdentificacaoNF::parseXmlString($fakeXmlString);
            expect($sut)->toBeInstanceOf(Result::class);
            expect($sut->isSuccess())->toBeFalsy();
            expect($sut->getError())->toBeInstanceOf(ValidationError::class);
        });

        test('Should be fail if serie tag  isn\'t provided', function () {
            $fakeXmlString = '<infNFe Id="NFe11251102393780000293550030005188581546834922" versao="4.00"><ide><cUF>11</cUF><cNF>54683492</cNF><natOp>VENDA DE COMBUSTIVEL/ VENDA DE MERC. ADQ./ VENDA LUBRIFICANT</natOp><mod>55</mod><nNF>518858</nNF><dhEmi>2025-11-14T07:45:00-04:00</dhEmi><dhSaiEnt>2025-11-14T07:45:00-04:00</dhSaiEnt><tpNF>1</tpNF><idDest>1</idDest><cMunFG>1100205</cMunFG><tpImp>1</tpImp><tpEmis>1</tpEmis><cDV>2</cDV><tpAmb>1</tpAmb><finNFe>1</finNFe><indFinal>1</indFinal><indPres>1</indPres><procEmi>0</procEmi><verProc>12.1.2310</verProc></ide></infNFe>';
            $sut = IdentificacaoNF::parseXmlString($fakeXmlString);
            expect($sut)->toBeInstanceOf(Result::class);
            expect($sut->isSuccess())->toBeFalsy();
            expect($sut->getError())->toBeInstanceOf(ValidationError::class);
        });

        test('Should be fail if nNF tag  isn\'t provided', function () {
            $fakeXmlString = '<infNFe Id="NFe11251102393780000293550030005188581546834922" versao="4.00"><ide><cUF>11</cUF><cNF>54683492</cNF><natOp>VENDA DE COMBUSTIVEL/ VENDA DE MERC. ADQ./ VENDA LUBRIFICANT</natOp><mod>55</mod><serie>3</serie><dhEmi>2025-11-14T07:45:00-04:00</dhEmi><dhSaiEnt>2025-11-14T07:45:00-04:00</dhSaiEnt><tpNF>1</tpNF><idDest>1</idDest><cMunFG>1100205</cMunFG><tpImp>1</tpImp><tpEmis>1</tpEmis><cDV>2</cDV><tpAmb>1</tpAmb><finNFe>1</finNFe><indFinal>1</indFinal><indPres>1</indPres><procEmi>0</procEmi><verProc>12.1.2310</verProc></ide></infNFe>';
            $sut = IdentificacaoNF::parseXmlString($fakeXmlString);
            expect($sut)->toBeInstanceOf(Result::class);
            expect($sut->isSuccess())->toBeFalsy();
            expect($sut->getError())->toBeInstanceOf(ValidationError::class);
        });

        test('Should be fail if dhEmi tag  isn\'t provided', function () {
            $fakeXmlString = '<infNFe Id="NFe11251102393780000293550030005188581546834922" versao="4.00"><ide><cUF>11</cUF><cNF>54683492</cNF><natOp>VENDA DE COMBUSTIVEL/ VENDA DE MERC. ADQ./ VENDA LUBRIFICANT</natOp><mod>55</mod><serie>3</serie><nNF>518858</nNF><dhSaiEnt>2025-11-14T07:45:00-04:00</dhSaiEnt><tpNF>1</tpNF><idDest>1</idDest><cMunFG>1100205</cMunFG><tpImp>1</tpImp><tpEmis>1</tpEmis><cDV>2</cDV><tpAmb>1</tpAmb><finNFe>1</finNFe><indFinal>1</indFinal><indPres>1</indPres><procEmi>0</procEmi><verProc>12.1.2310</verProc></ide></infNFe>';
            $sut = IdentificacaoNF::parseXmlString($fakeXmlString);
            expect($sut)->toBeInstanceOf(Result::class);
            expect($sut->isSuccess())->toBeFalsy();
            expect($sut->getError())->toBeInstanceOf(ValidationError::class);
        });

        test('Should be fail if mod tag was 55 and dhSaiEnt tag isn\'t provided', function () {
            $fakeXmlString = '<infNFe Id="NFe11251102393780000293550030005188581546834922" versao="4.00"><ide><cUF>11</cUF><cNF>54683492</cNF><natOp>VENDA DE COMBUSTIVEL/ VENDA DE MERC. ADQ./ VENDA LUBRIFICANT</natOp><mod>55</mod><serie>3</serie><nNF>518858</nNF><dhEmi>2025-11-14T07:45:00-04:00</dhEmi><tpNF>1</tpNF><idDest>1</idDest><cMunFG>1100205</cMunFG><tpImp>1</tpImp><tpEmis>1</tpEmis><cDV>2</cDV><tpAmb>1</tpAmb><finNFe>1</finNFe><indFinal>1</indFinal><indPres>1</indPres><procEmi>0</procEmi><verProc>12.1.2310</verProc></ide></infNFe>';
            $sut = IdentificacaoNF::parseXmlString($fakeXmlString);
            expect($sut)->toBeInstanceOf(Result::class);
            expect($sut->isSuccess())->toBeFalsy();
            expect($sut->getError())->toBeInstanceOf(ValidationError::class);
        });

        test('Should be fail if tpNF tag  isn\'t provided', function () {
            $fakeXmlString = '<infNFe Id="NFe11251102393780000293550030005188581546834922" versao="4.00"><ide><cUF>11</cUF><cNF>54683492</cNF><natOp>VENDA DE COMBUSTIVEL/ VENDA DE MERC. ADQ./ VENDA LUBRIFICANT</natOp><mod>55</mod><serie>3</serie><nNF>518858</nNF><dhEmi>2025-11-14T07:45:00-04:00</dhEmi><dhSaiEnt>2025-11-14T07:45:00-04:00</dhSaiEnt><idDest>1</idDest><cMunFG>1100205</cMunFG><tpImp>1</tpImp><tpEmis>1</tpEmis><cDV>2</cDV><tpAmb>1</tpAmb><finNFe>1</finNFe><indFinal>1</indFinal><indPres>1</indPres><procEmi>0</procEmi><verProc>12.1.2310</verProc></ide></infNFe>';
            $sut = IdentificacaoNF::parseXmlString($fakeXmlString);
            expect($sut)->toBeInstanceOf(Result::class);
            expect($sut->isSuccess())->toBeFalsy();
            expect($sut->getError())->toBeInstanceOf(ValidationError::class);
        });

        test('Should be fail if idDest tag  isn\'t provided', function () {
            $fakeXmlString = '<infNFe Id="NFe11251102393780000293550030005188581546834922" versao="4.00"><ide><cUF>11</cUF><cNF>54683492</cNF><natOp>VENDA DE COMBUSTIVEL/ VENDA DE MERC. ADQ./ VENDA LUBRIFICANT</natOp><mod>55</mod><serie>3</serie><nNF>518858</nNF><dhEmi>2025-11-14T07:45:00-04:00</dhEmi><dhSaiEnt>2025-11-14T07:45:00-04:00</dhSaiEnt><tpNF>1</tpNF><cMunFG>1100205</cMunFG><tpImp>1</tpImp><tpEmis>1</tpEmis><cDV>2</cDV><tpAmb>1</tpAmb><finNFe>1</finNFe><indFinal>1</indFinal><indPres>1</indPres><procEmi>0</procEmi><verProc>12.1.2310</verProc></ide></infNFe>';
            $sut = IdentificacaoNF::parseXmlString($fakeXmlString);
            expect($sut)->toBeInstanceOf(Result::class);
            expect($sut->isSuccess())->toBeFalsy();
            expect($sut->getError())->toBeInstanceOf(ValidationError::class);
        });

        test('Should be fail if cMunFG tag  isn\'t provided', function () {
            $fakeXmlString = '<infNFe Id="NFe11251102393780000293550030005188581546834922" versao="4.00"><ide><cUF>11</cUF><cNF>54683492</cNF><natOp>VENDA DE COMBUSTIVEL/ VENDA DE MERC. ADQ./ VENDA LUBRIFICANT</natOp><mod>55</mod><serie>3</serie><nNF>518858</nNF><dhEmi>2025-11-14T07:45:00-04:00</dhEmi><dhSaiEnt>2025-11-14T07:45:00-04:00</dhSaiEnt><tpNF>1</tpNF><idDest>1</idDest><tpImp>1</tpImp><tpEmis>1</tpEmis><cDV>2</cDV><tpAmb>1</tpAmb><finNFe>1</finNFe><indFinal>1</indFinal><indPres>1</indPres><procEmi>0</procEmi><verProc>12.1.2310</verProc></ide></infNFe>';
            $sut = IdentificacaoNF::parseXmlString($fakeXmlString);
            expect($sut)->toBeInstanceOf(Result::class);
            expect($sut->isSuccess())->toBeFalsy();
            expect($sut->getError())->toBeInstanceOf(ValidationError::class);
        });

        test('Should be fail if tpImp tag  isn\'t provided', function () {
            $fakeXmlString = '<infNFe Id="NFe11251102393780000293550030005188581546834922" versao="4.00"><ide><cUF>11</cUF><cNF>54683492</cNF><natOp>VENDA DE COMBUSTIVEL/ VENDA DE MERC. ADQ./ VENDA LUBRIFICANT</natOp><mod>55</mod><serie>3</serie><nNF>518858</nNF><dhEmi>2025-11-14T07:45:00-04:00</dhEmi><dhSaiEnt>2025-11-14T07:45:00-04:00</dhSaiEnt><tpNF>1</tpNF><idDest>1</idDest><cMunFG>1100205</cMunFG><tpEmis>1</tpEmis><cDV>2</cDV><tpAmb>1</tpAmb><finNFe>1</finNFe><indFinal>1</indFinal><indPres>1</indPres><procEmi>0</procEmi><verProc>12.1.2310</verProc></ide></infNFe>';
            $sut = IdentificacaoNF::parseXmlString($fakeXmlString);
            expect($sut)->toBeInstanceOf(Result::class);
            expect($sut->isSuccess())->toBeFalsy();
            expect($sut->getError())->toBeInstanceOf(ValidationError::class);
        });

        test('Should be fail if tpEmis tag  isn\'t provided', function () {
            $fakeXmlString = '<infNFe Id="NFe11251102393780000293550030005188581546834922" versao="4.00"><ide><cUF>11</cUF><cNF>54683492</cNF><natOp>VENDA DE COMBUSTIVEL/ VENDA DE MERC. ADQ./ VENDA LUBRIFICANT</natOp><mod>55</mod><serie>3</serie><nNF>518858</nNF><dhEmi>2025-11-14T07:45:00-04:00</dhEmi><dhSaiEnt>2025-11-14T07:45:00-04:00</dhSaiEnt><tpNF>1</tpNF><idDest>1</idDest><cMunFG>1100205</cMunFG><tpImp>1</tpImp><cDV>2</cDV><tpAmb>1</tpAmb><finNFe>1</finNFe><indFinal>1</indFinal><indPres>1</indPres><procEmi>0</procEmi><verProc>12.1.2310</verProc></ide></infNFe>';
            $sut = IdentificacaoNF::parseXmlString($fakeXmlString);
            expect($sut)->toBeInstanceOf(Result::class);
            expect($sut->isSuccess())->toBeFalsy();
            expect($sut->getError())->toBeInstanceOf(ValidationError::class);
        });

        test('Should be fail if cDV tag  isn\'t provided', function () {
            $fakeXmlString = '<infNFe Id="NFe11251102393780000293550030005188581546834922" versao="4.00"><ide><cUF>11</cUF><cNF>54683492</cNF><natOp>VENDA DE COMBUSTIVEL/ VENDA DE MERC. ADQ./ VENDA LUBRIFICANT</natOp><mod>55</mod><serie>3</serie><nNF>518858</nNF><dhEmi>2025-11-14T07:45:00-04:00</dhEmi><dhSaiEnt>2025-11-14T07:45:00-04:00</dhSaiEnt><tpNF>1</tpNF><idDest>1</idDest><cMunFG>1100205</cMunFG><tpImp>1</tpImp><tpEmis>1</tpEmis><tpAmb>1</tpAmb><finNFe>1</finNFe><indFinal>1</indFinal><indPres>1</indPres><procEmi>0</procEmi><verProc>12.1.2310</verProc></ide></infNFe>';
            $sut = IdentificacaoNF::parseXmlString($fakeXmlString);
            expect($sut)->toBeInstanceOf(Result::class);
            expect($sut->isSuccess())->toBeFalsy();
            expect($sut->getError())->toBeInstanceOf(ValidationError::class);
        });

        test('Should be fail if tpAmb tag  isn\'t provided', function () {
            $fakeXmlString = '<infNFe Id="NFe11251102393780000293550030005188581546834922" versao="4.00"><ide><cUF>11</cUF><cNF>54683492</cNF><natOp>VENDA DE COMBUSTIVEL/ VENDA DE MERC. ADQ./ VENDA LUBRIFICANT</natOp><mod>55</mod><serie>3</serie><nNF>518858</nNF><dhEmi>2025-11-14T07:45:00-04:00</dhEmi><dhSaiEnt>2025-11-14T07:45:00-04:00</dhSaiEnt><tpNF>1</tpNF><idDest>1</idDest><cMunFG>1100205</cMunFG><tpImp>1</tpImp><tpEmis>1</tpEmis><cDV>2</cDV><finNFe>1</finNFe><indFinal>1</indFinal><indPres>1</indPres><procEmi>0</procEmi><verProc>12.1.2310</verProc></ide></infNFe>';
            $sut = IdentificacaoNF::parseXmlString($fakeXmlString);
            expect($sut)->toBeInstanceOf(Result::class);
            expect($sut->isSuccess())->toBeFalsy();
            expect($sut->getError())->toBeInstanceOf(ValidationError::class);
        });

        test('Should be fail if finNFe tag  isn\'t provided', function () {
            $fakeXmlString = '<infNFe Id="NFe11251102393780000293550030005188581546834922" versao="4.00"><ide><cUF>11</cUF><cNF>54683492</cNF><natOp>VENDA DE COMBUSTIVEL/ VENDA DE MERC. ADQ./ VENDA LUBRIFICANT</natOp><mod>55</mod><serie>3</serie><nNF>518858</nNF><dhEmi>2025-11-14T07:45:00-04:00</dhEmi><dhSaiEnt>2025-11-14T07:45:00-04:00</dhSaiEnt><tpNF>1</tpNF><idDest>1</idDest><cMunFG>1100205</cMunFG><tpImp>1</tpImp><tpEmis>1</tpEmis><cDV>2</cDV><tpAmb>1</tpAmb><indFinal>1</indFinal><indPres>1</indPres><procEmi>0</procEmi><verProc>12.1.2310</verProc></ide></infNFe>';
            $sut = IdentificacaoNF::parseXmlString($fakeXmlString);
            expect($sut)->toBeInstanceOf(Result::class);
            expect($sut->isSuccess())->toBeFalsy();
            expect($sut->getError())->toBeInstanceOf(ValidationError::class);
        });

        test('Should be fail if indFinal tag  isn\'t provided', function () {
            $fakeXmlString = '<infNFe Id="NFe11251102393780000293550030005188581546834922" versao="4.00"><ide><cUF>11</cUF><cNF>54683492</cNF><natOp>VENDA DE COMBUSTIVEL/ VENDA DE MERC. ADQ./ VENDA LUBRIFICANT</natOp><mod>55</mod><serie>3</serie><nNF>518858</nNF><dhEmi>2025-11-14T07:45:00-04:00</dhEmi><dhSaiEnt>2025-11-14T07:45:00-04:00</dhSaiEnt><tpNF>1</tpNF><idDest>1</idDest><cMunFG>1100205</cMunFG><tpImp>1</tpImp><tpEmis>1</tpEmis><cDV>2</cDV><tpAmb>1</tpAmb><finNFe>1</finNFe><indPres>1</indPres><procEmi>0</procEmi><verProc>12.1.2310</verProc></ide></infNFe>';
            $sut = IdentificacaoNF::parseXmlString($fakeXmlString);
            expect($sut)->toBeInstanceOf(Result::class);
            expect($sut->isSuccess())->toBeFalsy();
            expect($sut->getError())->toBeInstanceOf(ValidationError::class);
        });

        test('Should be fail if indPres tag  isn\'t provided', function () {
            $fakeXmlString = '<infNFe Id="NFe11251102393780000293550030005188581546834922" versao="4.00"><ide><cUF>11</cUF><cNF>54683492</cNF><natOp>VENDA DE COMBUSTIVEL/ VENDA DE MERC. ADQ./ VENDA LUBRIFICANT</natOp><mod>55</mod><serie>3</serie><nNF>518858</nNF><dhEmi>2025-11-14T07:45:00-04:00</dhEmi><dhSaiEnt>2025-11-14T07:45:00-04:00</dhSaiEnt><tpNF>1</tpNF><idDest>1</idDest><cMunFG>1100205</cMunFG><tpImp>1</tpImp><tpEmis>1</tpEmis><cDV>2</cDV><tpAmb>1</tpAmb><finNFe>1</finNFe><indFinal>1</indFinal><procEmi>0</procEmi><verProc>12.1.2310</verProc></ide></infNFe>';
            $sut = IdentificacaoNF::parseXmlString($fakeXmlString);
            expect($sut)->toBeInstanceOf(Result::class);
            expect($sut->isSuccess())->toBeFalsy();
            expect($sut->getError())->toBeInstanceOf(ValidationError::class);
        });

        test('Should be fail if procEmi tag  isn\'t provided', function () {
            $fakeXmlString = '<infNFe Id="NFe11251102393780000293550030005188581546834922" versao="4.00"><ide><cUF>11</cUF><cNF>54683492</cNF><natOp>VENDA DE COMBUSTIVEL/ VENDA DE MERC. ADQ./ VENDA LUBRIFICANT</natOp><mod>55</mod><serie>3</serie><nNF>518858</nNF><dhEmi>2025-11-14T07:45:00-04:00</dhEmi><dhSaiEnt>2025-11-14T07:45:00-04:00</dhSaiEnt><tpNF>1</tpNF><idDest>1</idDest><cMunFG>1100205</cMunFG><tpImp>1</tpImp><tpEmis>1</tpEmis><cDV>2</cDV><tpAmb>1</tpAmb><finNFe>1</finNFe><indFinal>1</indFinal><indPres>1</indPres><verProc>12.1.2310</verProc></ide></infNFe>';
            $sut = IdentificacaoNF::parseXmlString($fakeXmlString);
            expect($sut)->toBeInstanceOf(Result::class);
            expect($sut->isSuccess())->toBeFalsy();
            expect($sut->getError())->toBeInstanceOf(ValidationError::class);
        });
    });
});
