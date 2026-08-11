<?php

declare(strict_types=1);

use BradiApi\Domain\Common\ValueObjects\Result;
use BradiApi\Domain\Invoices\Validators\HasNoChildrenValidator;
use BradiApi\Domain\Xml\ValueObjects\Element;
use BradiApi\Tests\TestCase;

describe('HasNoChildrenValidator', function () {
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
        $sut = $nameSpace . '\\HasNoChildrenValidator';
        expect(class_exists($sut))->toBeTrue();
    });

    describe('methods', function () {
        describe('check()', function () {
            test('Should succeed if the element has no children', function (string $xmlString) {
                $sut = new HasNoChildrenValidator;
                $sutResponse = $sut->check(($this->makeElement)($xmlString));
                expect($sutResponse)->toBeInstanceOf(Result::class);
                expect($sutResponse->isSuccess())->toBeTrue();
            })->with([
                'auto_close_tag' => '<tag/>',
                'tag_with_value' => '<tag>aValue</tag>',
                'tag_with_attribute' => '<tag attribute="aValue"/>',
            ]);

            test('Should fail if the element has children', function (string $xmlString) {
                $sut = new HasNoChildrenValidator;
                $sutResponse = $sut->check(($this->makeElement)($xmlString));
                expect($sutResponse->isFailure())->toBeTrue();
                expect($sutResponse->getError()->getMessage())->toBe('cannot contain child elements.');
            })->with([
                'single_child' => '<tag><child>aValue</child></tag>',
                'multiple_children' => '<tag><child>aValue</child><other>otherValue</other></tag>',
            ]);

            test('Should fail if the candidate is not an Element', function (mixed $candidate) {
                $sut = new HasNoChildrenValidator;
                $sutResponse = $sut->check($candidate);
                expect($sutResponse->isFailure())->toBeTrue();
                expect($sutResponse->getError()->getMessage())->toBe('candidate must be an Element instance.');
            })->with([
                'string' => '<tag/>',
                'null' => null,
            ]);
        });
    });
});
