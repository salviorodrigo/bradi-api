<?php

declare(strict_types=1);

use BradiApi\Domain\Common\ValueObjects\Result;
use BradiApi\Domain\Invoices\NFe\v4_00\ValueObjects\CadastroPF;
use BradiApi\Domain\Invoices\Templates\DFeElement;
use BradiApi\Domain\Xml\ValueObjects\Element;

describe('CadastroPF', function () {
    test('Should succeed if is declared', function () {
        $nameSpace = 'BradiApi\\Domain\\Invoices\\NFe\\v4_00\\ValueObjects';
        $sut = $nameSpace . '\\CadastroPF';
        expect(class_exists($sut))->toBeTrue();
    });

    test('Should succeed if extends DFeElement', function () {
        $sut = new CadastroPF('parentTag');
        expect(is_subclass_of($sut, DFeElement::class))->toBeTrue();
    });

    describe('properties', function () {
        describe('FIELD_NAME', function () {
            test('Should be set correctly', function () {
                $reflection = new ReflectionClass(CadastroPF::class);
                $reflectedProperty = $reflection->getConstant('FIELD_NAME');
                expect($reflectedProperty)->toBe('CPF');
            });
        });
    });

    describe('methods', function () {
        describe('validateTagValue', function () {
            test('Should succeed with valid values', function (string $candidate) {
                $element = new Element;
                $element->name = 'CPF';
                $element->value = $candidate;
                $instance = new CadastroPF('parentTag');
                $sut = new ReflectionMethod($instance, 'validateTagValue');
                $sutResponse = $sut->invoke($instance, $element);
                expect($sutResponse)->toBeInstanceOf(Result::class);
                if ($sutResponse->isFailure()) {
                    $this->fail(json_encode($sutResponse->getError()));
                }
                expect($sutResponse->isSuccess())->toBeTrue();
            })->with(['standard' => '01505280001']);

            test('Should fail if value is invalid', function (string $candidate) {
                $element = new Element;
                $element->name = 'CPF';
                $element->value = $candidate;
                $instance = new CadastroPF('parentTag');
                $sut = new ReflectionMethod($instance, 'validateTagValue');
                $sutResponse = $sut->invoke($instance, $element);
                expect($sutResponse->isFailure())->toBeTrue();
            })->with([
                'empty' => '',
                'too_short' => '0150528000',
                'too_long' => '015052800012',
                'leading_space' => ' 01505280001',
                'trailing_space' => '01505280001 ',
                'middle_space' => '01505 280001',
                'masked' => '015.052.800-01',
                'alphanumeric' => '0150A280001',
            ]);
        });
    });
});
