<?php

declare(strict_types=1);

use BradiApi\Domain\Common\ValueObjects\Result;
use BradiApi\Domain\Invoices\NFe\v4_00\ValueObjects\UnidadeComercial;
use BradiApi\Domain\Invoices\Templates\DFeElement;
use BradiApi\Domain\Xml\ValueObjects\Element;

describe('UnidadeComercial', function () {
    test('Should succeed if is declared', function () {
        $nameSpace = 'BradiApi\\Domain\\Invoices\\NFe\\v4_00\\ValueObjects';
        $sut = $nameSpace . '\\UnidadeComercial';
        expect(class_exists($sut))->toBeTrue();
    });

    test('Should succeed if extends DFeElement', function () {
        $sut = new UnidadeComercial('parentTag');
        expect(is_subclass_of($sut, DFeElement::class))->toBeTrue();
    });

    describe('properties', function () {
        describe('FIELD_NAME', function () {
            test('Should be set correctly', function () {
                $reflection = new ReflectionClass(UnidadeComercial::class);
                $reflectedProperty = $reflection->getConstant('FIELD_NAME');
                expect($reflectedProperty)->toBe('uCom');
            });
        });
    });

    describe('methods', function () {
        describe('validateTagValue', function () {
            test('Should succeed with valid units', function (string $candidate) {
                $element = new Element;
                $element->name = 'uCom';
                $element->value = $candidate;
                $unidade = new UnidadeComercial('parentTag');
                $sut = new ReflectionMethod($unidade, 'validateTagValue');
                $sutResponse = $sut->invoke($unidade, $element);
                expect($sutResponse)->toBeInstanceOf(Result::class);
                if ($sutResponse->isFailure()) {
                    $this->fail(json_encode($sutResponse->getError()));
                }
                expect($sutResponse->isSuccess())->toBeTrue();
            })->with([
                'unit' => 'UN',
                'weight' => 'KG',
                'box' => 'CAIXA',
            ]);

            test('Should fail if value is empty', function () {
                $element = new Element;
                $element->name = 'uCom';
                $element->value = '';
                $unidade = new UnidadeComercial('parentTag');
                $sut = new ReflectionMethod($unidade, 'validateTagValue');
                $sutResponse = $sut->invoke($unidade, $element);
                expect($sutResponse->isFailure())->toBeTrue();
            });

            test('Should fail with invalid values', function (string $candidate) {
                $element = new Element;
                $element->name = 'uCom';
                $element->value = $candidate;
                $unidade = new UnidadeComercial('parentTag');
                $sut = new ReflectionMethod($unidade, 'validateTagValue');
                $sutResponse = $sut->invoke($unidade, $element);
                expect($sutResponse->isFailure())->toBeTrue();
            })->with([
                'too_long' => 'UNIDADE',
                'leading_space' => ' L',
                'trailing_space' => 'L ',
            ]);
        });
    });
});
