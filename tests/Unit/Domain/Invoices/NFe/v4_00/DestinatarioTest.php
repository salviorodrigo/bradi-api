<?php

declare(strict_types=1);

use BradiApi\Domain\Invoices\NFe\v4_00\Destinatario;
use BradiApi\Domain\Invoices\Templates\DFeElement;
use BradiApi\Domain\Xml\ValueObjects\Element;

describe('Destinatario', function () {
    test('Should succeed if is declared', function () {
        $nameSpace = 'BradiApi\Domain\Invoices\NFe\v4_00';
        $sut = $nameSpace . '\\Destinatario';
        expect(class_exists($sut))->toBeTrue();
    });

    test('Should succeed if extends DFeElement', function () {
        $sut = new Destinatario;
        expect(is_subclass_of($sut, DFeElement::class))->toBeTrue();
    });

    test('Should succeed if FIELD_NAME is set correctly', function () {
        $sut = new Destinatario;
        expect($sut::FIELD_NAME)->toBe('dest');
    });

    describe('properties', function () {
        describe('$CNPJ', function () {
            test('Should be declared', function () {
                $sut = new Destinatario;
                expect($sut)->toHaveProperty('CNPJ');
            });

            test('Should be a subclass of DFeElement::class', function () {
                $reflection = new ReflectionClass(Destinatario::class);
                $reflectedProperty = $reflection->getProperty('CNPJ');
                $sut = $reflectedProperty->getType();
                expect((is_subclass_of($sut->getName(), DFeElement::class)))->toBeTrue();
            });

            test('Should be optional', function () {
                $reflection = new ReflectionClass(Destinatario::class);
                $reflectedProperty = $reflection->getProperty('CNPJ');
                $sut = $reflectedProperty->getType();
                expect($sut->allowsNull())->toBeTrue();
            });
        });

        describe('$CPF', function () {
            test('Should be declared', function () {
                $sut = new Destinatario;
                expect($sut)->toHaveProperty('CPF');
            });

            test('Should be a subclass of DFeElement::class', function () {
                $reflection = new ReflectionClass(Destinatario::class);
                $reflectedProperty = $reflection->getProperty('CPF');
                $sut = $reflectedProperty->getType();
                expect((is_subclass_of($sut->getName(), DFeElement::class)))->toBeTrue();
            });

            test('Should be optional', function () {
                $reflection = new ReflectionClass(Destinatario::class);
                $reflectedProperty = $reflection->getProperty('CPF');
                $sut = $reflectedProperty->getType();
                expect($sut->allowsNull())->toBeTrue();
            });
        });

        describe('$IdEstrangeiro', function () {
            test('Should be declared', function () {
                $sut = new Destinatario;
                expect($sut)->toHaveProperty('IdEstrangeiro');
            });

            test('Should be a subclass of DFeElement::class', function () {
                $reflection = new ReflectionClass(Destinatario::class);
                $reflectedProperty = $reflection->getProperty('IdEstrangeiro');
                $sut = $reflectedProperty->getType();
                expect((is_subclass_of($sut->getName(), DFeElement::class)))->toBeTrue();
            });

            test('Should be optional', function () {
                $reflection = new ReflectionClass(Destinatario::class);
                $reflectedProperty = $reflection->getProperty('IdEstrangeiro');
                $sut = $reflectedProperty->getType();
                expect($sut->allowsNull())->toBeTrue();
            });
        })->skip();

        describe('$xNome', function () {
            test('Should be declared', function () {
                $sut = new Destinatario;
                expect($sut)->toHaveProperty('xNome');
            });

            test('Should be a subclass of DFeElement::class', function () {
                $reflection = new ReflectionClass(Destinatario::class);
                $reflectedProperty = $reflection->getProperty('xNome');
                $sut = $reflectedProperty->getType();
                expect((is_subclass_of($sut->getName(), DFeElement::class)))->toBeTrue();
            });

            test('Should be optional', function () {
                $reflection = new ReflectionClass(Destinatario::class);
                $reflectedProperty = $reflection->getProperty('xNome');
                $sut = $reflectedProperty->getType();
                expect($sut->allowsNull())->toBeTrue();
            });
        });

        describe('$indIEDest', function () {
            test('Should be declared', function () {
                $sut = new Destinatario;
                expect($sut)->toHaveProperty('indIEDest');
            });

            test('Should be a subclass of DFeElement::class', function () {
                $reflection = new ReflectionClass(Destinatario::class);
                $reflectedProperty = $reflection->getProperty('indIEDest');
                $sut = $reflectedProperty->getType();
                expect((is_subclass_of($sut->getName(), DFeElement::class)))->toBeTrue();
            });

            test('Should be required', function () {
                $reflection = new ReflectionClass(Destinatario::class);
                $reflectedProperty = $reflection->getProperty('indIEDest');
                $sut = $reflectedProperty->getType();
                expect($sut->allowsNull())->toBeFalse();
            });
        });

        describe('$IE', function () {
            test('Should be declared', function () {
                $sut = new Destinatario;
                expect($sut)->toHaveProperty('IE');
            });

            test('Should be a subclass of DFeElement::class', function () {
                $reflection = new ReflectionClass(Destinatario::class);
                $reflectedProperty = $reflection->getProperty('IE');
                $sut = $reflectedProperty->getType();
                expect((is_subclass_of($sut->getName(), DFeElement::class)))->toBeTrue();
            });

            test('Should be optional', function () {
                $reflection = new ReflectionClass(Destinatario::class);
                $reflectedProperty = $reflection->getProperty('IE');
                $sut = $reflectedProperty->getType();
                expect($sut->allowsNull())->toBeTrue();
            });
        });

        describe('$ISUF', function () {
            test('Should be declared', function () {
                $sut = new Destinatario;
                expect($sut)->toHaveProperty('ISUF');
            });

            test('Should be a subclass of DFeElement::class', function () {
                $reflection = new ReflectionClass(Destinatario::class);
                $reflectedProperty = $reflection->getProperty('ISUF');
                $sut = $reflectedProperty->getType();
                expect((is_subclass_of($sut->getName(), DFeElement::class)))->toBeTrue();
            });

            test('Should be optional', function () {
                $reflection = new ReflectionClass(Destinatario::class);
                $reflectedProperty = $reflection->getProperty('ISUF');
                $sut = $reflectedProperty->getType();
                expect($sut->allowsNull())->toBeTrue();
            });
        })->skip();

        describe('$enderDest', function () {
            test('Should be declared', function () {
                $sut = new Destinatario;
                expect($sut)->toHaveProperty('enderDest');
            });

            test('Should be a subclass of DFeElement::class', function () {
                $reflection = new ReflectionClass(Destinatario::class);
                $reflectedProperty = $reflection->getProperty('enderDest');
                $sut = $reflectedProperty->getType();
                expect((is_subclass_of($sut->getName(), DFeElement::class)))->toBeTrue();
            });

            test('Should be optional', function () {
                $reflection = new ReflectionClass(Destinatario::class);
                $reflectedProperty = $reflection->getProperty('enderDest');
                $sut = $reflectedProperty->getType();
                expect($sut->allowsNull())->toBeTrue();
            });
        });

        describe('$IM', function () {
            test('Should be declared', function () {
                $sut = new Destinatario;
                expect($sut)->toHaveProperty('IM');
            });

            test('Should be a subclass of DFeElement::class', function () {
                $reflection = new ReflectionClass(Destinatario::class);
                $reflectedProperty = $reflection->getProperty('IM');
                $sut = $reflectedProperty->getType();
                expect((is_subclass_of($sut->getName(), DFeElement::class)))->toBeTrue();
            });

            test('Should be optional', function () {
                $reflection = new ReflectionClass(Destinatario::class);
                $reflectedProperty = $reflection->getProperty('IM');
                $sut = $reflectedProperty->getType();
                expect($sut->allowsNull())->toBeTrue();
            });
        })->skip();

        describe('email', function () {
            test('Should be declared', function () {
                $sut = new Destinatario;
                expect($sut)->toHaveProperty('email');
            });

            test('Should be a subclass of DFeElement::class', function () {
                $reflection = new ReflectionClass(Destinatario::class);
                $reflectedProperty = $reflection->getProperty('email');
                $sut = $reflectedProperty->getType();
                expect((is_subclass_of($sut->getName(), DFeElement::class)))->toBeTrue();
            });

            test('Should be optional', function () {
                $reflection = new ReflectionClass(Destinatario::class);
                $reflectedProperty = $reflection->getProperty('email');
                $sut = $reflectedProperty->getType();
                expect($sut->allowsNull())->toBeTrue();
            });
        })->skip();
    });

    describe('methods', function () {
        describe('validateTagAttributes', function () {
            test('Should fail if an attribute is provided', function () {
                $xmlString = '<dest attribute="value"><CNPJ></CNPJ><xNome></xNome><enderEmit></enderEmit><IE></IE><CRT></CRT></dest>';
                $xmlElement = new Element;
                $xmlElement->parse($xmlString);
                $identificacaoNotaFiscal = new Destinatario;
                $sut = new ReflectionMethod($identificacaoNotaFiscal, 'validateTagAttributes');
                $sutResponse = $sut->invoke($identificacaoNotaFiscal, $xmlElement);
                expect($sutResponse->isFailure())->toBeTrue();
            });
        });

        describe('validateTagElements', function () {
            test('Should succeed if all required tags id provided', function () {
                $xmlString = '<dest><CNPJ></CNPJ><indIEDest></indIEDest></dest>';
                $xmlElement = new Element;
                $xmlElement->parse($xmlString);
                $destinatario = new Destinatario;
                $sut = new ReflectionMethod($destinatario, 'validateTagElements');
                $sutResponse = $sut->invoke($destinatario, $xmlElement);
                expect($sutResponse->isSuccess())->toBeTrue();
            });

            test('Should succeed if all tags is provided', function () {
                $xmlString = '<dest><CNPJ></CNPJ><xNome></xNome><indIEDest></indIEDest><IE></IE><ISUF></ISUF><IM></IM><email></email><enderDest></enderDest></dest>';
                $xmlElement = new Element;
                $xmlElement->parse($xmlString);
                $destinatario = new Destinatario;
                $sut = new ReflectionMethod($destinatario, 'validateTagElements');
                $sutResponse = $sut->invoke($destinatario, $xmlElement);
                expect($sutResponse->isSuccess())->toBeTrue();
            });

            test('Should fail if CNPJ, CPF or idEstrangeiro tag isnt provided', function () {
                $xmlString = '<dest><indIEDest></indIEDest></dest>';
                $xmlElement = new Element;
                $xmlElement->parse($xmlString);
                $destinatario = new Destinatario;
                $sut = new ReflectionMethod($destinatario, 'validateTagElements');
                $sutResponse = $sut->invoke($destinatario, $xmlElement);
                expect($sutResponse->isFailure())->toBeTrue();
            });

            test('Should fail if indIEDest tag isnt provided', function () {
                $xmlString = '<dest><CNPJ></CNPJ></dest>';
                $xmlElement = new Element;
                $xmlElement->parse($xmlString);
                $destinatario = new Destinatario;
                $sut = new ReflectionMethod($destinatario, 'validateTagElements');
                $sutResponse = $sut->invoke($destinatario, $xmlElement);
                expect($sutResponse->isFailure())->toBeTrue();
            });

            test('Should fail if unallowed tag is provided', function () {
                $xmlString = '<dest><unallowed></unallowed><CNPJ></CNPJ><indIEDest></indIEDest></dest>';
                $xmlElement = new Element;
                $xmlElement->parse($xmlString);
                $destinatario = new Destinatario;
                $sut = new ReflectionMethod($destinatario, 'validateTagElements');
                $sutResponse = $sut->invoke($destinatario, $xmlElement);
                expect($sutResponse->isFailure())->toBeTrue();
            });
        });
    });
});
