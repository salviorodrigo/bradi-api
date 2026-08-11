<?php

declare(strict_types=1);

use BradiApi\Domain\Common\ValueObjects\Result;
use BradiApi\Domain\Invoices\Validators\AllowedAttributesValidator;
use BradiApi\Domain\Xml\ValueObjects\Element;
use BradiApi\Tests\TestCase;

describe('AllowedAttributesValidator', function () {
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
        $sut = $nameSpace . '\\AllowedAttributesValidator';
        expect(class_exists($sut))->toBeTrue();
    });

    describe('methods', function () {
        describe('check()', function () {
            test('Should succeed if every attribute is allowed', function (string $xmlString) {
                $sut = new AllowedAttributesValidator(['versao', 'Id']);
                $sutResponse = $sut->check(($this->makeElement)($xmlString));
                expect($sutResponse)->toBeInstanceOf(Result::class);
                expect($sutResponse->isSuccess())->toBeTrue();
            })->with([
                'all_allowed_attributes' => '<infNFe versao="4.00" Id="NFe123"/>',
                'part_of_allowed_attributes' => '<infNFe versao="4.00"/>',
                'without_attributes' => '<infNFe/>',
            ]);

            test('Should fail if some attribute is not allowed', function () {
                $sut = new AllowedAttributesValidator(['versao']);
                $sutResponse = $sut->check(($this->makeElement)('<infNFe versao="4.00" unallowed="aValue"/>'));
                expect($sutResponse->isFailure())->toBeTrue();
                expect($sutResponse->getError()->getMessage())->toBe('attribute "unallowed" is not allowed.');
            });

            test('Should fail if no attribute is allowed', function () {
                $sut = new AllowedAttributesValidator([]);
                $sutResponse = $sut->check(($this->makeElement)('<infNFe versao="4.00"/>'));
                expect($sutResponse->isFailure())->toBeTrue();
                expect($sutResponse->getError()->getMessage())->toBe('attribute "versao" is not allowed.');
            });

            test('Should fail if the candidate is not an Element', function (mixed $candidate) {
                $sut = new AllowedAttributesValidator(['versao']);
                $sutResponse = $sut->check($candidate);
                expect($sutResponse->isFailure())->toBeTrue();
                expect($sutResponse->getError()->getMessage())->toBe('candidate must be an Element instance.');
            })->with([
                'string' => '<infNFe versao="4.00"/>',
                'null' => null,
            ]);
        });
    });
});
