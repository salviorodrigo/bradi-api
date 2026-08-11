<?php

declare(strict_types=1);

use BradiApi\Domain\Common\ValueObjects\Result;
use BradiApi\Domain\Invoices\Templates\DFeAttribute;
use BradiApi\Domain\Xml\ValueObjects\Attribute;
use BradiApi\Tests\Doubles\Domain\Invoices\NFe\FakeDFeAttribute;
use BradiApi\Tests\Doubles\Domain\Invoices\NFe\FakeDFeAttributeWithoutFieldName;
use BradiApi\Tests\TestCase;

describe('DFeAttribute', function () {
    beforeEach(function () {
        /** @var TestCase $this */
        $this->sut = new FakeDFeAttribute('parentTag');
    });

    test('Should succeed if is declared', function () {
        $nameSpace = 'BradiApi\Domain\Invoices\Templates';
        $sut = $nameSpace . '\\DFeAttribute';
        expect(class_exists($sut))->toBeTrue();
    });

    test('Should be declared as abstract', function () {
        $sut = new ReflectionClass(DFeAttribute::class);
        expect($sut->isAbstract())->toBeTrue();
    });

    describe('properties', function () {
        describe('FIELD_NAME', function () {
            test('Should have the correct field name', function () {
                expect(FakeDFeAttribute::FIELD_NAME)->toBe('fakeAttr');
            });
        });

        describe('$fieldURI', function () {
            test('Should have the correct field URI', function () {
                expect($this->sut->fieldURI)->toBe('parentTag.fakeAttr');
            });

            test('Should prefix the whole parent field URI', function () {
                $sut = new FakeDFeAttribute('infNFe.det.prod');

                expect($sut->fieldURI)->toBe('infNFe.det.prod.fakeAttr');
            });

            test('Should be a readonly string', function () {
                $reflection = new ReflectionClass(DFeAttribute::class);
                $sut = $reflection->getProperty('fieldURI');
                expect($sut->getType()->getName())->toBe('string');
                expect($sut->isReadOnly())->toBeTrue();
            });
        });

        describe('$value', function () {
            test('Should be declared', function () {
                expect($this->sut)->toHaveProperty('value');
            });

            test('Should be a nullable string', function () {
                $reflection = new ReflectionClass(DFeAttribute::class);
                $sut = $reflection->getProperty('value')->getType();
                expect($sut->getName())->toBe('string');
                expect($sut->allowsNull())->toBeTrue();
            });

            test('Should propagate the assigned value to the source attribute', function () {
                $this->sut->value = 'ABC123';

                expect($this->sut->toXML()->value)->toBe('ABC123');
            });

            test('Should propagate a later value to the source attribute', function () {
                $this->sut->value = 'ABC123';
                $this->sut->value = 'XYZ789';

                expect($this->sut->toXML()->value)->toBe('XYZ789');
            });

            test('Should drop the source when the value is set to null', function () {
                $this->sut->value = 'ABC123';
                $this->sut->value = null;

                expect($this->sut->toXML())->toBeNull();
            });

            test('Should drop the source when the value is set to an empty string', function () {
                $this->sut->value = 'ABC123';
                $this->sut->value = '';

                expect($this->sut->toXML())->toBeNull();
            });

            test('Should keep the source when the value is zero', function () {
                $this->sut->value = '0';

                expect((string) $this->sut)->toBe('fakeAttr="0"');
            });
        });
    });

    describe('methods', function () {
        describe('__construct()', function () {
            test('Should throw if parent field URI is empty', function () {
                expect(fn () => new FakeDFeAttribute(''))
                    ->toThrow(RuntimeException::class, 'Parent field URI must be provided');
            });

            test('Should throw a RuntimeException when FIELD_NAME is not defined', function () {
                expect(fn () => new FakeDFeAttributeWithoutFieldName('parentTag'))
                    ->toThrow(RuntimeException::class, 'must define a constant "FIELD_NAME"');
            });
        });

        describe('parse()', function () {
            test('Should set value property correctly', function () {
                $attribute = new Attribute('fakeAttr', 'ABC123');

                $this->sut->parse($attribute);

                expect($this->sut->value)->toBe('ABC123');
            });

            test('Should set serialized string correctly', function () {
                $attribute = new Attribute('fakeAttr', 'ABC123');

                $this->sut->parse($attribute);

                expect((string) $this->sut)->toBe((string) $attribute);
            });

            test('Should return a successful Result holding itself', function () {
                $attribute = new Attribute('fakeAttr', 'ABC123');

                $parsingResponse = $this->sut->parse($attribute);

                expect($parsingResponse)->toBeInstanceOf(Result::class);
                expect($parsingResponse->isSuccess())->toBeTrue();
                expect($parsingResponse->getData())->toBe($this->sut);
            });

            test('Should return a failure Result when the attribute key does not match', function () {
                $attribute = new Attribute('wrongKey', 'ABC123');

                $parsingResponse = $this->sut->parse($attribute);

                expect($parsingResponse)->toBeInstanceOf(Result::class);
                expect($parsingResponse->isFailure())->toBeTrue();
            });
        });

        describe('toXML()', function () {
            test('Should return null when the value was never assigned', function () {
                expect($this->sut->toXML())->toBeNull();
            });

            test('Should return an attribute built from FIELD_NAME value and parent tag name', function () {
                $this->sut->value = 'ABC123';

                $source = $this->sut->toXML();

                expect($source)->toBeInstanceOf(Attribute::class);
                expect($source->name)->toBe('fakeAttr');
                expect($source->value)->toBe('ABC123');
            });

            test('Should return the very attribute instance given to parse', function () {
                $attribute = new Attribute('fakeAttr', 'ABC123');

                $this->sut->parse($attribute);

                expect($this->sut->toXML())->toBe($attribute);
            });
        });

        describe('__toString()', function () {
            test('Should return an empty string when the value was not initialized', function () {
                expect((string) $this->sut)->toBe('');
            });

            test('Should return serialized string on success', function () {
                $this->sut->value = 'ABC123';

                expect((string) $this->sut)->toBe('fakeAttr="ABC123"');
            });

            test('Should return the updated xml string after changing the value', function () {
                $this->sut->parse(new Attribute('fakeAttr', 'ORIGINAL'));

                $this->sut->value = 'CHANGED';

                expect((string) $this->sut)->toBe('fakeAttr="CHANGED"');
            });
        });
    });
});
