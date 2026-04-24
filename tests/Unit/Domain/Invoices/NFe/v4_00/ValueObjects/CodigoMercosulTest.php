<?php

declare(strict_types=1);

use BradiNfeApi\Domain\Common\Protocols\ApiError;
use BradiNfeApi\Domain\Common\ValueObjects\Result;
use BradiNfeApi\Domain\Invoices\NFe\v4_00\ValueObjects\CodigoMercosul;
use BradiNfeApi\Tests\TestCase;

describe('CodigoMercosul', function () {

    beforeEach(function () {
        /** @var TestCase $this */
        $this->sut = new CodigoMercosul('');
    });

    describe('::parse()', function () {
        test('Should succeed with dataset :dataset', function ($candidate) {
            $xmlString = $candidate === '' ? '' : '<' . CodigoMercosul::TAG_NAME . ">{$candidate}</" . CodigoMercosul::TAG_NAME . '>';
            $sutResponse = $this->sut->parseFromXmlElement(xml_to_element($xmlString));
            expect($sutResponse)->toBeInstanceOf(Result::class);
            if ($sutResponse->isFailure()) {
                $this->fail(json_encode($sutResponse->getError()));
            }
            expect($sutResponse->getData())->toBeInstanceOf(CodigoMercosul::class);
            expect($sutResponse->getData()->value)->toBe($candidate);
            expect((string) $sutResponse->getData())->toBe($xmlString);
        })->with(datasets('dfes.nfe.value_tags.' . CodigoMercosul::TAG_NAME . '.valid'));

        test('Should fail with data set :dataset', function ($candidate) {
            $xmlString = '<' . CodigoMercosul::TAG_NAME . ">{$candidate}</" . CodigoMercosul::TAG_NAME . '>';
            $sutResponse = $this->sut->parseFromXmlElement(xml_to_element($xmlString));
            if ($sutResponse->isSuccess()) {
                $this->fail(json_encode($sutResponse->getData()));
            }
            expect($sutResponse)->toBeInstanceOf(Result::class);
            expect($sutResponse->getError())->toBeInstanceOf(ApiError::class);
        })->with(datasets('dfes.nfe.value_tags.' . CodigoMercosul::TAG_NAME . '.invalid'));

        test('Should fail if attributes is provided', function ($candidate) {
            $xmlString = '<' . CodigoMercosul::TAG_NAME . " fake=\"attribute\">{$candidate}</" . CodigoMercosul::TAG_NAME . '>';
            $sutResponse = $this->sut->parseFromXmlElement(xml_to_element($xmlString));
            expect($sutResponse)->toBeInstanceOf(Result::class);
            if ($sutResponse->isSuccess()) {
                $this->fail(json_encode($sutResponse->getData()));
            }
            expect($sutResponse->getError())->toBeInstanceOf(ApiError::class);
        })->with(datasets('dfes.nfe.value_tags.' . CodigoMercosul::TAG_NAME . '.valid'));

        test('Should fail if elements is provided', function ($candidate) {
            $xmlString = '<' . CodigoMercosul::TAG_NAME . ">{$candidate}<fake>element</fake></" . CodigoMercosul::TAG_NAME . '>';
            $sutResponse = $this->sut->parseFromXmlElement(xml_to_element($xmlString));
            expect($sutResponse)->toBeInstanceOf(Result::class);
            if ($sutResponse->isSuccess()) {
                $this->fail(json_encode($sutResponse->getData()));
            }
            expect($sutResponse->getError())->toBeInstanceOf(ApiError::class);
        })->with(datasets('dfes.nfe.value_tags.' . CodigoMercosul::TAG_NAME . '.valid'));
    });
});
