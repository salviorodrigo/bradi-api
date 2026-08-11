<?php

declare(strict_types=1);

use BradiApi\Domain\Common\ValueObjects\Result;
use BradiApi\Domain\Invoices\Validators\AtLeastOneTagValidator;
use BradiApi\Domain\Xml\ValueObjects\Element;
use BradiApi\Tests\TestCase;

describe('AtLeastOneTagValidator', function () {
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
        $sut = $nameSpace . '\\AtLeastOneTagValidator';
        expect(class_exists($sut))->toBeTrue();
    });

    describe('methods', function () {
        describe('check()', function () {
            test('Should succeed if at least one of the tags is informed', function (string $xmlString) {
                $sut = new AtLeastOneTagValidator(['CNPJ', 'CPF']);
                $sutResponse = $sut->check(($this->makeElement)($xmlString));
                expect($sutResponse)->toBeInstanceOf(Result::class);
                expect($sutResponse->isSuccess())->toBeTrue();
            })->with([
                'first_option' => '<dest><CNPJ>04840356000194</CNPJ></dest>',
                'second_option' => '<dest><CPF>67422533048</CPF></dest>',
                'both_options' => '<dest><CNPJ>04840356000194</CNPJ><CPF>67422533048</CPF></dest>',
            ]);

            test('Should fail if none of the tags is informed', function (string $xmlString) {
                $sut = new AtLeastOneTagValidator(['CNPJ', 'CPF']);
                $sutResponse = $sut->check(($this->makeElement)($xmlString));
                expect($sutResponse->isFailure())->toBeTrue();
                expect($sutResponse->getError()->getMessage())
                    ->toBe('At least one of the following tags must be informed: CNPJ, CPF.');
            })->with([
                'other_tags' => '<dest><indIEDest>1</indIEDest></dest>',
                'without_tags' => '<dest>aValue</dest>',
            ]);

            test('Should fail if the candidate is not an Element', function (mixed $candidate) {
                $sut = new AtLeastOneTagValidator(['CNPJ']);
                $sutResponse = $sut->check($candidate);
                expect($sutResponse->isFailure())->toBeTrue();
                expect($sutResponse->getError()->getMessage())->toBe('candidate must be an Element instance.');
            })->with([
                'string' => '<dest><CNPJ>04840356000194</CNPJ></dest>',
                'null' => null,
            ]);
        });
    });
});
