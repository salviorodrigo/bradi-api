<?php

declare(strict_types=1);

use BradiApi\Domain\Common\Protocols\ApiError;
use BradiApi\Domain\Invoices\NFe\v4_00\Icms;
use BradiApi\Domain\Invoices\Templates\DFeElement;
use BradiApi\Domain\Xml\ValueObjects\Element;
use BradiApi\Tests\TestCase;

describe('Icms', function () {
    test('Should succeed if Icms is declared', function () {
        $nameSpace = 'BradiApi\Domain\Invoices\NFe\v4_00';
        $sut = $nameSpace . '\\Icms';
        expect(class_exists($sut))->toBeTrue();
    });

    test('Should succeed if Icms extends DFeElement', function () {
        $sut = new Icms;
        expect(is_subclass_of($sut, DFeElement::class))->toBeTrue();
    });

    beforeEach(function () {
        /** @var TestCase $this */
        $this->sut = new Icms;
    });

    describe('properties', function () {
        describe('$ICMS00', function () {
            test('Should be declared', function () {
                $sut = new Icms;
                expect($sut)->toHaveProperty('ICMS00');
            });

            test('Should be a subclass of DFeElement::class', function () {
                $reflection = new ReflectionClass(Icms::class);
                $reflectedProperty = $reflection->getProperty('ICMS00');
                $sut = $reflectedProperty->getType();
                expect((is_subclass_of($sut->getName(), DFeElement::class)))->toBeTrue();
            });

            test('Should be optional', function () {
                $reflection = new ReflectionClass(Icms::class);
                $reflectedProperty = $reflection->getProperty('ICMS00');
                $sut = $reflectedProperty->getType();
                expect($sut->allowsNull())->toBeTrue();
            });
        });

        describe('$ICMS10', function () {
            test('Should be declared', function () {
                $sut = new Icms;
                expect($sut)->toHaveProperty('ICMS10');
            });

            test('Should be a subclass of DFeElement::class', function () {
                $reflection = new ReflectionClass(Icms::class);
                $reflectedProperty = $reflection->getProperty('ICMS10');
                $sut = $reflectedProperty->getType();
                expect((is_subclass_of($sut->getName(), DFeElement::class)))->toBeTrue();
            });

            test('Should be optional', function () {
                $reflection = new ReflectionClass(Icms::class);
                $reflectedProperty = $reflection->getProperty('ICMS10');
                $sut = $reflectedProperty->getType();
                expect($sut->allowsNull())->toBeTrue();
            });
        })->skip();

        describe('$ICMS20', function () {
            test('Should be declared', function () {
                $sut = new Icms;
                expect($sut)->toHaveProperty('ICMS20');
            });

            test('Should be a subclass of DFeElement::class', function () {
                $reflection = new ReflectionClass(Icms::class);
                $reflectedProperty = $reflection->getProperty('ICMS20');
                $sut = $reflectedProperty->getType();
                expect((is_subclass_of($sut->getName(), DFeElement::class)))->toBeTrue();
            });

            test('Should be optional', function () {
                $reflection = new ReflectionClass(Icms::class);
                $reflectedProperty = $reflection->getProperty('ICMS20');
                $sut = $reflectedProperty->getType();
                expect($sut->allowsNull())->toBeTrue();
            });
        })->skip();

        describe('$ICMS30', function () {
            test('Should be declared', function () {
                $sut = new Icms;
                expect($sut)->toHaveProperty('ICMS30');
            });

            test('Should be a subclass of DFeElement::class', function () {
                $reflection = new ReflectionClass(Icms::class);
                $reflectedProperty = $reflection->getProperty('ICMS30');
                $sut = $reflectedProperty->getType();
                expect((is_subclass_of($sut->getName(), DFeElement::class)))->toBeTrue();
            });

            test('Should be optional', function () {
                $reflection = new ReflectionClass(Icms::class);
                $reflectedProperty = $reflection->getProperty('ICMS30');
                $sut = $reflectedProperty->getType();
                expect($sut->allowsNull())->toBeTrue();
            });
        })->skip();

        describe('$ICMS40', function () {
            test('Should be declared', function () {
                $sut = new Icms;
                expect($sut)->toHaveProperty('ICMS40');
            });

            test('Should be a subclass of DFeElement::class', function () {
                $reflection = new ReflectionClass(Icms::class);
                $reflectedProperty = $reflection->getProperty('ICMS40');
                $sut = $reflectedProperty->getType();
                expect((is_subclass_of($sut->getName(), DFeElement::class)))->toBeTrue();
            });

            test('Should be optional', function () {
                $reflection = new ReflectionClass(Icms::class);
                $reflectedProperty = $reflection->getProperty('ICMS40');
                $sut = $reflectedProperty->getType();
                expect($sut->allowsNull())->toBeTrue();
            });
        })->skip();

        describe('$ICMS51', function () {
            test('Should be declared', function () {
                $sut = new Icms;
                expect($sut)->toHaveProperty('ICMS51');
            });

            test('Should be a subclass of DFeElement::class', function () {
                $reflection = new ReflectionClass(Icms::class);
                $reflectedProperty = $reflection->getProperty('ICMS51');
                $sut = $reflectedProperty->getType();
                expect((is_subclass_of($sut->getName(), DFeElement::class)))->toBeTrue();
            });

            test('Should be optional', function () {
                $reflection = new ReflectionClass(Icms::class);
                $reflectedProperty = $reflection->getProperty('ICMS51');
                $sut = $reflectedProperty->getType();
                expect($sut->allowsNull())->toBeTrue();
            });
        })->skip();

        describe('$ICMS60', function () {
            test('Should be declared', function () {
                $sut = new Icms;
                expect($sut)->toHaveProperty('ICMS60');
            });

            test('Should be a subclass of DFeElement::class', function () {
                $reflection = new ReflectionClass(Icms::class);
                $reflectedProperty = $reflection->getProperty('ICMS60');
                $sut = $reflectedProperty->getType();
                expect((is_subclass_of($sut->getName(), DFeElement::class)))->toBeTrue();
            });

            test('Should be optional', function () {
                $reflection = new ReflectionClass(Icms::class);
                $reflectedProperty = $reflection->getProperty('ICMS60');
                $sut = $reflectedProperty->getType();
                expect($sut->allowsNull())->toBeTrue();
            });
        })->skip();

        describe('$ICMS70', function () {
            test('Should be declared', function () {
                $sut = new Icms;
                expect($sut)->toHaveProperty('ICMS70');
            });

            test('Should be a subclass of DFeElement::class', function () {
                $reflection = new ReflectionClass(Icms::class);
                $reflectedProperty = $reflection->getProperty('ICMS70');
                $sut = $reflectedProperty->getType();
                expect((is_subclass_of($sut->getName(), DFeElement::class)))->toBeTrue();
            });

            test('Should be optional', function () {
                $reflection = new ReflectionClass(Icms::class);
                $reflectedProperty = $reflection->getProperty('ICMS70');
                $sut = $reflectedProperty->getType();
                expect($sut->allowsNull())->toBeTrue();
            });
        })->skip();

        describe('$ICMS90', function () {
            test('Should be declared', function () {
                $sut = new Icms;
                expect($sut)->toHaveProperty('ICMS90');
            });

            test('Should be a subclass of DFeElement::class', function () {
                $reflection = new ReflectionClass(Icms::class);
                $reflectedProperty = $reflection->getProperty('ICMS90');
                $sut = $reflectedProperty->getType();
                expect((is_subclass_of($sut->getName(), DFeElement::class)))->toBeTrue();
            });

            test('Should be optional', function () {
                $reflection = new ReflectionClass(Icms::class);
                $reflectedProperty = $reflection->getProperty('ICMS90');
                $sut = $reflectedProperty->getType();
                expect($sut->allowsNull())->toBeTrue();
            });
        })->skip();

        describe('$ICMSPart', function () {
            test('Should be declared', function () {
                $sut = new Icms;
                expect($sut)->toHaveProperty('ICMSPart');
            });

            test('Should be a subclass of DFeElement::class', function () {
                $reflection = new ReflectionClass(Icms::class);
                $reflectedProperty = $reflection->getProperty('ICMSPart');
                $sut = $reflectedProperty->getType();
                expect((is_subclass_of($sut->getName(), DFeElement::class)))->toBeTrue();
            });

            test('Should be optional', function () {
                $reflection = new ReflectionClass(Icms::class);
                $reflectedProperty = $reflection->getProperty('ICMSPart');
                $sut = $reflectedProperty->getType();
                expect($sut->allowsNull())->toBeTrue();
            });
        })->skip();

        describe('$ICMSST', function () {
            test('Should be declared', function () {
                $sut = new Icms;
                expect($sut)->toHaveProperty('ICMSST');
            });

            test('Should be a subclass of DFeElement::class', function () {
                $reflection = new ReflectionClass(Icms::class);
                $reflectedProperty = $reflection->getProperty('ICMSST');
                $sut = $reflectedProperty->getType();
                expect((is_subclass_of($sut->getName(), DFeElement::class)))->toBeTrue();
            });

            test('Should be optional', function () {
                $reflection = new ReflectionClass(Icms::class);
                $reflectedProperty = $reflection->getProperty('ICMSST');
                $sut = $reflectedProperty->getType();
                expect($sut->allowsNull())->toBeTrue();
            });
        })->skip();

        describe('$ICMSSN101', function () {
            test('Should be declared', function () {
                $sut = new Icms;
                expect($sut)->toHaveProperty('ICMSSN101');
            });

            test('Should be a subclass of DFeElement::class', function () {
                $reflection = new ReflectionClass(Icms::class);
                $reflectedProperty = $reflection->getProperty('ICMSSN101');
                $sut = $reflectedProperty->getType();
                expect((is_subclass_of($sut->getName(), DFeElement::class)))->toBeTrue();
            });

            test('Should be optional', function () {
                $reflection = new ReflectionClass(Icms::class);
                $reflectedProperty = $reflection->getProperty('ICMSSN101');
                $sut = $reflectedProperty->getType();
                expect($sut->allowsNull())->toBeTrue();
            });
        })->skip();

        describe('$ICMSSN102', function () {
            test('Should be declared', function () {
                $sut = new Icms;
                expect($sut)->toHaveProperty('ICMSSN102');
            });

            test('Should be a subclass of DFeElement::class', function () {
                $reflection = new ReflectionClass(Icms::class);
                $reflectedProperty = $reflection->getProperty('ICMSSN102');
                $sut = $reflectedProperty->getType();
                expect((is_subclass_of($sut->getName(), DFeElement::class)))->toBeTrue();
            });

            test('Should be optional', function () {
                $reflection = new ReflectionClass(Icms::class);
                $reflectedProperty = $reflection->getProperty('ICMSSN102');
                $sut = $reflectedProperty->getType();
                expect($sut->allowsNull())->toBeTrue();
            });
        })->skip();

        describe('$ICMSSN201', function () {
            test('Should be declared', function () {
                $sut = new Icms;
                expect($sut)->toHaveProperty('ICMSSN201');
            });

            test('Should be a subclass of DFeElement::class', function () {
                $reflection = new ReflectionClass(Icms::class);
                $reflectedProperty = $reflection->getProperty('ICMSSN201');
                $sut = $reflectedProperty->getType();
                expect((is_subclass_of($sut->getName(), DFeElement::class)))->toBeTrue();
            });

            test('Should be optional', function () {
                $reflection = new ReflectionClass(Icms::class);
                $reflectedProperty = $reflection->getProperty('ICMSSN201');
                $sut = $reflectedProperty->getType();
                expect($sut->allowsNull())->toBeTrue();
            });
        })->skip();

        describe('$ICMSSN202', function () {
            test('Should be declared', function () {
                $sut = new Icms;
                expect($sut)->toHaveProperty('ICMSSN202');
            });

            test('Should be a subclass of DFeElement::class', function () {
                $reflection = new ReflectionClass(Icms::class);
                $reflectedProperty = $reflection->getProperty('ICMSSN202');
                $sut = $reflectedProperty->getType();
                expect((is_subclass_of($sut->getName(), DFeElement::class)))->toBeTrue();
            });

            test('Should be optional', function () {
                $reflection = new ReflectionClass(Icms::class);
                $reflectedProperty = $reflection->getProperty('ICMSSN202');
                $sut = $reflectedProperty->getType();
                expect($sut->allowsNull())->toBeTrue();
            });
        })->skip();

        describe('$ICMSSN500', function () {
            test('Should be declared', function () {
                $sut = new Icms;
                expect($sut)->toHaveProperty('ICMSSN500');
            });

            test('Should be a subclass of DFeElement::class', function () {
                $reflection = new ReflectionClass(Icms::class);
                $reflectedProperty = $reflection->getProperty('ICMSSN500');
                $sut = $reflectedProperty->getType();
                expect((is_subclass_of($sut->getName(), DFeElement::class)))->toBeTrue();
            });

            test('Should be optional', function () {
                $reflection = new ReflectionClass(Icms::class);
                $reflectedProperty = $reflection->getProperty('ICMSSN500');
                $sut = $reflectedProperty->getType();
                expect($sut->allowsNull())->toBeTrue();
            });
        })->skip();

        describe('$ICMSSN900', function () {
            test('Should be declared', function () {
                $sut = new Icms;
                expect($sut)->toHaveProperty('ICMSSN900');
            });

            test('Should be a subclass of DFeElement::class', function () {
                $reflection = new ReflectionClass(Icms::class);
                $reflectedProperty = $reflection->getProperty('ICMSSN900');
                $sut = $reflectedProperty->getType();
                expect((is_subclass_of($sut->getName(), DFeElement::class)))->toBeTrue();
            });

            test('Should be optional', function () {
                $reflection = new ReflectionClass(Icms::class);
                $reflectedProperty = $reflection->getProperty('ICMSSN900');
                $sut = $reflectedProperty->getType();
                expect($sut->allowsNull())->toBeTrue();
            });
        })->skip();
    });

    describe('methods', function () {
        describe('validateTagAttributes', function () {
            test('Should fail if an attribute is provided', function () {
                $xmlString = '<ICMS attribute="value"><ICMS00></ICMS00></ICMS>';
                $xmlElement = new Element;
                $xmlElement->parse($xmlString);
                $icms = new Icms;
                $sut = new ReflectionMethod($icms, 'validateTagAttributes');
                $sutResponse = $sut->invoke($icms, $xmlElement);
                expect($sutResponse->isFailure())->toBeTrue();
            });
        });

        describe('validateTagElements', function () {
            test('Should succeed if all required tags is provided', function () {
                $xmlString = '<ICMS><ICMS00></ICMS00></ICMS>';
                $xmlElement = new Element;
                $xmlElement->parse($xmlString);
                $icms = new Icms;
                $sut = new ReflectionMethod($icms, 'validateTagElements');
                $sutResponse = $sut->invoke($icms, $xmlElement);
                expect($sutResponse->isSuccess())->toBeTrue();
            });

            test('Should fail if ICMS00 tag isnt provided', function () {
                $xmlString = '<ICMS></ICMS>';
                $xmlElement = new Element;
                $xmlElement->parse($xmlString);
                $icms = new Icms;
                $sut = new ReflectionMethod($icms, 'validateTagElements');
                $sutResponse = $sut->invoke($icms, $xmlElement);
                expect($sutResponse->isFailure())->toBeTrue();
            });

            test('Should succeed if an unallowed tag is provided', function () {
                $xmlString = '<ICMS><unallowed></unallowed><ICMS00></ICMS00></ICMS>';
                $xmlElement = new Element;
                $xmlElement->parse($xmlString);
                $icms = new Icms;
                $sut = new ReflectionMethod($icms, 'validateTagElements');
                $sutResponse = $sut->invoke($icms, $xmlElement);
                expect($sutResponse->isSuccess())->toBeTrue();
            });
        });

        describe('validateTagValue', function () {
            test('Should fail if a value is provided', function () {
                $xmlString = '<ICMS>value</ICMS>';
                $xmlElement = new Element;
                $xmlElement->parse($xmlString);
                $icms = new Icms;
                $sut = new ReflectionMethod($icms, 'validateTagValue');
                $sutResponse = $sut->invoke($icms, $xmlElement);
                expect($sutResponse->isFailure())->toBeTrue();
                expect($sutResponse->getError())->toBeInstanceOf(ApiError::class);
            });
        });
    });
});
