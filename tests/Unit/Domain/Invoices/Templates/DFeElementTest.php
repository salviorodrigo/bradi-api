<?php

declare(strict_types=1);

use BradiApi\Domain\Common\ValueObjects\Result;
use BradiApi\Domain\Invoices\Templates\DFeElement;
use BradiApi\Domain\Xml\ValueObjects\Element;
use BradiApi\Tests\Doubles\Domain\Invoices\NFe\FakeDFeAttribute;
use BradiApi\Tests\Doubles\Domain\Invoices\NFe\FakeDFeElement;
use BradiApi\Tests\Doubles\Domain\Invoices\NFe\FakeDFeElementWithEmptyFieldName;
use BradiApi\Tests\Doubles\Domain\Invoices\NFe\FakeDFeElementWithoutFieldName;
use BradiApi\Tests\Doubles\Domain\Invoices\NFe\FakeDFeGroupWithAttribute;
use BradiApi\Tests\TestCase;

describe('DFeElement', function () {
    beforeEach(function () {
        /** @var TestCase $this */
        $this->sut = new FakeDFeElement;
    });

    test('Should succeed if is declared', function () {
        $nameSpace = 'BradiApi\Domain\Invoices\Templates';
        $sut = $nameSpace . '\\DFeElement';
        expect(class_exists($sut))->toBeTrue();
    });

    test('Should be declared as abstract', function () {
        $sut = new ReflectionClass(DFeElement::class);
        expect($sut->isAbstract())->toBeTrue();
    });

    describe('properties', function () {
        describe('FIELD_NAME', function () {
            test('Should have the correct field name', function () {
                expect(FakeDFeElement::FIELD_NAME)->toBe('FakeTag');
            });
        });

        describe('$fieldURI', function () {
            test('Should build field URI from field name when no parent is provided', function () {
                expect($this->sut->fieldURI)->toBe('FakeTag');
            });

            test('Should build field URI by prefixing the parent field URI', function () {
                $sut = new FakeDFeElement('parentTag');
                expect($sut->fieldURI)->toBe('parentTag.FakeTag');
            });

            test('Should be a readonly string', function () {
                $reflection = new ReflectionClass(DFeElement::class);
                $sut = $reflection->getProperty('fieldURI');
                expect($sut->getType()->getName())->toBe('string');
                expect($sut->isReadOnly())->toBeTrue();
            });
        });

        describe('$value', function () {
            test('Should be declared', function () {
                expect($this->sut)->toHaveProperty('value');
            });

            test('Should be a nullable string', function () {
                $reflection = new ReflectionClass(DFeElement::class);
                $sut = $reflection->getProperty('value')->getType();
                expect($sut->getName())->toBe('string');
                expect($sut->allowsNull())->toBeTrue();
            });

            test('Should propagate the assigned value to the parsed source element', function () {
                $element = new Element;
                $element->parse('<FakeTag>hello</FakeTag>');
                $this->sut->parse($element);

                $this->sut->value = 'changed';

                expect($this->sut->getSource()->value)->toBe('changed');
                expect($element->value)->toBe('changed');
            });
        });
    });

    describe('methods', function () {
        describe('__construct()', function () {
            test('Should not throw when parent field URI is empty', function () {
                expect(fn () => new FakeDFeElement(''))
                    ->not->toThrow(Error::class);
            });

            // Sao dois caminhos distintos: com FIELD_NAME herdando null, a atribuicao de
            // $fieldURI estoura antes do guard clause, que so e alcancado com FIELD_NAME = ''.
            test('Should throw a TypeError when FIELD_NAME is not defined', function () {
                expect(fn () => new FakeDFeElementWithoutFieldName)
                    ->toThrow(TypeError::class, 'Cannot assign null to property');
            });

            test('Should throw a RuntimeException when FIELD_NAME is empty', function () {
                expect(fn () => new FakeDFeElementWithEmptyFieldName)
                    ->toThrow(RuntimeException::class, 'must define a constant "FIELD_NAME"');
            });
        });

        describe('parse()', function () {
            test('Should set value property correctly', function () {
                $element = new Element;
                $element->parse('<FakeTag>hello</FakeTag>');

                $this->sut->parse($element);

                expect($this->sut->value)->toBe('hello');
            });

            test('Should return a successful Result holding itself', function () {
                $element = new Element;
                $element->parse('<FakeTag>hello</FakeTag>');

                $parsingResponse = $this->sut->parse($element);

                expect($parsingResponse)->toBeInstanceOf(Result::class);
                expect($parsingResponse->isSuccess())->toBeTrue();
                expect($parsingResponse->getData())->toBe($this->sut);
            });

            test('Should return a failure Result when the root tag does not match', function () {
                $element = new Element;
                $element->parse('<WrongTag>hello</WrongTag>');

                $parsingResponse = $this->sut->parse($element);

                expect($parsingResponse)->toBeInstanceOf(Result::class);
                expect($parsingResponse->isFailure())->toBeTrue();
            });

            test('Should hydrate child element and attribute of a group', function () {
                $element = new Element;
                $element->parse('<FakeGroup fakeAttr="ABC123"><FakeTag>childValue</FakeTag></FakeGroup>');

                $sut = new FakeDFeGroupWithAttribute;
                $parsingResponse = $sut->parse($element);

                expect($parsingResponse->isSuccess())->toBeTrue();
                expect($sut->fakeAttr->value)->toBe('ABC123');
                expect($sut->fakeChild->value)->toBe('childValue');
            });
        });

        describe('getSource()', function () {
            test('Should return null when there is no value and no child data', function () {
                expect($this->sut->getSource())->toBeNull();
            });

            test('Should return an element named after FIELD_NAME once a value is assigned', function () {
                $this->sut->value = 'hello';

                $source = $this->sut->getSource();

                expect($source)->toBeInstanceOf(Element::class);
                expect($source->name)->toBe('FakeTag');
                expect($source->value)->toBe('hello');
            });

            test('Should return the very element instance given to parse', function () {
                $element = new Element;
                $element->parse('<FakeTag>hello</FakeTag>');

                $this->sut->parse($element);

                expect($this->sut->getSource())->toBe($element);
            });

            test('Should return the same instance across calls', function () {
                $this->sut->value = 'hello';

                expect($this->sut->getSource())->toBe($this->sut->getSource());
            });
        });

        describe('__toString()', function () {
            test('Should return an empty string when there is no value and no child data', function () {
                expect((string) $this->sut)->toBe('');
            });

            test('Should serialize xml string from cache when already set', function () {
                $this->sut->value = 'hello';

                expect((string) $this->sut)->toBe('<FakeTag>hello</FakeTag>');
            });

            test('Should return updated xml string after changing value directly DFeElement', function () {
                $element = new Element;
                $element->parse('<FakeTag>hello</FakeTag>');

                $this->sut->parse($element);
                $this->sut->value = 'updated';

                expect((string) $this->sut)->toBe('<FakeTag>updated</FakeTag>');
            });

            test('Should return updated parent xml string after changing value of child DFeElement', function () {
                $element = new Element;
                $element->parse('<FakeTag><FakeTag>hello</FakeTag></FakeTag>');

                $this->sut->parse($element);
                $this->sut->childElement->value = 'updated';

                expect((string) $this->sut)->toBe('<FakeTag><FakeTag>updated</FakeTag></FakeTag>');
            });

            test('Should replace child tag when the child property receives another DFeElement instance', function () {
                $element = new Element;
                $element->parse('<FakeTag><FakeTag>hello</FakeTag></FakeTag>');
                $this->sut->parse($element);

                $replacement = new FakeDFeElement;
                $replacement->value = 'other';
                $this->sut->childElement = $replacement;

                expect((string) $this->sut)->toBe('<FakeTag><FakeTag>other</FakeTag></FakeTag>');
            });

            test('Should remove child tag when an optional child property is set to null', function () {
                $element = new Element;
                $element->parse('<FakeTag><FakeTag>hello</FakeTag></FakeTag>');
                $this->sut->parse($element);
                $this->sut->childElement = null;

                expect((string) $this->sut)->toBe('<FakeTag/>');
            });

            test('Should keep tags that are not mapped as properties when a mapped child changes', function () {
                $element = new Element;
                $element->parse('<FakeGroup fakeAttr="ABC123"><FakeTag>childValue</FakeTag><unmapped>keep</unmapped></FakeGroup>');

                $sut = new FakeDFeGroupWithAttribute;
                $sut->parse($element);
                $sut->fakeChild->value = 'updated';

                expect((string) $sut)->toBe('<FakeGroup fakeAttr="ABC123"><FakeTag>updated</FakeTag><unmapped>keep</unmapped></FakeGroup>');
            });

            test('Should return the same xml string when serialized twice', function () {
                $element = new Element;
                $element->parse('<FakeGroup fakeAttr="ABC123"><FakeTag>childValue</FakeTag></FakeGroup>');

                $sut = new FakeDFeGroupWithAttribute;
                $sut->parse($element);

                expect((string) $sut)->toBe((string) $sut);
            });

            test('Should serialize special characters verbatim and keep value readable as assigned', function () {
                $this->sut->value = 'A&B';

                expect((string) $this->sut)->toBe('<FakeTag>A&B</FakeTag>');
                expect($this->sut->value)->toBe('A&B');
            });

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
                $child->value = 'childValue';

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

            test('Should throw Error when required DFeAttribute property is not initialized', function () {
                $sut = new FakeDFeGroupWithAttribute;
                // fakeAttr intentionally not initialized
                expect(fn () => $sut->fakeAttr)->toThrow(Error::class);
            });
        });
    });
});
