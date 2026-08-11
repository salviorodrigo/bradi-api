<?php

declare(strict_types=1);

use BradiApi\Domain\Common\ValueObjects\Result;
use BradiApi\Domain\Xml\Validators\MaxDFeCollectionSizeValidator;
use BradiApi\Domain\Xml\ValueObjects\Element;
use BradiApi\Tests\TestCase;

describe('MaxDFeCollectionSizeValidator', function () {
    beforeEach(function () {
        /** @var TestCase $this */
        $this->makeElements = function (int $amount): array {
            $elements = [];
            for ($position = 0; $position < $amount; $position++) {
                $element = new Element;
                $element->name = 'item';
                $elements[] = $element;
            }

            return $elements;
        };
    });

    test('Should succeed if is declared', function () {
        $nameSpace = 'BradiApi\Domain\Xml\Validators';
        $sut = $nameSpace . '\\MaxDFeCollectionSizeValidator';
        expect(class_exists($sut))->toBeTrue();
    });

    describe('methods', function () {
        describe('check()', function () {
            test('Should succeed if the collection size is up to the max', function (int $amount) {
                $sut = new MaxDFeCollectionSizeValidator(2);
                $sutResponse = $sut->check(($this->makeElements)($amount));
                expect($sutResponse)->toBeInstanceOf(Result::class);
                expect($sutResponse->isSuccess())->toBeTrue();
            })->with([
                'empty' => 0,
                'below_max' => 1,
                'exact_max' => 2,
            ]);

            test('Should fail if the collection size exceeds the max', function () {
                $sut = new MaxDFeCollectionSizeValidator(2);
                $sutResponse = $sut->check(($this->makeElements)(3));
                expect($sutResponse->isFailure())->toBeTrue();
                expect($sutResponse->getError()->getMessage())
                    ->toBe('Collection size exceeds maximum of 2. 3 items given.');
            });

            test('Should fail if any item is not an Element', function () {
                $sut = new MaxDFeCollectionSizeValidator(2);
                $sutResponse = $sut->check([...($this->makeElements)(1), 'aValue']);
                expect($sutResponse->isFailure())->toBeTrue();
                expect($sutResponse->getError()->getMessage())
                    ->toBe('All items in the collection must be an Element.');
            });

            test('Should fail if the candidate is neither an array nor an object', function (mixed $candidate) {
                $sut = new MaxDFeCollectionSizeValidator(2);
                $sutResponse = $sut->check($candidate);
                expect($sutResponse->isFailure())->toBeTrue();
                expect($sutResponse->getError()->getMessage())->toBe('Candidate must be an array or an object.');
            })->with([
                'string' => 'aValue',
                'integer' => 1058,
                'null' => null,
            ]);
        });
    });
});
