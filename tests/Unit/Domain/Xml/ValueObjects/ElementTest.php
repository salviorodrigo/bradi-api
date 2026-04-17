<?php

declare(strict_types=1);

use BradiNfeApi\Domain\Xml\ValueObjects\Attribute;
use BradiNfeApi\Domain\Xml\ValueObjects\Element;
use BradiNfeApi\Tests\Doubles\Domain\Common\FakeValidationService;
use BradiNfeApi\Tests\Doubles\Domain\Xml\FakeXmlIterator;

describe('Element', function () {
    describe('::__toString()', function () {
        beforeEach(function () {
            /** @var \BradiNfeApi\Tests\TestCase $this */
            $this->sut = new Element(new FakeXmlIterator, new FakeValidationService);
            $this->sut->name = 'tag';
        });

        describe('auto-close', function () {
            test('returns auto-close tag when no value and no children', function () {
                expect((string) $this->sut)->toBe('<tag/>');
            });

            test('returns auto-close tag with attribute when no value and no children', function () {
                $this->sut->addAttribute(new Attribute('id', '1'));

                expect((string) $this->sut)->toBe('<tag id="1"/>');
            });

            test('returns auto-close tag with multiple attributes', function () {
                $this->sut->addAttribute(new Attribute('id', '1'));
                $this->sut->addAttribute(new Attribute('status', 'active'));

                expect((string) $this->sut)->toBe('<tag id="1" status="active"/>');
            });
        });

        describe('tag with value', function () {
            test('returns tag with simple value', function () {
                $this->sut->value = 'content';

                expect((string) $this->sut)->toBe('<tag>content</tag>');
            });

            test('returns tag with value and attribute', function () {
                $this->sut->value = 'content';
                $this->sut->addAttribute(new Attribute('id', '1'));

                expect((string) $this->sut)->toBe('<tag id="1">content</tag>');
            });

            test('returns tag with value and multiple attributes', function () {
                $this->sut->value = 'content';
                $this->sut->addAttribute(new Attribute('id', '1'));
                $this->sut->addAttribute(new Attribute('type', 'A'));

                expect((string) $this->sut)->toBe('<tag id="1" type="A">content</tag>');
            });
        });

        describe('tag with children', function () {
            test('returns tag with single child', function () {
                $this->sut->name = 'root';

                $child = new Element(new FakeXmlIterator, new FakeValidationService);
                $child->name = 'item';
                $child->value = 'value';

                $this->sut->addChild($child);

                expect((string) $this->sut)->toBe('<root><item>value</item></root>');
            });

            test('returns tag with multiple children in insertion order', function () {
                $this->sut->name = 'root';

                $child1 = new Element(new FakeXmlIterator, new FakeValidationService);
                $child1->name = 'a';
                $child1->value = '1';

                $child2 = new Element(new FakeXmlIterator, new FakeValidationService);
                $child2->name = 'b';
                $child2->value = '2';

                $this->sut->addChild($child1);
                $this->sut->addChild($child2);

                expect((string) $this->sut)->toBe('<root><a>1</a><b>2</b></root>');
            });

            test('returns tag with nested children across multiple levels', function () {
                $this->sut->name = 'root';

                $middle = new Element(new FakeXmlIterator, new FakeValidationService);
                $middle->name = 'middle';

                $leaf = new Element(new FakeXmlIterator, new FakeValidationService);
                $leaf->name = 'leaf';
                $leaf->value = 'data';

                $middle->addChild($leaf);
                $this->sut->addChild($middle);

                expect((string) $this->sut)->toBe('<root><middle><leaf>data</leaf></middle></root>');
            });

            test('child with no value and no grandchildren becomes auto-close', function () {
                $this->sut->name = 'root';

                $child = new Element(new FakeXmlIterator, new FakeValidationService);
                $child->name = 'empty';

                $this->sut->addChild($child);

                expect((string) $this->sut)->toBe('<root><empty/></root>');
            });
        });

        describe('special character escaping', function () {
            test('escapes ampersand in value', function () {
                $this->sut->value = 'A&B';

                expect((string) $this->sut)->toBe('<tag>A&amp;B</tag>');
            });

            test('escapes less-than in value', function () {
                $this->sut->value = '5<3';

                expect((string) $this->sut)->toBe('<tag>5&lt;3</tag>');
            });

            test('escapes greater-than in value', function () {
                $this->sut->value = '5>3';

                expect((string) $this->sut)->toBe('<tag>5&gt;3</tag>');
            });

            test('escapes double quotes in attribute value', function () {
                $this->sut->addAttribute(new Attribute('ref', 'say "hi"'));

                expect((string) $this->sut)->toBe('<tag ref="say &quot;hi&quot;"/>');
            });

            test('escapes ampersand in attribute value', function () {
                $this->sut->addAttribute(new Attribute('ref', 'A&B'));

                expect((string) $this->sut)->toBe('<tag ref="A&amp;B"/>');
            });
        });

        describe('null and empty value', function () {
            test('treats null value as auto-close when no children', function () {
                $this->sut->value = null;

                expect((string) $this->sut)->toBe('<tag/>');
            });

            test('treats empty string value as auto-close when no children', function () {
                $this->sut->value = '';

                expect((string) $this->sut)->toBe('<tag/>');
            });
        });
    });
});
