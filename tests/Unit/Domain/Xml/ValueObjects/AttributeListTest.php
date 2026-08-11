<?php

declare(strict_types=1);

use BradiApi\Domain\Xml\ValueObjects\Attribute;
use BradiApi\Domain\Xml\ValueObjects\AttributeList;
use BradiApi\Tests\TestCase;

describe('AttributeList', function () {
    test('Should succeed if is declared', function () {
        $nameSpace = 'BradiApi\Domain\Xml\ValueObjects';
        $sut = $nameSpace . '\\AttributeList';
        expect(class_exists($sut))->toBeTrue();
    });

    test('Should be declared as final', function () {
        $sut = new ReflectionClass(AttributeList::class);
        expect($sut->isFinal())->toBeTrue();
    });

    describe('properties', function () {
        describe('$records', function () {
            test('Should be declared', function () {
                $sut = new AttributeList;
                expect($sut)->toHaveProperty('records');
            });

            test('Should be an array', function () {
                $reflection = new ReflectionClass(AttributeList::class);
                $sut = $reflection->getProperty('records')->getType();
                expect($sut->getName())->toBe('array');
            });

            test('Should start empty', function () {
                $sut = new AttributeList;
                expect($sut->records)->toBe([]);
            });

            test('Should keep a packed list of attributes', function () {
                $sut = new AttributeList;
                $sut->add(new Attribute('id', '10'));
                $sut->add(new Attribute('status', 'ok'));

                expect(array_keys($sut->records))->toBe([0, 1]);
                expect($sut->records)->each->toBeInstanceOf(Attribute::class);
            });
        });
    });

    describe('methods', function () {
        describe('add()', function () {
            beforeEach(function () {
                /** @var TestCase $this */
                $this->sut = new AttributeList;
            });

            test('Should store the attribute in records', function () {
                $attribute = new Attribute('id', '10');

                $this->sut->add($attribute);

                expect($this->sut->records)->toHaveCount(1);
                expect($this->sut->records[0])->toBe($attribute);
            });

            test('Should append attributes in insertion order', function () {
                $this->sut->add(new Attribute('id', '10'));
                $this->sut->add(new Attribute('status', 'ok'));
                $this->sut->add(new Attribute('type', 'A'));

                expect(array_map(fn (Attribute $attribute) => $attribute->name, $this->sut->records))
                    ->toBe(['id', 'status', 'type']);
            });

            test('Should throw when the attribute name already exists', function () {
                $this->sut->add(new Attribute('id', '10'));

                expect(fn () => $this->sut->add(new Attribute('id', '11')))
                    ->toThrow(InvalidArgumentException::class, "Attribute with name 'id' already exists.");
            });
        });

        // Diferente do ElementList, que casa por identidade de instancia, aqui a busca e por nome:
        // o XML proibe atributos homonimos no mesmo elemento, entao o nome ja identifica o registro.
        // E o que permite ao Element::replace() trocar um atributo por outra instancia de mesmo nome.
        describe('indexOf()', function () {
            beforeEach(function () {
                /** @var TestCase $this */
                $this->sut = new AttributeList;
                $this->sut->add(new Attribute('id', '10'));
                $this->sut->add(new Attribute('status', 'ok'));
            });

            test('Should return the position of an attribute', function () {
                expect($this->sut->indexOf($this->sut->records[1]))->toBe(1);
            });

            test('Should match by name and not by instance identity', function () {
                $twin = new Attribute('id', '99');

                expect($this->sut->indexOf($twin))->toBe(0);
            });

            test('Should return null when no attribute has that name', function () {
                expect($this->sut->indexOf(new Attribute('unknown', '1')))->toBeNull();
            });
        });

        describe('exists()', function () {
            beforeEach(function () {
                /** @var TestCase $this */
                $this->sut = new AttributeList;
                $this->sut->add(new Attribute('id', '10'));
            });

            test('Should return true when an attribute with the same name is present', function () {
                expect($this->sut->exists($this->sut->records[0]))->toBeTrue();
            });

            test('Should return true for a different instance with the same name', function () {
                expect($this->sut->exists(new Attribute('id', '99')))->toBeTrue();
            });

            test('Should return false when no attribute has that name', function () {
                expect($this->sut->exists(new Attribute('status', 'ok')))->toBeFalse();
            });
        });

        describe('remove()', function () {
            beforeEach(function () {
                /** @var TestCase $this */
                $this->sut = new AttributeList;
                $this->sut->add(new Attribute('id', '10'));
            });

            test('Should remove the attribute', function () {
                $this->sut->remove($this->sut->records[0]);

                expect($this->sut->records)->toBe([]);
                expect($this->sut->id)->toBeNull();
            });

            test('Should remove by name even when given another instance', function () {
                $this->sut->remove(new Attribute('id', '99'));

                expect($this->sut->records)->toBe([]);
            });

            test('Should keep records as a packed list', function () {
                $this->sut->add(new Attribute('status', 'ok'));
                $this->sut->add(new Attribute('type', 'A'));

                $this->sut->remove($this->sut->records[1]);

                expect(array_keys($this->sut->records))->toBe([0, 1]);
                expect(array_map(fn (Attribute $attribute) => $attribute->name, $this->sut->records))
                    ->toBe(['id', 'type']);
            });

            test('Should do nothing when the attribute is absent', function () {
                $this->sut->remove(new Attribute('unknown', '1'));

                expect($this->sut->records)->toHaveCount(1);
                expect($this->sut->id?->value)->toBe('10');
            });
        });

        describe('sortByNames()', function () {
            beforeEach(function () {
                /** @var TestCase $this */
                $this->sut = new AttributeList;
                $this->sut->add(new Attribute('type', 'A'));
                $this->sut->add(new Attribute('status', 'ok'));
                $this->sut->add(new Attribute('id', '10'));
            });

            test('Should reorder records following the given sequence', function () {
                $this->sut->sortByNames(['id', 'status', 'type']);

                expect(array_map(fn (Attribute $attribute) => $attribute->name, $this->sut->records))
                    ->toBe(['id', 'status', 'type']);
            });

            test('Should push names absent from the sequence to the end keeping their relative order', function () {
                $this->sut->sortByNames(['id']);

                expect(array_map(fn (Attribute $attribute) => $attribute->name, $this->sut->records))
                    ->toBe(['id', 'type', 'status']);
            });

            test('Should ignore sequence names with no matching attribute', function () {
                $this->sut->sortByNames(['unknown', 'id', 'status', 'type']);

                expect(array_map(fn (Attribute $attribute) => $attribute->name, $this->sut->records))
                    ->toBe(['id', 'status', 'type']);
            });

            test('Should keep records as a packed list', function () {
                $this->sut->sortByNames(['id', 'status', 'type']);

                expect(array_keys($this->sut->records))->toBe([0, 1, 2]);
            });

            test('Should preserve the attribute instances', function () {
                $expected = $this->sut->id;

                $this->sut->sortByNames(['id', 'status', 'type']);

                expect($this->sut->records[0])->toBe($expected);
            });

            test('Should do nothing when the sequence is empty', function () {
                $this->sut->sortByNames([]);

                expect(array_map(fn (Attribute $attribute) => $attribute->name, $this->sut->records))
                    ->toBe(['type', 'status', 'id']);
            });

            test('Should throw when any sequence name is not a non-empty string', function () {
                expect(fn () => $this->sut->sortByNames(['id', 10]))
                    ->toThrow(InvalidArgumentException::class, 'All sequence names must be non-empty strings.');

                expect(fn () => $this->sut->sortByNames(['id', '']))
                    ->toThrow(InvalidArgumentException::class, 'All sequence names must be non-empty strings.');
            });
        });

        describe('__get()', function () {
            beforeEach(function () {
                /** @var TestCase $this */
                $this->sut = new AttributeList;
                $this->sut->add(new Attribute('id', '10'));
                $this->sut->add(new Attribute('status', 'ok'));
            });

            test('Should return the attribute matching the name', function () {
                expect($this->sut->status)->toBeInstanceOf(Attribute::class);
                expect($this->sut->status?->value)->toBe('ok');
            });

            test('Should return null when no attribute matches the name', function () {
                expect($this->sut->unknown)->toBeNull();
            });
        });
    });
});
