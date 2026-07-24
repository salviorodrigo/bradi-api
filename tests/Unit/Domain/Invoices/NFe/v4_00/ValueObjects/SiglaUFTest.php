<?php

declare(strict_types=1);

use BradiApi\Domain\Common\ValueObjects\Result;
use BradiApi\Domain\Invoices\NFe\v4_00\ValueObjects\SiglaUF;
use BradiApi\Domain\Invoices\Templates\DFeElement;
use BradiApi\Domain\Xml\ValueObjects\Element;

describe('SiglaUF', function () {
    test('Should succeed if is declared', function () {
        $nameSpace = 'BradiApi\\Domain\\Invoices\\NFe\\v4_00\\ValueObjects';
        $sut = $nameSpace . '\\SiglaUF';
        expect(class_exists($sut))->toBeTrue();
    });

    test('Should succeed if extends DFeElement', function () {
        $sut = new SiglaUF('parentTag');
        expect(is_subclass_of($sut, DFeElement::class))->toBeTrue();
    });

    describe('properties', function () {
        describe('FIELD_NAME', function () {
            test('Should be set correctly', function () {
                expect(SiglaUF::FIELD_NAME)->toBe('UF');
            });
        });
    });

    describe('methods', function () {
        describe('validateTagValue', function () {
            test('Should succeed with valid state codes', function (string $candidate) {
                $element = new Element;
                $element->name = SiglaUF::FIELD_NAME;
                $element->value = $candidate;
                $instance = new SiglaUF('parentTag');
                $sut = new ReflectionMethod($instance, 'validateTagValue');
                $sutResponse = $sut->invoke($instance, $element);
                expect($sutResponse)->toBeInstanceOf(Result::class);
                if ($sutResponse->isFailure()) {
                    $this->fail(json_encode($sutResponse->getError()));
                }
                expect($sutResponse->isSuccess())->toBeTrue();
            })->with([
                'sao_paulo' => 'SP',
                'minas_gerais' => 'MG',
                'rio_janeiro' => 'RJ',
                'bahia' => 'BA',
                'amazonas' => 'AM',
            ]);

            test('Should fail if value is empty', function () {
                $element = new Element;
                $element->name = SiglaUF::FIELD_NAME;
                $element->value = '';
                $instance = new SiglaUF('parentTag');
                $sut = new ReflectionMethod($instance, 'validateTagValue');
                $sutResponse = $sut->invoke($instance, $element);
                expect($sutResponse->isFailure())->toBeTrue();
            });

            test('Should fail with invalid values', function (string $candidate) {
                $element = new Element;
                $element->name = SiglaUF::FIELD_NAME;
                $element->value = $candidate;
                $instance = new SiglaUF('parentTag');
                $sut = new ReflectionMethod($instance, 'validateTagValue');
                $sutResponse = $sut->invoke($instance, $element);
                expect($sutResponse->isFailure())->toBeTrue();
            })->with([
                'too_short' => 'S',
                'too_long' => 'SPP',
                'invalid_code' => 'XX',
                'lowercase' => 'sp',
                'leading_space' => ' SP',
                'trailing_space' => 'SP ',
                'numeric' => '12',
            ]);
        });
    });
});
