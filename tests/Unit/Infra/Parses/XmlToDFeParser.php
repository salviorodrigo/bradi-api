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

        test('Should be return all occurrences of target tag on success, if exists most than one tag', function () {
            $fakeXmlString = '<infNFe Id="NFe11250702393780000102550020008692371804601060" versao="4.00"><det nItem="1"><prod><xProd>OLEO DIESEL B S10</xProd><uCom>L</uCom><qCom>622.0000</qCom><vUnCom>6.13000000</vUnCom><vProd>3812.86</vProd></prod></det><det nItem="2"><prod><xProd>ARLA 32 BALDE 20L</xProd><uCom>UN</uCom><qCom>2.0000</qCom><vUnCom>99.90000000</vUnCom><vProd>199.80</vProd></prod></det></infNFe>';
            $sut = new XmlToDFeParser;

            expect($sut->getTags($fakeXmlString, 'det'))
                ->toBeArray()
                ->toBe([
                    '<det nItem="1"><prod><xProd>OLEO DIESEL B S10</xProd><uCom>L</uCom><qCom>622.0000</qCom><vUnCom>6.13000000</vUnCom><vProd>3812.86</vProd></prod></det>',
                    '<det nItem="2"><prod><xProd>ARLA 32 BALDE 20L</xProd><uCom>UN</uCom><qCom>2.0000</qCom><vUnCom>99.90000000</vUnCom><vProd>199.80</vProd></prod></det>',
                ]);
        });

        test('Should be return an empty array if tag doesn\'t exists', function () {
            $fakeXmlString = '<infNFe Id="NFe11250702393780000102550020008692371804601060" versao="4.00"><det nItem="1"><prod><xProd>OLEO DIESEL B S10</xProd><uCom>L</uCom><qCom>622.0000</qCom><vUnCom>6.13000000</vUnCom><vProd>3812.86</vProd></prod></det><det nItem="2"><prod><xProd>ARLA 32 BALDE 20L</xProd><uCom>UN</uCom><qCom>2.0000</qCom><vUnCom>99.90000000</vUnCom><vProd>199.80</vProd></prod></det></infNFe>';
            $sut = new XmlToDFeParser;

            expect($sut->getTags($fakeXmlString, 'invalidTag'))
                ->toBeArray()
                ->toBe([]);
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

        test('Should be return first occurrence of target tag on success, if exist most than one occurrence', function () {
            $fakeXmlString = '<infNFe Id="NFe11250702393780000102550020008692371804601060" versao="4.00"><det nItem="1"><prod><xProd>OLEO DIESEL B S10</xProd><uCom>L</uCom><qCom>622.0000</qCom><vUnCom>6.13000000</vUnCom><vProd>3812.86</vProd></prod></det><det nItem="2"><prod><xProd>ARLA 32 BALDE 20L</xProd><uCom>UN</uCom><qCom>2.0000</qCom><vUnCom>99.90000000</vUnCom><vProd>199.80</vProd></prod></det></infNFe>';
            $sut = new XmlToDFeParser;

            expect($sut->getTag($fakeXmlString, 'det'))
                ->toBeString()
                ->toBe('<det nItem="1"><prod><xProd>OLEO DIESEL B S10</xProd><uCom>L</uCom><qCom>622.0000</qCom><vUnCom>6.13000000</vUnCom><vProd>3812.86</vProd></prod></det>');
        });

        test('Should be return an empty string if tag doesn\'t exists', function () {
            $fakeXmlString = '<infNFe Id="NFe11250702393780000102550020008692371804601060" versao="4.00"><det nItem="1"><prod><xProd>OLEO DIESEL B S10</xProd><uCom>L</uCom><qCom>622.0000</qCom><vUnCom>6.13000000</vUnCom><vProd>3812.86</vProd></prod></det><det nItem="2"><prod><xProd>ARLA 32 BALDE 20L</xProd><uCom>UN</uCom><qCom>2.0000</qCom><vUnCom>99.90000000</vUnCom><vProd>199.80</vProd></prod></det></infNFe>';
            $sut = new XmlToDFeParser;

            expect($sut->getTag($fakeXmlString, 'invalidTag'))
                ->toBeString()
                ->toBe('');
        });
    });

    describe('.getTagValue()', function () {
        test('Should be return value of target tag is target isn\'t xml element', function () {
            $fakeXmlString = '<xProd>OLEO DIESEL B S10</xProd>';
            $sut = new XmlToDFeParser;

            expect($sut->getTagValue($fakeXmlString, 'xProd'))
                ->toBeString()
                ->toBe('OLEO DIESEL B S10');
        });

        test('Should be return empty string of target tag is a xlm element', function () {
            $fakeXmlString = '<prod><xProd>OLEO DIESEL B S10</xProd><uCom>L</uCom><qCom>622.0000</qCom><vUnCom>6.13000000</vUnCom><vProd>3812.86</vProd></prod>';
            $sut = new XmlToDFeParser;

            expect($sut->getTagValue($fakeXmlString, 'prod'))
                ->toBeString()
                ->toBe('');
        });

        test('Should be return an empty string if xml tag doesn\'t exists', function () {
            $fakeXmlString = '<xProd>OLEO DIESEL B S10</xProd>';
            $sut = new XmlToDFeParser;

            expect($sut->getTagValue($fakeXmlString, 'uCom'))
                ->toBeString()
                ->toBe('');
        });
    });

    describe('.getTagAttributes()', function () {
        test('Should be return array with tag attributes, when they\'re available', function () {
            $fakeXmlString = '<infNFe Id="NFe11250702393780000102550020008692371804601060" versao="4.00"><det nItem="1"><prod><xProd>OLEO DIESEL B S10</xProd><uCom>L</uCom><qCom>622.0000</qCom><vUnCom>6.13000000</vUnCom><vProd>3812.86</vProd></prod></det><det nItem="2"><prod><xProd>ARLA 32 BALDE 20L</xProd><uCom>UN</uCom><qCom>2.0000</qCom><vUnCom>99.90000000</vUnCom><vProd>199.80</vProd></prod></det></infNFe>';
            $sut = new XmlToDFeParser;

            expect($sut->getTagAttributes($fakeXmlString, 'infNFe'))
                ->toBeArray()
                ->toBe([
                    'Id' => 'NFe11250702393780000102550020008692371804601060',
                    'versao' => '4.00',
                ]);
        });
    });
});
