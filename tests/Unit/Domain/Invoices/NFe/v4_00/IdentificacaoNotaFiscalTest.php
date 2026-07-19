<?php

declare(strict_types=1);

use BradiApi\Domain\Invoices\NFe\v4_00\IdentificacaoNotaFiscal;
use BradiApi\Domain\Invoices\Templates\DFeElement;
use BradiApi\Domain\Invoices\Templates\DFeElementCollection;
use BradiApi\Domain\Xml\ValueObjects\Element;

describe('IdentificacaoNotaFiscal', function () {
    test('Should succeed if IdentificacaoNotaFiscal is declared', function () {
        $nameSpace = 'BradiApi\Domain\Invoices\NFe\v4_00';
        $sut = $nameSpace . '\\IdentificacaoNotaFiscal';
        expect(class_exists($sut))->toBeTrue();
    });

    test('Should succeed if IdentificacaoNotaFiscal extends DFeElement', function () {
        $sut = new IdentificacaoNotaFiscal;
        expect(is_subclass_of($sut, DFeElement::class))->toBeTrue();
    });

    describe('properties', function () {
        describe('$cUF', function () {
            test('Should be declared', function () {
                $sut = new IdentificacaoNotaFiscal;
                expect($sut)->toHaveProperty('cUF');
            });

            test('Should be a subclass of DFeElement::class', function () {
                $reflection = new ReflectionClass(IdentificacaoNotaFiscal::class);
                $reflectedProperty = $reflection->getProperty('cUF');
                $sut = $reflectedProperty->getType();
                expect((is_subclass_of($sut->getName(), DFeElement::class)))->toBeTrue();
            });

            test('Should be required', function () {
                $reflection = new ReflectionClass(IdentificacaoNotaFiscal::class);
                $reflectedProperty = $reflection->getProperty('cUF');
                $sut = $reflectedProperty->getType();
                expect($sut->allowsNull())->toBeFalse();
            });
        });

        describe('$cNF', function () {
            test('Should be declared', function () {
                $sut = new IdentificacaoNotaFiscal;
                expect($sut)->toHaveProperty('cNF');
            });

            test('Should be a subclass of DFeElement::class', function () {
                $reflection = new ReflectionClass(IdentificacaoNotaFiscal::class);
                $reflectedProperty = $reflection->getProperty('cNF');
                $sut = $reflectedProperty->getType();
                expect((is_subclass_of($sut->getName(), DFeElement::class)))->toBeTrue();
            });

            test('Should be required', function () {
                $reflection = new ReflectionClass(IdentificacaoNotaFiscal::class);
                $reflectedProperty = $reflection->getProperty('cNF');
                $sut = $reflectedProperty->getType();
                expect($sut->allowsNull())->toBeFalse();
            });
        });

        describe('$natOp', function () {
            test('Should be declared', function () {
                $sut = new IdentificacaoNotaFiscal;
                expect($sut)->toHaveProperty('natOp');
            });

            test('Should be a subclass of DFeElement::class', function () {
                $reflection = new ReflectionClass(IdentificacaoNotaFiscal::class);
                $reflectedProperty = $reflection->getProperty('natOp');
                $sut = $reflectedProperty->getType();
                expect((is_subclass_of($sut->getName(), DFeElement::class)))->toBeTrue();
            });

            test('Should be required', function () {
                $reflection = new ReflectionClass(IdentificacaoNotaFiscal::class);
                $reflectedProperty = $reflection->getProperty('natOp');
                $sut = $reflectedProperty->getType();
                expect($sut->allowsNull())->toBeFalse();
            });
        });

        describe('$mod', function () {
            test('Should be declared', function () {
                $sut = new IdentificacaoNotaFiscal;
                expect($sut)->toHaveProperty('mod');
            });

            test('Should be a subclass of DFeElement::class', function () {
                $reflection = new ReflectionClass(IdentificacaoNotaFiscal::class);
                $reflectedProperty = $reflection->getProperty('mod');
                $sut = $reflectedProperty->getType();
                expect((is_subclass_of($sut->getName(), DFeElement::class)))->toBeTrue();
            });

            test('Should be required', function () {
                $reflection = new ReflectionClass(IdentificacaoNotaFiscal::class);
                $reflectedProperty = $reflection->getProperty('mod');
                $sut = $reflectedProperty->getType();
                expect($sut->allowsNull())->toBeFalse();
            });
        });

        describe('$serie', function () {
            test('Should be declared', function () {
                $sut = new IdentificacaoNotaFiscal;
                expect($sut)->toHaveProperty('serie');
            });

            test('Should be a subclass of DFeElement::class', function () {
                $reflection = new ReflectionClass(IdentificacaoNotaFiscal::class);
                $reflectedProperty = $reflection->getProperty('serie');
                $sut = $reflectedProperty->getType();
                expect((is_subclass_of($sut->getName(), DFeElement::class)))->toBeTrue();
            });

            test('Should be required', function () {
                $reflection = new ReflectionClass(IdentificacaoNotaFiscal::class);
                $reflectedProperty = $reflection->getProperty('serie');
                $sut = $reflectedProperty->getType();
                expect($sut->allowsNull())->toBeFalse();
            });
        });

        describe('$nNF', function () {
            test('Should be declared', function () {
                $sut = new IdentificacaoNotaFiscal;
                expect($sut)->toHaveProperty('nNF');
            });

            test('Should be a subclass of DFeElement::class', function () {
                $reflection = new ReflectionClass(IdentificacaoNotaFiscal::class);
                $reflectedProperty = $reflection->getProperty('nNF');
                $sut = $reflectedProperty->getType();
                expect((is_subclass_of($sut->getName(), DFeElement::class)))->toBeTrue();
            });

            test('Should be required', function () {
                $reflection = new ReflectionClass(IdentificacaoNotaFiscal::class);
                $reflectedProperty = $reflection->getProperty('nNF');
                $sut = $reflectedProperty->getType();
                expect($sut->allowsNull())->toBeFalse();
            });
        });

        describe('$dhEmi', function () {
            test('Should be declared', function () {
                $sut = new IdentificacaoNotaFiscal;
                expect($sut)->toHaveProperty('dhEmi');
            });

            test('Should be a subclass of DFeElement::class', function () {
                $reflection = new ReflectionClass(IdentificacaoNotaFiscal::class);
                $reflectedProperty = $reflection->getProperty('dhEmi');
                $sut = $reflectedProperty->getType();
                expect((is_subclass_of($sut->getName(), DFeElement::class)))->toBeTrue();
            });

            test('Should be required', function () {
                $reflection = new ReflectionClass(IdentificacaoNotaFiscal::class);
                $reflectedProperty = $reflection->getProperty('dhEmi');
                $sut = $reflectedProperty->getType();
                expect($sut->allowsNull())->toBeFalse();
            });
        });

        describe('$dhSaiEnt', function () {
            test('Should be declared', function () {
                $sut = new IdentificacaoNotaFiscal;
                expect($sut)->toHaveProperty('dhSaiEnt');
            });

            test('Should be a subclass of DFeElement::class', function () {
                $reflection = new ReflectionClass(IdentificacaoNotaFiscal::class);
                $reflectedProperty = $reflection->getProperty('dhSaiEnt');
                $sut = $reflectedProperty->getType();
                expect((is_subclass_of($sut->getName(), DFeElement::class)))->toBeTrue();
            });

            test('Should be optional', function () {
                $reflection = new ReflectionClass(IdentificacaoNotaFiscal::class);
                $reflectedProperty = $reflection->getProperty('dhSaiEnt');
                $sut = $reflectedProperty->getType();
                expect($sut->allowsNull())->toBeTrue();
            });
        })->skip();

        describe('$tpNF', function () {
            test('Should be declared', function () {
                $sut = new IdentificacaoNotaFiscal;
                expect($sut)->toHaveProperty('tpNF');
            });

            test('Should be a subclass of DFeElement::class', function () {
                $reflection = new ReflectionClass(IdentificacaoNotaFiscal::class);
                $reflectedProperty = $reflection->getProperty('tpNF');
                $sut = $reflectedProperty->getType();
                expect((is_subclass_of($sut->getName(), DFeElement::class)))->toBeTrue();
            });

            test('Should be required', function () {
                $reflection = new ReflectionClass(IdentificacaoNotaFiscal::class);
                $reflectedProperty = $reflection->getProperty('tpNF');
                $sut = $reflectedProperty->getType();
                expect($sut->allowsNull())->toBeFalse();
            });
        });

        describe('$idDest', function () {
            test('Should be declared', function () {
                $sut = new IdentificacaoNotaFiscal;
                expect($sut)->toHaveProperty('idDest');
            });

            test('Should be a subclass of DFeElement::class', function () {
                $reflection = new ReflectionClass(IdentificacaoNotaFiscal::class);
                $reflectedProperty = $reflection->getProperty('idDest');
                $sut = $reflectedProperty->getType();
                expect((is_subclass_of($sut->getName(), DFeElement::class)))->toBeTrue();
            });

            test('Should be required', function () {
                $reflection = new ReflectionClass(IdentificacaoNotaFiscal::class);
                $reflectedProperty = $reflection->getProperty('idDest');
                $sut = $reflectedProperty->getType();
                expect($sut->allowsNull())->toBeFalse();
            });
        });

        describe('$cMunFG', function () {
            test('Should be declared', function () {
                $sut = new IdentificacaoNotaFiscal;
                expect($sut)->toHaveProperty('cMunFG');
            });

            test('Should be a subclass of DFeElement::class', function () {
                $reflection = new ReflectionClass(IdentificacaoNotaFiscal::class);
                $reflectedProperty = $reflection->getProperty('cMunFG');
                $sut = $reflectedProperty->getType();
                expect((is_subclass_of($sut->getName(), DFeElement::class)))->toBeTrue();
            });

            test('Should be required', function () {
                $reflection = new ReflectionClass(IdentificacaoNotaFiscal::class);
                $reflectedProperty = $reflection->getProperty('cMunFG');
                $sut = $reflectedProperty->getType();
                expect($sut->allowsNull())->toBeFalse();
            });
        });

        describe('$tpImp', function () {
            test('Should be declared', function () {
                $sut = new IdentificacaoNotaFiscal;
                expect($sut)->toHaveProperty('tpImp');
            });

            test('Should be a subclass of DFeElement::class', function () {
                $reflection = new ReflectionClass(IdentificacaoNotaFiscal::class);
                $reflectedProperty = $reflection->getProperty('tpImp');
                $sut = $reflectedProperty->getType();
                expect((is_subclass_of($sut->getName(), DFeElement::class)))->toBeTrue();
            });

            test('Should be required', function () {
                $reflection = new ReflectionClass(IdentificacaoNotaFiscal::class);
                $reflectedProperty = $reflection->getProperty('tpImp');
                $sut = $reflectedProperty->getType();
                expect($sut->allowsNull())->toBeFalse();
            });
        })->skip();

        describe('$tpEmis', function () {
            test('Should be declared', function () {
                $sut = new IdentificacaoNotaFiscal;
                expect($sut)->toHaveProperty('tpEmis');
            });

            test('Should be a subclass of DFeElement::class', function () {
                $reflection = new ReflectionClass(IdentificacaoNotaFiscal::class);
                $reflectedProperty = $reflection->getProperty('tpEmis');
                $sut = $reflectedProperty->getType();
                expect((is_subclass_of($sut->getName(), DFeElement::class)))->toBeTrue();
            });

            test('Should be required', function () {
                $reflection = new ReflectionClass(IdentificacaoNotaFiscal::class);
                $reflectedProperty = $reflection->getProperty('tpEmis');
                $sut = $reflectedProperty->getType();
                expect($sut->allowsNull())->toBeFalse();
            });
        });

        describe('$cDV', function () {
            test('Should be declared', function () {
                $sut = new IdentificacaoNotaFiscal;
                expect($sut)->toHaveProperty('cDV');
            });

            test('Should be a subclass of DFeElement::class', function () {
                $reflection = new ReflectionClass(IdentificacaoNotaFiscal::class);
                $reflectedProperty = $reflection->getProperty('cDV');
                $sut = $reflectedProperty->getType();
                expect((is_subclass_of($sut->getName(), DFeElement::class)))->toBeTrue();
            });

            test('Should be required', function () {
                $reflection = new ReflectionClass(IdentificacaoNotaFiscal::class);
                $reflectedProperty = $reflection->getProperty('cDV');
                $sut = $reflectedProperty->getType();
                expect($sut->allowsNull())->toBeFalse();
            });
        })->skip();

        describe('$tpAmb', function () {
            test('Should be declared', function () {
                $sut = new IdentificacaoNotaFiscal;
                expect($sut)->toHaveProperty('tpAmb');
            });

            test('Should be a subclass of DFeElement::class', function () {
                $reflection = new ReflectionClass(IdentificacaoNotaFiscal::class);
                $reflectedProperty = $reflection->getProperty('tpAmb');
                $sut = $reflectedProperty->getType();
                expect((is_subclass_of($sut->getName(), DFeElement::class)))->toBeTrue();
            });

            test('Should be required', function () {
                $reflection = new ReflectionClass(IdentificacaoNotaFiscal::class);
                $reflectedProperty = $reflection->getProperty('tpAmb');
                $sut = $reflectedProperty->getType();
                expect($sut->allowsNull())->toBeFalse();
            });
        });

        describe('$finNFe', function () {
            test('Should be declared', function () {
                $sut = new IdentificacaoNotaFiscal;
                expect($sut)->toHaveProperty('finNFe');
            });

            test('Should be a subclass of DFeElement::class', function () {
                $reflection = new ReflectionClass(IdentificacaoNotaFiscal::class);
                $reflectedProperty = $reflection->getProperty('finNFe');
                $sut = $reflectedProperty->getType();
                expect((is_subclass_of($sut->getName(), DFeElement::class)))->toBeTrue();
            });

            test('Should be required', function () {
                $reflection = new ReflectionClass(IdentificacaoNotaFiscal::class);
                $reflectedProperty = $reflection->getProperty('finNFe');
                $sut = $reflectedProperty->getType();
                expect($sut->allowsNull())->toBeFalse();
            });
        });

        describe('$indFinal', function () {
            test('Should be declared', function () {
                $sut = new IdentificacaoNotaFiscal;
                expect($sut)->toHaveProperty('indFinal');
            });

            test('Should be a subclass of DFeElement::class', function () {
                $reflection = new ReflectionClass(IdentificacaoNotaFiscal::class);
                $reflectedProperty = $reflection->getProperty('indFinal');
                $sut = $reflectedProperty->getType();
                expect((is_subclass_of($sut->getName(), DFeElement::class)))->toBeTrue();
            });

            test('Should be required', function () {
                $reflection = new ReflectionClass(IdentificacaoNotaFiscal::class);
                $reflectedProperty = $reflection->getProperty('indFinal');
                $sut = $reflectedProperty->getType();
                expect($sut->allowsNull())->toBeFalse();
            });
        });

        describe('$indPres', function () {
            test('Should be declared', function () {
                $sut = new IdentificacaoNotaFiscal;
                expect($sut)->toHaveProperty('indPres');
            });

            test('Should be a subclass of DFeElement::class', function () {
                $reflection = new ReflectionClass(IdentificacaoNotaFiscal::class);
                $reflectedProperty = $reflection->getProperty('indPres');
                $sut = $reflectedProperty->getType();
                expect((is_subclass_of($sut->getName(), DFeElement::class)))->toBeTrue();
            });

            test('Should be required', function () {
                $reflection = new ReflectionClass(IdentificacaoNotaFiscal::class);
                $reflectedProperty = $reflection->getProperty('indPres');
                $sut = $reflectedProperty->getType();
                expect($sut->allowsNull())->toBeFalse();
            });
        })->skip();

        describe('$indIntermed', function () {
            test('Should be declared', function () {
                $sut = new IdentificacaoNotaFiscal;
                expect($sut)->toHaveProperty('indIntermed');
            });

            test('Should be a subclass of DFeElement::class', function () {
                $reflection = new ReflectionClass(IdentificacaoNotaFiscal::class);
                $reflectedProperty = $reflection->getProperty('indIntermed');
                $sut = $reflectedProperty->getType();
                expect((is_subclass_of($sut->getName(), DFeElement::class)))->toBeTrue();
            });

            test('Should be optional', function () {
                $reflection = new ReflectionClass(IdentificacaoNotaFiscal::class);
                $reflectedProperty = $reflection->getProperty('indIntermed');
                $sut = $reflectedProperty->getType();
                expect($sut->allowsNull())->toBeTrue();
            });
        })->skip();

        describe('$procEmi', function () {
            test('Should be declared', function () {
                $sut = new IdentificacaoNotaFiscal;
                expect($sut)->toHaveProperty('procEmi');
            });

            test('Should be a subclass of DFeElement::class', function () {
                $reflection = new ReflectionClass(IdentificacaoNotaFiscal::class);
                $reflectedProperty = $reflection->getProperty('procEmi');
                $sut = $reflectedProperty->getType();
                expect((is_subclass_of($sut->getName(), DFeElement::class)))->toBeTrue();
            });

            test('Should be required', function () {
                $reflection = new ReflectionClass(IdentificacaoNotaFiscal::class);
                $reflectedProperty = $reflection->getProperty('procEmi');
                $sut = $reflectedProperty->getType();
                expect($sut->allowsNull())->toBeFalse();
            });
        })->skip();

        describe('$verProc', function () {
            test('Should be declared', function () {
                $sut = new IdentificacaoNotaFiscal;
                expect($sut)->toHaveProperty('verProc');
            });

            test('Should be a subclass of DFeElement::class', function () {
                $reflection = new ReflectionClass(IdentificacaoNotaFiscal::class);
                $reflectedProperty = $reflection->getProperty('verProc');
                $sut = $reflectedProperty->getType();
                expect((is_subclass_of($sut->getName(), DFeElement::class)))->toBeTrue();
            });

            test('Should be required', function () {
                $reflection = new ReflectionClass(IdentificacaoNotaFiscal::class);
                $reflectedProperty = $reflection->getProperty('verProc');
                $sut = $reflectedProperty->getType();
                expect($sut->allowsNull())->toBeFalse();
            });
        })->skip();

        describe('$dhCont', function () {
            test('Should be declared', function () {
                $sut = new IdentificacaoNotaFiscal;
                expect($sut)->toHaveProperty('dhCont');
            });

            test('Should be a subclass of DFeElement::class', function () {
                $reflection = new ReflectionClass(IdentificacaoNotaFiscal::class);
                $reflectedProperty = $reflection->getProperty('dhCont');
                $sut = $reflectedProperty->getType();
                expect((is_subclass_of($sut->getName(), DFeElement::class)))->toBeTrue();
            });

            test('Should be optional', function () {
                $reflection = new ReflectionClass(IdentificacaoNotaFiscal::class);
                $reflectedProperty = $reflection->getProperty('dhCont');
                $sut = $reflectedProperty->getType();
                expect($sut->allowsNull())->toBeTrue();
            });
        })->skip();

        describe('$xJust', function () {
            test('Should be declared', function () {
                $sut = new IdentificacaoNotaFiscal;
                expect($sut)->toHaveProperty('xJust');
            });

            test('Should be a subclass of DFeElement::class', function () {
                $reflection = new ReflectionClass(IdentificacaoNotaFiscal::class);
                $reflectedProperty = $reflection->getProperty('xJust');
                $sut = $reflectedProperty->getType();
                expect((is_subclass_of($sut->getName(), DFeElement::class)))->toBeTrue();
            });

            test('Should be required', function () {
                $reflection = new ReflectionClass(IdentificacaoNotaFiscal::class);
                $reflectedProperty = $reflection->getProperty('xJust');
                $sut = $reflectedProperty->getType();
                expect($sut->allowsNull())->toBeFalse();
            });
        })->skip();

        describe('NFref', function () {
            test('Should be declared', function () {
                $sut = new IdentificacaoNotaFiscal;
                expect($sut)->toHaveProperty('NFref');
            });

            test('Should be a subclass of DFeElement::class', function () {
                $reflection = new ReflectionClass(IdentificacaoNotaFiscal::class);
                $reflectedProperty = $reflection->getProperty('NFref');
                $sut = $reflectedProperty->getType();
                expect((is_subclass_of($sut->getName(), DFeElementCollection::class)))->toBeTrue();
            });

            test('Should be optional', function () {
                $reflection = new ReflectionClass(IdentificacaoNotaFiscal::class);
                $reflectedProperty = $reflection->getProperty('NFref');
                $sut = $reflectedProperty->getType();
                expect($sut->allowsNull())->toBeTrue();
            });
        })->skip();
    });

    describe('methods', function () {
        describe('validateTagAttributes', function () {
            test('Should fail if an attribute is provided', function () {
                $xmlString = '<ide attribute="value"><cUF></cUF><cNF></cNF><natOp></natOp><mod></mod><serie></serie><nNF></nNF><dhEmi></dhEmi><tpNF></tpNF><idDest></idDest><cMunFG></cMunFG><tpImp></tpImp><tpEmis></tpEmis><cDV></cDV><tpAmb></tpAmb><finNFe></finNFe><indFinal></indFinal><indPres></indPres><procEmi></procEmi><verProc></verProc></ide>';
                $xmlElement = new Element;
                $xmlElement->parse($xmlString);
                $identificacaoNotaFiscal = new IdentificacaoNotaFiscal;
                $sut = new ReflectionMethod($identificacaoNotaFiscal, 'validateTagAttributes');
                $sutResponse = $sut->invoke($identificacaoNotaFiscal, $xmlElement);
                expect($sutResponse->isFailure())->toBeTrue();
            });
        });

        describe('validateTagElements', function () {
            test('Should succeed if all required tags are provided', function () {
                $xmlString = '<ide><cUF></cUF><cNF></cNF><natOp></natOp><mod></mod><serie></serie><nNF></nNF><dhEmi></dhEmi><tpNF></tpNF><idDest></idDest><cMunFG></cMunFG><tpImp></tpImp><tpEmis></tpEmis><cDV></cDV><tpAmb></tpAmb><finNFe></finNFe><indFinal></indFinal><indPres></indPres><procEmi></procEmi><verProc></verProc></ide>';
                $xmlElement = new Element;
                $xmlElement->parse($xmlString);
                $identificacaoNotaFiscal = new IdentificacaoNotaFiscal;
                $sut = new ReflectionMethod($identificacaoNotaFiscal, 'validateTagElements');
                $sutResponse = $sut->invoke($identificacaoNotaFiscal, $xmlElement);
                expect($sutResponse->isSuccess())->toBeTrue();
            });

            test('Should succeed if all tags are provided', function () {
                $xmlString = '<ide><cUF></cUF><cNF></cNF><natOp></natOp><mod></mod><serie></serie><nNF></nNF><dhEmi></dhEmi><dhSaiEnt></dhSaiEnt><tpNF></tpNF><idDest></idDest><cMunFG></cMunFG><tpImp></tpImp><tpEmis></tpEmis><cDV></cDV><tpAmb></tpAmb><finNFe></finNFe><indFinal></indFinal><indPres></indPres><indIntermed></indIntermed><procEmi></procEmi><verProc></verProc><dhCont></dhCont><xJust></xJust></ide>';
                $xmlElement = new Element;
                $xmlElement->parse($xmlString);
                $identificacaoNotaFiscal = new IdentificacaoNotaFiscal;
                $sut = new ReflectionMethod($identificacaoNotaFiscal, 'validateTagElements');
                $sutResponse = $sut->invoke($identificacaoNotaFiscal, $xmlElement);
                expect($sutResponse->isSuccess())->toBeTrue();
            });

            test('Should fail if cUF tag isnt provided', function () {
                $xmlString = '<ide><cNF></cNF><natOp></natOp><mod></mod><serie></serie><nNF></nNF><dhEmi></dhEmi><tpNF></tpNF><idDest></idDest><cMunFG></cMunFG><tpImp></tpImp><tpEmis></tpEmis><cDV></cDV><tpAmb></tpAmb><finNFe></finNFe><indFinal></indFinal><indPres></indPres><procEmi></procEmi><verProc></verProc></ide>';
                $xmlElement = new Element;
                $xmlElement->parse($xmlString);
                $identificacaoNotaFiscal = new IdentificacaoNotaFiscal;
                $sut = new ReflectionMethod($identificacaoNotaFiscal, 'validateTagElements');
                $sutResponse = $sut->invoke($identificacaoNotaFiscal, $xmlElement);
                expect($sutResponse->isFailure())->toBeTrue();
            });

            test('Should fail if cNF tag isnt provided', function () {
                $xmlString = '<ide><cUF></cUF><natOp></natOp><mod></mod><serie></serie><nNF></nNF><dhEmi></dhEmi><tpNF></tpNF><idDest></idDest><cMunFG></cMunFG><tpImp></tpImp><tpEmis></tpEmis><cDV></cDV><tpAmb></tpAmb><finNFe></finNFe><indFinal></indFinal><indPres></indPres><procEmi></procEmi><verProc></verProc></ide>';
                $xmlElement = new Element;
                $xmlElement->parse($xmlString);
                $identificacaoNotaFiscal = new IdentificacaoNotaFiscal;
                $sut = new ReflectionMethod($identificacaoNotaFiscal, 'validateTagElements');
                $sutResponse = $sut->invoke($identificacaoNotaFiscal, $xmlElement);
                expect($sutResponse->isFailure())->toBeTrue();
            });

            test('Should fail if natOp tag isnt provided', function () {
                $xmlString = '<ide><cUF></cUF><cNF></cNF><mod></mod><serie></serie><nNF></nNF><dhEmi></dhEmi><tpNF></tpNF><idDest></idDest><cMunFG></cMunFG><tpImp></tpImp><tpEmis></tpEmis><cDV></cDV><tpAmb></tpAmb><finNFe></finNFe><indFinal></indFinal><indPres></indPres><procEmi></procEmi><verProc></verProc></ide>';
                $xmlElement = new Element;
                $xmlElement->parse($xmlString);
                $identificacaoNotaFiscal = new IdentificacaoNotaFiscal;
                $sut = new ReflectionMethod($identificacaoNotaFiscal, 'validateTagElements');
                $sutResponse = $sut->invoke($identificacaoNotaFiscal, $xmlElement);
                expect($sutResponse->isFailure())->toBeTrue();
            });

            test('Should fail if mod tag isnt provided', function () {
                $xmlString = '<ide><cUF></cUF><cNF></cNF><natOp></natOp><serie></serie><nNF></nNF><dhEmi></dhEmi><tpNF></tpNF><idDest></idDest><cMunFG></cMunFG><tpImp></tpImp><tpEmis></tpEmis><cDV></cDV><tpAmb></tpAmb><finNFe></finNFe><indFinal></indFinal><indPres></indPres><procEmi></procEmi><verProc></verProc></ide>';
                $xmlElement = new Element;
                $xmlElement->parse($xmlString);
                $identificacaoNotaFiscal = new IdentificacaoNotaFiscal;
                $sut = new ReflectionMethod($identificacaoNotaFiscal, 'validateTagElements');
                $sutResponse = $sut->invoke($identificacaoNotaFiscal, $xmlElement);
                expect($sutResponse->isFailure())->toBeTrue();
            });

            test('Should fail if serie tag isnt provided', function () {
                $xmlString = '<ide><cUF></cUF><cNF></cNF><natOp></natOp><mod></mod><nNF></nNF><dhEmi></dhEmi><tpNF></tpNF><idDest></idDest><cMunFG></cMunFG><tpImp></tpImp><tpEmis></tpEmis><cDV></cDV><tpAmb></tpAmb><finNFe></finNFe><indFinal></indFinal><indPres></indPres><procEmi></procEmi><verProc></verProc></ide>';
                $xmlElement = new Element;
                $xmlElement->parse($xmlString);
                $identificacaoNotaFiscal = new IdentificacaoNotaFiscal;
                $sut = new ReflectionMethod($identificacaoNotaFiscal, 'validateTagElements');
                $sutResponse = $sut->invoke($identificacaoNotaFiscal, $xmlElement);
                expect($sutResponse->isFailure())->toBeTrue();
            });

            test('Should fail if nNF tag isnt provided', function () {
                $xmlString = '<ide><cUF></cUF><cNF></cNF><natOp></natOp><mod></mod><serie></serie><dhEmi></dhEmi><tpNF></tpNF><idDest></idDest><cMunFG></cMunFG><tpImp></tpImp><tpEmis></tpEmis><cDV></cDV><tpAmb></tpAmb><finNFe></finNFe><indFinal></indFinal><indPres></indPres><procEmi></procEmi><verProc></verProc></ide>';
                $xmlElement = new Element;
                $xmlElement->parse($xmlString);
                $identificacaoNotaFiscal = new IdentificacaoNotaFiscal;
                $sut = new ReflectionMethod($identificacaoNotaFiscal, 'validateTagElements');
                $sutResponse = $sut->invoke($identificacaoNotaFiscal, $xmlElement);
                expect($sutResponse->isFailure())->toBeTrue();
            });

            test('Should fail if dhEmi tag isnt provided', function () {
                $xmlString = '<ide><cUF></cUF><cNF></cNF><natOp></natOp><mod></mod><serie></serie><nNF></nNF><tpNF></tpNF><idDest></idDest><cMunFG></cMunFG><tpImp></tpImp><tpEmis></tpEmis><cDV></cDV><tpAmb></tpAmb><finNFe></finNFe><indFinal></indFinal><indPres></indPres><procEmi></procEmi><verProc></verProc></ide>';
                $xmlElement = new Element;
                $xmlElement->parse($xmlString);
                $identificacaoNotaFiscal = new IdentificacaoNotaFiscal;
                $sut = new ReflectionMethod($identificacaoNotaFiscal, 'validateTagElements');
                $sutResponse = $sut->invoke($identificacaoNotaFiscal, $xmlElement);
                expect($sutResponse->isFailure())->toBeTrue();
            });

            test('Should fail if tpNF tag isnt provided', function () {
                $xmlString = '<ide><cUF></cUF><cNF></cNF><natOp></natOp><mod></mod><serie></serie><nNF></nNF><dhEmi></dhEmi><idDest></idDest><cMunFG></cMunFG><tpImp></tpImp><tpEmis></tpEmis><cDV></cDV><tpAmb></tpAmb><finNFe></finNFe><indFinal></indFinal><indPres></indPres><procEmi></procEmi><verProc></verProc></ide>';
                $xmlElement = new Element;
                $xmlElement->parse($xmlString);
                $identificacaoNotaFiscal = new IdentificacaoNotaFiscal;
                $sut = new ReflectionMethod($identificacaoNotaFiscal, 'validateTagElements');
                $sutResponse = $sut->invoke($identificacaoNotaFiscal, $xmlElement);
                expect($sutResponse->isFailure())->toBeTrue();
            });

            test('Should fail if idDest tag isnt provided', function () {
                $xmlString = '<ide><cUF></cUF><cNF></cNF><natOp></natOp><mod></mod><serie></serie><nNF></nNF><dhEmi></dhEmi><tpNF></tpNF><cMunFG></cMunFG><tpImp></tpImp><tpEmis></tpEmis><cDV></cDV><tpAmb></tpAmb><finNFe></finNFe><indFinal></indFinal><indPres></indPres><procEmi></procEmi><verProc></verProc></ide>';
                $xmlElement = new Element;
                $xmlElement->parse($xmlString);
                $identificacaoNotaFiscal = new IdentificacaoNotaFiscal;
                $sut = new ReflectionMethod($identificacaoNotaFiscal, 'validateTagElements');
                $sutResponse = $sut->invoke($identificacaoNotaFiscal, $xmlElement);
                expect($sutResponse->isFailure())->toBeTrue();
            });

            test('Should fail if cMunFG tag isnt provided', function () {
                $xmlString = '<ide><cUF></cUF><cNF></cNF><natOp></natOp><mod></mod><serie></serie><nNF></nNF><dhEmi></dhEmi><tpNF></tpNF><idDest></idDest><tpImp></tpImp><tpEmis></tpEmis><cDV></cDV><tpAmb></tpAmb><finNFe></finNFe><indFinal></indFinal><indPres></indPres><procEmi></procEmi><verProc></verProc></ide>';
                $xmlElement = new Element;
                $xmlElement->parse($xmlString);
                $identificacaoNotaFiscal = new IdentificacaoNotaFiscal;
                $sut = new ReflectionMethod($identificacaoNotaFiscal, 'validateTagElements');
                $sutResponse = $sut->invoke($identificacaoNotaFiscal, $xmlElement);
                expect($sutResponse->isFailure())->toBeTrue();
            });

            test('Should fail if tpImp tag isnt provided', function () {
                $xmlString = '<ide><cUF></cUF><cNF></cNF><natOp></natOp><mod></mod><serie></serie><nNF></nNF><dhEmi></dhEmi><tpNF></tpNF><idDest></idDest><cMunFG></cMunFG><tpEmis></tpEmis><cDV></cDV><tpAmb></tpAmb><finNFe></finNFe><indFinal></indFinal><indPres></indPres><procEmi></procEmi><verProc></verProc></ide>';
                $xmlElement = new Element;
                $xmlElement->parse($xmlString);
                $identificacaoNotaFiscal = new IdentificacaoNotaFiscal;
                $sut = new ReflectionMethod($identificacaoNotaFiscal, 'validateTagElements');
                $sutResponse = $sut->invoke($identificacaoNotaFiscal, $xmlElement);
                expect($sutResponse->isFailure())->toBeTrue();
            });

            test('Should fail if tpEmis tag isnt provided', function () {
                $xmlString = '<ide><cUF></cUF><cNF></cNF><natOp></natOp><mod></mod><serie></serie><nNF></nNF><dhEmi></dhEmi><tpNF></tpNF><idDest></idDest><cMunFG></cMunFG><tpImp></tpImp><cDV></cDV><tpAmb></tpAmb><finNFe></finNFe><indFinal></indFinal><indPres></indPres><procEmi></procEmi><verProc></verProc></ide>';
                $xmlElement = new Element;
                $xmlElement->parse($xmlString);
                $identificacaoNotaFiscal = new IdentificacaoNotaFiscal;
                $sut = new ReflectionMethod($identificacaoNotaFiscal, 'validateTagElements');
                $sutResponse = $sut->invoke($identificacaoNotaFiscal, $xmlElement);
                expect($sutResponse->isFailure())->toBeTrue();
            });

            test('Should fail if cDV tag isnt provided', function () {
                $xmlString = '<ide><cUF></cUF><cNF></cNF><natOp></natOp><mod></mod><serie></serie><nNF></nNF><dhEmi></dhEmi><tpNF></tpNF><idDest></idDest><cMunFG></cMunFG><tpImp></tpImp><tpEmis></tpEmis><tpAmb></tpAmb><finNFe></finNFe><indFinal></indFinal><indPres></indPres><procEmi></procEmi><verProc></verProc></ide>';
                $xmlElement = new Element;
                $xmlElement->parse($xmlString);
                $identificacaoNotaFiscal = new IdentificacaoNotaFiscal;
                $sut = new ReflectionMethod($identificacaoNotaFiscal, 'validateTagElements');
                $sutResponse = $sut->invoke($identificacaoNotaFiscal, $xmlElement);
                expect($sutResponse->isFailure())->toBeTrue();
            });

            test('Should fail if tpAmb tag isnt provided', function () {
                $xmlString = '<ide><cUF></cUF><cNF></cNF><natOp></natOp><mod></mod><serie></serie><nNF></nNF><dhEmi></dhEmi><tpNF></tpNF><idDest></idDest><cMunFG></cMunFG><tpImp></tpImp><tpEmis></tpEmis><cDV></cDV><finNFe></finNFe><indFinal></indFinal><indPres></indPres><procEmi></procEmi><verProc></verProc></ide>';
                $xmlElement = new Element;
                $xmlElement->parse($xmlString);
                $identificacaoNotaFiscal = new IdentificacaoNotaFiscal;
                $sut = new ReflectionMethod($identificacaoNotaFiscal, 'validateTagElements');
                $sutResponse = $sut->invoke($identificacaoNotaFiscal, $xmlElement);
                expect($sutResponse->isFailure())->toBeTrue();
            });

            test('Should fail if finNFe tag isnt provided', function () {
                $xmlString = '<ide><cUF></cUF><cNF></cNF><natOp></natOp><mod></mod><serie></serie><nNF></nNF><dhEmi></dhEmi><tpNF></tpNF><idDest></idDest><cMunFG></cMunFG><tpImp></tpImp><tpEmis></tpEmis><cDV></cDV><tpAmb></tpAmb><indFinal></indFinal><indPres></indPres><procEmi></procEmi><verProc></verProc></ide>';
                $xmlElement = new Element;
                $xmlElement->parse($xmlString);
                $identificacaoNotaFiscal = new IdentificacaoNotaFiscal;
                $sut = new ReflectionMethod($identificacaoNotaFiscal, 'validateTagElements');
                $sutResponse = $sut->invoke($identificacaoNotaFiscal, $xmlElement);
                expect($sutResponse->isFailure())->toBeTrue();
            });

            test('Should fail if indFinal tag isnt provided', function () {
                $xmlString = '<ide><cUF></cUF><cNF></cNF><natOp></natOp><mod></mod><serie></serie><nNF></nNF><dhEmi></dhEmi><tpNF></tpNF><idDest></idDest><cMunFG></cMunFG><tpImp></tpImp><tpEmis></tpEmis><cDV></cDV><tpAmb></tpAmb><finNFe></finNFe><indPres></indPres><procEmi></procEmi><verProc></verProc></ide>';
                $xmlElement = new Element;
                $xmlElement->parse($xmlString);
                $identificacaoNotaFiscal = new IdentificacaoNotaFiscal;
                $sut = new ReflectionMethod($identificacaoNotaFiscal, 'validateTagElements');
                $sutResponse = $sut->invoke($identificacaoNotaFiscal, $xmlElement);
                expect($sutResponse->isFailure())->toBeTrue();
            });

            test('Should fail if indPres tag isnt provided', function () {
                $xmlString = '<ide><cUF></cUF><cNF></cNF><natOp></natOp><mod></mod><serie></serie><nNF></nNF><dhEmi></dhEmi><tpNF></tpNF><idDest></idDest><cMunFG></cMunFG><tpImp></tpImp><tpEmis></tpEmis><cDV></cDV><tpAmb></tpAmb><finNFe></finNFe><indFinal></indFinal><procEmi></procEmi><verProc></verProc></ide>';
                $xmlElement = new Element;
                $xmlElement->parse($xmlString);
                $identificacaoNotaFiscal = new IdentificacaoNotaFiscal;
                $sut = new ReflectionMethod($identificacaoNotaFiscal, 'validateTagElements');
                $sutResponse = $sut->invoke($identificacaoNotaFiscal, $xmlElement);
                expect($sutResponse->isFailure())->toBeTrue();
            });

            test('Should fail if procEmi tag isnt provided', function () {
                $xmlString = '<ide><cUF></cUF><cNF></cNF><natOp></natOp><mod></mod><serie></serie><nNF></nNF><dhEmi></dhEmi><tpNF></tpNF><idDest></idDest><cMunFG></cMunFG><tpImp></tpImp><tpEmis></tpEmis><cDV></cDV><tpAmb></tpAmb><finNFe></finNFe><indFinal></indFinal><indPres></indPres><verProc></verProc></ide>';
                $xmlElement = new Element;
                $xmlElement->parse($xmlString);
                $identificacaoNotaFiscal = new IdentificacaoNotaFiscal;
                $sut = new ReflectionMethod($identificacaoNotaFiscal, 'validateTagElements');
                $sutResponse = $sut->invoke($identificacaoNotaFiscal, $xmlElement);
                expect($sutResponse->isFailure())->toBeTrue();
            });

            test('Should fail if verProc tag isnt provided', function () {
                $xmlString = '<ide><cUF></cUF><cNF></cNF><natOp></natOp><mod></mod><serie></serie><nNF></nNF><dhEmi></dhEmi><tpNF></tpNF><idDest></idDest><cMunFG></cMunFG><tpImp></tpImp><tpEmis></tpEmis><cDV></cDV><tpAmb></tpAmb><finNFe></finNFe><indFinal></indFinal><indPres></indPres><procEmi></procEmi></ide>';
                $xmlElement = new Element;
                $xmlElement->parse($xmlString);
                $identificacaoNotaFiscal = new IdentificacaoNotaFiscal;
                $sut = new ReflectionMethod($identificacaoNotaFiscal, 'validateTagElements');
                $sutResponse = $sut->invoke($identificacaoNotaFiscal, $xmlElement);
                expect($sutResponse->isFailure())->toBeTrue();
            });

            test('Should fail if unallowed tag is provided', function () {
                $xmlString = '<ide><unallowed></unallowed><cUF></cUF><cNF></cNF><natOp></natOp><mod></mod><serie></serie><nNF></nNF><dhEmi></dhEmi><dhSaiEnt></dhSaiEnt><tpNF></tpNF><idDest></idDest><cMunFG></cMunFG><tpImp></tpImp><tpEmis></tpEmis><cDV></cDV><tpAmb></tpAmb><finNFe></finNFe><indFinal></indFinal><indPres></indPres><indIntermed></indIntermed><procEmi></procEmi><verProc></verProc><dhCont></dhCont><xJust></xJust><NFref></NFref></ide>';
                $xmlElement = new Element;
                $xmlElement->parse($xmlString);
                $identificacaoNotaFiscal = new IdentificacaoNotaFiscal;
                $sut = new ReflectionMethod($identificacaoNotaFiscal, 'validateTagElements');
                $sutResponse = $sut->invoke($identificacaoNotaFiscal, $xmlElement);
                expect($sutResponse->isFailure())->toBeTrue();
            });
        });

        describe('validateTagValue', function () {
            test('Should fail if a tag value is provided', function () {
                $xmlString = '<ide>aValue<cUF></cUF><cNF></cNF><natOp></natOp><mod></mod><serie></serie><nNF></nNF><dhEmi></dhEmi><dhSaiEnt></dhSaiEnt><tpNF></tpNF><idDest></idDest><cMunFG></cMunFG><tpImp></tpImp><tpEmis></tpEmis><cDV></cDV><tpAmb></tpAmb><finNFe></finNFe><indFinal></indFinal><indPres></indPres><indIntermed></indIntermed><procEmi></procEmi><verProc></verProc><dhCont></dhCont><xJust></xJust><NFref></NFref></ide>';
                $xmlElement = new Element;
                $xmlElement->parse($xmlString);
                $identificacaoNotaFiscal = new IdentificacaoNotaFiscal;
                $sut = new ReflectionMethod($identificacaoNotaFiscal, 'validateTagValue');
                $sutResponse = $sut->invoke($identificacaoNotaFiscal, $xmlElement);
                expect($sutResponse->isFailure())->toBeTrue();
            });
        });
    });
});
