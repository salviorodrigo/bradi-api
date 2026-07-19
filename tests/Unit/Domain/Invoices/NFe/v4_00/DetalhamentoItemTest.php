<?php

declare(strict_types=1);

use BradiApi\Domain\Invoices\NFe\v4_00\DetalhamentoItem;
use BradiApi\Domain\Invoices\Templates\DFeAttribute;
use BradiApi\Domain\Invoices\Templates\DFeElement;
use BradiApi\Domain\Xml\ValueObjects\Element;

describe('DetalhamentoItem', function () {
    test('Should succeed if detalhamentoItem$detalhamentoItem is declared', function () {
        $nameSpace = 'BradiApi\Domain\Invoices\NFe\v4_00';
        $sut = $nameSpace . '\\DetalhamentoItem';
        expect(class_exists($sut))->toBeTrue();
    });

    test('Should succeed if DetalhamentoItem extends DFeElement', function () {
        $sut = new DetalhamentoItem;
        expect(is_subclass_of($sut, DFeElement::class))->toBeTrue();
    });

    describe('properties', function () {
        describe('$nItem', function () {
            test('Should be declared', function () {
                $sut = new DetalhamentoItem;
                expect($sut)->toHaveProperty('nItem');
            });

            test('Should be a subclass of DFeAttribute::class', function () {
                $reflection = new ReflectionClass(DetalhamentoItem::class);
                $reflectedProperty = $reflection->getProperty('nItem');
                $sut = $reflectedProperty->getType();
                expect((is_subclass_of($sut->getName(), DFeAttribute::class)))->toBeTrue();
            });

            test('Should be required', function () {
                $reflection = new ReflectionClass(DetalhamentoItem::class);
                $reflectedProperty = $reflection->getProperty('nItem');
                $sut = $reflectedProperty->getType();
                expect($sut->allowsNull())->toBeFalse();
            });
        });

        describe('$infAdProd', function () {
            test('Should be declared', function () {
                $sut = new DetalhamentoItem;
                expect($sut)->toHaveProperty('infAdProd');
            });

            test('Should be a subclass of DFeAttribute::class', function () {
                $reflection = new ReflectionClass(DetalhamentoItem::class);
                $reflectedProperty = $reflection->getProperty('infAdProd');
                $sut = $reflectedProperty->getType();
                expect((is_subclass_of($sut->getName(), DFeAttribute::class)))->toBeTrue();
            });

            test('Should be optional', function () {
                $reflection = new ReflectionClass(DetalhamentoItem::class);
                $reflectedProperty = $reflection->getProperty('infAdProd');
                $sut = $reflectedProperty->getType();
                expect($sut->allowsNull())->toBeTrue();
            });
        })->skip();

        describe('$prod', function () {
            test('Should be declared', function () {
                $sut = new DetalhamentoItem;
                expect($sut)->toHaveProperty('prod');
            });

            test('Should be a subclass of DFeElement::class', function () {
                $reflection = new ReflectionClass(DetalhamentoItem::class);
                $reflectedProperty = $reflection->getProperty('prod');
                $sut = $reflectedProperty->getType();
                expect((is_subclass_of($sut->getName(), DFeElement::class)))->toBeTrue();
            });

            test('Should be required', function () {
                $reflection = new ReflectionClass(DetalhamentoItem::class);
                $reflectedProperty = $reflection->getProperty('prod');
                $sut = $reflectedProperty->getType();
                expect($sut->allowsNull())->toBeFalse();
            });
        });

        describe('$imposto', function () {
            test('Should be declared', function () {
                $sut = new DetalhamentoItem;
                expect($sut)->toHaveProperty('imposto');
            });

            test('Should be a subclass of DFeElement::class', function () {
                $reflection = new ReflectionClass(DetalhamentoItem::class);
                $reflectedProperty = $reflection->getProperty('imposto');
                $sut = $reflectedProperty->getType();
                expect((is_subclass_of($sut->getName(), DFeElement::class)))->toBeTrue();
            });

            test('Should be required', function () {
                $reflection = new ReflectionClass(DetalhamentoItem::class);
                $reflectedProperty = $reflection->getProperty('imposto');
                $sut = $reflectedProperty->getType();
                expect($sut->allowsNull())->toBeFalse();
            });
        });

        describe('$impostoDevol', function () {
            test('Should be declared', function () {
                $sut = new DetalhamentoItem;
                expect($sut)->toHaveProperty('impostoDevol');
            });

            test('Should be a subclass of DFeElement::class', function () {
                $reflection = new ReflectionClass(DetalhamentoItem::class);
                $reflectedProperty = $reflection->getProperty('impostoDevol');
                $sut = $reflectedProperty->getType();
                expect((is_subclass_of($sut->getName(), DFeElement::class)))->toBeTrue();
            });

            test('Should be optional', function () {
                $reflection = new ReflectionClass(DetalhamentoItem::class);
                $reflectedProperty = $reflection->getProperty('impostoDevol');
                $sut = $reflectedProperty->getType();
                expect($sut->allowsNull())->toBeTrue();
            });
        })->skip();
    });

    describe('methods', function () {
        describe('validateTagAttributes', function () {
            test('Should succeed if required attributes are provided', function () {
                $xmlString = '<det nItem="1"></det>';
                $xmlElement = new Element;
                $xmlElement->parse($xmlString);
                $detalhamentoItem = new DetalhamentoItem;
                $sut = new ReflectionMethod($detalhamentoItem, 'validateTagAttributes');
                $sutResponse = $sut->invoke($detalhamentoItem, $xmlElement);
                expect($sutResponse->isSuccess())->toBeTrue();
            });

            test('Should succeed if all attributes are provided', function () {
                $xmlString = '<det nItem="1" infAdProd="aValue"></det>';
                $xmlElement = new Element;
                $xmlElement->parse($xmlString);
                $detalhamentoItem = new DetalhamentoItem;
                $sut = new ReflectionMethod($detalhamentoItem, 'validateTagAttributes');
                $sutResponse = $sut->invoke($detalhamentoItem, $xmlElement);
                expect($sutResponse->isSuccess())->toBeTrue();
            });

            test('Should fail if nItem attribute isn\'t provided', function () {
                $xmlString = '<det infAdProd="aValue"></det>';
                $xmlElement = new Element;
                $xmlElement->parse($xmlString);
                $detalhamentoItem = new DetalhamentoItem;
                $sut = new ReflectionMethod($detalhamentoItem, 'validateTagAttributes');
                $sutResponse = $sut->invoke($detalhamentoItem, $xmlElement);
                expect($sutResponse->isFailure())->toBeTrue();
            });

            test('Should fail if an unallowed attribute is provided', function () {
                $xmlString = '<det nItem="1" infAdProd="aValue" unallowed="value"></det>';
                $xmlElement = new Element;
                $xmlElement->parse($xmlString);
                $detalhamentoItem = new DetalhamentoItem;
                $sut = new ReflectionMethod($detalhamentoItem, 'validateTagAttributes');
                $sutResponse = $sut->invoke($detalhamentoItem, $xmlElement);
                expect($sutResponse->isFailure())->toBeTrue();
            });
        });

        describe('validateTagElements', function () {
            test('Should succeed if all required tags are provided', function () {
                $xmlString = '<det nItem="1"><prod></prod><imposto></imposto></det>';
                $xmlElement = new Element;
                $xmlElement->parse($xmlString);
                $detalhamentoItem = new DetalhamentoItem;
                $sut = new ReflectionMethod($detalhamentoItem, 'validateTagElements');
                $sutResponse = $sut->invoke($detalhamentoItem, $xmlElement);
                expect($sutResponse->isSuccess())->toBeTrue();
            });

            test('Should succeed if all tags is provided', function () {
                $xmlString = '<det nItem="1"><prod></prod><imposto></imposto><impostoDevol></impostoDevol></det>';
                $xmlElement = new Element;
                $xmlElement->parse($xmlString);
                $detalhamentoItem = new DetalhamentoItem;
                $sut = new ReflectionMethod($detalhamentoItem, 'validateTagElements');
                $sutResponse = $sut->invoke($detalhamentoItem, $xmlElement);
                expect($sutResponse->isSuccess())->toBeTrue();
            });

            test('Should fail if prod tag is missing', function () {
                $xmlString = '<det nItem="1"><imposto></imposto></det>';
                $xmlElement = new Element;
                $xmlElement->parse($xmlString);
                $detalhamentoItem = new DetalhamentoItem;
                $sut = new ReflectionMethod($detalhamentoItem, 'validateTagElements');
                $sutResponse = $sut->invoke($detalhamentoItem, $xmlElement);
                expect($sutResponse->isFailure())->toBeTrue();
            });

            test('Should fail if imposto tag are provided', function () {
                $xmlString = '<det nItem="1"><prod></prod></det>';
                $xmlElement = new Element;
                $xmlElement->parse($xmlString);
                $detalhamentoItem = new DetalhamentoItem;
                $sut = new ReflectionMethod($detalhamentoItem, 'validateTagElements');
                $sutResponse = $sut->invoke($detalhamentoItem, $xmlElement);
                expect($sutResponse->isFailure())->toBeTrue();
            });

            test('Should fail if unallowed tag is provided', function () {
                $xmlString = '<det nItem="1"><prod></prod><imposto></imposto><unallowed></unallowed></det>';
                $xmlElement = new Element;
                $xmlElement->parse($xmlString);
                $detalhamentoItem = new DetalhamentoItem;
                $sut = new ReflectionMethod($detalhamentoItem, 'validateTagElements');
                $sutResponse = $sut->invoke($detalhamentoItem, $xmlElement);
                expect($sutResponse->isFailure())->toBeTrue();
            });
        });
    });
});
