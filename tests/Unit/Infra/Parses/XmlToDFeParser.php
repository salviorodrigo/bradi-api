<?php

declare(strict_types=1);

use BradiNfeApi\Infra\Parses\XmlToDFeParser;

/** Exempla xml string
 * <infNFe Id="NFe11250702393780000102550020008692371804601060" versao="4.00">
 * 	<det nItem="1">
 * 		<prod>
 * 			<xProd>OLEO DIESEL B S10</xProd>
 * 			<uCom>L</uCom>
 * 			<qCom>622.0000</qCom>
 * 			<vUnCom>6.13000000</vUnCom>
 * 			<vProd>3812.86</vProd>
 * 		</prod>
 * 	</det>
 * 	<det nItem="2">
 * 		<prod>
 * 			<xProd>ARLA 32 BALDE 20L</xProd>
 * 			<uCom>UN</uCom>
 * 			<qCom>2.0000</qCom>
 * 			<vUnCom>99.90000000</vUnCom>
 * 			<vProd>199.80</vProd>
 * 		</prod>
 * 	</det>
 * </infNFe>
 */
describe('XmlToDFeParser', function () {
    describe('.getTags()', function () {
        test('Should be return target tag on success, if exists just one tag', function () {
            $fakeXmlString = '<infNFe Id="NFe11250702393780000102550020008692371804601060" versao="4.00"><det nItem="1"><prod><xProd>OLEO DIESEL B S10</xProd><uCom>L</uCom><qCom>622.0000</qCom><vUnCom>6.13000000</vUnCom><vProd>3812.86</vProd></prod></det><det nItem="2"><prod><xProd>ARLA 32 BALDE 20L</xProd><uCom>UN</uCom><qCom>2.0000</qCom><vUnCom>99.90000000</vUnCom><vProd>199.80</vProd></prod></det></infNFe>';
            $sut = new XmlToDFeParser;

            expect($sut->getTags($fakeXmlString, 'infNFe'))
                ->toBeArray()
                ->toBe(['<infNFe Id="NFe11250702393780000102550020008692371804601060" versao="4.00"><det nItem="1"><prod><xProd>OLEO DIESEL B S10</xProd><uCom>L</uCom><qCom>622.0000</qCom><vUnCom>6.13000000</vUnCom><vProd>3812.86</vProd></prod></det><det nItem="2"><prod><xProd>ARLA 32 BALDE 20L</xProd><uCom>UN</uCom><qCom>2.0000</qCom><vUnCom>99.90000000</vUnCom><vProd>199.80</vProd></prod></det></infNFe>']);
        });

        test('Should be return target tag on success, if exists most than one tag', function () {
            $fakeXmlString = '<infNFe Id="NFe11250702393780000102550020008692371804601060" versao="4.00"><det nItem="1"><prod><xProd>OLEO DIESEL B S10</xProd><uCom>L</uCom><qCom>622.0000</qCom><vUnCom>6.13000000</vUnCom><vProd>3812.86</vProd></prod></det><det nItem="2"><prod><xProd>ARLA 32 BALDE 20L</xProd><uCom>UN</uCom><qCom>2.0000</qCom><vUnCom>99.90000000</vUnCom><vProd>199.80</vProd></prod></det></infNFe>';
            $sut = new XmlToDFeParser;

            expect($sut->getTags($fakeXmlString, 'det'))
                ->toBeArray()
                ->toBe([
                    '<det nItem="1"><prod><xProd>OLEO DIESEL B S10</xProd><uCom>L</uCom><qCom>622.0000</qCom><vUnCom>6.13000000</vUnCom><vProd>3812.86</vProd></prod></det>',
                    '<det nItem="2"><prod><xProd>ARLA 32 BALDE 20L</xProd><uCom>UN</uCom><qCom>2.0000</qCom><vUnCom>99.90000000</vUnCom><vProd>199.80</vProd></prod></det>',
                ]);
        });
    });

    describe('.getTag()', function () {
        test('Should be return target tag on success', function () {
            $fakeXmlString = '<infNFe Id="NFe11250702393780000102550020008692371804601060" versao="4.00"><det nItem="1"><prod><xProd>OLEO DIESEL B S10</xProd><uCom>L</uCom><qCom>622.0000</qCom><vUnCom>6.13000000</vUnCom><vProd>3812.86</vProd></prod></det><det nItem="2"><prod><xProd>ARLA 32 BALDE 20L</xProd><uCom>UN</uCom><qCom>2.0000</qCom><vUnCom>99.90000000</vUnCom><vProd>199.80</vProd></prod></det></infNFe>';
            $sut = new XmlToDFeParser;

            expect($sut->getTag($fakeXmlString, 'infNFe'))
                ->toBeString()
                ->toBe('<infNFe Id="NFe11250702393780000102550020008692371804601060" versao="4.00"><det nItem="1"><prod><xProd>OLEO DIESEL B S10</xProd><uCom>L</uCom><qCom>622.0000</qCom><vUnCom>6.13000000</vUnCom><vProd>3812.86</vProd></prod></det><det nItem="2"><prod><xProd>ARLA 32 BALDE 20L</xProd><uCom>UN</uCom><qCom>2.0000</qCom><vUnCom>99.90000000</vUnCom><vProd>199.80</vProd></prod></det></infNFe>');
        });

        test('Should be return first occurrence of target tag on success', function () {
            $fakeXmlString = '<infNFe Id="NFe11250702393780000102550020008692371804601060" versao="4.00"><det nItem="1"><prod><xProd>OLEO DIESEL B S10</xProd><uCom>L</uCom><qCom>622.0000</qCom><vUnCom>6.13000000</vUnCom><vProd>3812.86</vProd></prod></det><det nItem="2"><prod><xProd>ARLA 32 BALDE 20L</xProd><uCom>UN</uCom><qCom>2.0000</qCom><vUnCom>99.90000000</vUnCom><vProd>199.80</vProd></prod></det></infNFe>';
            $sut = new XmlToDFeParser;

            expect($sut->getTag($fakeXmlString, 'det'))
                ->toBeString()
                ->toBe('<det nItem="1"><prod><xProd>OLEO DIESEL B S10</xProd><uCom>L</uCom><qCom>622.0000</qCom><vUnCom>6.13000000</vUnCom><vProd>3812.86</vProd></prod></det>');
        });
    });
});
