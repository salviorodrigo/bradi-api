<?php

declare(strict_types=1);

use BradiApi\Domain\Xml\ValueObjects\Element;
use BradiApi\Domain\Xml\ValueObjects\ElementList;
use BradiApi\Tests\TestCase;

describe('ElementList', function () {
    describe('::__construct()', function () {
        test('accepts empty records by default', function () {
            $sut = new ElementList;

            expect($sut->records)->toBe([]);
        });

        test('throws when any record is not an element', function () {
            expect(fn () => new ElementList([new stdClass]))
                ->toThrow(InvalidArgumentException::class, 'All records must be instances of BradiApi\\Domain\\Xml\\ValueObjects\\Element.');
        });
    });

    describe('::add()', function () {
        test('adds a new element to records', function () {
            $sut = new ElementList;
            $child = new Element;
            $child->name = 'item';
            $child->value = 'a';

            $sut->add($child);

            expect($sut->records)->toHaveCount(1);
            expect($sut->records[0])->toBe($child);
        });

        test('throws when trying to add the same element instance twice', function () {
            $sut = new ElementList;

            $child = new Element;
            $child->name = 'item';
            $child->value = 'a';

            $sut->add($child);

            expect(fn () => $sut->add($child))
                ->toThrow(InvalidArgumentException::class, 'The same Element instance is already present in this list.');
        });

        test('accepts structurally identical elements from distinct instances', function () {
            // Regression: repeated identical siblings are legal in a DFe (e.g. two equal <detPag>),
            // and Element::parse() feeds every child through add().
            $sut = new ElementList;

            $child = new Element;
            $child->name = 'item';
            $child->value = 'a';

            $sameValueChild = new Element;
            $sameValueChild->name = 'item';
            $sameValueChild->value = 'a';

            $sut->add($child);
            $sut->add($sameValueChild);

            expect($sut->records)->toHaveCount(2);
        });
    });

    describe('::indexOf()', function () {
        test('returns the position of an element by identity', function () {
            $first = new Element;
            $first->name = 'item';
            $second = new Element;
            $second->name = 'item';

            $sut = new ElementList([$first, $second]);

            expect($sut->indexOf($second))->toBe(1);
        });

        test('returns null when the element is absent', function () {
            $absent = new Element;
            $absent->name = 'item';

            $sut = new ElementList;

            expect($sut->indexOf($absent))->toBeNull();
        });

        test('does not match a structurally identical element from another instance', function () {
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

    describe('::insertAt()', function () {
        test('inserts at the given position keeping the remaining order', function () {
            $first = new Element;
            $first->name = 'first';
            $last = new Element;
            $last->name = 'last';
            $middle = new Element;
            $middle->name = 'middle';

            $sut = new ElementList([$first, $last]);
            $sut->insertAt(1, $middle);

            expect(array_map(fn (Element $element) => $element->name, $sut->records))
                ->toBe(['first', 'middle', 'last']);
        });

        test('appends when the index is beyond the last position', function () {
            $first = new Element;
            $first->name = 'first';
            $extra = new Element;
            $extra->name = 'extra';

            $sut = new ElementList([$first]);
            $sut->insertAt(10, $extra);

            expect(array_map(fn (Element $element) => $element->name, $sut->records))
                ->toBe(['first', 'extra']);
        });

        test('throws when the instance is already present', function () {
            $child = new Element;
            $child->name = 'item';

            $sut = new ElementList([$child]);

            expect(fn () => $sut->insertAt(0, $child))
                ->toThrow(InvalidArgumentException::class, 'The same Element instance is already present in this list.');
        });
    });

    describe('::replace()', function () {
        test('replaces an element keeping its position', function () {
            $first = new Element;
            $first->name = 'first';
            $second = new Element;
            $second->name = 'second';
            $replacement = new Element;
            $replacement->name = 'replacement';

            $sut = new ElementList([$first, $second]);
            $sut->replace($first, $replacement);

            expect(array_map(fn (Element $element) => $element->name, $sut->records))
                ->toBe(['replacement', 'second']);
        });

        test('throws when the replaced element is not in the list', function () {
            $absent = new Element;
            $absent->name = 'absent';
            $replacement = new Element;
            $replacement->name = 'replacement';

            $sut = new ElementList;

            expect(fn () => $sut->replace($absent, $replacement))
                ->toThrow(InvalidArgumentException::class, 'Element "absent" is not in this list.');
        });
    });

    describe('::remove()', function () {
        test('removes an element and keeps records as a packed list', function () {
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

        test('throws when the removed element is not in the list', function () {
            $absent = new Element;
            $absent->name = 'absent';

            $sut = new ElementList;

            expect(fn () => $sut->remove($absent))
                ->toThrow(InvalidArgumentException::class, 'Element "absent" is not in this list.');
        });
    });

    describe('::__get()', function () {
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

        test('returns null when no element matches by name', function () {
            expect($this->sut->unknown)->toBeNull();
        });

        test('returns a single element when only one record matches', function () {
            $result = $this->sut->single;

            expect($result)->toBeInstanceOf(Element::class);
            expect($result?->value)->toBe('one');
        });

        test('returns an element list when multiple records match', function () {
            $result = $this->sut->multi;

            expect($result)->toBeInstanceOf(ElementList::class);
            expect($result->records)->toHaveCount(2);
            expect(array_values(array_map(
                fn (Element $element) => $element->value,
                $result->records
            )))->toBe(['a', 'b']);
        });
    });
});
