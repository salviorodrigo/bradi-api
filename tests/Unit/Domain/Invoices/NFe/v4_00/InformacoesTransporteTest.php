<?php

declare(strict_types=1);

use BradiApi\Domain\Invoices\NFe\v4_00\InformacoesTransporte;
use BradiApi\Domain\Invoices\Templates\DFeAttribute;
use BradiApi\Domain\Invoices\Templates\DFeElement;
use BradiApi\Domain\Xml\ValueObjects\Element;

describe('InformacoesTransporte', function () {
    test('Should succeed if InformacoesTransporte is declared', function () {
        $nameSpace = 'BradiApi\Domain\Invoices\NFe\v4_00';
        $sut = $nameSpace . '\\InformacoesTransporte';
        expect(class_exists($sut))->toBeTrue();
    });

    test('Should succeed if InformacoesTransporte extends DFeElement', function () {
        $sut = new InformacoesTransporte;
        expect(is_subclass_of($sut, DFeElement::class))->toBeTrue();
    });

    describe('properties', function () {
        describe('FIELD_NAME', function () {
            test('Should be set correctly', function () {
                $reflection = new ReflectionClass(InformacoesTransporte::class);
                $reflectedProperty = $reflection->getConstant('FIELD_NAME');
                expect($reflectedProperty)->toBe('transp');
            });
        });

        describe('$modFrete', function () {
            test('Should be declared', function () {
                $sut = new InformacoesTransporte;
                expect($sut)->toHaveProperty('modFrete');
            });

            test('Should be a subclass of DFeAttribute::class', function () {
                $reflection = new ReflectionClass(InformacoesTransporte::class);
                $reflectedProperty = $reflection->getProperty('modFrete');
                $sut = $reflectedProperty->getType();
                expect((is_subclass_of($sut->getName(), DFeAttribute::class)))->toBeTrue();
            });

            test('Should be required', function () {
                $reflection = new ReflectionClass(InformacoesTransporte::class);
                $reflectedProperty = $reflection->getProperty('modFrete');
                $sut = $reflectedProperty->getType();
                expect($sut->allowsNull())->toBeFalse();
            });
        })->skip();

        describe('$transporta', function () {
            test('Should be declared', function () {
                $sut = new InformacoesTransporte;
                expect($sut)->toHaveProperty('transporta');
            });

            test('Should be a subclass of DFeAttribute::class', function () {
                $reflection = new ReflectionClass(InformacoesTransporte::class);
                $reflectedProperty = $reflection->getProperty('transporta');
                $sut = $reflectedProperty->getType();
                expect((is_subclass_of($sut->getName(), DFeAttribute::class)))->toBeTrue();
            });

            test('Should be optional', function () {
                $reflection = new ReflectionClass(InformacoesTransporte::class);
                $reflectedProperty = $reflection->getProperty('transporta');
                $sut = $reflectedProperty->getType();
                expect($sut->allowsNull())->toBeTrue();
            });
        })->skip();

        describe('$retTransp', function () {
            test('Should be declared', function () {
                $sut = new InformacoesTransporte;
                expect($sut)->toHaveProperty('retTransp');
            });

            test('Should be a subclass of DFeAttribute::class', function () {
                $reflection = new ReflectionClass(InformacoesTransporte::class);
                $reflectedProperty = $reflection->getProperty('retTransp');
                $sut = $reflectedProperty->getType();
                expect((is_subclass_of($sut->getName(), DFeAttribute::class)))->toBeTrue();
            });

            test('Should be optional', function () {
                $reflection = new ReflectionClass(InformacoesTransporte::class);
                $reflectedProperty = $reflection->getProperty('retTransp');
                $sut = $reflectedProperty->getType();
                expect($sut->allowsNull())->toBeTrue();
            });
        })->skip();

        describe('$veicTransp', function () {
            test('Should be declared', function () {
                $sut = new InformacoesTransporte;
                expect($sut)->toHaveProperty('veicTransp');
            });

            test('Should be a subclass of DFeAttribute::class', function () {
                $reflection = new ReflectionClass(InformacoesTransporte::class);
                $reflectedProperty = $reflection->getProperty('veicTransp');
                $sut = $reflectedProperty->getType();
                expect((is_subclass_of($sut->getName(), DFeAttribute::class)))->toBeTrue();
            });

            test('Should be optional', function () {
                $reflection = new ReflectionClass(InformacoesTransporte::class);
                $reflectedProperty = $reflection->getProperty('veicTransp');
                $sut = $reflectedProperty->getType();
                expect($sut->allowsNull())->toBeTrue();
            });
        })->skip();

        describe('$reboque', function () {
            test('Should be declared', function () {
                $sut = new InformacoesTransporte;
                expect($sut)->toHaveProperty('reboque');
            });

            test('Should be a subclass of DFeAttribute::class', function () {
                $reflection = new ReflectionClass(InformacoesTransporte::class);
                $reflectedProperty = $reflection->getProperty('reboque');
                $sut = $reflectedProperty->getType();
                expect((is_subclass_of($sut->getName(), DFeAttribute::class)))->toBeTrue();
            });

            test('Should be optional', function () {
                $reflection = new ReflectionClass(InformacoesTransporte::class);
                $reflectedProperty = $reflection->getProperty('reboque');
                $sut = $reflectedProperty->getType();
                expect($sut->allowsNull())->toBeTrue();
            });
        })->skip();

        describe('$vol', function () {
            test('Should be declared', function () {
                $sut = new InformacoesTransporte;
                expect($sut)->toHaveProperty('vol');
            });

            test('Should be a subclass of DFeAttribute::class', function () {
                $reflection = new ReflectionClass(InformacoesTransporte::class);
                $reflectedProperty = $reflection->getProperty('vol');
                $sut = $reflectedProperty->getType();
                expect((is_subclass_of($sut->getName(), DFeAttribute::class)))->toBeTrue();
            });

            test('Should be optional', function () {
                $reflection = new ReflectionClass(InformacoesTransporte::class);
                $reflectedProperty = $reflection->getProperty('vol');
                $sut = $reflectedProperty->getType();
                expect($sut->allowsNull())->toBeTrue();
            });
        })->skip();
    });

    describe('methods', function () {
        describe('validateTagAttributes', function () {
            test('Should fail if an attribute is provided', function () {
                $xmlString = '<transp attribute="value"></transp>';
                $xmlElement = new Element;
                $xmlElement->parse($xmlString);
                $targetClass = new InformacoesTransporte;
                $sut = new ReflectionMethod($targetClass, 'validateTagAttributes');
                $sutResponse = $sut->invoke($targetClass, $xmlElement);
                expect($sutResponse->isFailure())->toBeTrue();
            });
        });

        describe('validateTagElements', function () {
            test('Should succeed if all required tags are provided', function () {
                $xmlString = '<transp><modFrete/></transp>';
                $xmlElement = new Element;
                $xmlElement->parse($xmlString);
                $targetClass = new InformacoesTransporte;
                $sut = new ReflectionMethod($targetClass, 'validateTagElements');
                $sutResponse = $sut->invoke($targetClass, $xmlElement);
                expect($sutResponse->isFailure())->toBeFalse();
            });

            test('Should succeed if all available tags are provided', function () {
                $xmlString = '<transp><modFrete/><transporta/><retTransp/><veicTransp/><reboque/><vol/></transp>';
                $xmlElement = new Element;
                $xmlElement->parse($xmlString);
                $targetClass = new InformacoesTransporte;
                $sut = new ReflectionMethod($targetClass, 'validateTagElements');
                $sutResponse = $sut->invoke($targetClass, $xmlElement);
                expect($sutResponse->isFailure())->toBeFalse();
            });

            test('Should fail if modFrete tag is missing', function () {
                $xmlString = '<transp><transporta/><retTransp/><veicTransp/><reboque/><vol/></transp>';
                $xmlElement = new Element;
                $xmlElement->parse($xmlString);
                $targetClass = new InformacoesTransporte;
                $sut = new ReflectionMethod($targetClass, 'validateTagElements');
                $sutResponse = $sut->invoke($targetClass, $xmlElement);
                expect($sutResponse->isFailure())->toBeTrue();
            });

            test('Should fail if unallowed tag is provided', function () {
                $xmlString = '<transp><unallowed/><modFrete/><transporta/><retTransp/><veicTransp/><reboque/><vol/></transp>';
                $xmlElement = new Element;
                $xmlElement->parse($xmlString);
                $targetClass = new InformacoesTransporte;
                $sut = new ReflectionMethod($targetClass, 'validateTagElements');
                $sutResponse = $sut->invoke($targetClass, $xmlElement);
                expect($sutResponse->isFailure())->toBeTrue();
            });
        });

        describe('validateTagValue', function () {
            test('Should fail if a value is provided', function () {
                $xmlString = '<transp>value</transp>';
                $xmlElement = new Element;
                $xmlElement->parse($xmlString);
                $transp = new InformacoesTransporte;
                $sut = new ReflectionMethod($transp, 'validateTagValue');
                $sutResponse = $sut->invoke($transp, $xmlElement);
                expect($sutResponse->isFailure())->toBeTrue();
            });
        });
    });
});
