<?php

declare(strict_types=1);

use BradiApi\Domain\Common\ValueObjects\Result;
use BradiApi\Domain\Invoices\NFe\v4_00\ValueObjects\IndOrigem;
use BradiApi\Domain\Invoices\Templates\DFeElement;
use BradiApi\Domain\Xml\ValueObjects\Element;

describe('IndOrigem', function () {
    test('Should succeed if is declared', function () {
        $nameSpace = 'BradiApi\\Domain\\Invoices\\NFe\\v4_00\\ValueObjects';
        $sut = $nameSpace . '\\IndOrigem';
        expect(class_exists($sut))->toBeTrue();
    });

    test('Should succeed if extends DFeElement', function () {
        $sut = new IndOrigem('parentTag');
        expect(is_subclass_of($sut, DFeElement::class))->toBeTrue();
    });

    describe('properties', function () {
        describe('FIELD_NAME', function () {
            test('Should be set correctly', function () {
                $reflection = new ReflectionClass(IndOrigem::class);
                $reflectedProperty = $reflection->getConstant('FIELD_NAME');
                expect($reflectedProperty)->toBe('orig');
            });
        });
    });

    describe('methods', function () {
        describe('validateTagValue', function () {
            test('Should succeed with valid values', function (string $candidate) {
                $element = new Element;
                $element->name = 'orig';
                $element->value = $candidate;
                $instance = new IndOrigem('parentTag');
                $sut = new ReflectionMethod($instance, 'validateTagValue');
                $sutResponse = $sut->invoke($instance, $element);
                expect($sutResponse)->toBeInstanceOf(Result::class);
                if ($sutResponse->isFailure()) {
                    $this->fail(json_encode($sutResponse->getError()));
                }
                expect($sutResponse->isSuccess())->toBeTrue();
            })->with([
                'nacional' => '0',
                'estrangeira_importacao_direta' => '1',
                'estrangeira_mercado_interno' => '2',
                'nacional_importacao_superior_40' => '3',
                'nacional_processo_produtivo_basico' => '4',
                'nacional_importacao_ate_40' => '5',
                'estrangeira_importacao_sem_similar' => '6',
                'estrangeira_mercado_sem_similar' => '7',
                'nacional_importacao_superior_70' => '8',
            ]);

            test('Should fail if value is invalid', function (string $candidate) {
                $element = new Element;
                $element->name = 'orig';
                $element->value = $candidate;
                $instance = new IndOrigem('parentTag');
                $sut = new ReflectionMethod($instance, 'validateTagValue');
                $sutResponse = $sut->invoke($instance, $element);
                expect($sutResponse->isFailure())->toBeTrue();
            })->with([
                'empty' => '',
                'leading_space' => ' 1',
                'trailing_space' => '1 ',
                'alphabetic' => 'A',
                'out_of_range_negative' => '-1',
                'out_of_range_nine' => '9',
            ]);
        });
    });
});
