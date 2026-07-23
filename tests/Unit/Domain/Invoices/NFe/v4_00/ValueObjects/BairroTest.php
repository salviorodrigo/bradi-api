<?php

declare(strict_types=1);
use BradiApi\Domain\Common\ValueObjects\Result;
use BradiApi\Domain\Invoices\NFe\v4_00\ValueObjects\Bairro;
use BradiApi\Domain\Invoices\Templates\DFeElement;
use BradiApi\Domain\Xml\ValueObjects\Element;

describe('Bairro', function () {

    test('Should succeed if is declared', function () {
        $nameSpace = 'BradiApi\Domain\Invoices\NFe\v4_00\ValueObjects';
        $sut = $nameSpace . '\\Bairro';
        expect(class_exists($sut))->toBeTrue();
    });

    test('Should succeed if extends DFeelement', function () {
        $sut = new Bairro('parentTag');
        expect(is_subclass_of($sut, DFeElement::class))->toBeTrue();
    });

    describe('properties', function () {
        describe('FIELD_NAME', function () {
            test('Should be set correctly', function () {
                $reflection = new ReflectionClass(Bairro::class);
                $reflectedProperty = $reflection->getConstant('FIELD_NAME');
                expect($reflectedProperty)->toBe('xBairro');
            });
        });
    });

    describe('methods', function () {
        describe('validateTagValue', function () {
            test('Should succeed in border cases', function (string $candidate) {
                $element = new Element;
                $element->name = 'xBairro';
                $element->value = $candidate;
                $bairro = new Bairro('parentTag');
                $sut = new ReflectionMethod($bairro, 'validateTagValue');
                $sutResponse = $sut->invoke($bairro, $element);
                expect($sutResponse)->toBeInstanceOf(Result::class);
                if ($sutResponse->isFailure()) {
                    $this->fail(json_encode($sutResponse->getError()));
                }

                expect($sutResponse->isSuccess())->toBeTrue();
            })->with([
                'min_length' => 'AB',
                'max_length' => 'STRING WITH SIXTY CHARACTERS STRING WITH SIXTY CHARACTERS AB',
            ]);

            test('Should fail if value is empty', function () {
                $candidate = '';
                $element = new Element;
                $element->name = 'xBairro';
                $element->value = $candidate;
                $bairro = new Bairro('parentTag');
                $sut = new ReflectionMethod($bairro, 'validateTagValue');
                $sutResponse = $sut->invoke($bairro, $element);
                expect($sutResponse->isFailure())->toBeTrue();
            });

            test('Should fail if value is too long', function () {
                $candidate = 'STRING WITH SIXTY ONE CHARACTERS STRING WITH SIXTY ONE ABCDEF';
                $element = new Element;
                $element->name = 'xBairro';
                $element->value = $candidate;
                $bairro = new Bairro('parentTag');
                $sut = new ReflectionMethod($bairro, 'validateTagValue');
                $sutResponse = $sut->invoke($bairro, $element);
                expect($sutResponse->isFailure())->toBeTrue();
            });

            test('Should fail if value is too short', function () {
                $candidate = 'A';
                $element = new Element;
                $element->name = 'xBairro';
                $element->value = $candidate;
                $bairro = new Bairro('parentTag');
                $sut = new ReflectionMethod($bairro, 'validateTagValue');
                $sutResponse = $sut->invoke($bairro, $element);
                expect($sutResponse->isFailure())->toBeTrue();
            });

            test('Should fail if a text value with invalid spaces is provided', function (string $candidate) {
                $element = new Element;
                $element->name = 'xBairro';
                $element->value = $candidate;
                $bairro = new Bairro('parentTag');
                $sut = new ReflectionMethod($bairro, 'validateTagValue');
                $sutResponse = $sut->invoke($bairro, $element);
                expect($sutResponse->isFailure())->toBeTrue();
            })->with([
                'leading space' => ' NEIGHBORHOOD',
                'trailing space' => 'NEIGHBORHOOD ',
            ]);
        });
    });
});
