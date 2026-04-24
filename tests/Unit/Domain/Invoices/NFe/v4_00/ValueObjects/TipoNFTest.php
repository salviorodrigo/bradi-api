<?php

declare(strict_types=1);

use BradiNfeApi\Domain\Common\Protocols\ApiError;
use BradiNfeApi\Domain\Common\ValueObjects\Result;
use BradiNfeApi\Domain\Invoices\NFe\v4_00\ValueObjects\TipoNF;
use BradiNfeApi\Tests\TestCase;

describe('TipoNF', function () {

    beforeEach(function () {
        /** @var TestCase $this */
        $this->sut = new TipoNF('');
    });

    describe('::parse()', function () {
        test('Should succeed with dataset :dataset', function ($candidate) {
            $xmlString = $candidate === '' ? '' : '<' . TipoNF::TAG_NAME . ">{$candidate}</" . TipoNF::TAG_NAME . '>';
            $sutResponse = $this->sut->parseFromXmlElement(xml_to_element($xmlString));
            expect($sutResponse)->toBeInstanceOf(Result::class);
            if ($sutResponse->isFailure()) {
                $this->fail(json_encode($sutResponse->getError()));
            }
            expect($sutResponse->getData())->toBeInstanceOf(TipoNF::class);
            expect($sutResponse->getData()->value)->toBe($candidate);
            expect((string) $sutResponse->getData())->toBe($xmlString);
        })->with(datasets('dfes.nfe.value_tags.' . TipoNF::TAG_NAME . '.valid'));

        test('Should fail with data set :dataset', function ($candidate) {
            $xmlString = '<' . TipoNF::TAG_NAME . ">{$candidate}</" . TipoNF::TAG_NAME . '>';
            $sutResponse = $this->sut->parseFromXmlElement(xml_to_element($xmlString));
            if ($sutResponse->isSuccess()) {
                $this->fail(json_encode($sutResponse->getData()));
            }
            expect($sutResponse)->toBeInstanceOf(Result::class);
            expect($sutResponse->getError())->toBeInstanceOf(ApiError::class);
        })->with(datasets('dfes.nfe.value_tags.' . TipoNF::TAG_NAME . '.invalid'));

        test('Should fail if attributes is provided', function ($candidate) {
            $xmlString = '<' . TipoNF::TAG_NAME . " fake=\"attribute\">{$candidate}</" . TipoNF::TAG_NAME . '>';
            $sutResponse = $this->sut->parseFromXmlElement(xml_to_element($xmlString));
            expect($sutResponse)->toBeInstanceOf(Result::class);
            if ($sutResponse->isSuccess()) {
                $this->fail(json_encode($sutResponse->getData()));
            }
            expect($sutResponse->getError())->toBeInstanceOf(ApiError::class);
        })->with(datasets('dfes.nfe.value_tags.' . TipoNF::TAG_NAME . '.valid'));

        test('Should fail if elements is provided', function ($candidate) {
            $xmlString = '<' . TipoNF::TAG_NAME . ">{$candidate}<fake>element</fake></" . TipoNF::TAG_NAME . '>';
            $sutResponse = $this->sut->parseFromXmlElement(xml_to_element($xmlString));
            expect($sutResponse)->toBeInstanceOf(Result::class);
            if ($sutResponse->isSuccess()) {
                $this->fail(json_encode($sutResponse->getData()));
            }
            expect($sutResponse->getError())->toBeInstanceOf(ApiError::class);
        })->with(datasets('dfes.nfe.value_tags.' . TipoNF::TAG_NAME . '.valid'));
    });
});
