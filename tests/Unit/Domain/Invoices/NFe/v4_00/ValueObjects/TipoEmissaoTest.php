<?php

declare(strict_types=1);

use BradiNfeApi\Domain\Common\Protocols\ApiError;
use BradiNfeApi\Domain\Common\ValueObjects\Result;
use BradiNfeApi\Domain\Invoices\NFe\v4_00\ValueObjects\TipoEmissao;
use BradiNfeApi\Domain\Xml\ValueObjects\Element;
use BradiNfeApi\Tests\Doubles\Domain\Common\FakeValidationService;
use BradiNfeApi\Tests\TestCase;

describe('TipoEmissao', function () {

    beforeEach(function () {
        /** @var TestCase $this */
        $this->sut = new TipoEmissao('');
    });

    describe('::parse()', function () {
        test('Should succeed with dataset :dataset', function ($candidate) {
            $xmlString = $candidate === '' ? '' : '<' . TipoEmissao::FIELD_NAME . ">{$candidate}</" . TipoEmissao::FIELD_NAME . '>';
            $xmlElement = new Element(new FakeValidationService);
            $xmlElement->parse($xmlString);
            $sutResponse = $this->sut->parseFromXmlElement($xmlElement);
            expect($sutResponse)->toBeInstanceOf(Result::class);
            if ($sutResponse->isFailure()) {
                $this->fail(json_encode($sutResponse->getError()));
            }
            expect($sutResponse->getData())->toBeInstanceOf(TipoEmissao::class);
            expect($sutResponse->getData()->value)->toBe($candidate);
            expect((string) $sutResponse->getData())->toBe($xmlString);
        })->with(datasets('dfes.nfe.value_tags.' . TipoEmissao::FIELD_NAME . '.valid'));

        test('Should fail with data set :dataset', function ($candidate) {
            $xmlString = '<' . TipoEmissao::FIELD_NAME . ">{$candidate}</" . TipoEmissao::FIELD_NAME . '>';
            $xmlElement = new Element(new FakeValidationService);
            $xmlElement->parse($xmlString);
            $sutResponse = $this->sut->parseFromXmlElement($xmlElement);
            if ($sutResponse->isSuccess()) {
                $this->fail(json_encode($sutResponse->getData()));
            }
            expect($sutResponse)->toBeInstanceOf(Result::class);
            expect($sutResponse->getError())->toBeInstanceOf(ApiError::class);
        })->with(datasets('dfes.nfe.value_tags.' . TipoEmissao::FIELD_NAME . '.invalid'));

        test('Should fail if attributes is provided', function ($candidate) {
            $xmlString = '<' . TipoEmissao::FIELD_NAME . " fake=\"attribute\">{$candidate}</" . TipoEmissao::FIELD_NAME . '>';
            $xmlElement = new Element(new FakeValidationService);
            $xmlElement->parse($xmlString);
            $sutResponse = $this->sut->parseFromXmlElement($xmlElement);
            expect($sutResponse)->toBeInstanceOf(Result::class);
            if ($sutResponse->isSuccess()) {
                $this->fail(json_encode($sutResponse->getData()));
            }
            expect($sutResponse->getError())->toBeInstanceOf(ApiError::class);
        })->with(datasets('dfes.nfe.value_tags.' . TipoEmissao::FIELD_NAME . '.valid'));

        test('Should fail if elements is provided', function ($candidate) {
            $xmlString = '<' . TipoEmissao::FIELD_NAME . ">{$candidate}<fake>element</fake></" . TipoEmissao::FIELD_NAME . '>';
            $xmlElement = new Element(new FakeValidationService);
            $xmlElement->parse($xmlString);
            $sutResponse = $this->sut->parseFromXmlElement($xmlElement);
            expect($sutResponse)->toBeInstanceOf(Result::class);
            if ($sutResponse->isSuccess()) {
                $this->fail(json_encode($sutResponse->getData()));
            }
            expect($sutResponse->getError())->toBeInstanceOf(ApiError::class);
        })->with(datasets('dfes.nfe.value_tags.' . TipoEmissao::FIELD_NAME . '.valid'));
    });
});
