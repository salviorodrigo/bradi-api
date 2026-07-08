<?php

declare(strict_types=1);

use BradiNfeApi\Domain\Common\Protocols\ApiError;
use BradiNfeApi\Domain\Common\ValueObjects\Result;
use BradiNfeApi\Domain\Invoices\NFe\v4_00\Icms;
use BradiNfeApi\Domain\Xml\ValueObjects\Element;
use BradiNfeApi\Tests\Doubles\Domain\Common\FakeValidationService;
use BradiNfeApi\Tests\TestCase;

describe('Icms', function () {

    beforeEach(function () {
        /** @var TestCase $this */
        $this->sut = new Icms;
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
            expect($sutResponse->getData())->toBeInstanceOf(Icms::class);
            expect($sutResponse->getData()->value)->toBe('');
            expect((string) $sutResponse->getData())->toBe($candidate);
        })->with(datasets('dfes.nfe.element_tags.' . Icms::FIELD_NAME . '.valid'));

        test('Should fail with dataset :dataset', function ($candidate) {
            $xmlElement = new Element(new FakeValidationService);
            $xmlElement->parse($candidate);
            $sutResponse = $this->sut->parseFromXmlElement($xmlElement);
            expect($sutResponse)->toBeInstanceOf(Result::class);
            if ($sutResponse->isSuccess()) {
                $this->fail(json_encode($sutResponse->getData()));
            }
            expect($sutResponse->getError())->toBeInstanceOf(ApiError::class);
        })->with(datasets('dfes.nfe.element_tags.' . Icms::FIELD_NAME . '.invalid'));
    });
});
