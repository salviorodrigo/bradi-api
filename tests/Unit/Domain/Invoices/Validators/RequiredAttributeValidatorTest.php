<?php

declare(strict_types=1);

use BradiApi\Domain\Common\ValueObjects\Result;
use BradiApi\Domain\Invoices\Validators\RequiredAttributeValidator;
use BradiApi\Domain\Xml\ValueObjects\Element;
use BradiApi\Tests\TestCase;

describe('RequiredAttributeValidator', function () {
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
        $sut = $nameSpace . '\\RequiredAttributeValidator';
        expect(class_exists($sut))->toBeTrue();
    });

    describe('methods', function () {
        describe('check()', function () {
            test('Should succeed if every required attribute is informed', function (string $xmlString) {
                $sut = new RequiredAttributeValidator(['versao']);
                $sutResponse = $sut->check(($this->makeElement)($xmlString));
                expect($sutResponse)->toBeInstanceOf(Result::class);
                expect($sutResponse->isSuccess())->toBeTrue();
            })->with([
                'only_required_attribute' => '<infNFe versao="4.00"/>',
                'with_extra_attributes' => '<infNFe versao="4.00" Id="NFe123"/>',
            ]);

            test('Should succeed if no attribute is required', function () {
                $sut = new RequiredAttributeValidator([]);
                $sutResponse = $sut->check(($this->makeElement)('<infNFe/>'));
                expect($sutResponse->isSuccess())->toBeTrue();
            });

            test('Should fail if some required attribute is missing', function (string $xmlString) {
                $sut = new RequiredAttributeValidator(['versao']);
                $sutResponse = $sut->check(($this->makeElement)($xmlString));
                expect($sutResponse->isFailure())->toBeTrue();
                expect($sutResponse->getError()->getMessage())->toBe('attribute "versao" must be informed.');
            })->with([
                'other_attribute' => '<infNFe Id="NFe123"/>',
                'without_attributes' => '<infNFe/>',
            ]);

            test('Should fail if the candidate is not an Element', function (mixed $candidate) {
                $sut = new RequiredAttributeValidator(['versao']);
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
