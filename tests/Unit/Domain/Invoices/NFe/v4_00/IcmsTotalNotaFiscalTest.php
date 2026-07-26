<?php

declare(strict_types=1);

use BradiApi\Domain\Common\Protocols\ApiError;
use BradiApi\Domain\Invoices\NFe\v4_00\IcmsTotalNotaFiscal;
use BradiApi\Domain\Invoices\Templates\DFeElement;
use BradiApi\Domain\Xml\ValueObjects\Element;

describe('IcmsTotalNotaFiscal', function () {
    test('Should succeed if IcmsTotalNotaFiscal is declared', function () {
        $nameSpace = 'BradiApi\Domain\Invoices\NFe\v4_00';
        $sut = $nameSpace . '\\IcmsTotalNotaFiscal';
        expect(class_exists($sut))->toBeTrue();
    });

    test('Should succeed if IcmsTotalNotaFiscal extends DFeElement', function () {
        $sut = new IcmsTotalNotaFiscal;
        expect(is_subclass_of($sut, DFeElement::class))->toBeTrue();
    });

    describe('properties', function () {})->skip();

    describe('methods', function () {
        describe('validateTagAttributes', function () {
            test('Should fail if an attribute is provided', function () {
                $xmlString = '<total attribute="value"/>';
                $xmlElement = new Element;
                $xmlElement->parse($xmlString);
                $targetClass = new IcmsTotalNotaFiscal;
                $sut = new ReflectionMethod($targetClass, 'validateTagAttributes');
                $sutResponse = $sut->invoke($targetClass, $xmlElement);
                expect($sutResponse->isFailure())->toBeTrue();
            });
        });

        describe('validateTagElements', function () {
            test('Should succeed if all required tags are provided', function () {
                $xmlString = '<ICMSTot><vBC/><vICMS/><vICMSDeson/><vFCP/><vBCST/><vST/><vFCPST/><vFCPSTRet/><vProd/><vFrete/><vSeg/><vDesc/><vII/><vIPI/><vIPIDevol/><vPIS/><vCOFINS/><vOutro/><vNF/></ICMSTot>';
                $xmlElement = new Element;
                $xmlElement->parse($xmlString);
                $targetClass = new IcmsTotalNotaFiscal;
                $sut = new ReflectionMethod($targetClass, 'validateTagElements');
                $sutResponse = $sut->invoke($targetClass, $xmlElement);
                expect($sutResponse->isSuccess())->toBeTrue();
            });

            test('Should succeed if all tags is provided', function () {
                $xmlString = '<ICMSTot><vBC/><vICMS/><vICMSDeson/><vFCPUFDest/><vICMSUFDest/><vICMSUFRemet/><vFCP/><vBCST/><vST/><vFCPST/><vFCPSTRet/><vProd/><vFrete/><vSeg/><vDesc/><vII/><vIPI/><vIPIDevol/><vPIS/><vCOFINS/><vOutro/><vNF/><vTotTrib/></ICMSTot>';
                $xmlElement = new Element;
                $xmlElement->parse($xmlString);
                $targetClass = new IcmsTotalNotaFiscal;
                $sut = new ReflectionMethod($targetClass, 'validateTagElements');
                $sutResponse = $sut->invoke($targetClass, $xmlElement);
                expect($sutResponse->isSuccess())->toBeTrue();
            });

            test('Should fail if an unallowed tag is provided', function () {
                $xmlString = '<ICMSTot><unallowedTag/><ICMSTot/><ISSQNtot/><retTrib/></ICMSTot>';
                $xmlElement = new Element;
                $xmlElement->parse($xmlString);
                $targetClass = new IcmsTotalNotaFiscal;
                $sut = new ReflectionMethod($targetClass, 'validateTagElements');
                $sutResponse = $sut->invoke($targetClass, $xmlElement);
                expect($sutResponse->isFailure())->toBeTrue();
            })->skip();
        });

        describe('validateTagValue', function () {
            test('Should fail if a value is provided', function () {
                $xmlString = '<ICMSTot>value</ICMSTot>';
                $xmlElement = new Element;
                $xmlElement->parse($xmlString);
                $targetClass = new IcmsTotalNotaFiscal;
                $sut = new ReflectionMethod($targetClass, 'validateTagValue');
                $sutResponse = $sut->invoke($targetClass, $xmlElement);
                expect($sutResponse->isFailure())->toBeTrue();
                expect($sutResponse->getError())->toBeInstanceOf(ApiError::class);
            });
        });
    });
});
