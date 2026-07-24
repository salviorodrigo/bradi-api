<?php

declare(strict_types=1);
use BradiApi\Domain\Common\ValueObjects\Result;
use BradiApi\Domain\Invoices\NFe\v4_00\ValueObjects\DataHoraEmissao;
use BradiApi\Domain\Invoices\Templates\DFeElement;
use BradiApi\Domain\Xml\ValueObjects\Element;

describe('DataHoraEmissao', function () {

    test('Should succeed if is declared', function () {
        $nameSpace = 'BradiApi\Domain\Invoices\NFe\v4_00\ValueObjects';
        $sut = $nameSpace . '\\DataHoraEmissao';
        expect(class_exists($sut))->toBeTrue();
    });

    test('Should succeed if extends DFeelement', function () {
        $sut = new DataHoraEmissao('parentTag');
        expect(is_subclass_of($sut, DFeElement::class))->toBeTrue();
    });

    describe('properties', function () {
        describe('FIELD_NAME', function () {
            test('Should be set correctly', function () {
                $reflection = new ReflectionClass(DataHoraEmissao::class);
                $reflectedProperty = $reflection->getConstant('FIELD_NAME');
                expect($reflectedProperty)->toBe('dhEmi');
            });
        });
    });

    describe('methods', function () {
        describe('validateTagValue', function () {
            test('Should succeed in valid format', function () {
                $candidate = '2026-03-01T14:30:00-03:00';
                $element = new Element;
                $element->name = 'dhEmi';
                $element->value = $candidate;
                $dataHoraEmissao = new DataHoraEmissao('parentTag');
                $sut = new ReflectionMethod($dataHoraEmissao, 'validateTagValue');
                $sutResponse = $sut->invoke($dataHoraEmissao, $element);
                expect($sutResponse)->toBeInstanceOf(Result::class);
                if ($sutResponse->isFailure()) {
                    $this->fail(json_encode($sutResponse->getError()));
                }

                expect($sutResponse->isSuccess())->toBeTrue();
            });

            test('Should fail if value is empty', function () {
                $candidate = '';
                $element = new Element;
                $element->name = 'dhEmi';
                $element->value = $candidate;
                $dataHoraEmissao = new DataHoraEmissao('parentTag');
                $sut = new ReflectionMethod($dataHoraEmissao, 'validateTagValue');
                $sutResponse = $sut->invoke($dataHoraEmissao, $element);
                expect($sutResponse->isFailure())->toBeTrue();
            });

            test('Should fail if value has invalid spaces', function (string $candidate) {
                $element = new Element;
                $element->name = 'dhEmi';
                $element->value = $candidate;
                $dataHoraEmissao = new DataHoraEmissao('parentTag');
                $sut = new ReflectionMethod($dataHoraEmissao, 'validateTagValue');
                $sutResponse = $sut->invoke($dataHoraEmissao, $element);
                expect($sutResponse->isFailure())->toBeTrue();
            })->with([
                'leading space' => ' 2026-03-01T14:30:00-03:00',
                'trailing space' => '2026-03-01T14:30:00-03:00 ',
            ]);

            test('Should fail if value has invalid format', function (string $candidate) {
                $element = new Element;
                $element->name = 'dhEmi';
                $element->value = $candidate;
                $dataHoraEmissao = new DataHoraEmissao('parentTag');
                $sut = new ReflectionMethod($dataHoraEmissao, 'validateTagValue');
                $sutResponse = $sut->invoke($dataHoraEmissao, $element);
                expect($sutResponse->isFailure())->toBeTrue();
            })->with([
                'missing time zone' => '2026-03-01T14:30:00',
                'missing seconds' => '2026-03-01T14:30-03:00',
                'missing time' => '2026-03-01',
                'invalid format' => '03/01/2026 14:30:00-03:00',
            ]);
        });
    });
});
