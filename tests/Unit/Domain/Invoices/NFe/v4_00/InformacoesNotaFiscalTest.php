<?php

declare(strict_types=1);

use BradiApi\Domain\Invoices\NFe\v4_00\InformacoesNotaFiscal;
use BradiApi\Domain\Invoices\Templates\DFeAttribute;
use BradiApi\Domain\Invoices\Templates\DFeElement;
use BradiApi\Domain\Invoices\Templates\DFeElementCollection;
use BradiApi\Domain\Xml\ValueObjects\Element;

describe('InformacoesNotaFiscal', function () {
    test('Should succeed if InformacoesNotaFiscal is declared', function () {
        $nameSpace = 'BradiApi\Domain\Invoices\NFe\v4_00';
        $sut = $nameSpace . '\\InformacoesNotaFiscal';
        expect(class_exists($sut))->toBeTrue();
    });

    test('Should succeed if InformacoesNotaFiscal extends DFeElement', function () {
        $sut = new InformacoesNotaFiscal;
        expect(is_subclass_of($sut, DFeElement::class))->toBeTrue();
    });

    describe('properties', function () {
        describe('$versao', function () {
            test('Should be declared', function () {
                $sut = new InformacoesNotaFiscal;
                expect($sut)->toHaveProperty('versao');
            });

            test('Should be a subclass of DFeAttribute::class', function () {
                $reflection = new ReflectionClass(InformacoesNotaFiscal::class);
                $reflectedProperty = $reflection->getProperty('versao');
                $sut = $reflectedProperty->getType();

                expect((is_subclass_of($sut->getName(), DFeAttribute::class)))->toBeTrue();
            })->skip();

            test('Should be requited', function () {
                $reflection = new ReflectionClass(InformacoesNotaFiscal::class);
                $reflectedProperty = $reflection->getProperty('versao');
                $sut = $reflectedProperty->getType();

                expect($sut->allowsNull())->toBeFalse();
            });
        });

        describe('$ide', function () {
            test('Should be declared', function () {
                $sut = new InformacoesNotaFiscal;
                expect($sut)->toHaveProperty('ide');
            });

            test('Should be a subclass of DFeElement::class', function () {
                $reflection = new ReflectionClass(InformacoesNotaFiscal::class);
                $reflectedProperty = $reflection->getProperty('ide');
                $sut = $reflectedProperty->getType();
                expect((is_subclass_of($sut->getName(), DFeElement::class)))->toBeTrue();
            });

            test('Should be requited', function () {
                $reflection = new ReflectionClass(InformacoesNotaFiscal::class);
                $reflectedProperty = $reflection->getProperty('ide');
                $sut = $reflectedProperty->getType();
                expect($sut->allowsNull())->toBeFalse();
            });
        });

        describe('$emit', function () {
            test('Should be declared', function () {
                $sut = new InformacoesNotaFiscal;
                expect($sut)->toHaveProperty('emit');
            });

            test('Should be a subclass of DFeElement::class', function () {
                $reflection = new ReflectionClass(InformacoesNotaFiscal::class);
                $reflectedProperty = $reflection->getProperty('emit');
                $sut = $reflectedProperty->getType();
                expect((is_subclass_of($sut->getName(), DFeElement::class)))->toBeTrue();
            });

            test('Should be required', function () {
                $reflection = new ReflectionClass(InformacoesNotaFiscal::class);
                $reflectedProperty = $reflection->getProperty('emit');
                $sut = $reflectedProperty->getType();
                expect($sut->allowsNull())->toBeFalse();
            });
        });

        describe('$avulsa', function () {
            test('Should be declared', function () {
                $sut = new InformacoesNotaFiscal;
                expect($sut)->toHaveProperty('avulsa');
            });

            test('Should be a subclass of DFeElement::class', function () {
                $reflection = new ReflectionClass(InformacoesNotaFiscal::class);
                $reflectedProperty = $reflection->getProperty('avulsa');
                $sut = $reflectedProperty->getType();
                expect((is_subclass_of($sut->getName(), DFeElement::class)))->toBeTrue();
            });

            test('Should be optional', function () {
                $reflection = new ReflectionClass(InformacoesNotaFiscal::class);
                $reflectedProperty = $reflection->getProperty('avulsa');
                $sut = $reflectedProperty->getType();

                expect($sut->allowsNull())->toBeTrue();
            });
        })->skip();

        describe('$dest', function () {
            test('Should be declared', function () {
                $sut = new InformacoesNotaFiscal;
                expect($sut)->toHaveProperty('dest');
            });

            test('Should be a subclass of DFeElement::class', function () {
                $reflection = new ReflectionClass(InformacoesNotaFiscal::class);
                $reflectedProperty = $reflection->getProperty('dest');
                $sut = $reflectedProperty->getType();
                expect((is_subclass_of($sut->getName(), DFeElement::class)))->toBeTrue();
            });

            test('Should be optional', function () {
                $reflection = new ReflectionClass(InformacoesNotaFiscal::class);
                $reflectedProperty = $reflection->getProperty('dest');
                $sut = $reflectedProperty->getType();
                expect($sut->allowsNull())->toBeTrue();
            });
        });

        describe('$retirada', function () {
            test('Should be declared', function () {
                $sut = new InformacoesNotaFiscal;
                expect($sut)->toHaveProperty('retirada');
            });

            test('Should be a subclass of DFeElement::class', function () {
                $reflection = new ReflectionClass(InformacoesNotaFiscal::class);
                $reflectedProperty = $reflection->getProperty('retirada');
                $sut = $reflectedProperty->getType();
                expect((is_subclass_of($sut->getName(), DFeElement::class)))->toBeTrue();
            });

            test('Should be optional', function () {
                $reflection = new ReflectionClass(InformacoesNotaFiscal::class);
                $reflectedProperty = $reflection->getProperty('retirada');
                $sut = $reflectedProperty->getType();

                expect($sut->allowsNull())->toBeTrue();
            });
        })->skip();

        describe('$entrega', function () {
            test('Should be declared', function () {
                $sut = new InformacoesNotaFiscal;
                expect($sut)->toHaveProperty('entrega');
            });

            test('Should be a subclass of DFeElement::class', function () {
                $reflection = new ReflectionClass(InformacoesNotaFiscal::class);
                $reflectedProperty = $reflection->getProperty('entrega');
                $sut = $reflectedProperty->getType();
                expect((is_subclass_of($sut->getName(), DFeElement::class)))->toBeTrue();
            });

            test('Should be optional', function () {
                $reflection = new ReflectionClass(InformacoesNotaFiscal::class);
                $reflectedProperty = $reflection->getProperty('entrega');
                $sut = $reflectedProperty->getType();
                expect($sut->allowsNull())->toBeTrue();
            });
        })->skip();

        describe('$autXMLCollection', function () {
            test('Should be declared', function () {
                $sut = new InformacoesNotaFiscal;
                expect($sut)->toHaveProperty('autXMLCollection');
            });

            test('Should be a subclass of DFeElementCollection::class', function () {
                $reflection = new ReflectionClass(InformacoesNotaFiscal::class);
                $reflectedProperty = $reflection->getProperty('autXMLCollection');
                $sut = $reflectedProperty->getType();
                expect((is_subclass_of($sut->getName(), DFeElementCollection::class)))->toBeTrue();
            });

            test('Should be required', function () {
                $reflection = new ReflectionClass(InformacoesNotaFiscal::class);
                $reflectedProperty = $reflection->getProperty('autXMLCollection');
                $sut = $reflectedProperty->getType();
                expect($sut->allowsNull())->toBeFalse();
            });
        })->skip();

        describe('$detCollection', function () {
            test('Should be declared', function () {
                $sut = new InformacoesNotaFiscal;
                expect($sut)->toHaveProperty('detCollection');
            });

            test('Should be a subclass of DFeElementCollection::class', function () {
                $reflection = new ReflectionClass(InformacoesNotaFiscal::class);
                $reflectedProperty = $reflection->getProperty('detCollection');
                $sut = $reflectedProperty->getType();
                expect((is_subclass_of($sut->getName(), DFeElementCollection::class)))->toBeTrue();
            });

            test('Should be required', function () {
                $reflection = new ReflectionClass(InformacoesNotaFiscal::class);
                $reflectedProperty = $reflection->getProperty('detCollection');
                $sut = $reflectedProperty->getType();
                expect($sut->allowsNull())->toBeFalse();
            });
        })->skip();

        describe('$total', function () {
            test('Should be declared', function () {
                $sut = new InformacoesNotaFiscal;
                expect($sut)->toHaveProperty('total');
            });

            test('Should be a subclass of DFeElement::class', function () {
                $reflection = new ReflectionClass(InformacoesNotaFiscal::class);
                $reflectedProperty = $reflection->getProperty('total');
                $sut = $reflectedProperty->getType();
                expect((is_subclass_of($sut->getName(), DFeElement::class)))->toBeTrue();
            });

            test('Should be required', function () {
                $reflection = new ReflectionClass(InformacoesNotaFiscal::class);
                $reflectedProperty = $reflection->getProperty('total');
                $sut = $reflectedProperty->getType();
                expect($sut->allowsNull())->toBeFalse();
            });
        })->skip();

        describe('$transp', function () {
            test('Should be declared', function () {
                $sut = new InformacoesNotaFiscal;
                expect($sut)->toHaveProperty('transp');
            });

            test('Should be a subclass of DFeElement::class', function () {
                $reflection = new ReflectionClass(InformacoesNotaFiscal::class);
                $reflectedProperty = $reflection->getProperty('transp');
                $sut = $reflectedProperty->getType();
                expect((is_subclass_of($sut->getName(), DFeElement::class)))->toBeTrue();
            });

            test('Should be required', function () {
                $reflection = new ReflectionClass(InformacoesNotaFiscal::class);
                $reflectedProperty = $reflection->getProperty('transp');
                $sut = $reflectedProperty->getType();
                expect($sut->allowsNull())->toBeFalse();
            });
        })->skip();

        describe('$cobr', function () {
            test('Should be declared', function () {
                $sut = new InformacoesNotaFiscal;
                expect($sut)->toHaveProperty('cobr');
            });

            test('Should be a subclass of DFeElement::class', function () {
                $reflection = new ReflectionClass(InformacoesNotaFiscal::class);
                $reflectedProperty = $reflection->getProperty('cobr');
                $sut = $reflectedProperty->getType();
                expect((is_subclass_of($sut->getName(), DFeElement::class)))->toBeTrue();
            });

            test('Should be optional', function () {
                $reflection = new ReflectionClass(InformacoesNotaFiscal::class);
                $reflectedProperty = $reflection->getProperty('cobr');
                $sut = $reflectedProperty->getType();
                expect($sut->allowsNull())->toBeTrue();
            });
        })->skip();

        describe('$pag', function () {
            test('Should be declared', function () {
                $sut = new InformacoesNotaFiscal;
                expect($sut)->toHaveProperty('pag');
            });

            test('Should be a subclass of DFeElement::class', function () {
                $reflection = new ReflectionClass(InformacoesNotaFiscal::class);
                $reflectedProperty = $reflection->getProperty('pag');
                $sut = $reflectedProperty->getType();
                expect((is_subclass_of($sut->getName(), DFeElement::class)))->toBeTrue();
            });

            test('Should be required', function () {
                $reflection = new ReflectionClass(InformacoesNotaFiscal::class);
                $reflectedProperty = $reflection->getProperty('pag');
                $sut = $reflectedProperty->getType();
                expect($sut->allowsNull())->toBeFalse();
            });
        })->skip();

        describe('$infIntermed', function () {
            test('Should be declared', function () {
                $sut = new InformacoesNotaFiscal;
                expect($sut)->toHaveProperty('infIntermed');
            });

            test('Should be a subclass of DFeElement::class', function () {
                $reflection = new ReflectionClass(InformacoesNotaFiscal::class);
                $reflectedProperty = $reflection->getProperty('infIntermed');
                $sut = $reflectedProperty->getType();
                expect((is_subclass_of($sut->getName(), DFeElement::class)))->toBeTrue();
            });

            test('Should be optional', function () {
                $reflection = new ReflectionClass(InformacoesNotaFiscal::class);
                $reflectedProperty = $reflection->getProperty('infIntermed');
                $sut = $reflectedProperty->getType();
                expect($sut->allowsNull())->toBeTrue();
            });
        })->skip();

        describe('$infAdic', function () {
            test('Should be declared', function () {
                $sut = new InformacoesNotaFiscal;
                expect($sut)->toHaveProperty('infAdic');
            });

            test('Should be a subclass of DFeElement::class', function () {
                $reflection = new ReflectionClass(InformacoesNotaFiscal::class);
                $reflectedProperty = $reflection->getProperty('infAdic');
                $sut = $reflectedProperty->getType();
                expect((is_subclass_of($sut->getName(), DFeElement::class)))->toBeTrue();
            });

            test('Should be optional', function () {
                $reflection = new ReflectionClass(InformacoesNotaFiscal::class);
                $reflectedProperty = $reflection->getProperty('infAdic');
                $sut = $reflectedProperty->getType();
                expect($sut->allowsNull())->toBeTrue();
            });
        })->skip();

        describe('$exporta', function () {
            test('Should be declared', function () {
                $sut = new InformacoesNotaFiscal;
                expect($sut)->toHaveProperty('exporta');
            });

            test('Should be a subclass of DFeElement::class', function () {
                $reflection = new ReflectionClass(InformacoesNotaFiscal::class);
                $reflectedProperty = $reflection->getProperty('exporta');
                $sut = $reflectedProperty->getType();
                expect((is_subclass_of($sut->getName(), DFeElement::class)))->toBeTrue();
            });

            test('Should be optional', function () {
                $reflection = new ReflectionClass(InformacoesNotaFiscal::class);
                $reflectedProperty = $reflection->getProperty('exporta');
                $sut = $reflectedProperty->getType();
                expect($sut->allowsNull())->toBeTrue();
            });
        })->skip();

        describe('$compra', function () {
            test('Should be declared', function () {
                $sut = new InformacoesNotaFiscal;
                expect($sut)->toHaveProperty('compra');
            });

            test('Should be a subclass of DFeElement::class', function () {
                $reflection = new ReflectionClass(InformacoesNotaFiscal::class);
                $reflectedProperty = $reflection->getProperty('compra');
                $sut = $reflectedProperty->getType();
                expect((is_subclass_of($sut->getName(), DFeElement::class)))->toBeTrue();
            });

            test('Should be optional', function () {
                $reflection = new ReflectionClass(InformacoesNotaFiscal::class);
                $reflectedProperty = $reflection->getProperty('compra');
                $sut = $reflectedProperty->getType();
                expect($sut->allowsNull())->toBeTrue();
            });
        })->skip();

        describe('$cana', function () {
            test('Should be declared', function () {
                $sut = new InformacoesNotaFiscal;
                expect($sut)->toHaveProperty('cana');
            });

            test('Should be a subclass of DFeElement::class', function () {
                $reflection = new ReflectionClass(InformacoesNotaFiscal::class);
                $reflectedProperty = $reflection->getProperty('cana');
                $sut = $reflectedProperty->getType();
                expect((is_subclass_of($sut->getName(), DFeElement::class)))->toBeTrue();
            });

            test('Should be required', function () {
                $reflection = new ReflectionClass(InformacoesNotaFiscal::class);
                $reflectedProperty = $reflection->getProperty('cana');
                $sut = $reflectedProperty->getType();
                expect($sut->allowsNull())->toBeFalse();
            });
        })->skip();

        describe('$infRespTec', function () {
            test('Should be declared', function () {
                $sut = new InformacoesNotaFiscal;
                expect($sut)->toHaveProperty('infRespTec');
            });

            test('Should be a subclass of DFeElement::class', function () {
                $reflection = new ReflectionClass(InformacoesNotaFiscal::class);
                $reflectedProperty = $reflection->getProperty('infRespTec');
                $sut = $reflectedProperty->getType();
                expect((is_subclass_of($sut->getName(), DFeElement::class)))->toBeTrue();
            });

            test('Should be required', function () {
                $reflection = new ReflectionClass(InformacoesNotaFiscal::class);
                $reflectedProperty = $reflection->getProperty('infRespTec');
                $sut = $reflectedProperty->getType();
                expect($sut->allowsNull())->toBeFalse();
            });
        })->skip();
    });

    describe('methods', function () {
        describe('parserFromXmlElement', function () {
            test('Should fail if Id attribute isnt provided', function () {
                $xmlString = '<infNFe versao="4.00"><ide></ide><emit></emit><det nItem="1"></det><total></total><transp></transp><pag></pag><infAdic></infAdic><infRespTec></infRespTec></infNFe>';
                $xmlElement = new Element;
                $xmlElement->parse($xmlString);
                $sut = new InformacoesNotaFiscal;
                $sutParsingResult = $sut->parseFromXmlElement($xmlElement);
                expect($sutParsingResult->isFailure())->toBeTrue();
            })->skip();

            test('Should fail if versao attribute isnt provided', function () {
                $xmlString = '<infNFe Id="NFe11260602393780000102550020009487041538119784"><ide></ide><emit></emit><det nItem="1"></det><total></total><transp></transp><pag></pag><infAdic></infAdic><infRespTec></infRespTec></infNFe>';
                $xmlElement = new Element;
                $xmlElement->parse($xmlString);
                $sut = new InformacoesNotaFiscal;
                $sutParsingResult = $sut->parseFromXmlElement($xmlElement);
                expect($sutParsingResult->isFailure())->toBeTrue();
            })->skip();

            test('Should fail if ide tag isnt provided', function () {
                $xmlString = '<infNFe Id="NFe11260602393780000102550020009487041538119784" versao="4.00"><emit></emit><det nItem="1"></det><total></total><transp></transp><pag></pag><infAdic></infAdic><infRespTec></infRespTec></infNFe>';
                $xmlElement = new Element;
                $xmlElement->parse($xmlString);
                $sut = new InformacoesNotaFiscal;
                $sutParsingResult = $sut->parseFromXmlElement($xmlElement);
                expect($sutParsingResult->isFailure())->toBeTrue();
            })->skip();

            test('Should fail if emit tag isnt provided', function () {
                $xmlString = '<infNFe Id="NFe11260602393780000102550020009487041538119784" versao="4.00"><ide></ide><det nItem="1"></det><total></total><transp></transp><pag></pag><infAdic></infAdic><infRespTec></infRespTec></infNFe>';
                $xmlElement = new Element;
                $xmlElement->parse($xmlString);
                $sut = new InformacoesNotaFiscal;
                $sutParsingResult = $sut->parseFromXmlElement($xmlElement);
                expect($sutParsingResult->isFailure())->toBeTrue();
            })->skip();

            test('Should fail if det tag isnt provided', function () {
                $xmlString = '<infNFe Id="NFe11260602393780000102550020009487041538119784" versao="4.00"><ide></ide><emit></emit><total></total><transp></transp><pag></pag><infAdic></infAdic><infRespTec></infRespTec></infNFe>';
                $xmlElement = new Element;
                $xmlElement->parse($xmlString);
                $sut = new InformacoesNotaFiscal;
                $sutParsingResult = $sut->parseFromXmlElement($xmlElement);
                expect($sutParsingResult->isFailure())->toBeTrue();
            })->skip();

            test('Should fail if total tag isnt provided', function () {
                $xmlString = '<infNFe Id="NFe11260602393780000102550020009487041538119784" versao="4.00"><ide></ide><emit></emit><det nItem="1"></det><transp></transp><pag></pag><infAdic></infAdic><infRespTec></infRespTec></infNFe>';
                $xmlElement = new Element;
                $xmlElement->parse($xmlString);
                $sut = new InformacoesNotaFiscal;
                $sutParsingResult = $sut->parseFromXmlElement($xmlElement);
                expect($sutParsingResult->isFailure())->toBeTrue();
            })->skip();

            test('Should fail if transp tag isnt provided', function () {
                $xmlString = '<infNFe Id="NFe11260602393780000102550020009487041538119784" versao="4.00"><ide></ide><emit></emit><det nItem="1"></det><total></total><pag></pag><infAdic></infAdic><infRespTec></infRespTec></infNFe>';
                $xmlElement = new Element;
                $xmlElement->parse($xmlString);
                $sut = new InformacoesNotaFiscal;
                $sutParsingResult = $sut->parseFromXmlElement($xmlElement);
                expect($sutParsingResult->isFailure())->toBeTrue();
            })->skip();

            test('Should fail if pag tag isnt provided', function () {
                $xmlString = '<infNFe Id="NFe11260602393780000102550020009487041538119784" versao="4.00"><ide></ide><emit></emit><det nItem="1"></det><total></total><transp></transp><infAdic></infAdic><infRespTec></infRespTec></infNFe>';
                $xmlElement = new Element;
                $xmlElement->parse($xmlString);
                $sut = new InformacoesNotaFiscal;
                $sutParsingResult = $sut->parseFromXmlElement($xmlElement);
                expect($sutParsingResult->isFailure())->toBeTrue();
            })->skip();

            test('Should fail if unallowed tag is provided', function () {
                $xmlString = '<infNFe Id="NFe11260602393780000102550020009487041538119784" versao="4.00"><ide></ide><emit></emit><det nItem="1"></det><total></total><transp></transp><pag></pag><infAdic></infAdic><infRespTec></infRespTec><unallowed/></infNFe>';
                $xmlElement = new Element;
                $xmlElement->parse($xmlString);
                $sut = new InformacoesNotaFiscal;
                $sutParsingResult = $sut->parseFromXmlElement($xmlElement);
                expect($sutParsingResult->isFailure())->toBeTrue();
            })->skip();
        });
    });
});
