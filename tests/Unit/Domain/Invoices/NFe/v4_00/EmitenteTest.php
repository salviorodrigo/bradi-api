<?php

declare(strict_types=1);

use BradiApi\Domain\Invoices\NFe\v4_00\Emitente;
use BradiApi\Domain\Invoices\Templates\DFeElement;
use BradiApi\Domain\Xml\ValueObjects\Element;

describe('Emitente', function () {
    test('Should succeed if Emitente is declared', function () {
        $nameSpace = 'BradiApi\Domain\Invoices\NFe\v4_00';
        $sut = $nameSpace . '\\Emitente';
        expect(class_exists($sut))->toBeTrue();
    });

    test('Should succeed if Emitente extends DFeElement', function () {
        $sut = new Emitente;
        expect(is_subclass_of($sut, DFeElement::class))->toBeTrue();
    });

    describe('properties', function () {
        describe('FIELD_NAME', function () {
            test('Should be set correctly', function () {
                $reflection = new ReflectionClass(Emitente::class);
                $reflectedProperty = $reflection->getConstant('FIELD_NAME');
                expect($reflectedProperty)->toBe('emit');
            });
        });

        describe('$CNPJ', function () {
            test('Should be declared', function () {
                $sut = new Emitente;
                expect($sut)->toHaveProperty('CNPJ');
            });

            test('Should be a subclass of DFeElement::class', function () {
                $reflection = new ReflectionClass(Emitente::class);
                $reflectedProperty = $reflection->getProperty('CNPJ');
                $sut = $reflectedProperty->getType();
                expect((is_subclass_of($sut->getName(), DFeElement::class)))->toBeTrue();
            });

            test('Should be required', function () {
                $reflection = new ReflectionClass(Emitente::class);
                $reflectedProperty = $reflection->getProperty('CNPJ');
                $sut = $reflectedProperty->getType();
                expect($sut->allowsNull())->toBeFalse();
            });
        });

        describe('$CPF', function () {
            test('Should be declared', function () {
                $sut = new Emitente;
                expect($sut)->toHaveProperty('CPF');
            });

            test('Should be a subclass of DFeElement::class', function () {
                $reflection = new ReflectionClass(Emitente::class);
                $reflectedProperty = $reflection->getProperty('CPF');
                $sut = $reflectedProperty->getType();
                expect((is_subclass_of($sut->getName(), DFeElement::class)))->toBeTrue();
            });

            test('Should be optional', function () {
                $reflection = new ReflectionClass(Emitente::class);
                $reflectedProperty = $reflection->getProperty('CPF');
                $sut = $reflectedProperty->getType();
                expect($sut->allowsNull())->toBeTrue();
            });
        });

        describe('$xNome', function () {
            test('Should be declared', function () {
                $sut = new Emitente;
                expect($sut)->toHaveProperty('xNome');
            });

            test('Should be a subclass of DFeElement::class', function () {
                $reflection = new ReflectionClass(Emitente::class);
                $reflectedProperty = $reflection->getProperty('xNome');
                $sut = $reflectedProperty->getType();
                expect((is_subclass_of($sut->getName(), DFeElement::class)))->toBeTrue();
            });

            test('Should be required', function () {
                $reflection = new ReflectionClass(Emitente::class);
                $reflectedProperty = $reflection->getProperty('xNome');
                $sut = $reflectedProperty->getType();
                expect($sut->allowsNull())->toBeFalse();
            });
        });

        describe('$xFant', function () {
            test('Should be declared', function () {
                $sut = new Emitente;
                expect($sut)->toHaveProperty('xFant');
            });

            test('Should be a subclass of DFeElement::class', function () {
                $reflection = new ReflectionClass(Emitente::class);
                $reflectedProperty = $reflection->getProperty('xFant');
                $sut = $reflectedProperty->getType();
                expect((is_subclass_of($sut->getName(), DFeElement::class)))->toBeTrue();
            });

            test('Should be optional', function () {
                $reflection = new ReflectionClass(Emitente::class);
                $reflectedProperty = $reflection->getProperty('xFant');
                $sut = $reflectedProperty->getType();
                expect($sut->allowsNull())->toBeTrue();
            });
        });

        describe('$IE', function () {
            test('Should be declared', function () {
                $sut = new Emitente;
                expect($sut)->toHaveProperty('IE');
            });

            test('Should be a subclass of DFeElement::class', function () {
                $reflection = new ReflectionClass(Emitente::class);
                $reflectedProperty = $reflection->getProperty('IE');
                $sut = $reflectedProperty->getType();
                expect((is_subclass_of($sut->getName(), DFeElement::class)))->toBeTrue();
            });

            test('Should be required', function () {
                $reflection = new ReflectionClass(Emitente::class);
                $reflectedProperty = $reflection->getProperty('IE');
                $sut = $reflectedProperty->getType();
                expect($sut->allowsNull())->toBeFalse();
            });
        });

        describe('$IEST', function () {
            test('Should be declared', function () {
                $sut = new Emitente;
                expect($sut)->toHaveProperty('IEST');
            });

            test('Should be a subclass of DFeElement::class', function () {
                $reflection = new ReflectionClass(Emitente::class);
                $reflectedProperty = $reflection->getProperty('IEST');
                $sut = $reflectedProperty->getType();
                expect((is_subclass_of($sut->getName(), DFeElement::class)))->toBeTrue();
            });

            test('Should be required', function () {
                $reflection = new ReflectionClass(Emitente::class);
                $reflectedProperty = $reflection->getProperty('IEST');
                $sut = $reflectedProperty->getType();
                expect($sut->allowsNull())->toBeTrue();
            });
        })->skip();

        describe('$CRT', function () {
            test('Should be declared', function () {
                $sut = new Emitente;
                expect($sut)->toHaveProperty('CRT');
            });

            test('Should be a subclass of DFeElement::class', function () {
                $reflection = new ReflectionClass(Emitente::class);
                $reflectedProperty = $reflection->getProperty('CRT');
                $sut = $reflectedProperty->getType();
                expect((is_subclass_of($sut->getName(), DFeElement::class)))->toBeTrue();
            });

            test('Should be required', function () {
                $reflection = new ReflectionClass(Emitente::class);
                $reflectedProperty = $reflection->getProperty('CRT');
                $sut = $reflectedProperty->getType();
                expect($sut->allowsNull())->toBeFalse();
            });
        })->skip();

        describe('$enderEmit', function () {
            test('Should be declared', function () {
                $sut = new Emitente;
                expect($sut)->toHaveProperty('enderEmit');
            });

            test('Should be a subclass of DFeElement::class', function () {
                $reflection = new ReflectionClass(Emitente::class);
                $reflectedProperty = $reflection->getProperty('enderEmit');
                $sut = $reflectedProperty->getType();
                expect((is_subclass_of($sut->getName(), DFeElement::class)))->toBeTrue();
            });

            test('Should be required', function () {
                $reflection = new ReflectionClass(Emitente::class);
                $reflectedProperty = $reflection->getProperty('enderEmit');
                $sut = $reflectedProperty->getType();
                expect($sut->allowsNull())->toBeFalse();
            });
        });

        describe('$IM', function () {
            test('Should be declared', function () {
                $sut = new Emitente;
                expect($sut)->toHaveProperty('IM');
            });

            test('Should be a subclass of DFeElement::class', function () {
                $reflection = new ReflectionClass(Emitente::class);
                $reflectedProperty = $reflection->getProperty('IM');
                $sut = $reflectedProperty->getType();
                expect((is_subclass_of($sut->getName(), DFeElement::class)))->toBeTrue();
            });

            test('Should be optional', function () {
                $reflection = new ReflectionClass(Emitente::class);
                $reflectedProperty = $reflection->getProperty('IM');
                $sut = $reflectedProperty->getType();
                expect($sut->allowsNull())->toBeTrue();
            });
        })->skip();

        describe('CNAE', function () {
            test('Should be declared', function () {
                $sut = new Emitente;
                expect($sut)->toHaveProperty('CNAE');
            });

            test('Should be a subclass of DFeElement::class', function () {
                $reflection = new ReflectionClass(Emitente::class);
                $reflectedProperty = $reflection->getProperty('CNAE');
                $sut = $reflectedProperty->getType();
                expect((is_subclass_of($sut->getName(), DFeElement::class)))->toBeTrue();
            });

            test('Should be optional', function () {
                $reflection = new ReflectionClass(Emitente::class);
                $reflectedProperty = $reflection->getProperty('CNAE');
                $sut = $reflectedProperty->getType();
                expect($sut->allowsNull())->toBeTrue();
            });
        })->skip();
    });

    describe('methods', function () {
        describe('validateTagAttributes', function () {
            test('Should fail if an attribute is provided', function () {
                $xmlString = '<emit attribute="value"><CNPJ></CNPJ><xNome></xNome><enderEmit></enderEmit><IE></IE><CRT></CRT></emit>';
                $xmlElement = new Element;
                $xmlElement->parse($xmlString);
                $identificacaoNotaFiscal = new Emitente;
                $sut = new ReflectionMethod($identificacaoNotaFiscal, 'validateTagAttributes');
                $sutResponse = $sut->invoke($identificacaoNotaFiscal, $xmlElement);
                expect($sutResponse->isFailure())->toBeTrue();
            });
        });

        describe('validateTagElements', function () {
            test('Should succeed if all required tags id provided', function () {
                $xmlString = '<emit><CNPJ></CNPJ><xNome></xNome><enderEmit></enderEmit><IE></IE><CRT></CRT></emit>';
                $xmlElement = new Element;
                $xmlElement->parse($xmlString);
                $emitente = new Emitente;
                $sut = new ReflectionMethod($emitente, 'validateTagElements');
                $sutResponse = $sut->invoke($emitente, $xmlElement);
                expect($sutResponse->isSuccess())->toBeTrue();
            });

            test('Should succeed if all tags is provided', function () {
                $xmlString = '<emit><CNPJ></CNPJ><CPF></CPF><xNome></xNome><xFant></xFant><enderEmit></enderEmit><IE></IE><IEST></IEST><CRT></CRT><IM></IM><CNAE></CNAE></emit>';
                $xmlElement = new Element;
                $xmlElement->parse($xmlString);
                $emitente = new Emitente;
                $sut = new ReflectionMethod($emitente, 'validateTagElements');
                $sutResponse = $sut->invoke($emitente, $xmlElement);
                expect($sutResponse->isSuccess())->toBeTrue();
            });

            test('Should fail if CNPJ tag isnt provided', function () {
                $xmlString = '<emit><xNome></xNome><enderEmit></enderEmit><IE></IE><CRT></CRT></emit>';
                $xmlElement = new Element;
                $xmlElement->parse($xmlString);
                $emitente = new Emitente;
                $sut = new ReflectionMethod($emitente, 'validateTagElements');
                $sutResponse = $sut->invoke($emitente, $xmlElement);
                expect($sutResponse->isFailure())->toBeTrue();
            });

            test('Should fail if xNome tag isnt provided', function () {
                $xmlString = '<emit><CNPJ></CNPJ><enderEmit></enderEmit><IE></IE><CRT></CRT></emit>';
                $xmlElement = new Element;
                $xmlElement->parse($xmlString);
                $emitente = new Emitente;
                $sut = new ReflectionMethod($emitente, 'validateTagElements');
                $sutResponse = $sut->invoke($emitente, $xmlElement);
                expect($sutResponse->isFailure())->toBeTrue();
            });

            test('Should fail if enderEmit tag isnt provided', function () {
                $xmlString = '<emit><CNPJ></CNPJ><xNome></xNome><IE></IE><CRT></CRT></emit>';
                $xmlElement = new Element;
                $xmlElement->parse($xmlString);
                $emitente = new Emitente;
                $sut = new ReflectionMethod($emitente, 'validateTagElements');
                $sutResponse = $sut->invoke($emitente, $xmlElement);
                expect($sutResponse->isFailure())->toBeTrue();
            });

            test('Should fail if IE tag isnt provided', function () {
                $xmlString = '<emit><CNPJ></CNPJ><xNome></xNome><enderEmit></enderEmit><CRT></CRT></emit>';
                $xmlElement = new Element;
                $xmlElement->parse($xmlString);
                $emitente = new Emitente;
                $sut = new ReflectionMethod($emitente, 'validateTagElements');
                $sutResponse = $sut->invoke($emitente, $xmlElement);
                expect($sutResponse->isFailure())->toBeTrue();
            });

            test('Should fail if CRT tag isnt provided', function () {
                $xmlString = '<emit><CNPJ></CNPJ><xNome></xNome><enderEmit></enderEmit><IE></IE></emit>';
                $xmlElement = new Element;
                $xmlElement->parse($xmlString);
                $emitente = new Emitente;
                $sut = new ReflectionMethod($emitente, 'validateTagElements');
                $sutResponse = $sut->invoke($emitente, $xmlElement);
                expect($sutResponse->isFailure())->toBeTrue();
            });

            test('Should fail if unallowed tag is provided', function () {
                $xmlString = '<emit><unallowed></unallowed><CNPJ></CNPJ><CPF></CPF><xNome></xNome><xFant></xFant><enderEmit></enderEmit><IE></IE><IEST></IEST><CRT></CRT><IM></IM><CNAE></CNAE></emit>';
                $xmlElement = new Element;
                $xmlElement->parse($xmlString);
                $emitente = new Emitente;
                $sut = new ReflectionMethod($emitente, 'validateTagElements');
                $sutResponse = $sut->invoke($emitente, $xmlElement);
                expect($sutResponse->isFailure())->toBeTrue();
            })->skip();
        });
    });
});
