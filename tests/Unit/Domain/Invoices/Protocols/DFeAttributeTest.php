<?php

declare(strict_types=1);

use BradiNfeApi\Domain\Common\Protocols\ApiError;
use BradiNfeApi\Domain\Common\ValueObjects\Result;
use BradiNfeApi\Domain\Xml\ValueObjects\Element;
use BradiNfeApi\Infra\Parses\XmlStringIterator;
use BradiNfeApi\Tests\Doubles\Domain\Common\FakeValidationService;
use BradiNfeApi\Tests\Doubles\Domain\Invoices\NFe\FakeDFeAttribute;
use BradiNfeApi\Tests\TestCase;

describe('DFeAttribute', function () {
    beforeEach(function () {
        /** @var TestCase $this */
        $this->sut = new FakeDFeAttribute('infNFe');
    });

    describe('::parseFromXmlElement()', function () {
        test('Should succeed extracting value from xml tag attribute', function () {
            $candidate = '<infNFe fakeAttr="ABC123" versao="4.00"></infNFe>';
            $validationService = new FakeValidationService();
            $xmlIterator = new XmlStringIterator($validationService);
            $element = new Element($xmlIterator, $validationService);
            $parsingResult = $element->parse($candidate);
            if ($parsingResult->isFailure()) {
                $this->fail(json_encode($parsingResult->getError()));
            }

            $sutResponse = $this->sut->parseFromXmlElement($parsingResult->getData());

            expect($sutResponse)->toBeInstanceOf(Result::class);
            if ($sutResponse->isFailure()) {
                $this->fail(json_encode($sutResponse->getError()));
            }

            expect($sutResponse->getData())->toBeInstanceOf(FakeDFeAttribute::class);
            expect($sutResponse->getData()->value)->toBe('ABC123');
            expect((string) $sutResponse->getData())->toBe('fakeAttr="ABC123"');
        });

        test('Should fail when parent tag does not match', function () {
            $candidate = '<other fakeAttr="ABC123"></other>';
            $validationService = new FakeValidationService();
            $xmlIterator = new XmlStringIterator($validationService);
            $element = new Element($xmlIterator, $validationService);
            $parsingResult = $element->parse($candidate);   
            if ($parsingResult->isFailure()) {
                $this->fail(json_encode($parsingResult->getError()));
            }
            $sutResponse = $this->sut->parseFromXmlElement($parsingResult->getData());

            expect($sutResponse)->toBeInstanceOf(Result::class);
            if ($sutResponse->isSuccess()) {
                $this->fail(json_encode($sutResponse->getData()));
            }

            expect($sutResponse->getError())->toBeInstanceOf(ApiError::class);
        });
    });

    describe('::__toString()', function () {
        test('Should throw if attribute value was not initialized', function () {
            expect(fn () => (string) new FakeDFeAttribute('infNFe'))
                ->toThrow(RuntimeException::class);
        });
    });
});
