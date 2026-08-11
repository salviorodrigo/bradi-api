<?php

declare(strict_types=1);

use BradiApi\Domain\Common\ValueObjects\Result;
use BradiApi\Domain\Invoices\Validators\RequiredTagsValidator;
use BradiApi\Domain\Xml\ValueObjects\Element;
use BradiApi\Tests\TestCase;

describe('RequiredTagsValidator', function () {
    beforeEach(function () {
        /** @var TestCase $this */
        $this->makeElement = function (string $xmlString): Element {
            $element = new Element;
            $element->parse($xmlString);

            return $element;
        };
    });

    test('Should succeed if is declared', function () {
        $nameSpace = 'BradiApi\Domain\Invoices\Validators';
        $sut = $nameSpace . '\\RequiredTagsValidator';
        expect(class_exists($sut))->toBeTrue();
    });

    describe('methods', function () {
        describe('check()', function () {
            test('Should succeed if every required tag is informed', function (string $xmlString) {
                $sut = new RequiredTagsValidator(['first', 'second']);
                $sutResponse = $sut->check(($this->makeElement)($xmlString));
                expect($sutResponse)->toBeInstanceOf(Result::class);
                expect($sutResponse->isSuccess())->toBeTrue();
            })->with([
                'only_required_tags' => '<root><first>1</first><second>2</second></root>',
                'with_extra_tags' => '<root><first>1</first><second>2</second><third>3</third></root>',
            ]);

            test('Should succeed if no tag is required', function () {
                $sut = new RequiredTagsValidator([]);
                $sutResponse = $sut->check(($this->makeElement)('<root>aValue</root>'));
                expect($sutResponse->isSuccess())->toBeTrue();
            });

            test('Should fail if some required tag is missing', function (string $xmlString) {
                $sut = new RequiredTagsValidator(['first', 'second']);
                $sutResponse = $sut->check(($this->makeElement)($xmlString));
                expect($sutResponse->isFailure())->toBeTrue();
            })->with([
                'missing_tag' => '<root><first>1</first></root>',
                'without_tags' => '<root>aValue</root>',
            ]);

            test('Should report the first missing tag on the error message', function () {
                $sut = new RequiredTagsValidator(['first', 'second']);
                $sutResponse = $sut->check(($this->makeElement)('<root><first>1</first></root>'));
                expect($sutResponse->getError()->getMessage())->toBe('tag "second" must be informed.');
            });

            test('Should fail if the candidate is not an Element', function (mixed $candidate) {
                $sut = new RequiredTagsValidator(['first']);
                $sutResponse = $sut->check($candidate);
                expect($sutResponse->isFailure())->toBeTrue();
                expect($sutResponse->getError()->getMessage())->toBe('candidate must be an Element instance.');
            })->with([
                'string' => '<root><first>1</first></root>',
                'null' => null,
            ]);
        });
    });
});
