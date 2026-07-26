<?php

declare(strict_types=1);

use BradiApi\Domain\Common\Protocols\ApiError;
use BradiApi\Domain\Invoices\NFe\v4_00\Icms00;
use BradiApi\Domain\Invoices\Templates\DFeElement;
use BradiApi\Domain\Xml\ValueObjects\Element;
use BradiApi\Tests\TestCase;

describe('Icms00', function () {
    test('Should succeed if Icms00 is declared', function () {
        $nameSpace = 'BradiApi\Domain\Invoices\NFe\v4_00';
        $sut = $nameSpace . '\\Icms00';
        expect(class_exists($sut))->toBeTrue();
    });

    test('Should succeed if Icms00 extends DFeElement', function () {
        $sut = new Icms00;
        expect(is_subclass_of($sut, DFeElement::class))->toBeTrue();
    });

    beforeEach(function () {
        /** @var TestCase $this */
        $this->sut = new Icms00;
    });

    describe('properties', function () {
        describe('$orig', function () {
            test('Should be declared', function () {
                $sut = new Icms00;
                expect($sut)->toHaveProperty('orig');
            });

            test('Should be a subclass of DFeElement::class', function () {
                $reflection = new ReflectionClass(Icms00::class);
                $reflectedProperty = $reflection->getProperty('orig');
                $sut = $reflectedProperty->getType();
                expect((is_subclass_of($sut->getName(), DFeElement::class)))->toBeTrue();
            });

            test('Should be required', function () {
                $reflection = new ReflectionClass(Icms00::class);
                $reflectedProperty = $reflection->getProperty('orig');
                $sut = $reflectedProperty->getType();
                expect($sut->allowsNull())->toBeFalse();
            });
        });

        describe('$CST', function () {
            test('Should be declared', function () {
                $sut = new Icms00;
                expect($sut)->toHaveProperty('CST');
            });

            test('Should be a subclass of DFeElement::class', function () {
                $reflection = new ReflectionClass(Icms00::class);
                $reflectedProperty = $reflection->getProperty('CST');
                $sut = $reflectedProperty->getType();
                expect((is_subclass_of($sut->getName(), DFeElement::class)))->toBeTrue();
            });

            test('Should be required', function () {
                $reflection = new ReflectionClass(Icms00::class);
                $reflectedProperty = $reflection->getProperty('CST');
                $sut = $reflectedProperty->getType();
                expect($sut->allowsNull())->toBeFalse();
            });
        });

        describe('$modBC', function () {
            test('Should be declared', function () {
                $sut = new Icms00;
                expect($sut)->toHaveProperty('modBC');
            });

            test('Should be a subclass of DFeElement::class', function () {
                $reflection = new ReflectionClass(Icms00::class);
                $reflectedProperty = $reflection->getProperty('modBC');
                $sut = $reflectedProperty->getType();
                expect((is_subclass_of($sut->getName(), DFeElement::class)))->toBeTrue();
            });

            test('Should be required', function () {
                $reflection = new ReflectionClass(Icms00::class);
                $reflectedProperty = $reflection->getProperty('modBC');
                $sut = $reflectedProperty->getType();
                expect($sut->allowsNull())->toBeFalse();
            });
        });

        describe('$vBC', function () {
            test('Should be declared', function () {
                $sut = new Icms00;
                expect($sut)->toHaveProperty('vBC');
            });

            test('Should be a subclass of DFeElement::class', function () {
                $reflection = new ReflectionClass(Icms00::class);
                $reflectedProperty = $reflection->getProperty('vBC');
                $sut = $reflectedProperty->getType();
                expect((is_subclass_of($sut->getName(), DFeElement::class)))->toBeTrue();
            });

            test('Should be required', function () {
                $reflection = new ReflectionClass(Icms00::class);
                $reflectedProperty = $reflection->getProperty('vBC');
                $sut = $reflectedProperty->getType();
                expect($sut->allowsNull())->toBeFalse();
            });
        });

        describe('$pICMS', function () {
            test('Should be declared', function () {
                $sut = new Icms00;
                expect($sut)->toHaveProperty('pICMS');
            });

            test('Should be a subclass of DFeElement::class', function () {
                $reflection = new ReflectionClass(Icms00::class);
                $reflectedProperty = $reflection->getProperty('pICMS');
                $sut = $reflectedProperty->getType();
                expect((is_subclass_of($sut->getName(), DFeElement::class)))->toBeTrue();
            });

            test('Should be required', function () {
                $reflection = new ReflectionClass(Icms00::class);
                $reflectedProperty = $reflection->getProperty('pICMS');
                $sut = $reflectedProperty->getType();
                expect($sut->allowsNull())->toBeFalse();
            });
        });

        describe('$vICMS', function () {
            test('Should be declared', function () {
                $sut = new Icms00;
                expect($sut)->toHaveProperty('vICMS');
            });

            test('Should be a subclass of DFeElement::class', function () {
                $reflection = new ReflectionClass(Icms00::class);
                $reflectedProperty = $reflection->getProperty('vICMS');
                $sut = $reflectedProperty->getType();
                expect((is_subclass_of($sut->getName(), DFeElement::class)))->toBeTrue();
            });

            test('Should be required', function () {
                $reflection = new ReflectionClass(Icms00::class);
                $reflectedProperty = $reflection->getProperty('vICMS');
                $sut = $reflectedProperty->getType();
                expect($sut->allowsNull())->toBeFalse();
            });
        });

        describe('$pFCP', function () {
            test('Should be declared', function () {
                $sut = new Icms00;
                expect($sut)->toHaveProperty('pFCP');
            });

            test('Should be a subclass of DFeElement::class', function () {
                $reflection = new ReflectionClass(Icms00::class);
                $reflectedProperty = $reflection->getProperty('pFCP');
                $sut = $reflectedProperty->getType();
                expect((is_subclass_of($sut->getName(), DFeElement::class)))->toBeTrue();
            });

            test('Should be optional', function () {
                $reflection = new ReflectionClass(Icms00::class);
                $reflectedProperty = $reflection->getProperty('pFCP');
                $sut = $reflectedProperty->getType();
                expect($sut->allowsNull())->toBeTrue();
            });
        })->skip();

        describe('$vFCP', function () {
            test('Should be declared', function () {
                $sut = new Icms00;
                expect($sut)->toHaveProperty('vFCP');
            });

            test('Should be a subclass of DFeElement::class', function () {
                $reflection = new ReflectionClass(Icms00::class);
                $reflectedProperty = $reflection->getProperty('vFCP');
                $sut = $reflectedProperty->getType();
                expect((is_subclass_of($sut->getName(), DFeElement::class)))->toBeTrue();
            });

            test('Should be optional', function () {
                $reflection = new ReflectionClass(Icms00::class);
                $reflectedProperty = $reflection->getProperty('vFCP');
                $sut = $reflectedProperty->getType();
                expect($sut->allowsNull())->toBeTrue();
            });
        })->skip();
    });

    describe('methods', function () {
        describe('validateTagAttributes', function () {
            test('Should fail if an attribute is provided', function () {
                $xmlString = '<ICMS00 attribute="value"><orig></orig><CST></CST><modBC></modBC><vBC></vBC><pICMS></pICMS><vICMS></vICMS></ICMS00>';
                $xmlElement = new Element;
                $xmlElement->parse($xmlString);
                $icms00 = new Icms00;
                $sut = new ReflectionMethod($icms00, 'validateTagAttributes');
                $sutResponse = $sut->invoke($icms00, $xmlElement);
                expect($sutResponse->isFailure())->toBeTrue();
            });
        });

        describe('validateTagElements', function () {
            test('Should succeed if all required tags is provided', function () {
                $xmlString = '<ICMS00><orig></orig><CST></CST><modBC></modBC><vBC></vBC><pICMS></pICMS><vICMS></vICMS></ICMS00>';
                $xmlElement = new Element;
                $xmlElement->parse($xmlString);
                $icms00 = new Icms00;
                $sut = new ReflectionMethod($icms00, 'validateTagElements');
                $sutResponse = $sut->invoke($icms00, $xmlElement);
                expect($sutResponse->isSuccess())->toBeTrue();
            });

            test('Should succeed if all  tags is provided', function () {
                $xmlString = '<ICMS00><orig></orig><CST></CST><modBC></modBC><vBC></vBC><pICMS></pICMS><vICMS></vICMS><pFCP/><vFCP/></ICMS00>';
                $xmlElement = new Element;
                $xmlElement->parse($xmlString);
                $icms00 = new Icms00;
                $sut = new ReflectionMethod($icms00, 'validateTagElements');
                $sutResponse = $sut->invoke($icms00, $xmlElement);
                expect($sutResponse->isSuccess())->toBeTrue();
            });

            test('Should fail if orig tag isnt provided', function () {
                $xmlString = '<ICMS00><CST></CST><modBC></modBC><vBC></vBC><pICMS></pICMS><vICMS></vICMS></ICMS00>';
                $xmlElement = new Element;
                $xmlElement->parse($xmlString);
                $icms00 = new Icms00;
                $sut = new ReflectionMethod($icms00, 'validateTagElements');
                $sutResponse = $sut->invoke($icms00, $xmlElement);
                expect($sutResponse->isFailure())->toBeTrue();
            });

            test('Should fail if CST tag isnt provided', function () {
                $xmlString = '<ICMS00><orig></orig><modBC></modBC><vBC></vBC><pICMS></pICMS><vICMS></vICMS></ICMS00>';
                $xmlElement = new Element;
                $xmlElement->parse($xmlString);
                $icms00 = new Icms00;
                $sut = new ReflectionMethod($icms00, 'validateTagElements');
                $sutResponse = $sut->invoke($icms00, $xmlElement);
                expect($sutResponse->isFailure())->toBeTrue();
            });

            test('Should fail if modBC tag isnt provided', function () {
                $xmlString = '<ICMS00><orig></orig><CST></CST><vBC></vBC><pICMS></pICMS><vICMS></vICMS></ICMS00>';
                $xmlElement = new Element;
                $xmlElement->parse($xmlString);
                $icms00 = new Icms00;
                $sut = new ReflectionMethod($icms00, 'validateTagElements');
                $sutResponse = $sut->invoke($icms00, $xmlElement);
                expect($sutResponse->isFailure())->toBeTrue();
            });

            test('Should fail if vBC tag isnt provided', function () {
                $xmlString = '<ICMS00><orig></orig><CST></CST><modBC></modBC><pICMS></pICMS><vICMS></vICMS></ICMS00>';
                $xmlElement = new Element;
                $xmlElement->parse($xmlString);
                $icms00 = new Icms00;
                $sut = new ReflectionMethod($icms00, 'validateTagElements');
                $sutResponse = $sut->invoke($icms00, $xmlElement);
                expect($sutResponse->isFailure())->toBeTrue();
            });

            test('Should fail if pICMS tag isnt provided', function () {
                $xmlString = '<ICMS00><orig></orig><CST></CST><modBC></modBC><vBC></vBC><vICMS></vICMS></ICMS00>';
                $xmlElement = new Element;
                $xmlElement->parse($xmlString);
                $icms00 = new Icms00;
                $sut = new ReflectionMethod($icms00, 'validateTagElements');
                $sutResponse = $sut->invoke($icms00, $xmlElement);
                expect($sutResponse->isFailure())->toBeTrue();
            });

            test('Should fail if vICMS tag isnt provided', function () {
                $xmlString = '<ICMS00><orig></orig><CST></CST><modBC></modBC><vBC></vBC><pICMS></pICMS></ICMS00>';
                $xmlElement = new Element;
                $xmlElement->parse($xmlString);
                $icms00 = new Icms00;
                $sut = new ReflectionMethod($icms00, 'validateTagElements');
                $sutResponse = $sut->invoke($icms00, $xmlElement);
                expect($sutResponse->isFailure())->toBeTrue();
            });

            test('Should succeed if an unallowed tag is provided', function () {
                $xmlString = '<ICMS00><unallowed></unallowed><orig></orig><CST></CST><modBC></modBC><vBC></vBC><pICMS></pICMS><vICMS></vICMS></ICMS00>';
                $xmlElement = new Element;
                $xmlElement->parse($xmlString);
                $icms00 = new Icms00;
                $sut = new ReflectionMethod($icms00, 'validateTagElements');
                $sutResponse = $sut->invoke($icms00, $xmlElement);
                expect($sutResponse->isSuccess())->toBeTrue();
            });
        });

        describe('validateTagValue', function () {
            test('Should fail if a value is provided', function () {
                $xmlString = '<ICMS00>value</ICMS00>';
                $xmlElement = new Element;
                $xmlElement->parse($xmlString);
                $icms00 = new Icms00;
                $sut = new ReflectionMethod($icms00, 'validateTagValue');
                $sutResponse = $sut->invoke($icms00, $xmlElement);
                expect($sutResponse->isFailure())->toBeTrue();
                expect($sutResponse->getError())->toBeInstanceOf(ApiError::class);
            });
        });
    });
});
