<?php

declare(strict_types=1);

use BradiApi\Domain\Common\ValueObjects\Result;
use BradiApi\Domain\Invoices\NFe\v4_00\ValueObjects\DescricaoProduto;
use BradiApi\Domain\Invoices\Templates\DFeElement;
use BradiApi\Domain\Xml\ValueObjects\Element;

describe('DescricaoProduto', function () {
    test('Should succeed if is declared', function () {
        $nameSpace = 'BradiApi\\Domain\\Invoices\\NFe\\v4_00\\ValueObjects';
        $sut = $nameSpace . '\\DescricaoProduto';
        expect(class_exists($sut))->toBeTrue();
    });

    test('Should succeed if extends DFeElement', function () {
        $sut = new DescricaoProduto('parentTag');
        expect(is_subclass_of($sut, DFeElement::class))->toBeTrue();
    });

    describe('properties', function () {
        describe('FIELD_NAME', function () {
            test('Should be set correctly', function () {
                $reflection = new ReflectionClass(DescricaoProduto::class);
                $reflectedProperty = $reflection->getConstant('FIELD_NAME');
                expect($reflectedProperty)->toBe('xProd');
            });
        });
    });

    describe('methods', function () {
        describe('validateTagValue', function () {
            test('Should succeed with valid values', function (string $candidate) {
                $element = new Element;
                $element->name = 'xProd';
                $element->value = $candidate;
                $instance = new DescricaoProduto('parentTag');
                $sut = new ReflectionMethod($instance, 'validateTagValue');
                $sutResponse = $sut->invoke($instance, $element);
                expect($sutResponse)->toBeInstanceOf(Result::class);
                if ($sutResponse->isFailure()) {
                    $this->fail(json_encode($sutResponse->getError()));
                }
                expect($sutResponse->isSuccess())->toBeTrue();
            })->with(['min_length' => 'A', 'max_length' => 'STRING WITH A HUNDRED TWENTY CHARACTERS STRING WITH A HUNDRED TWENTY CHARACTERS STRING WITH A HUNDRED TWENTY CHARS ABCDE']);

            test('Should fail if value is invalid', function (string $candidate) {
                $element = new Element;
                $element->name = 'xProd';
                $element->value = $candidate;
                $instance = new DescricaoProduto('parentTag');
                $sut = new ReflectionMethod($instance, 'validateTagValue');
                $sutResponse = $sut->invoke($instance, $element);
                expect($sutResponse->isFailure())->toBeTrue();
            })->with([
                'empty' => '',
                'too_long' => 'STRING WITH A HUNDRED TWENTY ONE CHARACTERS STRING WITH A HUNDRED TWENTY ONE CHARACTERS STRING WITH A HUNDRED TWENTY ABCD',
                'leading_space' => ' NAME',
                'trailing_space' => 'NAME ',
                'nested_spaces' => 'NAME WITH  SPACES',
            ]);
        });
    });
});
