<?php

declare(strict_types=1);

use BradiApi\Domain\Common\ValueObjects\Result;
use BradiApi\Domain\Invoices\NFe\v4_00\ValueObjects\CodigoUF;
use BradiApi\Domain\Invoices\Templates\DFeElement;
use BradiApi\Domain\Xml\ValueObjects\Element;

describe('CodigoUF', function () {
    test('Should succeed if is declared', function () {
        $nameSpace = 'BradiApi\\Domain\\Invoices\\NFe\\v4_00\\ValueObjects';
        $sut = $nameSpace . '\\CodigoUF';
        expect(class_exists($sut))->toBeTrue();
    });

    test('Should succeed if extends DFeElement', function () {
        $sut = new CodigoUF('parentTag');
        expect(is_subclass_of($sut, DFeElement::class))->toBeTrue();
    });

    describe('properties', function () {
        describe('FIELD_NAME', function () {
            test('Should be set correctly', function () {
                $reflection = new ReflectionClass(CodigoUF::class);
                $reflectedProperty = $reflection->getConstant('FIELD_NAME');
                expect($reflectedProperty)->toBe('cUF');
            });
        });
    });

    describe('methods', function () {
        describe('validateTagValue', function () {
            test('Should succeed with valid codes', function (string $candidate) {
                $element = new Element;
                $element->name = 'cUF';
                $element->value = $candidate;
                $codigoUF = new CodigoUF('parentTag');
                $sut = new ReflectionMethod($codigoUF, 'validateTagValue');
                $sutResponse = $sut->invoke($codigoUF, $element);
                expect($sutResponse)->toBeInstanceOf(Result::class);
                if ($sutResponse->isFailure()) {
                    $this->fail(json_encode($sutResponse->getError()));
                }
                expect($sutResponse->isSuccess())->toBeTrue();
            })->with([
                'RO' => '11',
                'AC' => '12',
                'AM' => '13',
                'RR' => '14',
                'PA' => '15',
                'AP' => '16',
                'TO' => '17',
                'MA' => '21',
                'PI' => '22',
                'CE' => '23',
                'RN' => '24',
                'PB' => '25',
                'PE' => '26',
                'AL' => '27',
                'SE' => '28',
                'BA' => '29',
                'MG' => '31',
                'ES' => '32',
                'RJ' => '33',
                'SP' => '35',
                'PR' => '41',
                'SC' => '42',
                'RS' => '43',
                'MS' => '50',
                'MT' => '51',
                'GO' => '52',
                'DF' => '53',
            ]);

            test('Should fail if value is empty', function () {
                $candidate = '';
                $element = new Element;
                $element->name = 'cUF';
                $element->value = $candidate;
                $codigoUF = new CodigoUF('parentTag');
                $sut = new ReflectionMethod($codigoUF, 'validateTagValue');
                $sutResponse = $sut->invoke($codigoUF, $element);
                expect($sutResponse->isFailure())->toBeTrue();
            });

            test('Should fail if non-valid code', function (string $candidate) {
                $element = new Element;
                $element->name = 'cUF';
                $element->value = $candidate;
                $codigoUF = new CodigoUF('parentTag');
                $sut = new ReflectionMethod($codigoUF, 'validateTagValue');
                $sutResponse = $sut->invoke($codigoUF, $element);
                expect($sutResponse->isFailure())->toBeTrue();
            })->with([
                'too_short' => '1',
                'too_long' => '111',
                'leading_space' => ' 11',
                'trailing_space' => '11 ',
                'middle_space' => '1 1',
                'alphanumeric' => '1A',
                'invalid_ten' => '10',
                'invalid_eighteen' => '18',
                'invalid_twenty' => '20',
                'invalid_thirty' => '30',
                'invalid_thirty_six' => '36',
                'invalid_forty' => '40',
                'invalid_forty_four' => '44',
                'invalid_forty_nine' => '49',
                'invalid_fifty_four' => '54',
            ]);
        });
    });
});
