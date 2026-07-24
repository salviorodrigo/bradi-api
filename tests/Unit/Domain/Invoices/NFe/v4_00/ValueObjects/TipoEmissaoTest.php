<?php

declare(strict_types=1);
use BradiApi\Domain\Common\ValueObjects\Result;
use BradiApi\Domain\Invoices\NFe\v4_00\ValueObjects\TipoEmissao;
use BradiApi\Domain\Invoices\Templates\DFeElement;
use BradiApi\Domain\Xml\ValueObjects\Element;

describe('TipoEmissao', function () {

    test('Should succeed if is declared', function () {
        $nameSpace = 'BradiApi\Domain\Invoices\NFe\v4_00\ValueObjects';
        $sut = $nameSpace . '\\TipoEmissao';
        expect(class_exists($sut))->toBeTrue();
    });

    test('Should succeed if extends DFeelement', function () {
        $sut = new TipoEmissao('parentTag');
        expect(is_subclass_of($sut, DFeElement::class))->toBeTrue();
    });

    describe('properties', function () {
        describe('FIELD_NAME', function () {
            test('Should be set correctly', function () {
                $reflection = new ReflectionClass(TipoEmissao::class);
                $reflectedProperty = $reflection->getConstant('FIELD_NAME');
                expect($reflectedProperty)->toBe('tpEmis');
            });
        });
    });

    describe('methods', function () {
        describe('validateTagValue', function () {
            test('Should succeed in valid options', function (string $candidate) {
                $element = new Element;
                $element->name = 'tpEmis';
                $element->value = $candidate;
                $tipoEmissao = new TipoEmissao('parentTag');
                $sut = new ReflectionMethod($tipoEmissao, 'validateTagValue');
                $sutResponse = $sut->invoke($tipoEmissao, $element);
                expect($sutResponse)->toBeInstanceOf(Result::class);
                if ($sutResponse->isFailure()) {
                    $this->fail(json_encode($sutResponse->getError()));
                }

                expect($sutResponse->isSuccess())->toBeTrue();
            })->with([
                'normal' => '1',
                'fs_ia' => '2',
                'scan' => '3',
                'epec' => '4',
                'fs_da' => '5',
                'svc_an' => '6',
                'svc_rs' => '7',
                'offline_nfce' => '9',
            ]);

            test('Should fail if value is empty', function () {
                $candidate = '';
                $element = new Element;
                $element->name = 'tpEmis';
                $element->value = $candidate;
                $tipoEmissao = new TipoEmissao('parentTag');
                $sut = new ReflectionMethod($tipoEmissao, 'validateTagValue');
                $sutResponse = $sut->invoke($tipoEmissao, $element);
                expect($sutResponse->isFailure())->toBeTrue();
            });

            test('Should fail if value is out of range', function (string $candidate) {
                $element = new Element;
                $element->name = 'tpEmis';
                $element->value = $candidate;
                $tipoEmissao = new TipoEmissao('parentTag');
                $sut = new ReflectionMethod($tipoEmissao, 'validateTagValue');
                $sutResponse = $sut->invoke($tipoEmissao, $element);
                expect($sutResponse->isFailure())->toBeTrue();
            })->with([
                'zero' => '0',
                'eight' => '8',
            ]);

            test('Should fail if non-numeric value is provided', function () {
                $candidate = 'A';
                $element = new Element;
                $element->name = 'tpEmis';
                $element->value = $candidate;
                $tipoEmissao = new TipoEmissao('parentTag');
                $sut = new ReflectionMethod($tipoEmissao, 'validateTagValue');
                $sutResponse = $sut->invoke($tipoEmissao, $element);
                expect($sutResponse->isFailure())->toBeTrue();
            });

            test('Should fail if a numeric value with spaces is provided', function (string $candidate) {
                $element = new Element;
                $element->name = 'tpEmis';
                $element->value = $candidate;
                $tipoEmissao = new TipoEmissao('parentTag');
                $sut = new ReflectionMethod($tipoEmissao, 'validateTagValue');
                $sutResponse = $sut->invoke($tipoEmissao, $element);
                expect($sutResponse->isFailure())->toBeTrue();
            })->with([
                'leading space' => ' 1',
                'trailing space' => '1 ',
            ]);

            test('Should fail if value has invalid length', function () {
                $candidate = '10';
                $element = new Element;
                $element->name = 'tpEmis';
                $element->value = $candidate;
                $tipoEmissao = new TipoEmissao('parentTag');
                $sut = new ReflectionMethod($tipoEmissao, 'validateTagValue');
                $sutResponse = $sut->invoke($tipoEmissao, $element);
                expect($sutResponse->isFailure())->toBeTrue();
            });
        });
    });
});
