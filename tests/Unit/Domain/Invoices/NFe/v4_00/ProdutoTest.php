<?php

declare(strict_types=1);

use BradiApi\Domain\Common\Protocols\ApiError;
use BradiApi\Domain\Invoices\NFe\v4_00\Produto;
use BradiApi\Domain\Invoices\Templates\DFeElement;
use BradiApi\Domain\Invoices\Templates\DFeElementCollection;
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

        describe('$NVE', function () {
            test('Should be declared', function () {
                $sut = new Produto;
                expect($sut)->toHaveProperty('NVE');
            });

            test('Should be a subclass of DFeElement::class', function () {
                $reflection = new ReflectionClass(Produto::class);
                $reflectedProperty = $reflection->getProperty('NVE');
                $sut = $reflectedProperty->getType();
                expect((is_subclass_of($sut->getName(), DFeElement::class)))->toBeTrue();
            });

            test('Should be optional', function () {
                $reflection = new ReflectionClass(Produto::class);
                $reflectedProperty = $reflection->getProperty('NVE');
                $sut = $reflectedProperty->getType();
                expect($sut->allowsNull())->toBeTrue();
            });
        })->skip();

        describe('$CEST', function () {
            test('Should be declared', function () {
                $sut = new Produto;
                expect($sut)->toHaveProperty('CEST');
            });

            test('Should be a subclass of DFeElement::class', function () {
                $reflection = new ReflectionClass(Produto::class);
                $reflectedProperty = $reflection->getProperty('CEST');
                $sut = $reflectedProperty->getType();
                expect((is_subclass_of($sut->getName(), DFeElement::class)))->toBeTrue();
            });

            test('Should be optional', function () {
                $reflection = new ReflectionClass(Produto::class);
                $reflectedProperty = $reflection->getProperty('CEST');
                $sut = $reflectedProperty->getType();
                expect($sut->allowsNull())->toBeTrue();
            });
        })->skip();

        describe('$indEscala', function () {
            test('Should be declared', function () {
                $sut = new Produto;
                expect($sut)->toHaveProperty('indEscala');
            });

            test('Should be a subclass of DFeElement::class', function () {
                $reflection = new ReflectionClass(Produto::class);
                $reflectedProperty = $reflection->getProperty('indEscala');
                $sut = $reflectedProperty->getType();
                expect((is_subclass_of($sut->getName(), DFeElement::class)))->toBeTrue();
            });

            test('Should be optional', function () {
                $reflection = new ReflectionClass(Produto::class);
                $reflectedProperty = $reflection->getProperty('indEscala');
                $sut = $reflectedProperty->getType();
                expect($sut->allowsNull())->toBeTrue();
            });
        })->skip();

        describe('$CNPJFab', function () {
            test('Should be declared', function () {
                $sut = new Produto;
                expect($sut)->toHaveProperty('CNPJFab');
            });

            test('Should be a subclass of DFeElement::class', function () {
                $reflection = new ReflectionClass(Produto::class);
                $reflectedProperty = $reflection->getProperty('CNPJFab');
                $sut = $reflectedProperty->getType();
                expect((is_subclass_of($sut->getName(), DFeElement::class)))->toBeTrue();
            });

            test('Should be optional', function () {
                $reflection = new ReflectionClass(Produto::class);
                $reflectedProperty = $reflection->getProperty('CNPJFab');
                $sut = $reflectedProperty->getType();
                expect($sut->allowsNull())->toBeTrue();
            });
        })->skip();

        describe('$cBenef', function () {
            test('Should be declared', function () {
                $sut = new Produto;
                expect($sut)->toHaveProperty('cBenef');
            });

            test('Should be a subclass of DFeElement::class', function () {
                $reflection = new ReflectionClass(Produto::class);
                $reflectedProperty = $reflection->getProperty('cBenef');
                $sut = $reflectedProperty->getType();
                expect((is_subclass_of($sut->getName(), DFeElement::class)))->toBeTrue();
            });

            test('Should be optional', function () {
                $reflection = new ReflectionClass(Produto::class);
                $reflectedProperty = $reflection->getProperty('cBenef');
                $sut = $reflectedProperty->getType();
                expect($sut->allowsNull())->toBeTrue();
            });
        })->skip();

        describe('$EXTIPI', function () {
            test('Should be declared', function () {
                $sut = new Produto;
                expect($sut)->toHaveProperty('EXTIPI');
            });

            test('Should be a subclass of DFeElement::class', function () {
                $reflection = new ReflectionClass(Produto::class);
                $reflectedProperty = $reflection->getProperty('EXTIPI');
                $sut = $reflectedProperty->getType();
                expect((is_subclass_of($sut->getName(), DFeElement::class)))->toBeTrue();
            });

            test('Should be optional', function () {
                $reflection = new ReflectionClass(Produto::class);
                $reflectedProperty = $reflection->getProperty('EXTIPI');
                $sut = $reflectedProperty->getType();
                expect($sut->allowsNull())->toBeTrue();
            });
        })->skip();

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

        describe('$cEANTrib', function () {
            test('Should be declared', function () {
                $sut = new Produto;
                expect($sut)->toHaveProperty('cEANTrib');
            });

            test('Should be a subclass of DFeElement::class', function () {
                $reflection = new ReflectionClass(Produto::class);
                $reflectedProperty = $reflection->getProperty('cEANTrib');
                $sut = $reflectedProperty->getType();
                expect((is_subclass_of($sut->getName(), DFeElement::class)))->toBeTrue();
            });

            test('Should be optional', function () {
                $reflection = new ReflectionClass(Produto::class);
                $reflectedProperty = $reflection->getProperty('cEANTrib');
                $sut = $reflectedProperty->getType();
                expect($sut->allowsNull())->toBeTrue();
            });
        })->skip();

        describe('$uTrib', function () {
            test('Should be declared', function () {
                $sut = new Produto;
                expect($sut)->toHaveProperty('uTrib');
            });

            test('Should be a subclass of DFeElement::class', function () {
                $reflection = new ReflectionClass(Produto::class);
                $reflectedProperty = $reflection->getProperty('uTrib');
                $sut = $reflectedProperty->getType();
                expect((is_subclass_of($sut->getName(), DFeElement::class)))->toBeTrue();
            });

            test('Should be optional', function () {
                $reflection = new ReflectionClass(Produto::class);
                $reflectedProperty = $reflection->getProperty('uTrib');
                $sut = $reflectedProperty->getType();
                expect($sut->allowsNull())->toBeTrue();
            });
        })->skip();

        describe('$qTrib', function () {
            test('Should be declared', function () {
                $sut = new Produto;
                expect($sut)->toHaveProperty('qTrib');
            });

            test('Should be a subclass of DFeElement::class', function () {
                $reflection = new ReflectionClass(Produto::class);
                $reflectedProperty = $reflection->getProperty('qTrib');
                $sut = $reflectedProperty->getType();
                expect((is_subclass_of($sut->getName(), DFeElement::class)))->toBeTrue();
            });

            test('Should be optional', function () {
                $reflection = new ReflectionClass(Produto::class);
                $reflectedProperty = $reflection->getProperty('qTrib');
                $sut = $reflectedProperty->getType();
                expect($sut->allowsNull())->toBeTrue();
            });
        })->skip();

        describe('$vUnTrib', function () {
            test('Should be declared', function () {
                $sut = new Produto;
                expect($sut)->toHaveProperty('vUnTrib');
            });

            test('Should be a subclass of DFeElement::class', function () {
                $reflection = new ReflectionClass(Produto::class);
                $reflectedProperty = $reflection->getProperty('vUnTrib');
                $sut = $reflectedProperty->getType();
                expect((is_subclass_of($sut->getName(), DFeElement::class)))->toBeTrue();
            });

            test('Should be optional', function () {
                $reflection = new ReflectionClass(Produto::class);
                $reflectedProperty = $reflection->getProperty('vUnTrib');
                $sut = $reflectedProperty->getType();
                expect($sut->allowsNull())->toBeTrue();
            });
        })->skip();

        describe('$vFrete', function () {
            test('Should be declared', function () {
                $sut = new Produto;
                expect($sut)->toHaveProperty('vFrete');
            });

            test('Should be a subclass of DFeElement::class', function () {
                $reflection = new ReflectionClass(Produto::class);
                $reflectedProperty = $reflection->getProperty('vFrete');
                $sut = $reflectedProperty->getType();
                expect((is_subclass_of($sut->getName(), DFeElement::class)))->toBeTrue();
            });

            test('Should be optional', function () {
                $reflection = new ReflectionClass(Produto::class);
                $reflectedProperty = $reflection->getProperty('vFrete');
                $sut = $reflectedProperty->getType();
                expect($sut->allowsNull())->toBeTrue();
            });
        });

        describe('$vSeg', function () {
            test('Should be declared', function () {
                $sut = new Produto;
                expect($sut)->toHaveProperty('vSeg');
            });

            test('Should be a subclass of DFeElement::class', function () {
                $reflection = new ReflectionClass(Produto::class);
                $reflectedProperty = $reflection->getProperty('vSeg');
                $sut = $reflectedProperty->getType();
                expect((is_subclass_of($sut->getName(), DFeElement::class)))->toBeTrue();
            });

            test('Should be optional', function () {
                $reflection = new ReflectionClass(Produto::class);
                $reflectedProperty = $reflection->getProperty('vSeg');
                $sut = $reflectedProperty->getType();
                expect($sut->allowsNull())->toBeTrue();
            });
        });

        describe('$vDesc', function () {
            test('Should be declared', function () {
                $sut = new Produto;
                expect($sut)->toHaveProperty('vDesc');
            });

            test('Should be a subclass of DFeElement::class', function () {
                $reflection = new ReflectionClass(Produto::class);
                $reflectedProperty = $reflection->getProperty('vDesc');
                $sut = $reflectedProperty->getType();
                expect((is_subclass_of($sut->getName(), DFeElement::class)))->toBeTrue();
            });

            test('Should be optional', function () {
                $reflection = new ReflectionClass(Produto::class);
                $reflectedProperty = $reflection->getProperty('vDesc');
                $sut = $reflectedProperty->getType();
                expect($sut->allowsNull())->toBeTrue();
            });
        });

        describe('$vOutro', function () {
            test('Should be declared', function () {
                $sut = new Produto;
                expect($sut)->toHaveProperty('vOutro');
            });

            test('Should be a subclass of DFeElement::class', function () {
                $reflection = new ReflectionClass(Produto::class);
                $reflectedProperty = $reflection->getProperty('vOutro');
                $sut = $reflectedProperty->getType();
                expect((is_subclass_of($sut->getName(), DFeElement::class)))->toBeTrue();
            });

            test('Should be optional', function () {
                $reflection = new ReflectionClass(Produto::class);
                $reflectedProperty = $reflection->getProperty('vOutro');
                $sut = $reflectedProperty->getType();
                expect($sut->allowsNull())->toBeTrue();
            });
        });

        describe('$indTotal', function () {
            test('Should be declared', function () {
                $sut = new Produto;
                expect($sut)->toHaveProperty('indTotal');
            });

            test('Should be a subclass of DFeElement::class', function () {
                $reflection = new ReflectionClass(Produto::class);
                $reflectedProperty = $reflection->getProperty('indTotal');
                $sut = $reflectedProperty->getType();
                expect((is_subclass_of($sut->getName(), DFeElement::class)))->toBeTrue();
            });

            test('Should be required', function () {
                $reflection = new ReflectionClass(Produto::class);
                $reflectedProperty = $reflection->getProperty('indTotal');
                $sut = $reflectedProperty->getType();
                expect($sut->allowsNull())->toBeFalse();
            });
        })->skip();

        describe('$DI', function () {
            test('Should be declared', function () {
                $sut = new Produto;
                expect($sut)->toHaveProperty('DI');
            });

            test('Should be a subclass of DFeElementCollection::class', function () {
                $reflection = new ReflectionClass(Produto::class);
                $reflectedProperty = $reflection->getProperty('DI');
                $sut = $reflectedProperty->getType();
                expect((is_subclass_of($sut->getName(), DFeElementCollection::class)))->toBeTrue();
            });

            test('Should be optional', function () {
                $reflection = new ReflectionClass(Produto::class);
                $reflectedProperty = $reflection->getProperty('DI');
                $sut = $reflectedProperty->getType();
                expect($sut->allowsNull())->toBeTrue();
            });
        })->skip();

        describe('$detExport', function () {
            test('Should be declared', function () {
                $sut = new Produto;
                expect($sut)->toHaveProperty('detExport');
            });

            test('Should be a subclass of DFeElementCollection::class', function () {
                $reflection = new ReflectionClass(Produto::class);
                $reflectedProperty = $reflection->getProperty('detExport');
                $sut = $reflectedProperty->getType();
                expect((is_subclass_of($sut->getName(), DFeElementCollection::class)))->toBeTrue();
            });

            test('Should be optional', function () {
                $reflection = new ReflectionClass(Produto::class);
                $reflectedProperty = $reflection->getProperty('detExport');
                $sut = $reflectedProperty->getType();
                expect($sut->allowsNull())->toBeTrue();
            });
        })->skip();

        describe('$xPed', function () {
            test('Should be declared', function () {
                $sut = new Produto;
                expect($sut)->toHaveProperty('xPed');
            });

            test('Should be a subclass of DFeElement::class', function () {
                $reflection = new ReflectionClass(Produto::class);
                $reflectedProperty = $reflection->getProperty('xPed');
                $sut = $reflectedProperty->getType();
                expect((is_subclass_of($sut->getName(), DFeElement::class)))->toBeTrue();
            });

            test('Should be optional', function () {
                $reflection = new ReflectionClass(Produto::class);
                $reflectedProperty = $reflection->getProperty('xPed');
                $sut = $reflectedProperty->getType();
                expect($sut->allowsNull())->toBeTrue();
            });
        })->skip();

        describe('$nItemPed', function () {
            test('Should be declared', function () {
                $sut = new Produto;
                expect($sut)->toHaveProperty('nItemPed');
            });

            test('Should be a subclass of DFeElement::class', function () {
                $reflection = new ReflectionClass(Produto::class);
                $reflectedProperty = $reflection->getProperty('nItemPed');
                $sut = $reflectedProperty->getType();
                expect((is_subclass_of($sut->getName(), DFeElement::class)))->toBeTrue();
            });

            test('Should be optional', function () {
                $reflection = new ReflectionClass(Produto::class);
                $reflectedProperty = $reflection->getProperty('nItemPed');
                $sut = $reflectedProperty->getType();
                expect($sut->allowsNull())->toBeTrue();
            });
        })->skip();

        describe('$nFCI', function () {
            test('Should be declared', function () {
                $sut = new Produto;
                expect($sut)->toHaveProperty('nFCI');
            });

            test('Should be a subclass of DFeElement::class', function () {
                $reflection = new ReflectionClass(Produto::class);
                $reflectedProperty = $reflection->getProperty('nFCI');
                $sut = $reflectedProperty->getType();
                expect((is_subclass_of($sut->getName(), DFeElement::class)))->toBeTrue();
            });

            test('Should be optional', function () {
                $reflection = new ReflectionClass(Produto::class);
                $reflectedProperty = $reflection->getProperty('nFCI');
                $sut = $reflectedProperty->getType();
                expect($sut->allowsNull())->toBeTrue();
            });
        })->skip();

        describe('$rastro', function () {
            test('Should be declared', function () {
                $sut = new Produto;
                expect($sut)->toHaveProperty('rastro');
            });

            test('Should be a subclass of DFeElementCollection::class', function () {
                $reflection = new ReflectionClass(Produto::class);
                $reflectedProperty = $reflection->getProperty('rastro');
                $sut = $reflectedProperty->getType();
                expect((is_subclass_of($sut->getName(), DFeElementCollection::class)))->toBeTrue();
            });

            test('Should be optional', function () {
                $reflection = new ReflectionClass(Produto::class);
                $reflectedProperty = $reflection->getProperty('rastro');
                $sut = $reflectedProperty->getType();
                expect($sut->allowsNull())->toBeTrue();
            });
        })->skip();

        describe('$veicProd', function () {
            test('Should be declared', function () {
                $sut = new Produto;
                expect($sut)->toHaveProperty('veicProd');
            });

            test('Should be a subclass of DFeElement::class', function () {
                $reflection = new ReflectionClass(Produto::class);
                $reflectedProperty = $reflection->getProperty('veicProd');
                $sut = $reflectedProperty->getType();
                expect((is_subclass_of($sut->getName(), DFeElement::class)))->toBeTrue();
            });

            test('Should be optional', function () {
                $reflection = new ReflectionClass(Produto::class);
                $reflectedProperty = $reflection->getProperty('veicProd');
                $sut = $reflectedProperty->getType();
                expect($sut->allowsNull())->toBeTrue();
            });
        })->skip();

        describe('$med', function () {
            test('Should be declared', function () {
                $sut = new Produto;
                expect($sut)->toHaveProperty('med');
            });

            test('Should be a subclass of DFeElement::class', function () {
                $reflection = new ReflectionClass(Produto::class);
                $reflectedProperty = $reflection->getProperty('med');
                $sut = $reflectedProperty->getType();
                expect((is_subclass_of($sut->getName(), DFeElement::class)))->toBeTrue();
            });

            test('Should be optional', function () {
                $reflection = new ReflectionClass(Produto::class);
                $reflectedProperty = $reflection->getProperty('med');
                $sut = $reflectedProperty->getType();
                expect($sut->allowsNull())->toBeTrue();
            });
        })->skip();

        describe('$arma', function () {
            test('Should be declared', function () {
                $sut = new Produto;
                expect($sut)->toHaveProperty('arma');
            });

            test('Should be a subclass of DFeElementCollection::class', function () {
                $reflection = new ReflectionClass(Produto::class);
                $reflectedProperty = $reflection->getProperty('arma');
                $sut = $reflectedProperty->getType();
                expect((is_subclass_of($sut->getName(), DFeElementCollection::class)))->toBeTrue();
            });

            test('Should be optional', function () {
                $reflection = new ReflectionClass(Produto::class);
                $reflectedProperty = $reflection->getProperty('arma');
                $sut = $reflectedProperty->getType();
                expect($sut->allowsNull())->toBeTrue();
            });
        })->skip();

        describe('$comb', function () {
            test('Should be declared', function () {
                $sut = new Produto;
                expect($sut)->toHaveProperty('comb');
            });

            test('Should be a subclass of DFeElement::class', function () {
                $reflection = new ReflectionClass(Produto::class);
                $reflectedProperty = $reflection->getProperty('comb');
                $sut = $reflectedProperty->getType();
                expect((is_subclass_of($sut->getName(), DFeElement::class)))->toBeTrue();
            });

            test('Should be optional', function () {
                $reflection = new ReflectionClass(Produto::class);
                $reflectedProperty = $reflection->getProperty('comb');
                $sut = $reflectedProperty->getType();
                expect($sut->allowsNull())->toBeTrue();
            });
        })->skip();

        describe('$nRECOPI', function () {
            test('Should be declared', function () {
                $sut = new Produto;
                expect($sut)->toHaveProperty('nRECOPI');
            });

            test('Should be a subclass of DFeElement::class', function () {
                $reflection = new ReflectionClass(Produto::class);
                $reflectedProperty = $reflection->getProperty('nRECOPI');
                $sut = $reflectedProperty->getType();
                expect((is_subclass_of($sut->getName(), DFeElement::class)))->toBeTrue();
            });

            test('Should be optional', function () {
                $reflection = new ReflectionClass(Produto::class);
                $reflectedProperty = $reflection->getProperty('nRECOPI');
                $sut = $reflectedProperty->getType();
                expect($sut->allowsNull())->toBeTrue();
            });
        })->skip();
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
