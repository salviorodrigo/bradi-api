<?php

declare(strict_types=1);
use BradiApi\Domain\Common\ValueObjects\Result;
use BradiApi\Domain\Invoices\NFe\v4_00\ValueObjects\DataHoraSaidaEntrada;
use BradiApi\Domain\Invoices\Templates\DFeElement;
use BradiApi\Domain\Xml\ValueObjects\Element;

describe('DataHoraSaidaEntrada', function () {
    test('Should succeed if is declared', function () {
        $nameSpace = 'BradiApi\Domain\Invoices\NFe\v4_00\ValueObjects';
        $sut = $nameSpace . '\\DataHoraSaidaEntrada';
        expect(class_exists($sut))->toBeTrue();
    });

    test('Should succeed if extends DFeelement', function () {
        $sut = new DataHoraSaidaEntrada('parentTag');
        expect(is_subclass_of($sut, DFeElement::class))->toBeTrue();
    });

    describe('properties', function () {
        describe('FIELD_NAME', function () {
            test('Should be set correctly', function () {
                $reflection = new ReflectionClass(DataHoraSaidaEntrada::class);
                $reflectedProperty = $reflection->getConstant('FIELD_NAME');
                expect($reflectedProperty)->toBe('dhSaiEnt');
            });
        });
    });

    describe('methods', function () {
        describe('validateTagAttributes', function () {
            test('Should fail if some attribute is provided', function () {
                $targetClass = new DataHoraSaidaEntrada('parentTag');
                $fieldName = (new ReflectionClass($targetClass))->getConstant('FIELD_NAME');
                $xmlString = "<{$fieldName} attribute=\"aValue\"></{$fieldName}>";
                $xmlElement = new Element;
                $xmlElement->parse($xmlString);
                $sut = new ReflectionMethod($targetClass, 'validateTagAttributes');
                $sutResponse = $sut->invoke($targetClass, $xmlElement);
                expect($sutResponse->isFailure())->toBeTrue();
            });
        });

        describe('validateTagElements', function () {
            test('Should fail if some element is provided', function () {
                $targetClass = new DataHoraSaidaEntrada('parentTag');
                $fieldName = (new ReflectionClass($targetClass))->getConstant('FIELD_NAME');
                $xmlString = "<{$fieldName}><unallowed/></{$fieldName}>";
                $xmlElement = new Element;
                $xmlElement->parse($xmlString);
                $sut = new ReflectionMethod($targetClass, 'validateTagElements');
                $sutResponse = $sut->invoke($targetClass, $xmlElement);
                expect($sutResponse->isFailure())->toBeTrue();
            });
        });

        describe('validateTagValue', function () {
            test('Should succeed in valid format', function () {
                $candidate = '2026-03-01T14:30:00-03:00';
                $element = new Element;
                $element->name = 'dhSaiEnt';
                $element->value = $candidate;
                $dataHoraSaidaEntrada = new DataHoraSaidaEntrada('parentTag');
                $sut = new ReflectionMethod($dataHoraSaidaEntrada, 'validateTagValue');
                $sutResponse = $sut->invoke($dataHoraSaidaEntrada, $element);
                expect($sutResponse)->toBeInstanceOf(Result::class);
                if ($sutResponse->isFailure()) {
                    $this->fail(json_encode($sutResponse->getError()));
                }

                expect($sutResponse->isSuccess())->toBeTrue();
            });

            test('Should fail if value is empty', function () {
                $candidate = '';
                $element = new Element;
                $element->name = 'dhSaiEnt';
                $element->value = $candidate;
                $dataHoraSaidaEntrada = new DataHoraSaidaEntrada('parentTag');
                $sut = new ReflectionMethod($dataHoraSaidaEntrada, 'validateTagValue');
                $sutResponse = $sut->invoke($dataHoraSaidaEntrada, $element);
                expect($sutResponse->isFailure())->toBeTrue();
            });

            test('Should fail if value has invalid spaces', function (string $candidate) {
                $element = new Element;
                $element->name = 'dhSaiEnt';
                $element->value = $candidate;
                $dataHoraSaidaEntrada = new DataHoraSaidaEntrada('parentTag');
                $sut = new ReflectionMethod($dataHoraSaidaEntrada, 'validateTagValue');
                $sutResponse = $sut->invoke($dataHoraSaidaEntrada, $element);
                expect($sutResponse->isFailure())->toBeTrue();
            })->with([
                'leading space' => ' 2026-03-01T14:30:00-03:00',
                'trailing space' => '2026-03-01T14:30:00-03:00 ',
            ]);

            test('Should fail if value has invalid format', function (string $candidate) {
                $element = new Element;
                $element->name = 'dhSaiEnt';
                $element->value = $candidate;
                $dataHoraSaidaEntrada = new DataHoraSaidaEntrada('parentTag');
                $sut = new ReflectionMethod($dataHoraSaidaEntrada, 'validateTagValue');
                $sutResponse = $sut->invoke($dataHoraSaidaEntrada, $element);
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
