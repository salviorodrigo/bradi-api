<?php

declare(strict_types=1);

use BradiApi\Domain\Common\Protocols\ApiError;
use BradiApi\Domain\Common\ValueObjects\Result;
use BradiApi\Domain\Invoices\Templates\DFeElementCollection;
use BradiApi\Domain\Xml\ValueObjects\Element;
use BradiApi\Domain\Xml\ValueObjects\ElementList;
use BradiApi\Tests\Doubles\Domain\Common\FakeValidationService;
use BradiApi\Tests\Doubles\Domain\Invoices\NFe\FakeDFeElement;
use BradiApi\Tests\Doubles\Domain\Invoices\NFe\FakeDFeElementCollection;
use BradiApi\Tests\TestCase;

describe('DFeElementCollection', function () {
    beforeEach(function () {
        /** @var TestCase $this */
        $this->sut = new FakeDFeElementCollection('infNFe');
    });

    describe('::parseFromXmlElement()', function () {
        test('Should succeed parsing single Element', function () {
            $candidate = '<FakeTag>first</FakeTag>';
            $element = new Element(new FakeValidationService);
            $parsingResult = $element->parse($candidate);
            if ($parsingResult->isFailure()) {
                $this->fail(json_encode($parsingResult->getError()));
            }

            $parsingResponse = $this->sut->parseFromXmlElement($parsingResult->getData());
            expect($parsingResponse)->toBeInstanceOf(Result::class);
            if ($parsingResponse->isFailure()) {
                $this->fail(json_encode($parsingResponse->getError()));
            }

            expect($this->sut)->toBeInstanceOf(FakeDFeElementCollection::class);
            expect(count($this->sut->collection))->toBe(1);
            expect($this->sut->collection[0])->toBeInstanceOf(FakeDFeElement::class);
            expect($this->sut->collection[0]->value)->toBe('first');
        });

        test('Should succeed parsing ElementList with many elements', function () {
            $firstElement = new Element(new FakeValidationService);
            $firstElement->name = 'FakeTag';
            $firstElement->value = 'first';

            $secondElement = new Element(new FakeValidationService);
            $secondElement->name = 'FakeTag';
            $secondElement->value = 'second';

            $parsingResponse = $this->sut->parseFromXmlElement(new ElementList([$firstElement, $secondElement]));
            expect($parsingResponse)->toBeInstanceOf(Result::class);
            if ($parsingResponse->isFailure()) {
                $this->fail(json_encode($parsingResponse->getError()));
            }

            expect($this->sut)->toBeInstanceOf(FakeDFeElementCollection::class);
            expect(count($this->sut->collection))->toBe(2);
            expect($this->sut->collection[0]->value)->toBe('first');
            expect($this->sut->collection[1]->value)->toBe('second');
        });

        test('Should fail when one parsed element is invalid', function () {
            $candidate = '<root><FakeTag>first</FakeTag><WrongTag>second</WrongTag></root>';
            $element = new Element(new FakeValidationService);

            $parsingResult = $element->parse($candidate);
            if ($parsingResult->isFailure()) {
                $this->fail(json_encode($parsingResult->getError()));
            }

            $elements = $parsingResult->getData()->children->records;
            $parsingResponse = $this->sut->parseFromXmlElement(new ElementList($elements));
            expect($parsingResponse)->toBeInstanceOf(Result::class);
            if ($parsingResponse->isSuccess()) {
                $this->fail(json_encode($parsingResponse->getData()));
            }

            expect($parsingResponse->getError())->toBeInstanceOf(ApiError::class);
        });

        test('Should succeed with empty ElementList', function () {
            $parsingResponse = $this->sut->parseFromXmlElement(new ElementList);
            expect($parsingResponse)->toBeInstanceOf(Result::class);
            if ($parsingResponse->isFailure()) {
                $this->fail(json_encode($parsingResponse->getError()));
            }
            expect(count($this->sut->collection))->toBe(0);
        });

        test('Should throw when BASE_CLASS constant is not defined in child class', function () {
            $candidate = '<FakeTag>first</FakeTag>';
            $element = new Element(new FakeValidationService);
            $parsingResult = $element->parse($candidate);
            if ($parsingResult->isFailure()) {
                $this->fail(json_encode($parsingResult->getError()));
            }

            $sut = new class extends DFeElementCollection
            {
                public const string BASE_CLASS = '';
            };

            expect(fn () => $sut->parseFromXmlElement($parsingResult->getData()))
                ->toThrow(Exception::class, 'BASE_CLASS constant must be defined in the child class.');
        });

        test('Should throw when BASE_CLASS is not a subclass of DFeElement', function () {
            $candidate = '<FakeTag>first</FakeTag>';
            $element = new Element(new FakeValidationService);

            $parsingResult = $element->parse($candidate);
            if ($parsingResult->isFailure()) {
                $this->fail(json_encode($parsingResult->getError()));
            }

            $sut = new class extends DFeElementCollection
            {
                public const string BASE_CLASS = stdClass::class;
            };

            expect(fn () => $sut->parseFromXmlElement($parsingResult->getData()))
                ->toThrow(Exception::class, 'BASE_CLASS must be a subclass of DFeElement.');
        });
    });
});
