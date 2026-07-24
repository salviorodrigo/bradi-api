<?php

declare(strict_types=1);

use BradiApi\Domain\Common\ValueObjects\Result;
use BradiApi\Domain\Invoices\NFe\v4_00\ValueObjects\IdDestino;
use BradiApi\Domain\Invoices\Templates\DFeElement;
use BradiApi\Domain\Xml\ValueObjects\Element;

describe('IdDestino', function () {
    test('Should succeed if is declared', function () {
        $nameSpace = 'BradiApi\\Domain\\Invoices\\NFe\\v4_00\\ValueObjects';
        $sut = $nameSpace . '\\IdDestino';
        expect(class_exists($sut))->toBeTrue();
    });

    test('Should succeed if extends DFeElement', function () {
        $sut = new IdDestino('parentTag');
        expect(is_subclass_of($sut, DFeElement::class))->toBeTrue();
    });

    describe('properties', function () {
        describe('FIELD_NAME', function () {
            test('Should be set correctly', function () {
                expect(IdDestino::FIELD_NAME)->toBe('idDest');
            });
        });
    });

    describe('methods', function () {
        describe('validateTagValue', function () {
            test('Should succeed with valid numeric values', function (string $candidate) {
                $element = new Element;
                $element->name = IdDestino::FIELD_NAME;
                $element->value = $candidate;
                $instance = new IdDestino('parentTag');
                $sut = new ReflectionMethod($instance, 'validateTagValue');
                $sutResponse = $sut->invoke($instance, $element);
                expect($sutResponse)->toBeInstanceOf(Result::class);
                if ($sutResponse->isFailure()) {
                    $this->fail(json_encode($sutResponse->getError()));
                }
                expect($sutResponse->isSuccess())->toBeTrue();
            })->with([
                'one' => '1',
                'two' => '2',
                'three' => '3',
            ]);

            test('Should fail if value is empty', function () {
                $element = new Element;
                $element->name = IdDestino::FIELD_NAME;
                $element->value = '';
                $instance = new IdDestino('parentTag');
                $sut = new ReflectionMethod($instance, 'validateTagValue');
                $sutResponse = $sut->invoke($instance, $element);
                expect($sutResponse->isFailure())->toBeTrue();
            });

            test('Should fail with invalid values', function (string $candidate) {
                $element = new Element;
                $element->name = IdDestino::FIELD_NAME;
                $element->value = $candidate;
                $instance = new IdDestino('parentTag');
                $sut = new ReflectionMethod($instance, 'validateTagValue');
                $sutResponse = $sut->invoke($instance, $element);
                expect($sutResponse->isFailure())->toBeTrue();
            })->with([
                'zero' => '0',
                'four' => '4',
                'alphabetic' => 'a',
                'leading_space' => ' 1',
                'trailing_space' => '1 ',
            ]);
        });
    });
});
