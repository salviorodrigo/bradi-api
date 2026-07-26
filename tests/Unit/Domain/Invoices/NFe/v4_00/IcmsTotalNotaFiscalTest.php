<?php

declare(strict_types=1);

use BradiApi\Domain\Common\Protocols\ApiError;
use BradiApi\Domain\Invoices\NFe\v4_00\IcmsTotalNotaFiscal;
use BradiApi\Domain\Invoices\Templates\DFeElement;
use BradiApi\Domain\Xml\ValueObjects\Element;

describe('IcmsTotalNotaFiscal', function () {
    test('Should succeed if IcmsTotalNotaFiscal is declared', function () {
        $nameSpace = 'BradiApi\Domain\Invoices\NFe\v4_00';
        $sut = $nameSpace . '\\IcmsTotalNotaFiscal';
        expect(class_exists($sut))->toBeTrue();
    });

    test('Should succeed if IcmsTotalNotaFiscal extends DFeElement', function () {
        $sut = new IcmsTotalNotaFiscal;
        expect(is_subclass_of($sut, DFeElement::class))->toBeTrue();
    });

    describe('properties', function () {
        describe('FIELD_NAME', function () {
            test('Should be set correctly', function () {
                $reflection = new ReflectionClass(IcmsTotalNotaFiscal::class);
                $reflectedProperty = $reflection->getConstant('FIELD_NAME');
                expect($reflectedProperty)->toBe('ICMSTot');
            });
        });

        describe('$vBC', function () {
            test('Should be declared', function () {
                $sut = new IcmsTotalNotaFiscal;
                expect($sut)->toHaveProperty('vBC');
            });

            test('Should be a subclass of DFeElement::class', function () {
                $reflection = new ReflectionClass(IcmsTotalNotaFiscal::class);
                $reflectedProperty = $reflection->getProperty('vBC');
                $sut = $reflectedProperty->getType();
                expect((is_subclass_of($sut->getName(), DFeElement::class)))->toBeTrue();
            });

            test('Should be required', function () {
                $reflection = new ReflectionClass(IcmsTotalNotaFiscal::class);
                $reflectedProperty = $reflection->getProperty('vBC');
                $sut = $reflectedProperty->getType();
                expect($sut->allowsNull())->toBeFalse();
            });
        });

        describe('$vICMS', function () {
            test('Should be declared', function () {
                $sut = new IcmsTotalNotaFiscal;
                expect($sut)->toHaveProperty('vICMS');
            });

            test('Should be a subclass of DFeElement::class', function () {
                $reflection = new ReflectionClass(IcmsTotalNotaFiscal::class);
                $reflectedProperty = $reflection->getProperty('vICMS');
                $sut = $reflectedProperty->getType();
                expect((is_subclass_of($sut->getName(), DFeElement::class)))->toBeTrue();
            });

            test('Should be required', function () {
                $reflection = new ReflectionClass(IcmsTotalNotaFiscal::class);
                $reflectedProperty = $reflection->getProperty('vICMS');
                $sut = $reflectedProperty->getType();
                expect($sut->allowsNull())->toBeFalse();
            });
        });

        describe('$vICMSDeson', function () {
            test('Should be declared', function () {
                $sut = new IcmsTotalNotaFiscal;
                expect($sut)->toHaveProperty('vICMSDeson');
            });

            test('Should be a subclass of DFeElement::class', function () {
                $reflection = new ReflectionClass(IcmsTotalNotaFiscal::class);
                $reflectedProperty = $reflection->getProperty('vICMSDeson');
                $sut = $reflectedProperty->getType();
                expect((is_subclass_of($sut->getName(), DFeElement::class)))->toBeTrue();
            });

            test('Should be required', function () {
                $reflection = new ReflectionClass(IcmsTotalNotaFiscal::class);
                $reflectedProperty = $reflection->getProperty('vICMSDeson');
                $sut = $reflectedProperty->getType();
                expect($sut->allowsNull())->toBeFalse();
            });
        })->skip();

        describe('$vFCPUFDest', function () {
            test('Should be declared', function () {
                $sut = new IcmsTotalNotaFiscal;
                expect($sut)->toHaveProperty('vFCPUFDest');
            });

            test('Should be a subclass of DFeElement::class', function () {
                $reflection = new ReflectionClass(IcmsTotalNotaFiscal::class);
                $reflectedProperty = $reflection->getProperty('vFCPUFDest');
                $sut = $reflectedProperty->getType();
                expect((is_subclass_of($sut->getName(), DFeElement::class)))->toBeTrue();
            });

            test('Should be optional', function () {
                $reflection = new ReflectionClass(IcmsTotalNotaFiscal::class);
                $reflectedProperty = $reflection->getProperty('vFCPUFDest');
                $sut = $reflectedProperty->getType();
                expect($sut->allowsNull())->toBeTrue();
            });
        })->skip();

        describe('$vICMSUFDest', function () {
            test('Should be declared', function () {
                $sut = new IcmsTotalNotaFiscal;
                expect($sut)->toHaveProperty('vICMSUFDest');
            });

            test('Should be a subclass of DFeElement::class', function () {
                $reflection = new ReflectionClass(IcmsTotalNotaFiscal::class);
                $reflectedProperty = $reflection->getProperty('vICMSUFDest');
                $sut = $reflectedProperty->getType();
                expect((is_subclass_of($sut->getName(), DFeElement::class)))->toBeTrue();
            });

            test('Should be optional', function () {
                $reflection = new ReflectionClass(IcmsTotalNotaFiscal::class);
                $reflectedProperty = $reflection->getProperty('vICMSUFDest');
                $sut = $reflectedProperty->getType();
                expect($sut->allowsNull())->toBeTrue();
            });
        })->skip();

        describe('$vICMSUFRemet', function () {
            test('Should be declared', function () {
                $sut = new IcmsTotalNotaFiscal;
                expect($sut)->toHaveProperty('vICMSUFRemet');
            });

            test('Should be a subclass of DFeElement::class', function () {
                $reflection = new ReflectionClass(IcmsTotalNotaFiscal::class);
                $reflectedProperty = $reflection->getProperty('vICMSUFRemet');
                $sut = $reflectedProperty->getType();
                expect((is_subclass_of($sut->getName(), DFeElement::class)))->toBeTrue();
            });

            test('Should be optional', function () {
                $reflection = new ReflectionClass(IcmsTotalNotaFiscal::class);
                $reflectedProperty = $reflection->getProperty('vICMSUFRemet');
                $sut = $reflectedProperty->getType();
                expect($sut->allowsNull())->toBeFalse();
            });
        })->skip();

        describe('$vFCP', function () {
            test('Should be declared', function () {
                $sut = new IcmsTotalNotaFiscal;
                expect($sut)->toHaveProperty('vFCP');
            });

            test('Should be a subclass of DFeElement::class', function () {
                $reflection = new ReflectionClass(IcmsTotalNotaFiscal::class);
                $reflectedProperty = $reflection->getProperty('vFCP');
                $sut = $reflectedProperty->getType();
                expect((is_subclass_of($sut->getName(), DFeElement::class)))->toBeTrue();
            });

            test('Should be required', function () {
                $reflection = new ReflectionClass(IcmsTotalNotaFiscal::class);
                $reflectedProperty = $reflection->getProperty('vFCP');
                $sut = $reflectedProperty->getType();
                expect($sut->allowsNull())->toBeFalse();
            });
        })->skip();

        describe('$vBCST', function () {
            test('Should be declared', function () {
                $sut = new IcmsTotalNotaFiscal;
                expect($sut)->toHaveProperty('vBCST');
            });

            test('Should be a subclass of DFeElement::class', function () {
                $reflection = new ReflectionClass(IcmsTotalNotaFiscal::class);
                $reflectedProperty = $reflection->getProperty('vBCST');
                $sut = $reflectedProperty->getType();
                expect((is_subclass_of($sut->getName(), DFeElement::class)))->toBeTrue();
            });

            test('Should be required', function () {
                $reflection = new ReflectionClass(IcmsTotalNotaFiscal::class);
                $reflectedProperty = $reflection->getProperty('vBCST');
                $sut = $reflectedProperty->getType();
                expect($sut->allowsNull())->toBeFalse();
            });
        })->skip();

        describe('$vST', function () {
            test('Should be declared', function () {
                $sut = new IcmsTotalNotaFiscal;
                expect($sut)->toHaveProperty('vST');
            });

            test('Should be a subclass of DFeElement::class', function () {
                $reflection = new ReflectionClass(IcmsTotalNotaFiscal::class);
                $reflectedProperty = $reflection->getProperty('vST');
                $sut = $reflectedProperty->getType();
                expect((is_subclass_of($sut->getName(), DFeElement::class)))->toBeTrue();
            });

            test('Should be required', function () {
                $reflection = new ReflectionClass(IcmsTotalNotaFiscal::class);
                $reflectedProperty = $reflection->getProperty('vST');
                $sut = $reflectedProperty->getType();
                expect($sut->allowsNull())->toBeFalse();
            });
        })->skip();

        describe('$vFCPST', function () {
            test('Should be declared', function () {
                $sut = new IcmsTotalNotaFiscal;
                expect($sut)->toHaveProperty('vFCPST');
            });

            test('Should be a subclass of DFeElement::class', function () {
                $reflection = new ReflectionClass(IcmsTotalNotaFiscal::class);
                $reflectedProperty = $reflection->getProperty('vFCPST');
                $sut = $reflectedProperty->getType();
                expect((is_subclass_of($sut->getName(), DFeElement::class)))->toBeTrue();
            });

            test('Should be required', function () {
                $reflection = new ReflectionClass(IcmsTotalNotaFiscal::class);
                $reflectedProperty = $reflection->getProperty('vFCPST');
                $sut = $reflectedProperty->getType();
                expect($sut->allowsNull())->toBeFalse();
            });
        })->skip();

        describe('$vFCPSTRet', function () {
            test('Should be declared', function () {
                $sut = new IcmsTotalNotaFiscal;
                expect($sut)->toHaveProperty('vFCPSTRet');
            });

            test('Should be a subclass of DFeElement::class', function () {
                $reflection = new ReflectionClass(IcmsTotalNotaFiscal::class);
                $reflectedProperty = $reflection->getProperty('vFCPSTRet');
                $sut = $reflectedProperty->getType();
                expect((is_subclass_of($sut->getName(), DFeElement::class)))->toBeTrue();
            });

            test('Should be required', function () {
                $reflection = new ReflectionClass(IcmsTotalNotaFiscal::class);
                $reflectedProperty = $reflection->getProperty('vFCPSTRet');
                $sut = $reflectedProperty->getType();
                expect($sut->allowsNull())->toBeFalse();
            });
        })->skip();

        describe('$vProd', function () {
            test('Should be declared', function () {
                $sut = new IcmsTotalNotaFiscal;
                expect($sut)->toHaveProperty('vProd');
            });

            test('Should be a subclass of DFeElement::class', function () {
                $reflection = new ReflectionClass(IcmsTotalNotaFiscal::class);
                $reflectedProperty = $reflection->getProperty('vProd');
                $sut = $reflectedProperty->getType();
                expect((is_subclass_of($sut->getName(), DFeElement::class)))->toBeTrue();
            });

            test('Should be required', function () {
                $reflection = new ReflectionClass(IcmsTotalNotaFiscal::class);
                $reflectedProperty = $reflection->getProperty('vProd');
                $sut = $reflectedProperty->getType();
                expect($sut->allowsNull())->toBeFalse();
            });
        });

        describe('$vFrete', function () {
            test('Should be declared', function () {
                $sut = new IcmsTotalNotaFiscal;
                expect($sut)->toHaveProperty('vFrete');
            });

            test('Should be a subclass of DFeElement::class', function () {
                $reflection = new ReflectionClass(IcmsTotalNotaFiscal::class);
                $reflectedProperty = $reflection->getProperty('vFrete');
                $sut = $reflectedProperty->getType();
                expect((is_subclass_of($sut->getName(), DFeElement::class)))->toBeTrue();
            });

            test('Should be required', function () {
                $reflection = new ReflectionClass(IcmsTotalNotaFiscal::class);
                $reflectedProperty = $reflection->getProperty('vFrete');
                $sut = $reflectedProperty->getType();
                expect($sut->allowsNull())->toBeFalse();
            });
        });

        describe('$vSeg', function () {
            test('Should be declared', function () {
                $sut = new IcmsTotalNotaFiscal;
                expect($sut)->toHaveProperty('vSeg');
            });

            test('Should be a subclass of DFeElement::class', function () {
                $reflection = new ReflectionClass(IcmsTotalNotaFiscal::class);
                $reflectedProperty = $reflection->getProperty('vSeg');
                $sut = $reflectedProperty->getType();
                expect((is_subclass_of($sut->getName(), DFeElement::class)))->toBeTrue();
            });

            test('Should be required', function () {
                $reflection = new ReflectionClass(IcmsTotalNotaFiscal::class);
                $reflectedProperty = $reflection->getProperty('vSeg');
                $sut = $reflectedProperty->getType();
                expect($sut->allowsNull())->toBeFalse();
            });
        });

        describe('$vDesc', function () {
            test('Should be declared', function () {
                $sut = new IcmsTotalNotaFiscal;
                expect($sut)->toHaveProperty('vDesc');
            });

            test('Should be a subclass of DFeElement::class', function () {
                $reflection = new ReflectionClass(IcmsTotalNotaFiscal::class);
                $reflectedProperty = $reflection->getProperty('vDesc');
                $sut = $reflectedProperty->getType();
                expect((is_subclass_of($sut->getName(), DFeElement::class)))->toBeTrue();
            });

            test('Should be required', function () {
                $reflection = new ReflectionClass(IcmsTotalNotaFiscal::class);
                $reflectedProperty = $reflection->getProperty('vDesc');
                $sut = $reflectedProperty->getType();
                expect($sut->allowsNull())->toBeFalse();
            });
        });

        describe('$vII', function () {
            test('Should be declared', function () {
                $sut = new IcmsTotalNotaFiscal;
                expect($sut)->toHaveProperty('vII');
            });

            test('Should be a subclass of DFeElement::class', function () {
                $reflection = new ReflectionClass(IcmsTotalNotaFiscal::class);
                $reflectedProperty = $reflection->getProperty('vII');
                $sut = $reflectedProperty->getType();
                expect((is_subclass_of($sut->getName(), DFeElement::class)))->toBeTrue();
            });

            test('Should be required', function () {
                $reflection = new ReflectionClass(IcmsTotalNotaFiscal::class);
                $reflectedProperty = $reflection->getProperty('vII');
                $sut = $reflectedProperty->getType();
                expect($sut->allowsNull())->toBeFalse();
            });
        })->skip();

        describe('$vIPI', function () {
            test('Should be declared', function () {
                $sut = new IcmsTotalNotaFiscal;
                expect($sut)->toHaveProperty('vIPI');
            });

            test('Should be a subclass of DFeElement::class', function () {
                $reflection = new ReflectionClass(IcmsTotalNotaFiscal::class);
                $reflectedProperty = $reflection->getProperty('vIPI');
                $sut = $reflectedProperty->getType();
                expect((is_subclass_of($sut->getName(), DFeElement::class)))->toBeTrue();
            });

            test('Should be required', function () {
                $reflection = new ReflectionClass(IcmsTotalNotaFiscal::class);
                $reflectedProperty = $reflection->getProperty('vIPI');
                $sut = $reflectedProperty->getType();
                expect($sut->allowsNull())->toBeFalse();
            });
        })->skip();

        describe('$vIPIDevol', function () {
            test('Should be declared', function () {
                $sut = new IcmsTotalNotaFiscal;
                expect($sut)->toHaveProperty('vIPIDevol');
            });

            test('Should be a subclass of DFeElement::class', function () {
                $reflection = new ReflectionClass(IcmsTotalNotaFiscal::class);
                $reflectedProperty = $reflection->getProperty('vIPIDevol');
                $sut = $reflectedProperty->getType();
                expect((is_subclass_of($sut->getName(), DFeElement::class)))->toBeTrue();
            });

            test('Should be required', function () {
                $reflection = new ReflectionClass(IcmsTotalNotaFiscal::class);
                $reflectedProperty = $reflection->getProperty('vIPIDevol');
                $sut = $reflectedProperty->getType();
                expect($sut->allowsNull())->toBeFalse();
            });
        })->skip();

        describe('$vPIS', function () {
            test('Should be declared', function () {
                $sut = new IcmsTotalNotaFiscal;
                expect($sut)->toHaveProperty('vPIS');
            });

            test('Should be a subclass of DFeElement::class', function () {
                $reflection = new ReflectionClass(IcmsTotalNotaFiscal::class);
                $reflectedProperty = $reflection->getProperty('vPIS');
                $sut = $reflectedProperty->getType();
                expect((is_subclass_of($sut->getName(), DFeElement::class)))->toBeTrue();
            });

            test('Should be required', function () {
                $reflection = new ReflectionClass(IcmsTotalNotaFiscal::class);
                $reflectedProperty = $reflection->getProperty('vPIS');
                $sut = $reflectedProperty->getType();
                expect($sut->allowsNull())->toBeFalse();
            });
        });

        describe('$vCOFINS', function () {
            test('Should be declared', function () {
                $sut = new IcmsTotalNotaFiscal;
                expect($sut)->toHaveProperty('vCOFINS');
            });

            test('Should be a subclass of DFeElement::class', function () {
                $reflection = new ReflectionClass(IcmsTotalNotaFiscal::class);
                $reflectedProperty = $reflection->getProperty('vCOFINS');
                $sut = $reflectedProperty->getType();
                expect((is_subclass_of($sut->getName(), DFeElement::class)))->toBeTrue();
            });

            test('Should be required', function () {
                $reflection = new ReflectionClass(IcmsTotalNotaFiscal::class);
                $reflectedProperty = $reflection->getProperty('vCOFINS');
                $sut = $reflectedProperty->getType();
                expect($sut->allowsNull())->toBeFalse();
            });
        });

        describe('$vOutro', function () {
            test('Should be declared', function () {
                $sut = new IcmsTotalNotaFiscal;
                expect($sut)->toHaveProperty('vOutro');
            });

            test('Should be a subclass of DFeElement::class', function () {
                $reflection = new ReflectionClass(IcmsTotalNotaFiscal::class);
                $reflectedProperty = $reflection->getProperty('vOutro');
                $sut = $reflectedProperty->getType();
                expect((is_subclass_of($sut->getName(), DFeElement::class)))->toBeTrue();
            });

            test('Should be required', function () {
                $reflection = new ReflectionClass(IcmsTotalNotaFiscal::class);
                $reflectedProperty = $reflection->getProperty('vOutro');
                $sut = $reflectedProperty->getType();
                expect($sut->allowsNull())->toBeFalse();
            });
        });

        describe('$vNF', function () {
            test('Should be declared', function () {
                $sut = new IcmsTotalNotaFiscal;
                expect($sut)->toHaveProperty('vNF');
            });

            test('Should be a subclass of DFeElement::class', function () {
                $reflection = new ReflectionClass(IcmsTotalNotaFiscal::class);
                $reflectedProperty = $reflection->getProperty('vNF');
                $sut = $reflectedProperty->getType();
                expect((is_subclass_of($sut->getName(), DFeElement::class)))->toBeTrue();
            });

            test('Should be required', function () {
                $reflection = new ReflectionClass(IcmsTotalNotaFiscal::class);
                $reflectedProperty = $reflection->getProperty('vNF');
                $sut = $reflectedProperty->getType();
                expect($sut->allowsNull())->toBeFalse();
            });
        })->skip();

        describe('$vTotTrib', function () {
            test('Should be declared', function () {
                $sut = new IcmsTotalNotaFiscal;
                expect($sut)->toHaveProperty('vTotTrib');
            });

            test('Should be a subclass of DFeElement::class', function () {
                $reflection = new ReflectionClass(IcmsTotalNotaFiscal::class);
                $reflectedProperty = $reflection->getProperty('vTotTrib');
                $sut = $reflectedProperty->getType();
                expect((is_subclass_of($sut->getName(), DFeElement::class)))->toBeTrue();
            });

            test('Should be required', function () {
                $reflection = new ReflectionClass(IcmsTotalNotaFiscal::class);
                $reflectedProperty = $reflection->getProperty('vTotTrib');
                $sut = $reflectedProperty->getType();
                expect($sut->allowsNull())->toBeFalse();
            });
        })->skip();
    });

    describe('methods', function () {
        describe('validateTagAttributes', function () {
            test('Should fail if an attribute is provided', function () {
                $xmlString = '<total attribute="value"/>';
                $xmlElement = new Element;
                $xmlElement->parse($xmlString);
                $targetClass = new IcmsTotalNotaFiscal;
                $sut = new ReflectionMethod($targetClass, 'validateTagAttributes');
                $sutResponse = $sut->invoke($targetClass, $xmlElement);
                expect($sutResponse->isFailure())->toBeTrue();
            });
        });

        describe('validateTagElements', function () {
            test('Should succeed if all required tags are provided', function () {
                $xmlString = '<ICMSTot><vBC/><vICMS/><vICMSDeson/><vFCP/><vBCST/><vST/><vFCPST/><vFCPSTRet/><vProd/><vFrete/><vSeg/><vDesc/><vII/><vIPI/><vIPIDevol/><vPIS/><vCOFINS/><vOutro/><vNF/></ICMSTot>';
                $xmlElement = new Element;
                $xmlElement->parse($xmlString);
                $targetClass = new IcmsTotalNotaFiscal;
                $sut = new ReflectionMethod($targetClass, 'validateTagElements');
                $sutResponse = $sut->invoke($targetClass, $xmlElement);
                expect($sutResponse->isSuccess())->toBeTrue();
            });

            test('Should succeed if all tags is provided', function () {
                $xmlString = '<ICMSTot><vBC/><vICMS/><vICMSDeson/><vFCPUFDest/><vICMSUFDest/><vICMSUFRemet/><vFCP/><vBCST/><vST/><vFCPST/><vFCPSTRet/><vProd/><vFrete/><vSeg/><vDesc/><vII/><vIPI/><vIPIDevol/><vPIS/><vCOFINS/><vOutro/><vNF/><vTotTrib/></ICMSTot>';
                $xmlElement = new Element;
                $xmlElement->parse($xmlString);
                $targetClass = new IcmsTotalNotaFiscal;
                $sut = new ReflectionMethod($targetClass, 'validateTagElements');
                $sutResponse = $sut->invoke($targetClass, $xmlElement);
                expect($sutResponse->isSuccess())->toBeTrue();
            });

            test('Should fail if vBC is missing', function () {
                $xmlString = '<ICMSTot><vICMS/><vICMSDeson/><vFCPUFDest/><vICMSUFDest/><vICMSUFRemet/><vFCP/><vBCST/><vST/><vFCPST/><vFCPSTRet/><vProd/><vFrete/><vSeg/><vDesc/><vII/><vIPI/><vIPIDevol/><vPIS/><vCOFINS/><vOutro/><vNF/><vTotTrib/></ICMSTot>';
                $xmlElement = new Element;
                $xmlElement->parse($xmlString);
                $targetClass = new IcmsTotalNotaFiscal;
                $sut = new ReflectionMethod($targetClass, 'validateTagElements');
                $sutResponse = $sut->invoke($targetClass, $xmlElement);
                expect($sutResponse->isFailure())->toBeTrue();
            });

            test('Should fail if vICMS is missing', function () {
                $xmlString = '<ICMSTot><vBC/><vICMSDeson/><vFCPUFDest/><vICMSUFDest/><vICMSUFRemet/><vFCP/><vBCST/><vST/><vFCPST/><vFCPSTRet/><vProd/><vFrete/><vSeg/><vDesc/><vII/><vIPI/><vIPIDevol/><vPIS/><vCOFINS/><vOutro/><vNF/><vTotTrib/></ICMSTot>';
                $xmlElement = new Element;
                $xmlElement->parse($xmlString);
                $targetClass = new IcmsTotalNotaFiscal;
                $sut = new ReflectionMethod($targetClass, 'validateTagElements');
                $sutResponse = $sut->invoke($targetClass, $xmlElement);
                expect($sutResponse->isFailure())->toBeTrue();
            });

            test('Should fail if vICMSDeson is missing', function () {
                $xmlString = '<ICMSTot><vBC/><vICMS/><vFCPUFDest/><vICMSUFDest/><vICMSUFRemet/><vFCP/><vBCST/><vST/><vFCPST/><vFCPSTRet/><vProd/><vFrete/><vSeg/><vDesc/><vII/><vIPI/><vIPIDevol/><vPIS/><vCOFINS/><vOutro/><vNF/><vTotTrib/></ICMSTot>';
                $xmlElement = new Element;
                $xmlElement->parse($xmlString);
                $targetClass = new IcmsTotalNotaFiscal;
                $sut = new ReflectionMethod($targetClass, 'validateTagElements');
                $sutResponse = $sut->invoke($targetClass, $xmlElement);
                expect($sutResponse->isFailure())->toBeTrue();
            });

            test('Should fail if vFCP is missing', function () {
                $xmlString = '<ICMSTot><vBC/><vICMS/><vICMSDeson/><vFCPUFDest/><vICMSUFDest/><vICMSUFRemet/><vBCST/><vST/><vFCPST/><vFCPSTRet/><vProd/><vFrete/><vSeg/><vDesc/><vII/><vIPI/><vIPIDevol/><vPIS/><vCOFINS/><vOutro/><vNF/><vTotTrib/></ICMSTot>';
                $xmlElement = new Element;
                $xmlElement->parse($xmlString);
                $targetClass = new IcmsTotalNotaFiscal;
                $sut = new ReflectionMethod($targetClass, 'validateTagElements');
                $sutResponse = $sut->invoke($targetClass, $xmlElement);
                expect($sutResponse->isFailure())->toBeTrue();
            });

            test('Should fail if vBCST is missing', function () {
                $xmlString = '<ICMSTot><vBC/><vICMS/><vICMSDeson/><vFCPUFDest/><vICMSUFDest/><vICMSUFRemet/><vFCP/><vST/><vFCPST/><vFCPSTRet/><vProd/><vFrete/><vSeg/><vDesc/><vII/><vIPI/><vIPIDevol/><vPIS/><vCOFINS/><vOutro/><vNF/><vTotTrib/></ICMSTot>';
                $xmlElement = new Element;
                $xmlElement->parse($xmlString);
                $targetClass = new IcmsTotalNotaFiscal;
                $sut = new ReflectionMethod($targetClass, 'validateTagElements');
                $sutResponse = $sut->invoke($targetClass, $xmlElement);
                expect($sutResponse->isFailure())->toBeTrue();
            });

            test('Should fail if vST is missing', function () {
                $xmlString = '<ICMSTot><vBC/><vICMS/><vICMSDeson/><vFCPUFDest/><vICMSUFDest/><vICMSUFRemet/><vFCP/><vBCST/><vFCPST/><vFCPSTRet/><vProd/><vFrete/><vSeg/><vDesc/><vII/><vIPI/><vIPIDevol/><vPIS/><vCOFINS/><vOutro/><vNF/><vTotTrib/></ICMSTot>';
                $xmlElement = new Element;
                $xmlElement->parse($xmlString);
                $targetClass = new IcmsTotalNotaFiscal;
                $sut = new ReflectionMethod($targetClass, 'validateTagElements');
                $sutResponse = $sut->invoke($targetClass, $xmlElement);
                expect($sutResponse->isFailure())->toBeTrue();
            });

            test('Should fail if vFCPST is missing', function () {
                $xmlString = '<ICMSTot><vBC/><vICMS/><vICMSDeson/><vFCPUFDest/><vICMSUFDest/><vICMSUFRemet/><vFCP/><vBCST/><vST/><vFCPSTRet/><vProd/><vFrete/><vSeg/><vDesc/><vII/><vIPI/><vIPIDevol/><vPIS/><vCOFINS/><vOutro/><vNF/><vTotTrib/></ICMSTot>';
                $xmlElement = new Element;
                $xmlElement->parse($xmlString);
                $targetClass = new IcmsTotalNotaFiscal;
                $sut = new ReflectionMethod($targetClass, 'validateTagElements');
                $sutResponse = $sut->invoke($targetClass, $xmlElement);
                expect($sutResponse->isFailure())->toBeTrue();
            });

            test('Should fail if vFCPSTRet is missing', function () {
                $xmlString = '<ICMSTot><vBC/><vICMS/><vICMSDeson/><vFCPUFDest/><vICMSUFDest/><vICMSUFRemet/><vFCP/><vBCST/><vST/><vFCPST/><vProd/><vFrete/><vSeg/><vDesc/><vII/><vIPI/><vIPIDevol/><vPIS/><vCOFINS/><vOutro/><vNF/><vTotTrib/></ICMSTot>';
                $xmlElement = new Element;
                $xmlElement->parse($xmlString);
                $targetClass = new IcmsTotalNotaFiscal;
                $sut = new ReflectionMethod($targetClass, 'validateTagElements');
                $sutResponse = $sut->invoke($targetClass, $xmlElement);
                expect($sutResponse->isFailure())->toBeTrue();
            });

            test('Should fail if vProd is missing', function () {
                $xmlString = '<ICMSTot><vBC/><vICMS/><vICMSDeson/><vFCPUFDest/><vICMSUFDest/><vICMSUFRemet/><vFCP/><vBCST/><vST/><vFCPST/><vFCPSTRet/><vFrete/><vSeg/><vDesc/><vII/><vIPI/><vIPIDevol/><vPIS/><vCOFINS/><vOutro/><vNF/><vTotTrib/></ICMSTot>';
                $xmlElement = new Element;
                $xmlElement->parse($xmlString);
                $targetClass = new IcmsTotalNotaFiscal;
                $sut = new ReflectionMethod($targetClass, 'validateTagElements');
                $sutResponse = $sut->invoke($targetClass, $xmlElement);
                expect($sutResponse->isFailure())->toBeTrue();
            });

            test('Should fail if vFrete is missing', function () {
                $xmlString = '<ICMSTot><vBC/><vICMS/><vICMSDeson/><vFCPUFDest/><vICMSUFDest/><vICMSUFRemet/><vFCP/><vBCST/><vST/><vFCPST/><vFCPSTRet/><vProd/><vSeg/><vDesc/><vII/><vIPI/><vIPIDevol/><vPIS/><vCOFINS/><vOutro/><vNF/><vTotTrib/></ICMSTot>';
                $xmlElement = new Element;
                $xmlElement->parse($xmlString);
                $targetClass = new IcmsTotalNotaFiscal;
                $sut = new ReflectionMethod($targetClass, 'validateTagElements');
                $sutResponse = $sut->invoke($targetClass, $xmlElement);
                expect($sutResponse->isFailure())->toBeTrue();
            });

            test('Should fail if vSeg is missing', function () {
                $xmlString = '<ICMSTot><vBC/><vICMS/><vICMSDeson/><vFCPUFDest/><vICMSUFDest/><vICMSUFRemet/><vFCP/><vBCST/><vST/><vFCPST/><vFCPSTRet/><vProd/><vFrete/><vDesc/><vII/><vIPI/><vIPIDevol/><vPIS/><vCOFINS/><vOutro/><vNF/><vTotTrib/></ICMSTot>';
                $xmlElement = new Element;
                $xmlElement->parse($xmlString);
                $targetClass = new IcmsTotalNotaFiscal;
                $sut = new ReflectionMethod($targetClass, 'validateTagElements');
                $sutResponse = $sut->invoke($targetClass, $xmlElement);
                expect($sutResponse->isFailure())->toBeTrue();
            });

            test('Should fail if vDesc is missing', function () {
                $xmlString = '<ICMSTot><vBC/><vICMS/><vICMSDeson/><vFCPUFDest/><vICMSUFDest/><vICMSUFRemet/><vFCP/><vBCST/><vST/><vFCPST/><vFCPSTRet/><vProd/><vFrete/><vSeg/><vII/><vIPI/><vIPIDevol/><vPIS/><vCOFINS/><vOutro/><vNF/><vTotTrib/></ICMSTot>';
                $xmlElement = new Element;
                $xmlElement->parse($xmlString);
                $targetClass = new IcmsTotalNotaFiscal;
                $sut = new ReflectionMethod($targetClass, 'validateTagElements');
                $sutResponse = $sut->invoke($targetClass, $xmlElement);
                expect($sutResponse->isFailure())->toBeTrue();
            });

            test('Should fail if vII is missing', function () {
                $xmlString = '<ICMSTot><vBC/><vICMS/><vICMSDeson/><vFCPUFDest/><vICMSUFDest/><vICMSUFRemet/><vFCP/><vBCST/><vST/><vFCPST/><vFCPSTRet/><vProd/><vFrete/><vSeg/><vDesc/><vIPI/><vIPIDevol/><vPIS/><vCOFINS/><vOutro/><vNF/><vTotTrib/></ICMSTot>';
                $xmlElement = new Element;
                $xmlElement->parse($xmlString);
                $targetClass = new IcmsTotalNotaFiscal;
                $sut = new ReflectionMethod($targetClass, 'validateTagElements');
                $sutResponse = $sut->invoke($targetClass, $xmlElement);
                expect($sutResponse->isFailure())->toBeTrue();
            });

            test('Should fail if vIPI is missing', function () {
                $xmlString = '<ICMSTot><vBC/><vICMS/><vICMSDeson/><vFCPUFDest/><vICMSUFDest/><vICMSUFRemet/><vFCP/><vBCST/><vST/><vFCPST/><vFCPSTRet/><vProd/><vFrete/><vSeg/><vDesc/><vII/><vIPIDevol/><vPIS/><vCOFINS/><vOutro/><vNF/><vTotTrib/></ICMSTot>';
                $xmlElement = new Element;
                $xmlElement->parse($xmlString);
                $targetClass = new IcmsTotalNotaFiscal;
                $sut = new ReflectionMethod($targetClass, 'validateTagElements');
                $sutResponse = $sut->invoke($targetClass, $xmlElement);
                expect($sutResponse->isFailure())->toBeTrue();
            });

            test('Should fail if vIPIDevol is missing', function () {
                $xmlString = '<ICMSTot><vBC/><vICMS/><vICMSDeson/><vFCPUFDest/><vICMSUFDest/><vICMSUFRemet/><vFCP/><vBCST/><vST/><vFCPST/><vFCPSTRet/><vProd/><vFrete/><vSeg/><vDesc/><vII/><vIPI/><vPIS/><vCOFINS/><vOutro/><vNF/><vTotTrib/></ICMSTot>';
                $xmlElement = new Element;
                $xmlElement->parse($xmlString);
                $targetClass = new IcmsTotalNotaFiscal;
                $sut = new ReflectionMethod($targetClass, 'validateTagElements');
                $sutResponse = $sut->invoke($targetClass, $xmlElement);
                expect($sutResponse->isFailure())->toBeTrue();
            });

            test('Should fail if vPIS is missing', function () {
                $xmlString = '<ICMSTot><vBC/><vICMS/><vICMSDeson/><vFCPUFDest/><vICMSUFDest/><vICMSUFRemet/><vFCP/><vBCST/><vST/><vFCPST/><vFCPSTRet/><vProd/><vFrete/><vSeg/><vDesc/><vII/><vIPI/><vIPIDevol/><vCOFINS/><vOutro/><vNF/><vTotTrib/></ICMSTot>';
                $xmlElement = new Element;
                $xmlElement->parse($xmlString);
                $targetClass = new IcmsTotalNotaFiscal;
                $sut = new ReflectionMethod($targetClass, 'validateTagElements');
                $sutResponse = $sut->invoke($targetClass, $xmlElement);
                expect($sutResponse->isFailure())->toBeTrue();
            });

            test('Should fail if vCOFINS is missing', function () {
                $xmlString = '<ICMSTot><vBC/><vICMS/><vICMSDeson/><vFCPUFDest/><vICMSUFDest/><vICMSUFRemet/><vFCP/><vBCST/><vST/><vFCPST/><vFCPSTRet/><vProd/><vFrete/><vSeg/><vDesc/><vII/><vIPI/><vIPIDevol/><vPIS/><vOutro/><vNF/><vTotTrib/></ICMSTot>';
                $xmlElement = new Element;
                $xmlElement->parse($xmlString);
                $targetClass = new IcmsTotalNotaFiscal;
                $sut = new ReflectionMethod($targetClass, 'validateTagElements');
                $sutResponse = $sut->invoke($targetClass, $xmlElement);
                expect($sutResponse->isFailure())->toBeTrue();
            });

            test('Should fail if vOutro is missing', function () {
                $xmlString = '<ICMSTot><vBC/><vICMS/><vICMSDeson/><vFCPUFDest/><vICMSUFDest/><vICMSUFRemet/><vFCP/><vBCST/><vST/><vFCPST/><vFCPSTRet/><vProd/><vFrete/><vSeg/><vDesc/><vII/><vIPI/><vIPIDevol/><vPIS/><vCOFINS/><vNF/><vTotTrib/></ICMSTot>';
                $xmlElement = new Element;
                $xmlElement->parse($xmlString);
                $targetClass = new IcmsTotalNotaFiscal;
                $sut = new ReflectionMethod($targetClass, 'validateTagElements');
                $sutResponse = $sut->invoke($targetClass, $xmlElement);
                expect($sutResponse->isFailure())->toBeTrue();
            });

            test('Should fail if vNF is missing', function () {
                $xmlString = '<ICMSTot><vBC/><vICMS/><vICMSDeson/><vFCPUFDest/><vICMSUFDest/><vICMSUFRemet/><vFCP/><vBCST/><vST/><vFCPST/><vFCPSTRet/><vProd/><vFrete/><vSeg/><vDesc/><vII/><vIPI/><vIPIDevol/><vPIS/><vCOFINS/><vOutro/><vTotTrib/></ICMSTot>';
                $xmlElement = new Element;
                $xmlElement->parse($xmlString);
                $targetClass = new IcmsTotalNotaFiscal;
                $sut = new ReflectionMethod($targetClass, 'validateTagElements');
                $sutResponse = $sut->invoke($targetClass, $xmlElement);
                expect($sutResponse->isFailure())->toBeTrue();
            });

            test('Should fail if an unallowed tag is provided', function () {
                $xmlString = '<ICMSTot><unallowedTag/><ICMSTot/><ISSQNtot/><retTrib/></ICMSTot>';
                $xmlElement = new Element;
                $xmlElement->parse($xmlString);
                $targetClass = new IcmsTotalNotaFiscal;
                $sut = new ReflectionMethod($targetClass, 'validateTagElements');
                $sutResponse = $sut->invoke($targetClass, $xmlElement);
                expect($sutResponse->isFailure())->toBeTrue();
            });
        });

        describe('validateTagValue', function () {
            test('Should fail if a value is provided', function () {
                $xmlString = '<ICMSTot>value</ICMSTot>';
                $xmlElement = new Element;
                $xmlElement->parse($xmlString);
                $targetClass = new IcmsTotalNotaFiscal;
                $sut = new ReflectionMethod($targetClass, 'validateTagValue');
                $sutResponse = $sut->invoke($targetClass, $xmlElement);
                expect($sutResponse->isFailure())->toBeTrue();
                expect($sutResponse->getError())->toBeInstanceOf(ApiError::class);
            });
        });
    });
});
