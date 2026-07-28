<?php

declare(strict_types=1);

use BradiApi\Domain\Invoices\NFe\v4_00\ValueObjects\MeioDePagamento;
use BradiApi\Domain\Invoices\Templates\DFeElement;
use BradiApi\Domain\Xml\ValueObjects\Element;

describe('MeioDePagamento', function () {
    test('Should succeed if is declared', function () {
        $nameSpace = 'BradiApi\\Domain\\Invoices\\NFe\\v4_00\\ValueObjects';
        $sut = $nameSpace . '\\MeioDePagamento';
        expect(class_exists($sut))->toBeTrue();
    });

    test('Should succeed if extends DFeElement', function () {
        $sut = new MeioDePagamento('parentTag');
        expect(is_subclass_of($sut, DFeElement::class))->toBeTrue();
    });

    describe('properties', function () {
        describe('FIELD_NAME', function () {
            test('Should be set correctly', function () {
                $reflection = new ReflectionClass(MeioDePagamento::class);
                $reflectedProperty = $reflection->getConstant('FIELD_NAME');
                expect($reflectedProperty)->toBe('tPag');
            });
        });
    });

    describe('methods', function () {
        describe('validateTagAttributes', function () {
            test('Should fails if some attribute is provided', function () {
                $xmlString = '<tPag attribute="aValue"></tPag>';
                $xmlElement = new Element;
                $xmlElement->parse($xmlString);
                $targetClass = new MeioDePagamento('parentTag');
                $sut = new ReflectionMethod($targetClass, 'validateTagAttributes');
                $sutResponse = $sut->invoke($targetClass, $xmlElement);
                expect($sutResponse->isFailure())->toBeTrue();
            });
        });

        describe('validateTagElements', function () {
            test('Should fail if some element is provided', function () {
                $xmlString = '<tPag><unallowed/></tPag>';
                $xmlElement = new Element;
                $xmlElement->parse($xmlString);
                $targetClass = new MeioDePagamento('parentTag');
                $sut = new ReflectionMethod($targetClass, 'validateTagElements');
                $sutResponse = $sut->invoke($targetClass, $xmlElement);
                expect($sutResponse->isFailure())->toBeTrue();
            });
        });

        describe('validateTagValue', function () {
            test('Should succeed if a valid tPag value is provided', function ($candidate) {
                $xmlString = "<tPag>{$candidate}</tPag>";
                $xmlElement = new Element;
                $xmlElement->parse($xmlString);
                $targetClass = new MeioDePagamento('parentTag');
                $sut = new ReflectionMethod($targetClass, 'validateTagValue');
                $sutResponse = $sut->invoke($targetClass, $xmlElement);
                expect($sutResponse->isSuccess())->toBeTrue();
            })->with([
                'Dinheiro' => '01',
                'Cheque' => '02',
                'Cartão de Crédito' => '03',
                'Cartão de Débito' => '04',
                'Crédito Loja' => '05',
                'Vale Alimentação' => '10',
                'Vale Refeição' => '11',
                'Vale Presente' => '12',
                'Vale Combustível' => '13',
                'Boleto Bancário' => '15',
                'Depósito Bancário' => '16',
                'Pagamento Instantâneo (PIX)' => '17',
                'Transferência bancária, Carteira Digital' => '18',
                'Programa de fidelidade, Cashback, Crédito Virtual' => '19',
                'Sem pagamento' => '90',
                'Outros' => '99',
            ]);

            test('Should fail if a non numeric value is provided', function () {
                $candidate = 'iaValue';
                $xmlString = "<tPag>{$candidate}</tPag>";
                $xmlElement = new Element;
                $xmlElement->parse($xmlString);
                $targetClass = new MeioDePagamento('parentTag');
                $sut = new ReflectionMethod($targetClass, 'validateTagValue');
                $sutResponse = $sut->invoke($targetClass, $xmlElement);
                expect($sutResponse->isFailure())->toBeTrue();
            });
        });
    });
});
