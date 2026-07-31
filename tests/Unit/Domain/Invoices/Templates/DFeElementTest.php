<?php

declare(strict_types=1);

use BradiApi\Domain\Common\Protocols\Validator;
use BradiApi\Domain\Common\ValueObjects\Result;
use BradiApi\Domain\Invoices\Templates\DFeElement;
use BradiApi\Domain\Xml\ValueObjects\Element;
use BradiApi\Tests\Doubles\Domain\Invoices\NFe\FakeDFeAttribute;
use BradiApi\Tests\Doubles\Domain\Invoices\NFe\FakeDFeElement;
use BradiApi\Tests\Doubles\Domain\Invoices\NFe\FakeDFeGroupWithAttribute;
use BradiApi\Tests\TestCase;

// Todo: Test if all properties of DFeElement child have a set method that ensure sourceElement is updated with new data
// Todo: Ensure that DFeElements erase or create child data of sourceElement when property is optional
// Todo: Ensure that root xml string is updated when a child DFeAttribute value is updated

describe('DFeElement', function () {
    beforeEach(function () {
        /** @var TestCase $this */
        $this->sut = new FakeDFeElement;
    });

    describe('properties', function () {
        test('Should have the correct field name', function () {
            expect(FakeDFeElement::FIELD_NAME)->toBe('FakeTag');
        });

        test('Should build field URI from field name when no parent is provided', function () {
            expect($this->sut->fieldURI)->toBe('FakeTag');
        });

        test('Should build field URI by prefixing the parent field URI', function () {
            $sut = new FakeDFeElement('parentTag');
            expect($sut->fieldURI)->toBe('parentTag.FakeTag');
        });
    });

    describe('methods', function () {
        describe('construct()', function () {
            test('Should not throw when parent field URI is empty', function () {
                expect(fn () => new FakeDFeElement(''))
                    ->not->toThrow(RuntimeException::class);
            });

            test('Should throw when FIELD_NAME is not defined in the child class', function () {
                expect(fn () => new class extends DFeElement
                {
                    /** @return array<Validator> */
                    protected function tagValueValidators(): array
                    {
                        return [];
                    }

                    /** @return array<Validator> */
                    protected function tagAttributesValidators(): array
                    {
                        return [];
                    }

                    /** @return array<Validator> */
                    protected function tagElementsValidators(): array
                    {
                        return [];
                    }
                })->toThrow(RuntimeException::class);
            });
        });

        describe('parseFromXmlElement()', function () {
            test('Should set value property correctly', function () {
                $element = new Element;
                $element->parse('<FakeTag>hello</FakeTag>');

                $this->sut->parseFromXmlElement($element);

                expect($this->sut->value)->toBe('hello');
            });

            test('Should return a successful Result holding itself', function () {
                $element = new Element;
                $element->parse('<FakeTag>hello</FakeTag>');

                $parsingResponse = $this->sut->parseFromXmlElement($element);

                expect($parsingResponse)->toBeInstanceOf(Result::class);
                expect($parsingResponse->isSuccess())->toBeTrue();
                expect($parsingResponse->getData())->toBe($this->sut);
            });

            test('Should return a failure Result when the root tag does not match', function () {
                $element = new Element;
                $element->parse('<WrongTag>hello</WrongTag>');

                $parsingResponse = $this->sut->parseFromXmlElement($element);

                expect($parsingResponse)->toBeInstanceOf(Result::class);
                expect($parsingResponse->isFailure())->toBeTrue();
            });

            test('Should hydrate child element and attribute of a group', function () {
                $element = new Element;
                $element->parse('<FakeGroup fakeAttr="ABC123"><FakeTag>childValue</FakeTag></FakeGroup>');

                $sut = new FakeDFeGroupWithAttribute;
                $parsingResponse = $sut->parseFromXmlElement($element);

                expect($parsingResponse->isSuccess())->toBeTrue();
                expect($sut->fakeAttr->value)->toBe('ABC123');
                expect($sut->fakeChild->value)->toBe('childValue');
            });
        });

        describe('__toString()', function () {
            test('Should serialize xml string from cache when already set', function () {
                $this->sut->value = 'hello';

                expect((string) $this->sut)->toBe('<FakeTag>hello</FakeTag>');
            });

            test('Should return updated xml string after changing value directly DFeElement', function () {
                $element = new Element;
                $element->parse('<FakeTag>hello</FakeTag>');

                $this->sut->parseFromXmlElement($element);
                $this->sut->value = 'updated';

                expect((string) $this->sut)->toBe('<FakeTag>updated</FakeTag>');
            });

            test('Should return updated parent xml string after changing value of child DFeElement', function () {
                $element = new Element;
                $element->parse('<FakeTag><FakeTag>hello</FakeTag></FakeTag>');

                $this->sut->parseFromXmlElement($element);
                $this->sut->childElement->value = 'updated';

                expect((string) $this->sut)->toBe('<FakeTag><FakeTag>updated</FakeTag></FakeTag>');
            })->only();

            test('Should serialize group with child DFeElement', function () {
                $child = new FakeDFeElement;
                $child->value = 'childValue';

                $sut = new FakeDFeGroupWithAttribute;
                $sut->fakeAttr = new FakeDFeAttribute('FakeDFeGroupWithAttribute');
                $sut->fakeAttr->value = 'attrValue';
                $sut->fakeChild = $child;

                expect((string) $sut)->toBe('<FakeGroup fakeAttr="attrValue"><FakeTag>childValue</FakeTag></FakeGroup>');
            });

            test('Should include attribute in opening tag', function () {
                $attr = new FakeDFeAttribute('FakeDFeGroupWithAttribute');
                $attr->value = 'ABC123';

                $child = new FakeDFeElement('x');

                $sut = new FakeDFeGroupWithAttribute;
                $sut->fakeAttr = $attr;
                $sut->fakeChild = $child;

                $result = (string) $sut;

                expect($result)->toStartWith('<FakeGroup fakeAttr="ABC123">');
            });

            test('Should skip optional child when not initialized', function () {
                $attr = new FakeDFeAttribute('FakeDFeGroupWithAttribute');
                $attr->value = 'attrValue';

                $child = new FakeDFeElement;
                $child->value = 'childValue';

                $sut = new FakeDFeGroupWithAttribute;
                $sut->fakeAttr = $attr;
                $sut->fakeChild = $child;
                // fakeOptionalChild is intentionally not initialized

                $result = (string) $sut;

                expect($result)->toBe('<FakeGroup fakeAttr="attrValue"><FakeTag>childValue</FakeTag></FakeGroup>');
            });

            test('Should skip optional child when null', function () {
                $attr = new FakeDFeAttribute('FakeDFeGroupWithAttribute');
                $attr->value = 'attrValue';

                $child = new FakeDFeElement;
                $child->value = 'childValue';

                $sut = new FakeDFeGroupWithAttribute;
                $sut->fakeAttr = $attr;
                $sut->fakeChild = $child;
                $sut->fakeOptionalChild = null;

                $result = (string) $sut;

                expect($result)->toBe('<FakeGroup fakeAttr="attrValue"><FakeTag>childValue</FakeTag></FakeGroup>');
            });

            test('Should throw RuntimeException when required DFeElement property is not initialized', function () {
                $sut = new FakeDFeGroupWithAttribute;
                $sut->fakeAttr = new FakeDFeAttribute('FakeDFeGroupWithAttribute');
                $sut->fakeAttr->value = 'attrValue';
                // fakeChild intentionally not initialized

                expect(fn () => (string) $sut)->toThrow(RuntimeException::class);
            });

            test('Should throw RuntimeException when required DFeAttribute property is not initialized', function () {
                $sut = new FakeDFeGroupWithAttribute;
                // fakeAttr intentionally not initialized

                expect(fn () => (string) $sut)->toThrow(RuntimeException::class);
            });
        });
    });
});
