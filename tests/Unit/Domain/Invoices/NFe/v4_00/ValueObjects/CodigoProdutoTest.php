<?php

declare(strict_types=1);

use BradiApi\Domain\Common\ValueObjects\Result;
use BradiApi\Domain\Invoices\NFe\v4_00\ValueObjects\CodigoProduto;
use BradiApi\Domain\Invoices\Templates\DFeElement;
use BradiApi\Domain\Xml\ValueObjects\Element;

describe('CodigoProduto', function () {
    test('Should succeed if is declared', function () {
        $nameSpace = 'BradiApi\\Domain\\Invoices\\NFe\\v4_00\\ValueObjects';
        $sut = $nameSpace . '\\CodigoProduto';
        expect(class_exists($sut))->toBeTrue();
    });

    test('Should succeed if extends DFeElement', function () {
        $sut = new CodigoProduto('parentTag');
        expect(is_subclass_of($sut, DFeElement::class))->toBeTrue();
    });

    describe('properties', function () {
        describe('FIELD_NAME', function () {
            test('Should be set correctly', function () {
                $reflection = new ReflectionClass(CodigoProduto::class);
                $reflectedProperty = $reflection->getConstant('FIELD_NAME');
                expect($reflectedProperty)->toBe('cProd');
            });
        });
    });

    describe('methods', function () {
        describe('validateTagValue', function () {
            test('Should succeed with valid values', function (string $candidate) {
                $element = new Element;
                $element->name = 'cProd';
                $element->value = $candidate;
                $instance = new CodigoProduto('parentTag');
                $sut = new ReflectionMethod($instance, 'validateTagValue');
                $sutResponse = $sut->invoke($instance, $element);
                expect($sutResponse)->toBeInstanceOf(Result::class);
                if ($sutResponse->isFailure()) {
                    $this->fail(json_encode($sutResponse->getError()));
                }
                expect($sutResponse->isSuccess())->toBeTrue();
            })->with(['min_length' => 'A', 'max_length' => 'STRING WITH SIXTY CHARACTERS STRING WITH SIXTY CHARACTERS AB', 'middle_space' => 'SKU 123']);

            test('Should fail if value is invalid', function (string $candidate) {
                $element = new Element;
                $element->name = 'cProd';
                $element->value = $candidate;
                $instance = new CodigoProduto('parentTag');
                $sut = new ReflectionMethod($instance, 'validateTagValue');
                $sutResponse = $sut->invoke($instance, $element);
                expect($sutResponse->isFailure())->toBeTrue();
            })->with([
                'empty' => '',
                'too_long' => 'STRING WITH SIXTY ONE CHARACTERS STRING WITH SIXTY ONE ABCDEF',
                'leading_space' => ' SKU123',
                'trailing_space' => 'SKU123 ',
            ]);
        });
    });
});
