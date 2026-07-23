<?php

declare(strict_types=1);

use BradiApi\Domain\Invoices\NFe\v4_00\EnderecoDestinatario;
use BradiApi\Domain\Invoices\Templates\DFeElement;
use BradiApi\Domain\Xml\ValueObjects\Element;
use BradiApi\Tests\TestCase;

describe('EnderecoDestinatario', function () {
    test('Should succeed if EnderecoDestinatario is declared', function () {
        $nameSpace = 'BradiApi\Domain\Invoices\NFe\v4_00';
        $sut = $nameSpace . '\\EnderecoDestinatario';
        expect(class_exists($sut))->toBeTrue();
    });

    test('Should succeed if EnderecoDestinatario extends DFeElement', function () {
        $sut = new EnderecoDestinatario;
        expect(is_subclass_of($sut, DFeElement::class))->toBeTrue();
    });

    beforeEach(function () {
        /** @var TestCase $this */
        $this->sut = new EnderecoDestinatario;
    });

    describe('properties', function () {
        describe('FIELD_NAME', function () {
            test('Should be set correctly', function () {
                $reflection = new ReflectionClass(EnderecoDestinatario::class);
                $reflectedProperty = $reflection->getConstant('FIELD_NAME');
                expect($reflectedProperty)->toBe('enderDest');
            });
        });

        describe('$xLgr', function () {
            test('Should be declared', function () {
                $sut = new EnderecoDestinatario;
                expect($sut)->toHaveProperty('xLgr');
            });

            test('Should be a subclass of DFeElement::class', function () {
                $reflection = new ReflectionClass(EnderecoDestinatario::class);
                $reflectedProperty = $reflection->getProperty('xLgr');
                $sut = $reflectedProperty->getType();
                expect((is_subclass_of($sut->getName(), DFeElement::class)))->toBeTrue();
            });

            test('Should be required', function () {
                $reflection = new ReflectionClass(EnderecoDestinatario::class);
                $reflectedProperty = $reflection->getProperty('xLgr');
                $sut = $reflectedProperty->getType();
                expect($sut->allowsNull())->toBeFalse();
            });
        });

        describe('$nro', function () {
            test('Should be declared', function () {
                $sut = new EnderecoDestinatario;
                expect($sut)->toHaveProperty('nro');
            });

            test('Should be a subclass of DFeElement::class', function () {
                $reflection = new ReflectionClass(EnderecoDestinatario::class);
                $reflectedProperty = $reflection->getProperty('nro');
                $sut = $reflectedProperty->getType();
                expect((is_subclass_of($sut->getName(), DFeElement::class)))->toBeTrue();
            });

            test('Should be required', function () {
                $reflection = new ReflectionClass(EnderecoDestinatario::class);
                $reflectedProperty = $reflection->getProperty('nro');
                $sut = $reflectedProperty->getType();
                expect($sut->allowsNull())->toBeFalse();
            });
        });

        describe('$xCpl', function () {
            test('Should be declared', function () {
                $sut = new EnderecoDestinatario;
                expect($sut)->toHaveProperty('xCpl');
            });

            test('Should be a subclass of DFeElement::class', function () {
                $reflection = new ReflectionClass(EnderecoDestinatario::class);
                $reflectedProperty = $reflection->getProperty('xCpl');
                $sut = $reflectedProperty->getType();
                expect((is_subclass_of($sut->getName(), DFeElement::class)))->toBeTrue();
            });

            test('Should be optional', function () {
                $reflection = new ReflectionClass(EnderecoDestinatario::class);
                $reflectedProperty = $reflection->getProperty('xCpl');
                $sut = $reflectedProperty->getType();
                expect($sut->allowsNull())->toBeTrue();
            });
        });

        describe('$xBairro', function () {
            test('Should be declared', function () {
                $sut = new EnderecoDestinatario;
                expect($sut)->toHaveProperty('xBairro');
            });

            test('Should be a subclass of DFeElement::class', function () {
                $reflection = new ReflectionClass(EnderecoDestinatario::class);
                $reflectedProperty = $reflection->getProperty('xBairro');
                $sut = $reflectedProperty->getType();
                expect((is_subclass_of($sut->getName(), DFeElement::class)))->toBeTrue();
            });

            test('Should be required', function () {
                $reflection = new ReflectionClass(EnderecoDestinatario::class);
                $reflectedProperty = $reflection->getProperty('xBairro');
                $sut = $reflectedProperty->getType();
                expect($sut->allowsNull())->toBeFalse();
            });
        });

        describe('$cMun', function () {
            test('Should be declared', function () {
                $sut = new EnderecoDestinatario;
                expect($sut)->toHaveProperty('cMun');
            });

            test('Should be a subclass of DFeElement::class', function () {
                $reflection = new ReflectionClass(EnderecoDestinatario::class);
                $reflectedProperty = $reflection->getProperty('cMun');
                $sut = $reflectedProperty->getType();
                expect((is_subclass_of($sut->getName(), DFeElement::class)))->toBeTrue();
            });

            test('Should be required', function () {
                $reflection = new ReflectionClass(EnderecoDestinatario::class);
                $reflectedProperty = $reflection->getProperty('cMun');
                $sut = $reflectedProperty->getType();
                expect($sut->allowsNull())->toBeFalse();
            });
        });

        describe('$xMun', function () {
            test('Should be declared', function () {
                $sut = new EnderecoDestinatario;
                expect($sut)->toHaveProperty('xMun');
            });

            test('Should be a subclass of DFeElement::class', function () {
                $reflection = new ReflectionClass(EnderecoDestinatario::class);
                $reflectedProperty = $reflection->getProperty('xMun');
                $sut = $reflectedProperty->getType();
                expect((is_subclass_of($sut->getName(), DFeElement::class)))->toBeTrue();
            });

            test('Should be required', function () {
                $reflection = new ReflectionClass(EnderecoDestinatario::class);
                $reflectedProperty = $reflection->getProperty('xMun');
                $sut = $reflectedProperty->getType();
                expect($sut->allowsNull())->toBeFalse();
            });
        });

        describe('$UF', function () {
            test('Should be declared', function () {
                $sut = new EnderecoDestinatario;
                expect($sut)->toHaveProperty('UF');
            });

            test('Should be a subclass of DFeElement::class', function () {
                $reflection = new ReflectionClass(EnderecoDestinatario::class);
                $reflectedProperty = $reflection->getProperty('UF');
                $sut = $reflectedProperty->getType();
                expect((is_subclass_of($sut->getName(), DFeElement::class)))->toBeTrue();
            });

            test('Should be required', function () {
                $reflection = new ReflectionClass(EnderecoDestinatario::class);
                $reflectedProperty = $reflection->getProperty('UF');
                $sut = $reflectedProperty->getType();
                expect($sut->allowsNull())->toBeFalse();
            });
        });

        describe('$CEP', function () {
            test('Should be declared', function () {
                $sut = new EnderecoDestinatario;
                expect($sut)->toHaveProperty('CEP');
            });

            test('Should be a subclass of DFeElement::class', function () {
                $reflection = new ReflectionClass(EnderecoDestinatario::class);
                $reflectedProperty = $reflection->getProperty('CEP');
                $sut = $reflectedProperty->getType();
                expect((is_subclass_of($sut->getName(), DFeElement::class)))->toBeTrue();
            });

            test('Should be optional', function () {
                $reflection = new ReflectionClass(EnderecoDestinatario::class);
                $reflectedProperty = $reflection->getProperty('CEP');
                $sut = $reflectedProperty->getType();
                expect($sut->allowsNull())->toBeTrue();
            });
        });

        describe('$cPais', function () {
            test('Should be declared', function () {
                $sut = new EnderecoDestinatario;
                expect($sut)->toHaveProperty('cPais');
            });

            test('Should be a subclass of DFeElement::class', function () {
                $reflection = new ReflectionClass(EnderecoDestinatario::class);
                $reflectedProperty = $reflection->getProperty('cPais');
                $sut = $reflectedProperty->getType();
                expect((is_subclass_of($sut->getName(), DFeElement::class)))->toBeTrue();
            });

            test('Should be optional', function () {
                $reflection = new ReflectionClass(EnderecoDestinatario::class);
                $reflectedProperty = $reflection->getProperty('cPais');
                $sut = $reflectedProperty->getType();
                expect($sut->allowsNull())->toBeTrue();
            });
        });

        describe('$xPais', function () {
            test('Should be declared', function () {
                $sut = new EnderecoDestinatario;
                expect($sut)->toHaveProperty('xPais');
            });

            test('Should be a subclass of DFeElement::class', function () {
                $reflection = new ReflectionClass(EnderecoDestinatario::class);
                $reflectedProperty = $reflection->getProperty('xPais');
                $sut = $reflectedProperty->getType();
                expect((is_subclass_of($sut->getName(), DFeElement::class)))->toBeTrue();
            });

            test('Should be optional', function () {
                $reflection = new ReflectionClass(EnderecoDestinatario::class);
                $reflectedProperty = $reflection->getProperty('xPais');
                $sut = $reflectedProperty->getType();
                expect($sut->allowsNull())->toBeTrue();
            });
        });

        describe('$fone', function () {
            test('Should be declared', function () {
                $sut = new EnderecoDestinatario;
                expect($sut)->toHaveProperty('fone');
            });

            test('Should be a subclass of DFeElement::class', function () {
                $reflection = new ReflectionClass(EnderecoDestinatario::class);
                $reflectedProperty = $reflection->getProperty('fone');
                $sut = $reflectedProperty->getType();
                expect((is_subclass_of($sut->getName(), DFeElement::class)))->toBeTrue();
            });

            test('Should be optional', function () {
                $reflection = new ReflectionClass(EnderecoDestinatario::class);
                $reflectedProperty = $reflection->getProperty('fone');
                $sut = $reflectedProperty->getType();
                expect($sut->allowsNull())->toBeTrue();
            });
        });
    });

    describe('methods', function () {
        describe('validateTagAttributes', function () {
            test('Should fail if an attribute is provided', function () {
                $xmlString = '<enderDest attribute="value"><xLgr></xLgr><nro></nro><xBairro></xBairro><cMun></cMun><xMun></xMun><UF></UF><CEP></CEP></enderDest>';
                $xmlElement = new Element;
                $xmlElement->parse($xmlString);
                $enderecoDestinatario = new EnderecoDestinatario;
                $sut = new ReflectionMethod($enderecoDestinatario, 'validateTagAttributes');
                $sutResponse = $sut->invoke($enderecoDestinatario, $xmlElement);
                expect($sutResponse->isFailure())->toBeTrue();
            });
        });

        describe('validateTagElements', function () {
            test('Should succeed if all required tags is provided', function () {
                $xmlString = '<enderDest><xLgr></xLgr><nro></nro><xBairro></xBairro><cMun></cMun><xMun></xMun><UF></UF></enderDest>';
                $xmlElement = new Element;
                $xmlElement->parse($xmlString);
                $enderecoDestinatario = new EnderecoDestinatario;
                $sut = new ReflectionMethod($enderecoDestinatario, 'validateTagElements');
                $sutResponse = $sut->invoke($enderecoDestinatario, $xmlElement);
                expect($sutResponse->isSuccess())->toBeTrue();
            });

            test('Should succeed if all tags is provided', function () {
                $xmlString = '<enderDest><xLgr></xLgr><nro></nro><xCpl></xCpl><xBairro></xBairro><cMun></cMun><xMun></xMun><UF></UF><CEP></CEP><cPais></cPais><xPais></xPais><fone></fone></enderDest>';
                $xmlElement = new Element;
                $xmlElement->parse($xmlString);
                $enderecoDestinatario = new EnderecoDestinatario;
                $sut = new ReflectionMethod($enderecoDestinatario, 'validateTagElements');
                $sutResponse = $sut->invoke($enderecoDestinatario, $xmlElement);
                expect($sutResponse->isSuccess())->toBeTrue();
            });

            test('Should fail if xLgr tag isnt provided', function () {
                $xmlString = '<enderDest><nro></nro><xBairro></xBairro><cMun></cMun><xMun></xMun><UF></UF><CEP></CEP></enderDest>';
                $xmlElement = new Element;
                $xmlElement->parse($xmlString);
                $enderecoDestinatario = new EnderecoDestinatario;
                $sut = new ReflectionMethod($enderecoDestinatario, 'validateTagElements');
                $sutResponse = $sut->invoke($enderecoDestinatario, $xmlElement);
                expect($sutResponse->isFailure())->toBeTrue();
            });

            test('Should fail if nro tag isnt provided', function () {
                $xmlString = '<enderDest><xLgr></xLgr><xBairro></xBairro><cMun></cMun><xMun></xMun><UF></UF><CEP></CEP></enderDest>';
                $xmlElement = new Element;
                $xmlElement->parse($xmlString);
                $enderecoDestinatario = new EnderecoDestinatario;
                $sut = new ReflectionMethod($enderecoDestinatario, 'validateTagElements');
                $sutResponse = $sut->invoke($enderecoDestinatario, $xmlElement);
                expect($sutResponse->isFailure())->toBeTrue();
            });

            test('Should fail if xBairro tag isnt provided', function () {
                $xmlString = '<enderDest><xLgr></xLgr><nro></nro><cMun></cMun><xMun></xMun><UF></UF><CEP></CEP></enderDest>';
                $xmlElement = new Element;
                $xmlElement->parse($xmlString);
                $enderecoDestinatario = new EnderecoDestinatario;
                $sut = new ReflectionMethod($enderecoDestinatario, 'validateTagElements');
                $sutResponse = $sut->invoke($enderecoDestinatario, $xmlElement);
                expect($sutResponse->isFailure())->toBeTrue();
            });

            test('Should fail if cMun tag isnt provided', function () {
                $xmlString = '<enderDest><xLgr></xLgr><nro></nro><xBairro></xBairro><xMun></xMun><UF></UF><CEP></CEP></enderDest>';
                $xmlElement = new Element;
                $xmlElement->parse($xmlString);
                $enderecoDestinatario = new EnderecoDestinatario;
                $sut = new ReflectionMethod($enderecoDestinatario, 'validateTagElements');
                $sutResponse = $sut->invoke($enderecoDestinatario, $xmlElement);
                expect($sutResponse->isFailure())->toBeTrue();
            });

            test('Should fail if xMun tag isnt provided', function () {
                $xmlString = '<enderDest><xLgr></xLgr><nro></nro><xBairro></xBairro><cMun></cMun><UF></UF><CEP></CEP></enderDest>';
                $xmlElement = new Element;
                $xmlElement->parse($xmlString);
                $enderecoDestinatario = new EnderecoDestinatario;
                $sut = new ReflectionMethod($enderecoDestinatario, 'validateTagElements');
                $sutResponse = $sut->invoke($enderecoDestinatario, $xmlElement);
                expect($sutResponse->isFailure())->toBeTrue();
            });

            test('Should fail if UF tag isnt provided', function () {
                $xmlString = '<enderDest><xLgr></xLgr><nro></nro><xBairro></xBairro><cMun></cMun><xMun></xMun><CEP></CEP></enderDest>';
                $xmlElement = new Element;
                $xmlElement->parse($xmlString);
                $enderecoDestinatario = new EnderecoDestinatario;
                $sut = new ReflectionMethod($enderecoDestinatario, 'validateTagElements');
                $sutResponse = $sut->invoke($enderecoDestinatario, $xmlElement);
                expect($sutResponse->isFailure())->toBeTrue();
            });

            test('Should fail if an unallowed tag is provided', function () {
                $xmlString = '<enderDest><xLgr></xLgr><nro></nro><xBairro></xBairro><cMun></cMun><xMun></xMun><UF></UF><CEP></CEP><unallowedTag></unallowedTag></enderDest>';
                $xmlElement = new Element;
                $xmlElement->parse($xmlString);
                $enderecoDestinatario = new EnderecoDestinatario;
                $sut = new ReflectionMethod($enderecoDestinatario, 'validateTagElements');
                $sutResponse = $sut->invoke($enderecoDestinatario, $xmlElement);
                expect($sutResponse->isFailure())->toBeTrue();
            });
        });

        describe('validateTagValue', function () {
            test('Should fail if a value is provided', function () {
                $xmlString = '<enderDest>aValue<xLgr></xLgr><nro></nro><xBairro></xBairro><cMun></cMun><xMun></xMun><UF></UF><CEP></CEP></enderDest>';
                $xmlElement = new Element;
                $xmlElement->parse($xmlString);
                $enderecoDestinatario = new EnderecoDestinatario;
                $sut = new ReflectionMethod($enderecoDestinatario, 'validateTagValue');
                $sutResponse = $sut->invoke($enderecoDestinatario, $xmlElement);
                expect($sutResponse->isFailure())->toBeTrue();
            });
        });
    });
});
