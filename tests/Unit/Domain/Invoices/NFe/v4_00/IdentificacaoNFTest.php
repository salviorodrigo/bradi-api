<?php

declare(strict_types=1);

use BradiApi\Domain\Common\Protocols\ApiError;
use BradiApi\Domain\Common\ValueObjects\Result;
use BradiApi\Domain\Invoices\NFe\v4_00\IdentificacaoNF;
use BradiApi\Domain\Xml\ValueObjects\Element;
use BradiApi\Tests\Doubles\Domain\Common\FakeValidationService;
use BradiApi\Tests\TestCase;

describe('IdentificacaoNF', function () {

    beforeEach(function () {
        /** @var TestCase $this */
        $this->sut = new IdentificacaoNF;
    });

    describe('::parse()', function () {
        test('Should succeed with dataset :dataset', function ($candidate) {
            $xmlElement = new Element(new FakeValidationService);
            $xmlElement->parse($candidate);
            $sutResponse = $this->sut->parseFromXmlElement($xmlElement);
            expect($sutResponse)->toBeInstanceOf(Result::class);
            if ($sutResponse->isFailure()) {
                $this->fail(json_encode($sutResponse->getError()));
            }
            expect($sutResponse->getData())->toBeInstanceOf(IdentificacaoNF::class);
            expect($sutResponse->getData()->value)->toBe('');
            expect((string) $sutResponse->getData())->toBe($candidate);
        })->with(datasets('dfes.nfe.element_tags.' . IdentificacaoNF::FIELD_NAME . '.valid'));

        test('Should fail with dataset :dataset', function ($candidate) {
            $xmlElement = new Element(new FakeValidationService);
            $xmlElement->parse($candidate);
            $sutResponse = $this->sut->parseFromXmlElement($xmlElement);
            expect($sutResponse)->toBeInstanceOf(Result::class);
            if ($sutResponse->isSuccess()) {
                $this->fail(json_encode($sutResponse->getData()));
            }
            expect($sutResponse)->toBeInstanceOf(Result::class);
            expect($sutResponse->getError())->toBeInstanceOf(ApiError::class);
        })->with(datasets('dfes.nfe.element_tags.' . IdentificacaoNF::FIELD_NAME . '.invalid'));
    });
});
