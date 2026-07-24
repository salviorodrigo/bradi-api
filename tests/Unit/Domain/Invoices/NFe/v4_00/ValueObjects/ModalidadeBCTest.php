<?php

declare(strict_types=1);

use BradiApi\Domain\Common\ValueObjects\Result;
use BradiApi\Domain\Invoices\NFe\v4_00\ValueObjects\ModalidadeBC;
use BradiApi\Domain\Invoices\Templates\DFeElement;
use BradiApi\Domain\Xml\ValueObjects\Element;

describe('ModalidadeBC', function () {
    test('Should succeed if is declared', function () {
        $nameSpace = 'BradiApi\\Domain\\Invoices\\NFe\\v4_00\\ValueObjects';
        $sut = $nameSpace . '\\ModalidadeBC';
        expect(class_exists($sut))->toBeTrue();
    });

    test('Should succeed if extends DFeElement', function () {
        $sut = new ModalidadeBC('parentTag');
        expect(is_subclass_of($sut, DFeElement::class))->toBeTrue();
    });

    describe('properties', function () {
        describe('FIELD_NAME', function () {
            test('Should be set correctly', function () {
                $reflection = new ReflectionClass(ModalidadeBC::class);
                $reflectedProperty = $reflection->getConstant('FIELD_NAME');
                expect($reflectedProperty)->toBe('modBC');
            });
        });
    });

    describe('methods', function () {
        describe('validateTagValue', function () {
            test('Should succeed with valid values', function (string $candidate) {
                $element = new Element;
                $element->name = 'modBC';
                $element->value = $candidate;
                $instance = new ModalidadeBC('parentTag');
                $sut = new ReflectionMethod($instance, 'validateTagValue');
                $sutResponse = $sut->invoke($instance, $element);
                expect($sutResponse)->toBeInstanceOf(Result::class);
                if ($sutResponse->isFailure()) {
                    $this->fail(json_encode($sutResponse->getError()));
                }
                expect($sutResponse->isSuccess())->toBeTrue();
            })->with([
                'margem_valor_agregado' => '0',
                'pauta' => '1',
                'preco_tabelado_maximo' => '2',
                'valor_operacao' => '3',
            ]);

            test('Should fail if value is invalid', function (string $candidate) {
                $element = new Element;
                $element->name = 'modBC';
                $element->value = $candidate;
                $instance = new ModalidadeBC('parentTag');
                $sut = new ReflectionMethod($instance, 'validateTagValue');
                $sutResponse = $sut->invoke($instance, $element);
                expect($sutResponse->isFailure())->toBeTrue();
            })->with([
                'empty' => '',
                'leading_space' => ' 1',
                'trailing_space' => '1 ',
                'alphabetic' => 'A',
                'out_of_range_negative' => '-1',
                'out_of_range_four' => '4',
            ]);
        });
    });
});
