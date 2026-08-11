<?php

declare(strict_types=1);

use BradiApi\Domain\Xml\ValueObjects\Element;
use BradiApi\Domain\Xml\ValueObjects\ElementList;
use BradiApi\Tests\TestCase;

describe('ElementList', function () {
    test('Should succeed if is declared', function () {
        $nameSpace = 'BradiApi\Domain\Xml\ValueObjects';
        $sut = $nameSpace . '\\ElementList';
        expect(class_exists($sut))->toBeTrue();
    });

    test('Should be declared as final', function () {
        $sut = new ReflectionClass(ElementList::class);
        expect($sut->isFinal())->toBeTrue();
    });

    describe('properties', function () {
        describe('$records', function () {
            test('Should be declared', function () {
                $sut = new ElementList;
                expect($sut)->toHaveProperty('records');
            });

            test('Should be an array', function () {
                $reflection = new ReflectionClass(ElementList::class);
                $sut = $reflection->getProperty('records')->getType();
                expect($sut->getName())->toBe('array');
            });

            test('Should start empty', function () {
                $sut = new ElementList;
                expect($sut->records)->toBe([]);
            });

            test('Should keep a packed list of elements', function () {
                $first = new Element;
                $first->name = 'item';
                $second = new Element;
                $second->name = 'item';

                $sut = new ElementList;
                $sut->add($first);
                $sut->add($second);

                expect(array_keys($sut->records))->toBe([0, 1]);
                expect($sut->records)->each->toBeInstanceOf(Element::class);
            });
        });
    });

    describe('methods', function () {
        describe('__construct()', function () {
            test('Should accept empty records by default', function () {
                $sut = new ElementList;

                expect($sut->records)->toBe([]);
            });

            test('Should default the records parameter to an empty array', function () {
                $reflection = new ReflectionClass(ElementList::class);
                $sut = $reflection->getConstructor()->getParameters()[0];

                expect($sut->isOptional())->toBeTrue();
                expect($sut->getDefaultValue())->toBe([]);
            });

            test('Should accept a list of elements', function () {
                $first = new Element;
                $first->name = 'first';
                $second = new Element;
                $second->name = 'second';

                $sut = new ElementList([$first, $second]);

                expect($sut->records)->toHaveCount(2);
                expect($sut->records[0])->toBe($first);
                expect($sut->records[1])->toBe($second);
            });

            test('Should throw when any record is not an element', function () {
                expect(fn () => new ElementList([new stdClass]))
                    ->toThrow(InvalidArgumentException::class, 'All records must be instances of BradiApi\\Domain\\Xml\\ValueObjects\\Element.');
            });
        });

        describe('add()', function () {
            beforeEach(function () {
                /** @var TestCase $this */
                $this->sut = new ElementList;
            });

            test('Should store the element in records', function () {
                $child = new Element;
                $child->name = 'item';
                $child->value = 'a';

                $this->sut->add($child);

                expect($this->sut->records)->toHaveCount(1);
                expect($this->sut->records[0])->toBe($child);
            });

            test('Should append elements in insertion order', function () {
                foreach (['first', 'second', 'third'] as $name) {
                    $child = new Element;
                    $child->name = $name;
                    $this->sut->add($child);
                }

                expect(array_map(fn (Element $element) => $element->name, $this->sut->records))
                    ->toBe(['first', 'second', 'third']);
            });

            test('Should store every element of an ElementList', function () {
                $first = new Element;
                $first->name = 'item';
                $second = new Element;
                $second->name = 'item';

                $this->sut->add(new ElementList([$first, $second]));

                expect($this->sut->records)->toHaveCount(2);
                expect($this->sut->records[0])->toBe($first);
                expect($this->sut->records[1])->toBe($second);
            });

            test('Should throw when trying to add the same element instance twice', function () {
                $child = new Element;
                $child->name = 'item';
                $child->value = 'a';

                $this->sut->add($child);

                expect(fn () => $this->sut->add($child))
                    ->toThrow(InvalidArgumentException::class, 'The same Element instance is already present in this list.');
            });

            test('Should accept structurally identical elements from distinct instances', function () {
                $child = new Element;
                $child->name = 'item';
                $child->value = 'a';

                $sameValueChild = new Element;
                $sameValueChild->name = 'item';
                $sameValueChild->value = 'a';

                $this->sut->add($child);
                $this->sut->add($sameValueChild);

                expect($this->sut->records)->toHaveCount(2);
            });
        });

        // Diferente do AttributeList, que casa por nome, aqui a busca e por identidade de instancia:
        // o XML permite tags irmas homonimas, entao o nome nao identifica o registro.
        describe('indexOf()', function () {
            test('Should return the position of an element by identity', function () {
                $first = new Element;
                $first->name = 'item';
                $second = new Element;
                $second->name = 'item';

                $sut = new ElementList([$first, $second]);

                expect($sut->indexOf($second))->toBe(1);
            });

            test('Should return null when the element is absent', function () {
                $absent = new Element;
                $absent->name = 'item';

                $sut = new ElementList;

                expect($sut->indexOf($absent))->toBeNull();
            });

            test('Should not match a structurally identical element from another instance', function () {
                $child = new Element;
                $child->name = 'item';
                $child->value = 'a';

                $twin = new Element;
                $twin->name = 'item';
                $twin->value = 'a';

                $sut = new ElementList([$child]);

                expect($sut->indexOf($twin))->toBeNull();
            });
        });

        describe('exists()', function () {
            beforeEach(function () {
                /** @var TestCase $this */
                $child = new Element;
                $child->name = 'item';
                $child->value = 'a';

                $this->sut = new ElementList([$child]);
            });

            test('Should return true when the element instance is present', function () {
                expect($this->sut->exists($this->sut->records[0]))->toBeTrue();
            });

            test('Should return false for a structurally identical element from another instance', function () {
                $twin = new Element;
                $twin->name = 'item';
                $twin->value = 'a';

                expect($this->sut->exists($twin))->toBeFalse();
            });

            test('Should return false when the list is empty', function () {
                $absent = new Element;
                $absent->name = 'item';

                expect((new ElementList)->exists($absent))->toBeFalse();
            });
        });

        describe('remove()', function () {
            test('Should remove the element', function () {
                $child = new Element;
                $child->name = 'item';

                $sut = new ElementList([$child]);
                $sut->remove($child);

                expect($sut->records)->toBe([]);
            });

            test('Should keep records as a packed list', function () {
                $first = new Element;
                $first->name = 'first';
                $second = new Element;
                $second->name = 'second';
                $third = new Element;
                $third->name = 'third';

                $sut = new ElementList([$first, $second, $third]);
                $sut->remove($second);

                expect(array_keys($sut->records))->toBe([0, 1]);
                expect(array_map(fn (Element $element) => $element->name, $sut->records))
                    ->toBe(['first', 'third']);
            });

            test('Should do nothing when the element is absent', function () {
                $child = new Element;
                $child->name = 'item';

                $twin = new Element;
                $twin->name = 'item';

                $sut = new ElementList([$child]);
                $sut->remove($twin);

                expect($sut->records)->toHaveCount(1);
                expect($sut->records[0])->toBe($child);
            });
        });

        describe('sortByNames()', function () {
            beforeEach(function () {
                /** @var TestCase $this */
                $this->makeElement = function (string $name, ?string $value = null): Element {
                    $element = new Element;
                    $element->name = $name;
                    $element->value = $value;

                    return $element;
                };
            });

            test('Should reorder records following the given sequence', function () {
                $sut = new ElementList([
                    ($this->makeElement)('third'),
                    ($this->makeElement)('first'),
                    ($this->makeElement)('second'),
                ]);

                $sut->sortByNames(['first', 'second', 'third']);

                expect(array_map(fn (Element $element) => $element->name, $sut->records))
                    ->toBe(['first', 'second', 'third']);
            });

            test('Should push names absent from the sequence to the end keeping their relative order', function () {
                $sut = new ElementList([
                    ($this->makeElement)('unmapped'),
                    ($this->makeElement)('first'),
                    ($this->makeElement)('alsoUnmapped'),
                ]);

                $sut->sortByNames(['first']);

                expect(array_map(fn (Element $element) => $element->name, $sut->records))
                    ->toBe(['first', 'unmapped', 'alsoUnmapped']);
            });

            test('Should preserve the relative order of homonymous siblings', function () {
                $sut = new ElementList([
                    ($this->makeElement)('multi', 'a'),
                    ($this->makeElement)('single'),
                    ($this->makeElement)('multi', 'b'),
                ]);

                $sut->sortByNames(['multi', 'single']);

                expect(array_map(fn (Element $element) => $element->value, $sut->records))
                    ->toBe(['a', 'b', null]);
            });

            test('Should ignore sequence names with no matching element', function () {
                $sut = new ElementList([
                    ($this->makeElement)('second'),
                    ($this->makeElement)('first'),
                ]);

                $sut->sortByNames(['absent', 'first', 'second']);

                expect(array_map(fn (Element $element) => $element->name, $sut->records))
                    ->toBe(['first', 'second']);
            });

            test('Should keep records as a packed list', function () {
                $sut = new ElementList([
                    ($this->makeElement)('third'),
                    ($this->makeElement)('first'),
                    ($this->makeElement)('second'),
                ]);

                $sut->sortByNames(['first', 'second', 'third']);

                expect(array_keys($sut->records))->toBe([0, 1, 2]);
            });

            test('Should preserve the element instances', function () {
                $first = ($this->makeElement)('first');
                $sut = new ElementList([($this->makeElement)('second'), $first]);

                $sut->sortByNames(['first', 'second']);

                expect($sut->records[0])->toBe($first);
            });

            test('Should do nothing when the sequence is empty', function () {
                $sut = new ElementList([
                    ($this->makeElement)('third'),
                    ($this->makeElement)('first'),
                ]);

                $sut->sortByNames([]);

                expect(array_map(fn (Element $element) => $element->name, $sut->records))
                    ->toBe(['third', 'first']);
            });

            test('Should throw when any sequence name is not a non-empty string', function () {
                $sut = new ElementList([($this->makeElement)('first')]);

                expect(fn () => $sut->sortByNames(['first', 10]))
                    ->toThrow(InvalidArgumentException::class, 'All sequence names must be non-empty strings.');

                expect(fn () => $sut->sortByNames(['first', '']))
                    ->toThrow(InvalidArgumentException::class, 'All sequence names must be non-empty strings.');
            });
        });

        describe('__get()', function () {
            beforeEach(function () {
                $single = new Element;
                $single->name = 'single';
                $single->value = 'one';

                $multiA = new Element;
                $multiA->name = 'multi';
                $multiA->value = 'a';

                $multiB = new Element;
                $multiB->name = 'multi';
                $multiB->value = 'b';

                /** @var TestCase $this */
                $this->sut = new ElementList([$single, $multiA, $multiB]);
            });

            test('Should return a single element when only one record matches', function () {
                $result = $this->sut->single;

                expect($result)->toBeInstanceOf(Element::class);
                expect($result?->value)->toBe('one');
            });

            test('Should return an element list when multiple records match', function () {
                $result = $this->sut->multi;

                expect($result)->toBeInstanceOf(ElementList::class);
                expect($result->records)->toHaveCount(2);
                expect(array_values(array_map(
                    fn (Element $element) => $element->value,
                    $result->records
                )))->toBe(['a', 'b']);
            });

            test('Should return null when no element matches by name', function () {
                expect($this->sut->unknown)->toBeNull();
            });
        });
    });
});
