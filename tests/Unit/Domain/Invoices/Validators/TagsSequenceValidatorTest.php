<?php

declare(strict_types=1);

use BradiApi\Domain\Common\ValueObjects\Result;
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

    test('Should succeed if is declared', function () {
        $nameSpace = 'BradiApi\Domain\Invoices\Validators';
        $sut = $nameSpace . '\\TagsSequenceValidator';
        expect(class_exists($sut))->toBeTrue();
    });

    describe('methods', function () {
        describe('check()', function () {
            test('Should succeed if the child tags follow the sequence', function () {
                $sut = new TagsSequenceValidator(['first', 'second', 'third']);
                $sutResponse = $sut->check(($this->makeElement)(['first', 'second', 'third']));

                expect($sutResponse)->toBeInstanceOf(Result::class);
                expect($sutResponse->isSuccess())->toBeTrue();
            });

            test('Should succeed if only part of the sequence is informed', function () {
                $sut = new TagsSequenceValidator(['first', 'second', 'third']);
                $sutResponse = $sut->check(($this->makeElement)(['first', 'third']));

                expect($sutResponse->isSuccess())->toBeTrue();
            });

            test('Should succeed if the element has no children', function () {
                $sut = new TagsSequenceValidator(['first', 'second']);
                $sutResponse = $sut->check(($this->makeElement)([]));

                expect($sutResponse->isSuccess())->toBeTrue();
            });

            test('Should succeed for consecutive homonymous siblings', function () {
                $sut = new TagsSequenceValidator(['multi', 'last']);
                $sutResponse = $sut->check(($this->makeElement)(['multi', 'multi', 'last']));

                expect($sutResponse->isSuccess())->toBeTrue();
            });

            test('Should succeed ignoring tags that are not on the sequence', function () {
                $sut = new TagsSequenceValidator(['first', 'second']);
                $sutResponse = $sut->check(($this->makeElement)(['unmapped', 'first', 'unmapped', 'second']));

                expect($sutResponse->isSuccess())->toBeTrue();
            });

            test('Should succeed if no sequence is declared', function () {
                $sut = new TagsSequenceValidator([]);
                $sutResponse = $sut->check(($this->makeElement)(['second', 'first']));

                expect($sutResponse->isSuccess())->toBeTrue();
            });

            test('Should fail if a tag comes after its successor', function () {
                $sut = new TagsSequenceValidator(['first', 'second']);
                $sutResponse = $sut->check(($this->makeElement)(['second', 'first']));

                expect($sutResponse->isFailure())->toBeTrue();
                expect($sutResponse->getError()->getMessage())
                    ->toBe('tag "first" is out of sequence. It must be informed before "second".');
            });

            test('Should fail if a repeated tag is split by another one', function () {
                $sut = new TagsSequenceValidator(['multi', 'last']);
                $sutResponse = $sut->check(($this->makeElement)(['multi', 'last', 'multi']));

                expect($sutResponse->isFailure())->toBeTrue();
            });

            test('Should fail if the candidate is not an Element', function (mixed $candidate) {
                $sut = new TagsSequenceValidator(['first']);
                $sutResponse = $sut->check($candidate);

                expect($sutResponse->isFailure())->toBeTrue();
                expect($sutResponse->getError()->getMessage())->toBe('candidate must be an Element instance.');
            })->with([
                'string' => 'not an element',
                'null' => null,
            ]);
        });
    });
});
