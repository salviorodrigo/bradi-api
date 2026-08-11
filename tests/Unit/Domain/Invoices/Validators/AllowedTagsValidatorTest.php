<?php

declare(strict_types=1);

use BradiApi\Domain\Common\ValueObjects\Result;
use BradiApi\Domain\Invoices\Validators\AllowedTagsValidator;
use BradiApi\Domain\Xml\ValueObjects\Element;
use BradiApi\Tests\TestCase;

describe('AllowedTagsValidator', function () {
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
        $sut = $nameSpace . '\\AllowedTagsValidator';
        expect(class_exists($sut))->toBeTrue();
    });

    describe('methods', function () {
        describe('check()', function () {
            test('Should succeed if every tag is allowed', function (string $xmlString) {
                $sut = new AllowedTagsValidator(['first', 'second']);
                $sutResponse = $sut->check(($this->makeElement)($xmlString));
                expect($sutResponse)->toBeInstanceOf(Result::class);
                expect($sutResponse->isSuccess())->toBeTrue();
            })->with([
                'all_allowed_tags' => '<root><first>1</first><second>2</second></root>',
                'part_of_allowed_tags' => '<root><first>1</first></root>',
                'without_tags' => '<root>aValue</root>',
            ]);

            test('Should fail if some tag is not allowed', function () {
                $sut = new AllowedTagsValidator(['first', 'second']);
                $sutResponse = $sut->check(($this->makeElement)('<root><first>1</first><unallowed>3</unallowed></root>'));
                expect($sutResponse->isFailure())->toBeTrue();
                expect($sutResponse->getError()->getMessage())->toBe('tag "unallowed" is not allowed.');
            });

            test('Should fail if no tag is allowed', function () {
                $sut = new AllowedTagsValidator([]);
                $sutResponse = $sut->check(($this->makeElement)('<root><first>1</first></root>'));
                expect($sutResponse->isFailure())->toBeTrue();
                expect($sutResponse->getError()->getMessage())->toBe('tag "first" is not allowed.');
            });

            test('Should fail if the candidate is not an Element', function (mixed $candidate) {
                $sut = new AllowedTagsValidator(['first']);
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
