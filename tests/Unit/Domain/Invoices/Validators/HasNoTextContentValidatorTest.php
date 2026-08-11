<?php

declare(strict_types=1);

use BradiApi\Domain\Common\ValueObjects\Result;
use BradiApi\Domain\Invoices\Validators\HasNoTextContentValidator;
use BradiApi\Domain\Xml\ValueObjects\Element;
use BradiApi\Tests\TestCase;

describe('HasNoTextContentValidator', function () {
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
        $sut = $nameSpace . '\\HasNoTextContentValidator';
        expect(class_exists($sut))->toBeTrue();
    });

    describe('methods', function () {
        describe('check()', function () {
            test('Should succeed if the element has no text content', function (string $xmlString) {
                $sut = new HasNoTextContentValidator;
                $sutResponse = $sut->check(($this->makeElement)($xmlString));
                expect($sutResponse)->toBeInstanceOf(Result::class);
                expect($sutResponse->isSuccess())->toBeTrue();
            })->with([
                'auto_close_tag' => '<tag/>',
                'tag_with_children' => '<tag><child>aValue</child></tag>',
                'tag_with_attribute' => '<tag attribute="aValue"/>',
            ]);

            test('Should succeed if an empty string is provided', function () {
                $sut = new HasNoTextContentValidator;
                $sutResponse = $sut->check('');
                expect($sutResponse->isSuccess())->toBeTrue();
            });

            test('Should fail if the element has text content', function () {
                $sut = new HasNoTextContentValidator;
                $sutResponse = $sut->check(($this->makeElement)('<tag>aValue</tag>'));
                expect($sutResponse->isFailure())->toBeTrue();
                expect($sutResponse->getError()->getMessage())->toBe('cannot contain text content.');
            });

            test('Should fail if a filled string is provided', function () {
                $sut = new HasNoTextContentValidator;
                $sutResponse = $sut->check('aValue');
                expect($sutResponse->isFailure())->toBeTrue();
                expect($sutResponse->getError()->getMessage())->toBe('cannot contain text content.');
            });

            test('Should fail if the candidate is neither an Element nor a string', function (mixed $candidate) {
                $sut = new HasNoTextContentValidator;
                $sutResponse = $sut->check($candidate);
                expect($sutResponse->isFailure())->toBeTrue();
                expect($sutResponse->getError()->getMessage())->toBe('candidate must be an Element instance or string.');
            })->with([
                'integer' => 1058,
                'array' => [['aValue']],
                'null' => null,
            ]);
        });
    });
});
