<?php

declare(strict_types=1);
use BradiApi\Domain\Common\ValueObjects\Result;
use BradiApi\Domain\Invoices\NFe\v4_00\ValueObjects\ModalidadeFrete;
use BradiApi\Domain\Invoices\Templates\DFeElement;
use BradiApi\Domain\Xml\ValueObjects\Element;

describe('ModalidadeFrete', function () {
    test('Should succeed if is declared', function () {
        $nameSpace = 'BradiApi\Domain\Invoices\NFe\v4_00\ValueObjects';
        $sut = $nameSpace . '\\ModalidadeFrete';
        expect(class_exists($sut))->toBeTrue();
    });

    test('Should succeed if extends DFeElement', function () {
        $sut = new ModalidadeFrete('parentTag');
        expect(is_subclass_of($sut, DFeElement::class))->toBeTrue();
    });

    describe('properties', function () {
        describe('FIELD_NAME', function () {
            test('Should be set correctly', function () {
                $reflection = new ReflectionClass(ModalidadeFrete::class);
                $reflectedProperty = $reflection->getConstant('FIELD_NAME');
                expect($reflectedProperty)->toBe('modFrete');
            });
        });
    });

    describe('methods', function () {
        describe('validateTagAttributes', function () {
            test('Should fail if some attribute is provided', function () {
                $targetClass = new ModalidadeFrete('parentTag');
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
                $targetClass = new ModalidadeFrete('parentTag');
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
            test('Should succeed in valid options', function (string $candidate) {
                $element = new Element;
                $element->name = 'modFrete';
                $element->value = $candidate;
                $targetClass = new ModalidadeFrete('parentTag');
                $sut = new ReflectionMethod($targetClass, 'validateTagValue');
                $sutResponse = $sut->invoke($targetClass, $element);
                expect($sutResponse)->toBeInstanceOf(Result::class);
                if ($sutResponse->isFailure()) {
                    $this->fail(json_encode($sutResponse->getError()));
                }

                expect($sutResponse->isSuccess())->toBeTrue();
            })->with([
                'cif' => '0',
                'fob' => '1',
                'terceiros' => '2',
                'proprio_remetente' => '3',
                'proprio_destinatario' => '4',
                'sem_ocorrencia' => '9',
            ]);

            test('Should fail if value is empty', function () {
                $candidate = '';
                $element = new Element;
                $element->name = 'modFrete';
                $element->value = $candidate;
                $targetClass = new ModalidadeFrete('parentTag');
                $sut = new ReflectionMethod($targetClass, 'validateTagValue');
                $sutResponse = $sut->invoke($targetClass, $element);
                expect($sutResponse->isFailure())->toBeTrue();
            });

            test('Should fail if value is out of range', function (string $candidate) {
                $element = new Element;
                $element->name = 'modFrete';
                $element->value = $candidate;
                $targetClass = new ModalidadeFrete('parentTag');
                $sut = new ReflectionMethod($targetClass, 'validateTagValue');
                $sutResponse = $sut->invoke($targetClass, $element);
                expect($sutResponse->isFailure())->toBeTrue();
            })->with([
                'negative' => '-1',
                'five' => '5',
                'eight' => '8',
                'ten' => '10',
            ]);

            test('Should fail if non-numeric value is provided', function () {
                $candidate = 'A';
                $element = new Element;
                $element->name = 'modFrete';
                $element->value = $candidate;
                $targetClass = new ModalidadeFrete('parentTag');
                $sut = new ReflectionMethod($targetClass, 'validateTagValue');
                $sutResponse = $sut->invoke($targetClass, $element);
                expect($sutResponse->isFailure())->toBeTrue();
            });

            test('Should fail if a numeric value with spaces is provided', function (string $candidate) {
                $element = new Element;
                $element->name = 'modFrete';
                $element->value = $candidate;
                $targetClass = new ModalidadeFrete('parentTag');
                $sut = new ReflectionMethod($targetClass, 'validateTagValue');
                $sutResponse = $sut->invoke($targetClass, $element);
                expect($sutResponse->isFailure())->toBeTrue();
            })->with([
                'leading space' => ' 1',
                'trailing space' => '1 ',
            ]);

            test('Should fail if value has invalid length', function () {
                $candidate = '01';
                $element = new Element;
                $element->name = 'modFrete';
                $element->value = $candidate;
                $targetClass = new ModalidadeFrete('parentTag');
                $sut = new ReflectionMethod($targetClass, 'validateTagValue');
                $sutResponse = $sut->invoke($targetClass, $element);
                expect($sutResponse->isFailure())->toBeTrue();
            });
        });
    });
});
