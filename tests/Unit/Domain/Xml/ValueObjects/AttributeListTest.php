<?php

declare(strict_types=1);

use BradiApi\Domain\Xml\ValueObjects\Attribute;
use BradiApi\Domain\Xml\ValueObjects\AttributeList;
use InvalidArgumentException;

describe('AttributeList', function () {
    describe('::add()', function () {
        test('adds attribute to records', function () {
            $sut = new AttributeList;
            $attribute = new Attribute('id', '10', 'item');

            $sut->add($attribute);

            expect($sut->records)->toHaveCount(1);
            expect($sut->records[0])->toBe($attribute);
        });

        test('throws when trying to add duplicated attribute name', function () {
            $sut = new AttributeList;

            $sut->add(new Attribute('id', '10', 'item'));

            expect(fn () => $sut->add(new Attribute('id', '11', 'item')))
                ->toThrow(InvalidArgumentException::class, "Attribute with name 'id' already exists.");
        });
    });

    describe('::exists()', function () {
        test('returns true when an attribute with given name exists', function () {
            $sut = new AttributeList;
            $sut->add(new Attribute('id', '10', 'item'));

            expect($sut->exists('id'))->toBeTrue();
        });

        test('returns false when attribute name does not exist', function () {
            $sut = new AttributeList;
            $sut->add(new Attribute('id', '10', 'item'));

            expect($sut->exists('status'))->toBeFalse();
        });
    });

    describe('::__get()', function () {
        test('returns matching attribute by name', function () {
            $sut = new AttributeList;
            $sut->add(new Attribute('id', '10', 'item'));
            $sut->add(new Attribute('status', 'ok', 'item'));

            expect($sut->status)->toBeInstanceOf(Attribute::class);
            expect($sut->status?->value)->toBe('ok');
        });

        test('returns null when no attribute matches name', function () {
            $sut = new AttributeList;
            $sut->add(new Attribute('id', '10', 'item'));

            expect($sut->unknown)->toBeNull();
        });
    });
});
