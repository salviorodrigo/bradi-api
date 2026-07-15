<?php

declare(strict_types=1);

use BradiApi\Domain\Invoices\NFe\v4_00\InformacoesNotaFiscal;
use BradiApi\Domain\Invoices\Templates\DFeAttribute;
use BradiApi\Domain\Invoices\Templates\DFeElement;
use BradiApi\Domain\Invoices\Templates\DFeElementCollection;
use ReflectionClass;

describe('InformacoesNotaFiscal', function () {
    describe('properties', function () {
        test('Should succeed if InformacoesNotaFiscal is declared', function () {
            $nameSpace = 'BradiApi\Domain\Invoices\NFe\v4_00';
            $sut = $nameSpace . '\\InformacoesNotaFiscal';
            expect(class_exists($sut))->toBeTrue();
        });

        test('Should succeed if InformacoesNotaFiscal extends DFeElement', function () {
            $sut = new InformacoesNotaFiscal;
            expect(is_subclass_of($sut, DFeElement::class))->toBeTrue();
        });
        
        describe('$versao', function () {
            test('Should be declared', function () {
                $sut = new InformacoesNotaFiscal;
                expect($sut)->toHaveProperty('versao');
            })->skip();

            test('Should be a subclass of DFeAttribute::class', function () {
                $reflection = new ReflectionClass(InformacoesNotaFiscal::class);
                $versao = $reflection->getProperty('versao');
                $sut = $versao->getType();

                expect((is_subclass_of($sut->getName(), DFeAttribute::class)))->toBeTrue();
            })->skip();

            test('Should be requited', function () {
                $reflection = new ReflectionClass(InformacoesNotaFiscal::class);
                $versao = $reflection->getProperty('versao');
                $sut = $versao->getType();

                expect($sut->allowsNull())->toBeFalse();
            })->skip();
        });

        describe('$ide', function () {
            test('Should be declared', function () {
                $sut = new InformacoesNotaFiscal;
                expect($sut)->toHaveProperty('ide');
            });

            test('Should be a subclass of DFeElement::class', function () {
                $reflection = new ReflectionClass(InformacoesNotaFiscal::class);
                $ide = $reflection->getProperty('ide');
                $sut = $ide->getType();
                expect((is_subclass_of($sut->getName(), DFeElement::class)))->toBeTrue();
            });
            
            test('Should be requited', function () {
                $reflection = new ReflectionClass(InformacoesNotaFiscal::class);
                $ide = $reflection->getProperty('ide');
                $sut = $ide->getType();

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
                $emit = $reflection->getProperty('emit');
                $sut = $emit->getType();
                expect((is_subclass_of($sut->getName(), DFeElement::class)))->toBeTrue();
            });

            test('Should be required', function () {
                $reflection = new ReflectionClass(InformacoesNotaFiscal::class);
                $emit = $reflection->getProperty('emit');
                $sut = $emit->getType();

                expect($sut->allowsNull())->toBeFalse();
            });
        });

        describe('$dest', function () {
            test('Should be declared', function () {
                $sut = new InformacoesNotaFiscal;
                expect($sut)->toHaveProperty('dest');
            });

            test('Should be a subclass of DFeElement::class', function () {
                $reflection = new ReflectionClass(InformacoesNotaFiscal::class);
                $dest = $reflection->getProperty('dest');
            $sut = $dest->getType();
            expect((is_subclass_of($sut->getName(), DFeElement::class)))->toBeTrue();
        });

            test('Should be optional', function () {
                $reflection = new ReflectionClass(InformacoesNotaFiscal::class);
                $dest = $reflection->getProperty('dest');
                $sut = $dest->getType();

                expect($sut->allowsNull())->toBeTrue();
            });
        });

        describe('$detCollection', function () {
            test('Should be declared', function () {
                $sut = new InformacoesNotaFiscal;
                expect($sut)->toHaveProperty('detCollection');
            });

            test('Should be a subclass of DFeElementCollection::class', function () {
                $reflection = new ReflectionClass(InformacoesNotaFiscal::class);
                $det = $reflection->getProperty('detCollection');
                $sut = $det->getType();

                expect((is_subclass_of($sut->getName(), DFeElementCollection::class)))->toBeTrue();
            });

            test('Should be required', function () {
                $reflection = new ReflectionClass(InformacoesNotaFiscal::class);
                $det = $reflection->getProperty('detCollection');
                $sut = $det->getType();

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
                $total = $reflection->getProperty('total');
                $sut = $total->getType();
                expect((is_subclass_of($sut->getName(), DFeElement::class)))->toBeTrue();
            });

            test('Should be required', function () {
                $reflection = new ReflectionClass(InformacoesNotaFiscal::class);
                $total = $reflection->getProperty('total');
                $sut = $total->getType();

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
                $transp = $reflection->getProperty('transp');
                $sut = $transp->getType();
                expect((is_subclass_of($sut->getName(), DFeElement::class)))->toBeTrue();
            });

            test('Should be required', function () {
                $reflection = new ReflectionClass(InformacoesNotaFiscal::class);
                $transp = $reflection->getProperty('transp');
                $sut = $transp->getType();

                expect($sut->allowsNull())->toBeFalse();
            });
        })->skip();

        describe('$pag', function () {
            test('Should be declared', function () {
                $sut = new InformacoesNotaFiscal;
                expect($sut)->toHaveProperty('pag');
            });

            test('Should be a subclass of DFeElement::class', function () {
                $reflection = new ReflectionClass(InformacoesNotaFiscal::class);
                $pag = $reflection->getProperty('pag');
                $sut = $pag->getType();
                expect((is_subclass_of($sut->getName(), DFeElement::class)))->toBeTrue();
            });

            test('Should be required', function () {
                $reflection = new ReflectionClass(InformacoesNotaFiscal::class);
                $pag = $reflection->getProperty('pag');
                $sut = $pag->getType();

                expect($sut->allowsNull())->toBeFalse();
            });
        })->skip();
    });
});
