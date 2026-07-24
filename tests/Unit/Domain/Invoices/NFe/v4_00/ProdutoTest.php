<?php

declare(strict_types=1);

use BradiApi\Domain\Common\Protocols\ApiError;
use BradiApi\Domain\Invoices\NFe\v4_00\Produto;
use BradiApi\Domain\Invoices\Templates\DFeElement;
use BradiApi\Domain\Xml\ValueObjects\Element;
use BradiApi\Tests\TestCase;

describe('Produto', function () {
    test('Should succeed if Produto is declared', function () {
        $nameSpace = 'BradiApi\Domain\Invoices\NFe\v4_00';
        $sut = $nameSpace . '\\Produto';
        expect(class_exists($sut))->toBeTrue();
    });

    test('Should succeed if Produto extends DFeElement', function () {
        $sut = new Produto;
        expect(is_subclass_of($sut, DFeElement::class))->toBeTrue();
    });

    beforeEach(function () {
        /** @var TestCase $this */
        $this->sut = new Produto;
    });

    describe('properties', function () {
        describe('$cProd', function () {
            test('Should be declared', function () {
                $sut = new Produto;
                expect($sut)->toHaveProperty('cProd');
            });

            test('Should be a subclass of DFeElement::class', function () {
                $reflection = new ReflectionClass(Produto::class);
                $reflectedProperty = $reflection->getProperty('cProd');
                $sut = $reflectedProperty->getType();
                expect((is_subclass_of($sut->getName(), DFeElement::class)))->toBeTrue();
            });

            test('Should be required', function () {
                $reflection = new ReflectionClass(Produto::class);
                $reflectedProperty = $reflection->getProperty('cProd');
                $sut = $reflectedProperty->getType();
                expect($sut->allowsNull())->toBeFalse();
            });
        });

        describe('$cEAN', function () {
            test('Should be declared', function () {
                $sut = new Produto;
                expect($sut)->toHaveProperty('cEAN');
            });

            test('Should be a subclass of DFeElement::class', function () {
                $reflection = new ReflectionClass(Produto::class);
                $reflectedProperty = $reflection->getProperty('cEAN');
                $sut = $reflectedProperty->getType();
                expect((is_subclass_of($sut->getName(), DFeElement::class)))->toBeTrue();
            });

            test('Should be required', function () {
                $reflection = new ReflectionClass(Produto::class);
                $reflectedProperty = $reflection->getProperty('cEAN');
                $sut = $reflectedProperty->getType();
                expect($sut->allowsNull())->toBeFalse();
            });
        });

        describe('$xProd', function () {
            test('Should be declared', function () {
                $sut = new Produto;
                expect($sut)->toHaveProperty('xProd');
            });

            test('Should be a subclass of DFeElement::class', function () {
                $reflection = new ReflectionClass(Produto::class);
                $reflectedProperty = $reflection->getProperty('xProd');
                $sut = $reflectedProperty->getType();
                expect((is_subclass_of($sut->getName(), DFeElement::class)))->toBeTrue();
            });

            test('Should be required', function () {
                $reflection = new ReflectionClass(Produto::class);
                $reflectedProperty = $reflection->getProperty('xProd');
                $sut = $reflectedProperty->getType();
                expect($sut->allowsNull())->toBeFalse();
            });
        });

        describe('$NCM', function () {
            test('Should be declared', function () {
                $sut = new Produto;
                expect($sut)->toHaveProperty('NCM');
            });

            test('Should be a subclass of DFeElement::class', function () {
                $reflection = new ReflectionClass(Produto::class);
                $reflectedProperty = $reflection->getProperty('NCM');
                $sut = $reflectedProperty->getType();
                expect((is_subclass_of($sut->getName(), DFeElement::class)))->toBeTrue();
            });

            test('Should be required', function () {
                $reflection = new ReflectionClass(Produto::class);
                $reflectedProperty = $reflection->getProperty('NCM');
                $sut = $reflectedProperty->getType();
                expect($sut->allowsNull())->toBeFalse();
            });
        });

        describe('$CFOP', function () {
            test('Should be declared', function () {
                $sut = new Produto;
                expect($sut)->toHaveProperty('CFOP');
            });

            test('Should be a subclass of DFeElement::class', function () {
                $reflection = new ReflectionClass(Produto::class);
                $reflectedProperty = $reflection->getProperty('CFOP');
                $sut = $reflectedProperty->getType();
                expect((is_subclass_of($sut->getName(), DFeElement::class)))->toBeTrue();
            });

            test('Should be required', function () {
                $reflection = new ReflectionClass(Produto::class);
                $reflectedProperty = $reflection->getProperty('CFOP');
                $sut = $reflectedProperty->getType();
                expect($sut->allowsNull())->toBeFalse();
            });
        });

        describe('$uCom', function () {
            test('Should be declared', function () {
                $sut = new Produto;
                expect($sut)->toHaveProperty('uCom');
            });

            test('Should be a subclass of DFeElement::class', function () {
                $reflection = new ReflectionClass(Produto::class);
                $reflectedProperty = $reflection->getProperty('uCom');
                $sut = $reflectedProperty->getType();
                expect((is_subclass_of($sut->getName(), DFeElement::class)))->toBeTrue();
            });

            test('Should be required', function () {
                $reflection = new ReflectionClass(Produto::class);
                $reflectedProperty = $reflection->getProperty('uCom');
                $sut = $reflectedProperty->getType();
                expect($sut->allowsNull())->toBeFalse();
            });
        });

        describe('$qCom', function () {
            test('Should be declared', function () {
                $sut = new Produto;
                expect($sut)->toHaveProperty('qCom');
            });

            test('Should be a subclass of DFeElement::class', function () {
                $reflection = new ReflectionClass(Produto::class);
                $reflectedProperty = $reflection->getProperty('qCom');
                $sut = $reflectedProperty->getType();
                expect((is_subclass_of($sut->getName(), DFeElement::class)))->toBeTrue();
            });

            test('Should be required', function () {
                $reflection = new ReflectionClass(Produto::class);
                $reflectedProperty = $reflection->getProperty('qCom');
                $sut = $reflectedProperty->getType();
                expect($sut->allowsNull())->toBeFalse();
            });
        });

        describe('$vUnCom', function () {
            test('Should be declared', function () {
                $sut = new Produto;
                expect($sut)->toHaveProperty('vUnCom');
            });

            test('Should be a subclass of DFeElement::class', function () {
                $reflection = new ReflectionClass(Produto::class);
                $reflectedProperty = $reflection->getProperty('vUnCom');
                $sut = $reflectedProperty->getType();
                expect((is_subclass_of($sut->getName(), DFeElement::class)))->toBeTrue();
            });

            test('Should be required', function () {
                $reflection = new ReflectionClass(Produto::class);
                $reflectedProperty = $reflection->getProperty('vUnCom');
                $sut = $reflectedProperty->getType();
                expect($sut->allowsNull())->toBeFalse();
            });
        });

        describe('$vProd', function () {
            test('Should be declared', function () {
                $sut = new Produto;
                expect($sut)->toHaveProperty('vProd');
            });

            test('Should be a subclass of DFeElement::class', function () {
                $reflection = new ReflectionClass(Produto::class);
                $reflectedProperty = $reflection->getProperty('vProd');
                $sut = $reflectedProperty->getType();
                expect((is_subclass_of($sut->getName(), DFeElement::class)))->toBeTrue();
            });

            test('Should be required', function () {
                $reflection = new ReflectionClass(Produto::class);
                $reflectedProperty = $reflection->getProperty('vProd');
                $sut = $reflectedProperty->getType();
                expect($sut->allowsNull())->toBeFalse();
            });
        });
    });

    describe('methods', function () {
        describe('validateTagAttributes', function () {
            test('Should fail if an attribute is provided', function () {
                $xmlString = '<prod attribute="value"><cProd></cProd><cEAN></cEAN><xProd></xProd><NCM></NCM><CFOP></CFOP><uCom></uCom><qCom></qCom><vUnCom></vUnCom><vProd></vProd></prod>';
                $xmlElement = new Element;
                $xmlElement->parse($xmlString);
                $produto = new Produto;
                $sut = new ReflectionMethod($produto, 'validateTagAttributes');
                $sutResponse = $sut->invoke($produto, $xmlElement);
                expect($sutResponse->isFailure())->toBeTrue();
            });
        });

        describe('validateTagElements', function () {
            test('Should succeed if all required tags is provided', function () {
                $xmlString = '<prod><cProd></cProd><cEAN></cEAN><xProd></xProd><NCM></NCM><CFOP></CFOP><uCom></uCom><qCom></qCom><vUnCom></vUnCom><vProd></vProd></prod>';
                $xmlElement = new Element;
                $xmlElement->parse($xmlString);
                $produto = new Produto;
                $sut = new ReflectionMethod($produto, 'validateTagElements');
                $sutResponse = $sut->invoke($produto, $xmlElement);
                expect($sutResponse->isSuccess())->toBeTrue();
            });

            test('Should succeed if all tags is provided', function () {
                $xmlString = '<prod><cProd/><cEAN/><xProd/><NCM/><NVE/><CEST/><indEscala/><CNPJFab/><cBenef/><EXTIPI/><CFOP/><uCom/><qCom/><vUnCom/><vProd/><cEANTrib/><uTrib/><qTrib/><vUnTrib/><vFrete/><vSeg/><vDesc/><vOutro/><indTot/><DI/><detExport/><xPed/><nItemPed/><nFCI/><rastro/><veicProd/><med/><arma/><comb/><nRECOPI/></prod>';
                $xmlElement = new Element;
                $xmlElement->parse($xmlString);
                $produto = new Produto;
                $sut = new ReflectionMethod($produto, 'validateTagElements');
                $sutResponse = $sut->invoke($produto, $xmlElement);
                expect($sutResponse->isSuccess())->toBeTrue();
            });

            test('Should fail if cProd tag isnt provided', function () {
                $xmlString = '<prod><cEAN></cEAN><xProd></xProd><NCM></NCM><CFOP></CFOP><uCom></uCom><qCom></qCom><vUnCom></vUnCom><vProd></vProd></prod>';
                $xmlElement = new Element;
                $xmlElement->parse($xmlString);
                $produto = new Produto;
                $sut = new ReflectionMethod($produto, 'validateTagElements');
                $sutResponse = $sut->invoke($produto, $xmlElement);
                expect($sutResponse->isFailure())->toBeTrue();
            });

            test('Should fail if cEAN tag isnt provided', function () {
                $xmlString = '<prod><cProd></cProd><xProd></xProd><NCM></NCM><CFOP></CFOP><uCom></uCom><qCom></qCom><vUnCom></vUnCom><vProd></vProd></prod>';
                $xmlElement = new Element;
                $xmlElement->parse($xmlString);
                $produto = new Produto;
                $sut = new ReflectionMethod($produto, 'validateTagElements');
                $sutResponse = $sut->invoke($produto, $xmlElement);
                expect($sutResponse->isFailure())->toBeTrue();
            });

            test('Should fail if xProd tag isnt provided', function () {
                $xmlString = '<prod><cProd></cProd><cEAN></cEAN><NCM></NCM><CFOP></CFOP><uCom></uCom><qCom></qCom><vUnCom></vUnCom><vProd></vProd></prod>';
                $xmlElement = new Element;
                $xmlElement->parse($xmlString);
                $produto = new Produto;
                $sut = new ReflectionMethod($produto, 'validateTagElements');
                $sutResponse = $sut->invoke($produto, $xmlElement);
                expect($sutResponse->isFailure())->toBeTrue();
            });

            test('Should fail if NCM tag isnt provided', function () {
                $xmlString = '<prod><cProd></cProd><cEAN></cEAN><xProd></xProd><CFOP></CFOP><uCom></uCom><qCom></qCom><vUnCom></vUnCom><vProd></vProd></prod>';
                $xmlElement = new Element;
                $xmlElement->parse($xmlString);
                $produto = new Produto;
                $sut = new ReflectionMethod($produto, 'validateTagElements');
                $sutResponse = $sut->invoke($produto, $xmlElement);
                expect($sutResponse->isFailure())->toBeTrue();
            });

            test('Should fail if CFOP tag isnt provided', function () {
                $xmlString = '<prod><cProd></cProd><cEAN></cEAN><xProd></xProd><NCM></NCM><uCom></uCom><qCom></qCom><vUnCom></vUnCom><vProd></vProd></prod>';
                $xmlElement = new Element;
                $xmlElement->parse($xmlString);
                $produto = new Produto;
                $sut = new ReflectionMethod($produto, 'validateTagElements');
                $sutResponse = $sut->invoke($produto, $xmlElement);
                expect($sutResponse->isFailure())->toBeTrue();
            });

            test('Should fail if uCom tag isnt provided', function () {
                $xmlString = '<prod><cProd></cProd><cEAN></cEAN><xProd></xProd><NCM></NCM><CFOP></CFOP><qCom></qCom><vUnCom></vUnCom><vProd></vProd></prod>';
                $xmlElement = new Element;
                $xmlElement->parse($xmlString);
                $produto = new Produto;
                $sut = new ReflectionMethod($produto, 'validateTagElements');
                $sutResponse = $sut->invoke($produto, $xmlElement);
                expect($sutResponse->isFailure())->toBeTrue();
            });

            test('Should fail if qCom tag isnt provided', function () {
                $xmlString = '<prod><cProd></cProd><cEAN></cEAN><xProd></xProd><NCM></NCM><CFOP></CFOP><uCom></uCom><vUnCom></vUnCom><vProd></vProd></prod>';
                $xmlElement = new Element;
                $xmlElement->parse($xmlString);
                $produto = new Produto;
                $sut = new ReflectionMethod($produto, 'validateTagElements');
                $sutResponse = $sut->invoke($produto, $xmlElement);
                expect($sutResponse->isFailure())->toBeTrue();
            });

            test('Should fail if vUnCom tag isnt provided', function () {
                $xmlString = '<prod><cProd></cProd><cEAN></cEAN><xProd></xProd><NCM></NCM><CFOP></CFOP><uCom></uCom><qCom></qCom><vProd></vProd></prod>';
                $xmlElement = new Element;
                $xmlElement->parse($xmlString);
                $produto = new Produto;
                $sut = new ReflectionMethod($produto, 'validateTagElements');
                $sutResponse = $sut->invoke($produto, $xmlElement);
                expect($sutResponse->isFailure())->toBeTrue();
            });

            test('Should fail if vProd tag isnt provided', function () {
                $xmlString = '<prod><cProd></cProd><cEAN></cEAN><xProd></xProd><NCM></NCM><CFOP></CFOP><uCom></uCom><qCom></qCom><vUnCom></vUnCom></prod>';
                $xmlElement = new Element;
                $xmlElement->parse($xmlString);
                $produto = new Produto;
                $sut = new ReflectionMethod($produto, 'validateTagElements');
                $sutResponse = $sut->invoke($produto, $xmlElement);
                expect($sutResponse->isFailure())->toBeTrue();
            });

            test('Should fail if an unallowed tag is provided', function () {
                $xmlString = '<prod><unallowed></unallowed><cProd></cProd><cEAN></cEAN><xProd></xProd><NCM></NCM><CFOP></CFOP><uCom></uCom><qCom></qCom><vUnCom></vUnCom><vProd></vProd></prod>';
                $xmlElement = new Element;
                $xmlElement->parse($xmlString);
                $produto = new Produto;
                $sut = new ReflectionMethod($produto, 'validateTagElements');
                $sutResponse = $sut->invoke($produto, $xmlElement);
                expect($sutResponse->isFailure())->toBeTrue();
            });
        });

        describe('validateTagValue', function () {
            test('Should fail if a value is provided', function () {
                $xmlString = '<prod>value</prod>';
                $xmlElement = new Element;
                $xmlElement->parse($xmlString);
                $produto = new Produto;
                $sut = new ReflectionMethod($produto, 'validateTagValue');
                $sutResponse = $sut->invoke($produto, $xmlElement);
                expect($sutResponse->isFailure())->toBeTrue();
                expect($sutResponse->getError())->toBeInstanceOf(ApiError::class);
            });
        });
    });
});
