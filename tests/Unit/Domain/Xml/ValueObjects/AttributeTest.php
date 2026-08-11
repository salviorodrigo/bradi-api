<?php

declare(strict_types=1);

use BradiApi\Domain\Xml\ValueObjects\Attribute;

describe('Attribute', function () {
    test('Should succeed if is declared', function () {
        $nameSpace = 'BradiApi\Domain\Xml\ValueObjects';
        $sut = $nameSpace . '\\Attribute';
        expect(class_exists($sut))->toBeTrue();
    });

    describe('properties', function () {
        describe('$name', function () {
            test('Should be declared', function () {
                $sut = new Attribute('id', '123');
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

            test('Should be a promoted readonly property', function () {
                $reflection = new ReflectionClass(Attribute::class);
                $sut = $reflection->getProperty('name');
                expect($sut->isPromoted())->toBeTrue();
                expect($sut->isReadOnly())->toBeTrue();
            });
        });

        describe('$value', function () {
            test('Should be declared', function () {
                $sut = new Attribute('id', '123');
                expect($sut)->toHaveProperty('value');
            });

            test('Should be a string', function () {
                $reflection = new ReflectionClass(Attribute::class);
                $sut = $reflection->getProperty('value')->getType();
                expect($sut->getName())->toBe('string');
            });

            test('Should be optional', function () {
                $reflection = new ReflectionClass(Attribute::class);
                $sut = $reflection->getProperty('value')->getType();
                expect($sut->allowsNull())->toBeTrue();
            });

            test('Should be mutable', function () {
                $reflection = new ReflectionClass(Attribute::class);
                $sut = $reflection->getProperty('value');
                expect($sut->isReadOnly())->toBeFalse();
            });

            test('Should be a promoted property', function () {
                $reflection = new ReflectionClass(Attribute::class);
                $sut = $reflection->getProperty('value');
                expect($sut->isPromoted())->toBeTrue();
            });
        });
    });

    describe('methods', function () {
        describe('__construct()', function () {
            test('Should require all two arguments', function () {
                $reflection = new ReflectionClass(Attribute::class);
                $sut = $reflection->getConstructor()->getParameters();

                expect($sut)->toHaveCount(2);
                expect(array_map(fn (ReflectionParameter $parameter) => $parameter->isOptional(), $sut))
                    ->toBe([false, false]);
            });

            test('Should accept an empty value', function () {
                $sut = new Attribute('id', '');

                expect($sut->value)->toBe('');
            });
        });

        describe('__toString()', function () {
            describe('plain values', function () {
                test('Should serialize attribute name and value', function () {
                    $sut = new Attribute('id', '123');

                    expect((string) $sut)->toBe('id="123"');
                });

                test('Should not render the parent tag name', function () {
                    $sut = new Attribute('id', '123');

                    expect((string) $sut)->not->toContain('item');
                });

                test('Should serialize an empty value as an empty string', function () {
                    $sut = new Attribute('id', '');

                    expect((string) $sut)->toBe('');
                });

                test('Should keep a zero value instead of treating it as empty', function () {
                    $sut = new Attribute('indPag', '0');

                    expect((string) $sut)->toBe('indPag="0"');
                });

                test('Should keep a decimal value untouched', function () {
                    $sut = new Attribute('versao', '4.00');

                    expect((string) $sut)->toBe('versao="4.00"');
                });

                test('Should preserve non-ascii characters', function () {
                    $sut = new Attribute('xNome', 'José Ção');

                    expect((string) $sut)->toBe('xNome="José Ção"');
                });
            });

            describe('special characters', function () {
                test('Should not escape ampersand in value', function () {
                    $sut = new Attribute('ref', 'A&B');

                    expect((string) $sut)->toBe('ref="A&B"');
                });

                test('Should not escape less-than and greater-than in value', function () {
                    $sut = new Attribute('expr', '5 < 7 > 3');

                    expect((string) $sut)->toBe('expr="5 < 7 > 3"');
                });

                test('Should not escape single and double quotes in value', function () {
                    $sut = new Attribute('message', 'it\'s "ok"');

                    expect((string) $sut)->toBe('message="it\'s "ok""');
                });

                test('Should keep an already escaped value unchanged', function () {
                    $sut = new Attribute('ref', 'A&amp;B');

                    expect((string) $sut)->toBe('ref="A&amp;B"');
                });

                test('Should keep every special character verbatim', function () {
                    $sut = new Attribute('mix', 'a&b<c>d"e\'f');

                    expect((string) $sut)->toBe('mix="a&b<c>d"e\'f"');
                });
            });
        });
    });
});
