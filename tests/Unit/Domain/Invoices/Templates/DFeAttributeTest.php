<?php

declare(strict_types=1);

use BradiApi\Domain\Xml\ValueObjects\Attribute;
use BradiApi\Tests\Doubles\Domain\Invoices\NFe\FakeDFeAttribute;
use BradiApi\Tests\TestCase;

describe('DFeAttribute', function () {
    beforeEach(function () {
        /** @var TestCase $this */
        $this->sut = new FakeDFeAttribute('parentTag');
    });

    describe('properties', function () {
        test('Should have the correct field name', function () {
            expect(FakeDFeAttribute::FIELD_NAME)->toBe('fakeAttr');
        });

        test('Should have the correct parent tag name', function () {
            expect($this->sut->parentTagName)->toBe('parentTag');
        });

        test('Should have the correct field URI', function () {
            expect($this->sut->fieldURI)->toBe('parentTag.fakeAttr');
        });
    });

    describe('methods', function () {
        describe('construct()', function () {
            test('Should throw if parent field URI is empty', function () {
                expect(fn () => new FakeDFeAttribute(''))
                    ->toThrow(RuntimeException::class);
            });
        });

        describe('parseFromXmlElement()', function () {
            test('Should set value property correctly', function () {
                $attribute = new Attribute('fakeAttr', 'ABC123', 'parentTag');
                $this->sut->parseFromXmlElement($attribute);
                expect($this->sut->value)->toBe('ABC123');
            });

            test('Should set serialized string correctly', function () {
                $attribute = new Attribute('fakeAttr', 'ABC123', 'parentTag');
                $this->sut->parseFromXmlElement($attribute);
                expect((string) $this->sut)->toBe((string) $attribute);
            });
        });

        describe('toString()', function () {
            test('Should throw if attribute value was not initialized', function () {
                expect(fn () => (string) new FakeDFeAttribute('parentTag'))
                    ->toThrow(RuntimeException::class);
            });

            test('Should return serialized string on success', function () {
                $this->sut->value = 'ABC123';
                expect((string) $this->sut)->toBe('fakeAttr="ABC123"');
            });
        });
    });
});
