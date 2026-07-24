<?php

declare(strict_types=1);
use BradiApi\Domain\Common\ValueObjects\Result;
use BradiApi\Domain\Invoices\NFe\v4_00\ValueObjects\ComplementoEndereco;
use BradiApi\Domain\Invoices\Templates\DFeElement;
use BradiApi\Domain\Xml\ValueObjects\Element;

describe('ComplementoEndereco', function () {

    test('Should succeed if is declared', function () {
        $nameSpace = 'BradiApi\Domain\Invoices\NFe\v4_00\ValueObjects';
        $sut = $nameSpace . '\\ComplementoEndereco';
        expect(class_exists($sut))->toBeTrue();
    });

    test('Should succeed if extends DFeelement', function () {
        $sut = new ComplementoEndereco('parentTag');
        expect(is_subclass_of($sut, DFeElement::class))->toBeTrue();
    });

    describe('properties', function () {
        describe('FIELD_NAME', function () {
            test('Should be set correctly', function () {
                $reflection = new ReflectionClass(ComplementoEndereco::class);
                $reflectedProperty = $reflection->getConstant('FIELD_NAME');
                expect($reflectedProperty)->toBe('xCpl');
            });
        });
    });

    describe('methods', function () {
        describe('validateTagValue', function () {
            test('Should succeed in border cases', function (string $candidate) {
                $element = new Element;
                $element->name = 'xCpl';
                $element->value = $candidate;
                $complementoEndereco = new ComplementoEndereco('parentTag');
                $sut = new ReflectionMethod($complementoEndereco, 'validateTagValue');
                $sutResponse = $sut->invoke($complementoEndereco, $element);
                expect($sutResponse)->toBeInstanceOf(Result::class);
                if ($sutResponse->isFailure()) {
                    $this->fail(json_encode($sutResponse->getError()));
                }

                expect($sutResponse->isSuccess())->toBeTrue();
            })->with([
                'min_length' => 'A',
                'max_length' => 'STRING WITH SIXTY CHARACTERS STRING WITH SIXTY CHARACTERS AB',
            ]);

            test('Should fail if value is empty', function () {
                $candidate = '';
                $element = new Element;
                $element->name = 'xCpl';
                $element->value = $candidate;
                $complementoEndereco = new ComplementoEndereco('parentTag');
                $sut = new ReflectionMethod($complementoEndereco, 'validateTagValue');
                $sutResponse = $sut->invoke($complementoEndereco, $element);
                expect($sutResponse->isFailure())->toBeTrue();
            });

            test('Should fail if value is too long', function () {
                $candidate = 'STRING WITH SIXTY ONE CHARACTERS STRING WITH SIXTY ONE ABCDEF';
                $element = new Element;
                $element->name = 'xCpl';
                $element->value = $candidate;
                $complementoEndereco = new ComplementoEndereco('parentTag');
                $sut = new ReflectionMethod($complementoEndereco, 'validateTagValue');
                $sutResponse = $sut->invoke($complementoEndereco, $element);
                expect($sutResponse->isFailure())->toBeTrue();
            });

            test('Should fail if a text value with invalid spaces is provided', function (string $candidate) {
                $element = new Element;
                $element->name = 'xCpl';
                $element->value = $candidate;
                $complementoEndereco = new ComplementoEndereco('parentTag');
                $sut = new ReflectionMethod($complementoEndereco, 'validateTagValue');
                $sutResponse = $sut->invoke($complementoEndereco, $element);
                expect($sutResponse->isFailure())->toBeTrue();
            })->with([
                'leading space' => ' COMPLEMENT',
                'trailing space' => 'COMPLEMENT ',
                'nested spaces' => 'COMPLEMENT WITH  SPACES',
            ]);
        });
    });
});
