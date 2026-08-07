<?php

declare(strict_types=1);

use BradiApi\Domain\Xml\ValueObjects\Attribute;
use BradiApi\Tests\TestCase;

describe('Attribute', function () {
    test('Should succeed if is declared', function () {
        $nameSpace = 'BradiApi\Domain\Xml\ValueObjects';
        $sut = $nameSpace . '\\Attribute';
        expect(class_exists($sut))->toBeTrue();
    });

    describe('properties', function () {
        describe('$name', function () {
            test('Should be declared', function () {
                $sut = new Attribute('id', '123', 'item');
                expect($sut)->toHaveProperty('name');
            });

            test('Should be a string', function () {
                $reflection = new ReflectionClass(Attribute::class);
                $sut = $reflection->getProperty('name')->getType();
                expect($sut->getName())->toBe('string');
            });

            test('Should be required', function () {
                $reflection = new ReflectionClass(Attribute::class);
                $sut = $reflection->getProperty('name')->getType();
                expect($sut->allowsNull())->toBeFalse();
            });
        });

        describe('$value', function () {
            test('Should be declared', function () {
                $sut = new Attribute('id', '123', 'item');
                expect($sut)->toHaveProperty('value');
            });

            test('Should be a string', function () {
                $reflection = new ReflectionClass(Attribute::class);
                $sut = $reflection->getProperty('value')->getType();
                expect($sut->getName())->toBe('string');
            });

            test('Should be required', function () {
                $reflection = new ReflectionClass(Attribute::class);
                $sut = $reflection->getProperty('value')->getType();
                expect($sut->allowsNull())->toBeFalse();
            });
        });

        describe('$parentTagName', function () {
            test('Should be declared', function () {
                $sut = new Attribute('id', '123', 'item');
                expect($sut)->toHaveProperty('parentTagName');
            });

            test('Should be a string', function () {
                $reflection = new ReflectionClass(Attribute::class);
                $sut = $reflection->getProperty('parentTagName')->getType();
                expect($sut->getName())->toBe('string');
            });

            test('Should be required', function () {
                $reflection = new ReflectionClass(Attribute::class);
                $sut = $reflection->getProperty('parentTagName')->getType();
                expect($sut->allowsNull())->toBeFalse();
            });
        });
    });

    describe('methods', function () {
        describe('__construct()', function () {
            test('Should set name value and parent tag name', function () {
                $sut = new Attribute('id', '123', 'item');

                expect($sut->name)->toBe('id');
                expect($sut->value)->toBe('123');
                expect($sut->parentTagName)->toBe('item');
            });

            test('Should promote every argument as a readonly property', function () {
                $reflection = new ReflectionClass(Attribute::class);

                foreach (['name', 'value', 'parentTagName'] as $propertyName) {
                    $sut = $reflection->getProperty($propertyName);
                    expect($sut->isPromoted())->toBeTrue();
                    expect($sut->isReadOnly())->toBeTrue();
                }
            });

            test('Should require all three arguments', function () {
                $reflection = new ReflectionClass(Attribute::class);
                $sut = $reflection->getConstructor()->getParameters();

                expect($sut)->toHaveCount(3);
                expect(array_map(fn (ReflectionParameter $parameter) => $parameter->isOptional(), $sut))
                    ->toBe([false, false, false]);
            });

            test('Should accept an empty value', function () {
                $sut = new Attribute('id', '', 'item');

                expect($sut->value)->toBe('');
            });
        });

        describe('__toString()', function () {
            describe('plain values', function () {
                beforeEach(function () {
                    /** @var TestCase $this */
                    $this->sut = new Attribute('id', '123', 'item');
                });

                test('Should serialize attribute name and value', function () {
                    expect((string) $this->sut)->toBe('id="123"');
                });

                test('Should not render the parent tag name', function () {
                    expect((string) $this->sut)->not->toContain('item');
                });

                test('Should serialize an empty value as an empty pair of quotes', function () {
                    $sut = new Attribute('id', '', 'item');

                    expect((string) $sut)->toBe('id=""');
                });

                test('Should keep a decimal value untouched', function () {
                    $sut = new Attribute('versao', '4.00', 'infNFe');

                    expect((string) $sut)->toBe('versao="4.00"');
                });

                test('Should preserve non-ascii characters', function () {
                    $sut = new Attribute('xNome', 'José Ção', 'item');

                    expect((string) $sut)->toBe('xNome="José Ção"');
                });
            });

            describe('special characters', function () {
                test('Should not escape ampersand in value', function () {
                    $sut = new Attribute('ref', 'A&B', 'item');

                    expect((string) $sut)->toBe('ref="A&B"');
                });

                test('Should not escape less-than and greater-than in value', function () {
                    $sut = new Attribute('expr', '5 < 7 > 3', 'item');

                    expect((string) $sut)->toBe('expr="5 < 7 > 3"');
                });

                test('Should not escape single and double quotes in value', function () {
                    $sut = new Attribute('message', 'it\'s "ok"', 'item');

                    expect((string) $sut)->toBe('message="it\'s "ok""');
                });

                test('Should keep an already escaped value unchanged', function () {
                    $sut = new Attribute('ref', 'A&amp;B', 'item');

                    expect((string) $sut)->toBe('ref="A&amp;B"');
                });

                test('Should keep every special character verbatim', function () {
                    $sut = new Attribute('mix', 'a&b<c>d"e\'f', 'item');

                    expect((string) $sut)->toBe('mix="a&b<c>d"e\'f"');
                });
            });
        });
    });
});
