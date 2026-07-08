<?php

declare(strict_types=1);

use BradiNfeApi\Domain\Common\Protocols\ApiError;
use BradiNfeApi\Domain\Common\ValueObjects\Result;
use BradiNfeApi\Domain\Invoices\NFe\v4_00\ValueObjects\CodigoSituacaoTributaria;
use BradiNfeApi\Domain\Xml\ValueObjects\Element;
use BradiNfeApi\Tests\Doubles\Domain\Common\FakeValidationService;
use BradiNfeApi\Tests\TestCase;

describe('CodigoSituacaoTributaria', function () {

    beforeEach(function () {
        /** @var TestCase $this */
        $this->sut = new CodigoSituacaoTributaria('');
    });

    describe('::parse()', function () {
        test('Should succeed with dataset :dataset', function ($candidate) {
            $xmlString = $candidate === '' ? '' : '<' . CodigoSituacaoTributaria::FIELD_NAME . ">{$candidate}</" . CodigoSituacaoTributaria::FIELD_NAME . '>';
            $xmlElement = new Element(new FakeValidationService);
            $xmlElement->parse($xmlString);
            $sutResponse = $this->sut->parseFromXmlElement($xmlElement);
            expect($sutResponse)->toBeInstanceOf(Result::class);
            if ($sutResponse->isFailure()) {
                $this->fail(json_encode($sutResponse->getError()));
            }
            expect($sutResponse->getData())->toBeInstanceOf(CodigoSituacaoTributaria::class);
            expect($sutResponse->getData()->value)->toBe($candidate);
            expect((string) $sutResponse->getData())->toBe($xmlString);
        })->with(datasets('dfes.nfe.value_tags.' . CodigoSituacaoTributaria::FIELD_NAME . '.valid'));

        test('Should fail with data set :dataset', function ($candidate) {
            $xmlString = '<' . CodigoSituacaoTributaria::FIELD_NAME . ">{$candidate}</" . CodigoSituacaoTributaria::FIELD_NAME . '>';
            $xmlElement = new Element(new FakeValidationService);
            $xmlElement->parse($xmlString);
            $sutResponse = $this->sut->parseFromXmlElement($xmlElement);
            if ($sutResponse->isSuccess()) {
                $this->fail(json_encode($sutResponse->getData()));
            }
            expect($sutResponse)->toBeInstanceOf(Result::class);
            expect($sutResponse->getError())->toBeInstanceOf(ApiError::class);
        })->with(datasets('dfes.nfe.value_tags.' . CodigoSituacaoTributaria::FIELD_NAME . '.invalid'));

        test('Should fail if attributes is provided', function ($candidate) {
            $xmlString = '<' . CodigoSituacaoTributaria::FIELD_NAME . " fake=\"attribute\">{$candidate}</" . CodigoSituacaoTributaria::FIELD_NAME . '>';
            $xmlElement = new Element(new FakeValidationService);
            $xmlElement->parse($xmlString);
            $sutResponse = $this->sut->parseFromXmlElement($xmlElement);
            expect($sutResponse)->toBeInstanceOf(Result::class);
            if ($sutResponse->isSuccess()) {
                $this->fail(json_encode($sutResponse->getData()));
            }
            expect($sutResponse->getError())->toBeInstanceOf(ApiError::class);
        })->with(datasets('dfes.nfe.value_tags.' . CodigoSituacaoTributaria::FIELD_NAME . '.valid'));

        test('Should fail if elements is provided', function ($candidate) {
            $xmlString = '<' . CodigoSituacaoTributaria::FIELD_NAME . ">{$candidate}<fake>element</fake></" . CodigoSituacaoTributaria::FIELD_NAME . '>';
            $xmlElement = new Element(new FakeValidationService);
            $xmlElement->parse($xmlString);
            $sutResponse = $this->sut->parseFromXmlElement($xmlElement);
            expect($sutResponse)->toBeInstanceOf(Result::class);
            if ($sutResponse->isSuccess()) {
                $this->fail(json_encode($sutResponse->getData()));
            }
            expect($sutResponse->getError())->toBeInstanceOf(ApiError::class);
        })->with(datasets('dfes.nfe.value_tags.' . CodigoSituacaoTributaria::FIELD_NAME . '.valid'));
    });
});
