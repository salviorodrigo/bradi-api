<?php

declare(strict_types=1);

use BradiApi\Domain\Common\Protocols\ApiError;
use BradiApi\Domain\Invoices\NFe\v4_00\Imposto;
use BradiApi\Domain\Invoices\Templates\DFeElement;
use BradiApi\Domain\Xml\ValueObjects\Element;
use BradiApi\Tests\TestCase;

describe('Imposto', function () {
    test('Should succeed if Imposto is declared', function () {
        $nameSpace = 'BradiApi\Domain\Invoices\NFe\v4_00';
        $sut = $nameSpace . '\\Imposto';
        expect(class_exists($sut))->toBeTrue();
    });

    test('Should succeed if Imposto extends DFeElement', function () {
        $sut = new Imposto;
        expect(is_subclass_of($sut, DFeElement::class))->toBeTrue();
    });

    beforeEach(function () {
        /** @var TestCase $this */
        $this->sut = new Imposto;
    });

    describe('properties', function () {
        describe('$vTotTrib', function () {
            test('Should be declared', function () {
                $sut = new Imposto;
                expect($sut)->toHaveProperty('vTotTrib');
            });

            test('Should be a subclass of DFeElement::class', function () {
                $reflection = new ReflectionClass(Imposto::class);
                $reflectedProperty = $reflection->getProperty('vTotTrib');
                $sut = $reflectedProperty->getType();
                expect((is_subclass_of($sut->getName(), DFeElement::class)))->toBeTrue();
            });

            test('Should be optional', function () {
                $reflection = new ReflectionClass(Imposto::class);
                $reflectedProperty = $reflection->getProperty('vTotTrib');
                $sut = $reflectedProperty->getType();
                expect($sut->allowsNull())->toBeTrue();
            });
        })->skip();

        describe('$ICMS', function () {
            test('Should be declared', function () {
                $sut = new Imposto;
                expect($sut)->toHaveProperty('ICMS');
            });

            test('Should be a subclass of DFeElement::class', function () {
                $reflection = new ReflectionClass(Imposto::class);
                $reflectedProperty = $reflection->getProperty('ICMS');
                $sut = $reflectedProperty->getType();
                expect((is_subclass_of($sut->getName(), DFeElement::class)))->toBeTrue();
            });

            test('Should be required', function () {
                $reflection = new ReflectionClass(Imposto::class);
                $reflectedProperty = $reflection->getProperty('ICMS');
                $sut = $reflectedProperty->getType();
                expect($sut->allowsNull())->toBeFalse();
            });
        });

        describe('$ICMSUFDest', function () {
            test('Should be declared', function () {
                $sut = new Imposto;
                expect($sut)->toHaveProperty('ICMSUFDest');
            });

            test('Should be a subclass of DFeElement::class', function () {
                $reflection = new ReflectionClass(Imposto::class);
                $reflectedProperty = $reflection->getProperty('ICMSUFDest');
                $sut = $reflectedProperty->getType();
                expect((is_subclass_of($sut->getName(), DFeElement::class)))->toBeTrue();
            });

            test('Should be optional', function () {
                $reflection = new ReflectionClass(Imposto::class);
                $reflectedProperty = $reflection->getProperty('ICMSUFDest');
                $sut = $reflectedProperty->getType();
                expect($sut->allowsNull())->toBeTrue();
            });
        })->skip();

        describe('$IPI', function () {
            test('Should be declared', function () {
                $sut = new Imposto;
                expect($sut)->toHaveProperty('IPI');
            });

            test('Should be a subclass of DFeElement::class', function () {
                $reflection = new ReflectionClass(Imposto::class);
                $reflectedProperty = $reflection->getProperty('IPI');
                $sut = $reflectedProperty->getType();
                expect((is_subclass_of($sut->getName(), DFeElement::class)))->toBeTrue();
            });

            test('Should be optional', function () {
                $reflection = new ReflectionClass(Imposto::class);
                $reflectedProperty = $reflection->getProperty('IPI');
                $sut = $reflectedProperty->getType();
                expect($sut->allowsNull())->toBeTrue();
            });
        })->skip();

        describe('$II', function () {
            test('Should be declared', function () {
                $sut = new Imposto;
                expect($sut)->toHaveProperty('II');
            });

            test('Should be a subclass of DFeElement::class', function () {
                $reflection = new ReflectionClass(Imposto::class);
                $reflectedProperty = $reflection->getProperty('II');
                $sut = $reflectedProperty->getType();
                expect((is_subclass_of($sut->getName(), DFeElement::class)))->toBeTrue();
            });

            test('Should be optional', function () {
                $reflection = new ReflectionClass(Imposto::class);
                $reflectedProperty = $reflection->getProperty('II');
                $sut = $reflectedProperty->getType();
                expect($sut->allowsNull())->toBeTrue();
            });
        })->skip();

        describe('$PIS', function () {
            test('Should be declared', function () {
                $sut = new Imposto;
                expect($sut)->toHaveProperty('PIS');
            });

            test('Should be a subclass of DFeElement::class', function () {
                $reflection = new ReflectionClass(Imposto::class);
                $reflectedProperty = $reflection->getProperty('PIS');
                $sut = $reflectedProperty->getType();
                expect((is_subclass_of($sut->getName(), DFeElement::class)))->toBeTrue();
            });

            test('Should be optional', function () {
                $reflection = new ReflectionClass(Imposto::class);
                $reflectedProperty = $reflection->getProperty('PIS');
                $sut = $reflectedProperty->getType();
                expect($sut->allowsNull())->toBeTrue();
            });
        })->skip();

        describe('$PISST', function () {
            test('Should be declared', function () {
                $sut = new Imposto;
                expect($sut)->toHaveProperty('PISST');
            });

            test('Should be a subclass of DFeElement::class', function () {
                $reflection = new ReflectionClass(Imposto::class);
                $reflectedProperty = $reflection->getProperty('PISST');
                $sut = $reflectedProperty->getType();
                expect((is_subclass_of($sut->getName(), DFeElement::class)))->toBeTrue();
            });

            test('Should be optional', function () {
                $reflection = new ReflectionClass(Imposto::class);
                $reflectedProperty = $reflection->getProperty('PISST');
                $sut = $reflectedProperty->getType();
                expect($sut->allowsNull())->toBeTrue();
            });
        })->skip();

        describe('$COFINS', function () {
            test('Should be declared', function () {
                $sut = new Imposto;
                expect($sut)->toHaveProperty('COFINS');
            });

            test('Should be a subclass of DFeElement::class', function () {
                $reflection = new ReflectionClass(Imposto::class);
                $reflectedProperty = $reflection->getProperty('COFINS');
                $sut = $reflectedProperty->getType();
                expect((is_subclass_of($sut->getName(), DFeElement::class)))->toBeTrue();
            });

            test('Should be optional', function () {
                $reflection = new ReflectionClass(Imposto::class);
                $reflectedProperty = $reflection->getProperty('COFINS');
                $sut = $reflectedProperty->getType();
                expect($sut->allowsNull())->toBeTrue();
            });
        })->skip();

        describe('$COFINSST', function () {
            test('Should be declared', function () {
                $sut = new Imposto;
                expect($sut)->toHaveProperty('COFINSST');
            });

            test('Should be a subclass of DFeElement::class', function () {
                $reflection = new ReflectionClass(Imposto::class);
                $reflectedProperty = $reflection->getProperty('COFINSST');
                $sut = $reflectedProperty->getType();
                expect((is_subclass_of($sut->getName(), DFeElement::class)))->toBeTrue();
            });

            test('Should be optional', function () {
                $reflection = new ReflectionClass(Imposto::class);
                $reflectedProperty = $reflection->getProperty('COFINSST');
                $sut = $reflectedProperty->getType();
                expect($sut->allowsNull())->toBeTrue();
            });
        })->skip();

        describe('$ISSQN', function () {
            test('Should be declared', function () {
                $sut = new Imposto;
                expect($sut)->toHaveProperty('ISSQN');
            });

            test('Should be a subclass of DFeElement::class', function () {
                $reflection = new ReflectionClass(Imposto::class);
                $reflectedProperty = $reflection->getProperty('ISSQN');
                $sut = $reflectedProperty->getType();
                expect((is_subclass_of($sut->getName(), DFeElement::class)))->toBeTrue();
            });

            test('Should be optional', function () {
                $reflection = new ReflectionClass(Imposto::class);
                $reflectedProperty = $reflection->getProperty('ISSQN');
                $sut = $reflectedProperty->getType();
                expect($sut->allowsNull())->toBeTrue();
            });
        })->skip();
    });

    describe('methods', function () {
        describe('validateTagAttributes', function () {
            test('Should fail if an attribute is provided', function () {
                $xmlString = '<imposto attribute="value"><ICMS></ICMS></imposto>';
                $xmlElement = new Element;
                $xmlElement->parse($xmlString);
                $imposto = new Imposto;
                $sut = new ReflectionMethod($imposto, 'validateTagAttributes');
                $sutResponse = $sut->invoke($imposto, $xmlElement);
                expect($sutResponse->isFailure())->toBeTrue();
            });
        });

        describe('validateTagElements', function () {
            test('Should succeed if all required tags is provided', function () {
                $xmlString = '<imposto><ICMS></ICMS></imposto>';
                $xmlElement = new Element;
                $xmlElement->parse($xmlString);
                $imposto = new Imposto;
                $sut = new ReflectionMethod($imposto, 'validateTagElements');
                $sutResponse = $sut->invoke($imposto, $xmlElement);
                expect($sutResponse->isSuccess())->toBeTrue();
            });

            test('Should fail if ICMS tag isnt provided', function () {
                $xmlString = '<imposto></imposto>';
                $xmlElement = new Element;
                $xmlElement->parse($xmlString);
                $imposto = new Imposto;
                $sut = new ReflectionMethod($imposto, 'validateTagElements');
                $sutResponse = $sut->invoke($imposto, $xmlElement);
                expect($sutResponse->isFailure())->toBeTrue();
            });

            test('Should fail if an unallowed tag is provided', function () {
                $xmlString = '<imposto><unallowed></unallowed><ICMS></ICMS></imposto>';
                $xmlElement = new Element;
                $xmlElement->parse($xmlString);
                $imposto = new Imposto;
                $sut = new ReflectionMethod($imposto, 'validateTagElements');
                $sutResponse = $sut->invoke($imposto, $xmlElement);
                expect($sutResponse->isFailure())->toBeTrue();
            })->skip();
        });

        describe('validateTagValue', function () {
            test('Should fail if a value is provided', function () {
                $xmlString = '<imposto>value</imposto>';
                $xmlElement = new Element;
                $xmlElement->parse($xmlString);
                $imposto = new Imposto;
                $sut = new ReflectionMethod($imposto, 'validateTagValue');
                $sutResponse = $sut->invoke($imposto, $xmlElement);
                expect($sutResponse->isFailure())->toBeTrue();
                expect($sutResponse->getError())->toBeInstanceOf(ApiError::class);
            });
        });
    });
});
