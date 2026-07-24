<?php

declare(strict_types=1);

use BradiApi\Domain\Common\ValueObjects\Result;
use BradiApi\Domain\Invoices\NFe\v4_00\ValueObjects\IndFinal;
use BradiApi\Domain\Invoices\Templates\DFeElement;
use BradiApi\Domain\Xml\ValueObjects\Element;

describe('IndFinal', function () {
    test('Should succeed if is declared', function () {
        $nameSpace = 'BradiApi\\Domain\\Invoices\\NFe\\v4_00\\ValueObjects';
        $sut = $nameSpace . '\\IndFinal';
        expect(class_exists($sut))->toBeTrue();
    });

    test('Should succeed if extends DFeElement', function () {
        $sut = new IndFinal('parentTag');
        expect(is_subclass_of($sut, DFeElement::class))->toBeTrue();
    });

    describe('properties', function () {
        describe('FIELD_NAME', function () {
            test('Should be set correctly', function () {
                expect(IndFinal::FIELD_NAME)->toBe('indFinal');
            });
        });
    });

    describe('methods', function () {
        describe('validateTagValue', function () {
            test('Should succeed with valid numeric values', function (string $candidate) {
                $element = new Element;
                $element->name = IndFinal::FIELD_NAME;
                $element->value = $candidate;
                $instance = new IndFinal('parentTag');
                $sut = new ReflectionMethod($instance, 'validateTagValue');
                $sutResponse = $sut->invoke($instance, $element);
                expect($sutResponse)->toBeInstanceOf(Result::class);
                if ($sutResponse->isFailure()) {
                    $this->fail(json_encode($sutResponse->getError()));
                }
                expect($sutResponse->isSuccess())->toBeTrue();
            })->with([
                'zero' => '0',
                'one' => '1',
            ]);

            test('Should fail if value is empty', function () {
                $element = new Element;
                $element->name = IndFinal::FIELD_NAME;
                $element->value = '';
                $instance = new IndFinal('parentTag');
                $sut = new ReflectionMethod($instance, 'validateTagValue');
                $sutResponse = $sut->invoke($instance, $element);
                expect($sutResponse->isFailure())->toBeTrue();
            });

            test('Should fail with invalid values', function (string $candidate) {
                $element = new Element;
                $element->name = IndFinal::FIELD_NAME;
                $element->value = $candidate;
                $instance = new IndFinal('parentTag');
                $sut = new ReflectionMethod($instance, 'validateTagValue');
                $sutResponse = $sut->invoke($instance, $element);
                expect($sutResponse->isFailure())->toBeTrue();
            })->with([
                'two' => '2',
                'three' => '3',
                'alphabetic' => 'a',
                'leading_space' => ' 0',
                'trailing_space' => '0 ',
            ]);
        });
    });
});
