<?php

declare(strict_types=1);

use BradiApi\Domain\Invoices\Validators\TagsSequenceValidator;
use BradiApi\Domain\Xml\ValueObjects\Element;
use BradiApi\Tests\TestCase;

describe('TagsSequenceValidator', function () {
    beforeEach(function () {
        /** @var TestCase $this */
        $this->makeElement = function (array $childrenNames): Element {
            $element = new Element;
            $element->name = 'root';
            foreach ($childrenNames as $childName) {
                $child = new Element;
                $child->name = $childName;
                $element->add($child);
            }

            return $element;
        };
    });

    describe('check()', function () {
        test('Should return a success Result when the child tags follow the sequence', function () {
            $sut = new TagsSequenceValidator(['first', 'second', 'third']);

            $sutResponse = $sut->check(($this->makeElement)(['first', 'second', 'third']));

            expect($sutResponse->isSuccess())->toBeTrue();
        });

        test('Should return a success Result when only part of the sequence is informed', function () {
            $sut = new TagsSequenceValidator(['first', 'second', 'third']);

            $sutResponse = $sut->check(($this->makeElement)(['first', 'third']));

            expect($sutResponse->isSuccess())->toBeTrue();
        });

        test('Should return a success Result when the element has no children', function () {
            $sut = new TagsSequenceValidator(['first', 'second']);

            $sutResponse = $sut->check(($this->makeElement)([]));

            expect($sutResponse->isSuccess())->toBeTrue();
        });

        test('Should return a failure Result when a tag comes after its successor', function () {
            $sut = new TagsSequenceValidator(['first', 'second']);

            $sutResponse = $sut->check(($this->makeElement)(['second', 'first']));

            expect($sutResponse->isFailure())->toBeTrue();
            expect($sutResponse->getError()->getMessage())
                ->toBe('tag "first" is out of sequence. It must be informed before "second".');
        });

        test('Should return a success Result for consecutive homonymous siblings', function () {
            $sut = new TagsSequenceValidator(['multi', 'last']);

            $sutResponse = $sut->check(($this->makeElement)(['multi', 'multi', 'last']));

            expect($sutResponse->isSuccess())->toBeTrue();
        });

        test('Should return a failure Result when a repeated tag is split by another one', function () {
            $sut = new TagsSequenceValidator(['multi', 'last']);

            $sutResponse = $sut->check(($this->makeElement)(['multi', 'last', 'multi']));

            expect($sutResponse->isFailure())->toBeTrue();
        });

        test('Should ignore tags that are not on the sequence', function () {
            $sut = new TagsSequenceValidator(['first', 'second']);

            $sutResponse = $sut->check(($this->makeElement)(['unmapped', 'first', 'unmapped', 'second']));

            expect($sutResponse->isSuccess())->toBeTrue();
        });

        test('Should return a success Result when no sequence is declared', function () {
            $sut = new TagsSequenceValidator([]);

            $sutResponse = $sut->check(($this->makeElement)(['second', 'first']));

            expect($sutResponse->isSuccess())->toBeTrue();
        });

        test('Should return a failure Result when the candidate is not an Element', function () {
            $sut = new TagsSequenceValidator(['first']);

            $sutResponse = $sut->check('not an element');

            expect($sutResponse->isFailure())->toBeTrue();
            expect($sutResponse->getError()->getMessage())->toBe('candidate must be an Element instance.');
        });
    });
});
