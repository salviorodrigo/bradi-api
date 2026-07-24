<?php

declare(strict_types=1);

use BradiApi\Domain\Common\ValueObjects\Result;
use BradiApi\Domain\Invoices\NFe\v4_00\ValueObjects\Telefone;
use BradiApi\Domain\Invoices\Templates\DFeElement;
use BradiApi\Domain\Xml\ValueObjects\Element;

describe('Telefone', function () {
    test('Should succeed if is declared', function () {
        $nameSpace = 'BradiApi\\Domain\\Invoices\\NFe\\v4_00\\ValueObjects';
        $sut = $nameSpace . '\\Telefone';
        expect(class_exists($sut))->toBeTrue();
    });

    test('Should succeed if extends DFeElement', function () {
        $sut = new Telefone('parentTag');
        expect(is_subclass_of($sut, DFeElement::class))->toBeTrue();
    });

    describe('properties', function () {
        describe('FIELD_NAME', function () {
            test('Should be set correctly', function () {
                expect(Telefone::FIELD_NAME)->toBe('fone');
            });
        });
    });

    describe('methods', function () {
        describe('validateTagValue', function () {
            test('Should succeed with valid phone numbers', function (string $candidate) {
                $element = new Element;
                $element->name = Telefone::FIELD_NAME;
                $element->value = $candidate;
                $instance = new Telefone('parentTag');
                $sut = new ReflectionMethod($instance, 'validateTagValue');
                $sutResponse = $sut->invoke($instance, $element);
                expect($sutResponse)->toBeInstanceOf(Result::class);
                if ($sutResponse->isFailure()) {
                    $this->fail(json_encode($sutResponse->getError()));
                }
                expect($sutResponse->isSuccess())->toBeTrue();
            })->with([
                'minimum' => '123456',
                'standard' => '1133334444',
                'maximum' => '12345678901234',
            ]);

            test('Should fail if value is empty', function () {
                $element = new Element;
                $element->name = Telefone::FIELD_NAME;
                $element->value = '';
                $instance = new Telefone('parentTag');
                $sut = new ReflectionMethod($instance, 'validateTagValue');
                $sutResponse = $sut->invoke($instance, $element);
                expect($sutResponse->isFailure())->toBeTrue();
            });

            test('Should fail with invalid values', function (string $candidate) {
                $element = new Element;
                $element->name = Telefone::FIELD_NAME;
                $element->value = $candidate;
                $instance = new Telefone('parentTag');
                $sut = new ReflectionMethod($instance, 'validateTagValue');
                $sutResponse = $sut->invoke($instance, $element);
                expect($sutResponse->isFailure())->toBeTrue();
            })->with([
                'too_short' => '12345',
                'too_long' => '123456789012345',
                'alphabetic' => 'abcdefgh',
                'leading_space' => ' 123456',
                'trailing_space' => '123456 ',
                'middle_space' => '123 456',
                'with_hyphen' => '11-3333-4444',
            ]);
        });
    });
});
