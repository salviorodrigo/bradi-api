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

        test('throws when trying to add a duplicated element', function () {
            $sut = new ElementList;

            $child = new Element;
            $child->name = 'item';
            $child->value = 'a';

            $sameValueChild = new Element;
            $sameValueChild->name = 'item';
            $sameValueChild->value = 'a';

            $sut->add($child);

            expect(fn () => $sut->add($sameValueChild))
                ->toThrow(InvalidArgumentException::class, 'Elements cannot be duplicated.');
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
