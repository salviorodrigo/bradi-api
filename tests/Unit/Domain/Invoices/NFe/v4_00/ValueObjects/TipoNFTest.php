<?php

declare(strict_types=1);
use BradiApi\Domain\Common\ValueObjects\Result;
use BradiApi\Domain\Invoices\NFe\v4_00\ValueObjects\TipoNF;
use BradiApi\Domain\Invoices\Templates\DFeElement;
use BradiApi\Domain\Xml\ValueObjects\Element;

describe('TipoNF', function () {

    test('Should succeed if is declared', function () {
        $nameSpace = 'BradiApi\Domain\Invoices\NFe\v4_00\ValueObjects';
        $sut = $nameSpace . '\\TipoNF';
        expect(class_exists($sut))->toBeTrue();
    });

    test('Should succeed if extends DFeelement', function () {
        $sut = new TipoNF('parentTag');
        expect(is_subclass_of($sut, DFeElement::class))->toBeTrue();
    });

    describe('properties', function () {
        describe('FIELD_NAME', function () {
            test('Should be set correctly', function () {
                $reflection = new ReflectionClass(TipoNF::class);
                $reflectedProperty = $reflection->getConstant('FIELD_NAME');
                expect($reflectedProperty)->toBe('tpNF');
            });
        });
    });

    describe('methods', function () {
        describe('validateTagValue', function () {
            test('Should succeed in valid options', function (string $candidate) {
                $element = new Element;
                $element->name = 'tpNF';
                $element->value = $candidate;
                $tipoNF = new TipoNF('parentTag');
                $sut = new ReflectionMethod($tipoNF, 'validateTagValue');
                $sutResponse = $sut->invoke($tipoNF, $element);
                expect($sutResponse)->toBeInstanceOf(Result::class);
                if ($sutResponse->isFailure()) {
                    $this->fail(json_encode($sutResponse->getError()));
                }

                expect($sutResponse->isSuccess())->toBeTrue();
            })->with([
                'entry' => '0',
                'exit' => '1',
            ]);

            test('Should fail if value is empty', function () {
                $candidate = '';
                $element = new Element;
                $element->name = 'tpNF';
                $element->value = $candidate;
                $tipoNF = new TipoNF('parentTag');
                $sut = new ReflectionMethod($tipoNF, 'validateTagValue');
                $sutResponse = $sut->invoke($tipoNF, $element);
                expect($sutResponse->isFailure())->toBeTrue();
            });

            test('Should fail if value is out of range', function () {
                $candidate = '2';
                $element = new Element;
                $element->name = 'tpNF';
                $element->value = $candidate;
                $tipoNF = new TipoNF('parentTag');
                $sut = new ReflectionMethod($tipoNF, 'validateTagValue');
                $sutResponse = $sut->invoke($tipoNF, $element);
                expect($sutResponse->isFailure())->toBeTrue();
            });

            test('Should fail if non-numeric value is provided', function () {
                $candidate = 'A';
                $element = new Element;
                $element->name = 'tpNF';
                $element->value = $candidate;
                $tipoNF = new TipoNF('parentTag');
                $sut = new ReflectionMethod($tipoNF, 'validateTagValue');
                $sutResponse = $sut->invoke($tipoNF, $element);
                expect($sutResponse->isFailure())->toBeTrue();
            });

            test('Should fail if a numeric value with spaces is provided', function (string $candidate) {
                $element = new Element;
                $element->name = 'tpNF';
                $element->value = $candidate;
                $tipoNF = new TipoNF('parentTag');
                $sut = new ReflectionMethod($tipoNF, 'validateTagValue');
                $sutResponse = $sut->invoke($tipoNF, $element);
                expect($sutResponse->isFailure())->toBeTrue();
            })->with([
                'leading space' => ' 1',
                'trailing space' => '1 ',
            ]);

            test('Should fail if value has invalid length', function () {
                $candidate = '01';
                $element = new Element;
                $element->name = 'tpNF';
                $element->value = $candidate;
                $tipoNF = new TipoNF('parentTag');
                $sut = new ReflectionMethod($tipoNF, 'validateTagValue');
                $sutResponse = $sut->invoke($tipoNF, $element);
                expect($sutResponse->isFailure())->toBeTrue();
            });
        });
    });
});
