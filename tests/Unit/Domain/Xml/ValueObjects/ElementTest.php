<?php

declare(strict_types=1);

use BradiApi\Domain\Xml\ValueObjects\Attribute;
use BradiApi\Domain\Xml\ValueObjects\Element;
use BradiApi\Domain\Xml\ValueObjects\ElementList;
use BradiApi\Tests\TestCase;

describe('Element', function () {
    describe('::parse()', function () {
        beforeEach(function () {
            /** @var TestCase $this */
            $this->sut = new Element;
        });

        test('returns failure when candidate is not a valid xml string', function () {
            $parsingResponse = $this->sut->parse(['not-an-xml']);

            expect($parsingResponse->isFailure())->toBeTrue();
        });

        test('parses name value attributes and children recursively', function () {
            $candidate = '<root id="10" status="ok"><item>1</item><item>2</item><meta><flag>true</flag></meta></root>';

            $parsingResponse = $this->sut->parse($candidate);

            expect($parsingResponse->isSuccess())->toBeTrue();
            expect($parsingResponse->getData())->toBe($this->sut);
            expect($this->sut->name)->toBe('root');
            expect($this->sut->value)->toBe('');
            expect($this->sut->attributes->records)->toHaveCount(2);
            expect($this->sut->attributes->id?->value)->toBe('10');
            expect($this->sut->attributes->status?->value)->toBe('ok');
            expect($this->sut->children->records)->toHaveCount(3);

            $items = $this->sut->children->item;
            expect($items)->toBeInstanceOf(ElementList::class);
            expect($items->records)->toHaveCount(2);
            expect($items->records[0]->value)->toBe('1');
            expect($items->records[1]->value)->toBe('2');

            $meta = $this->sut->children->meta;
            expect($meta)->toBeInstanceOf(Element::class);
            expect($meta?->children->flag?->value)->toBe('true');
        });
    });

    describe('::__get()', function () {
        beforeEach(function () {
            /** @var TestCase $this */
            $this->sut = new Element;
            $this->sut->name = 'root';

            $this->sut->addAttribute(new Attribute('id', '42', 'root'));

            $singleChild = new Element;
            $singleChild->name = 'single';
            $singleChild->value = 'single-value';

            $multiChildA = new Element;
            $multiChildA->name = 'multi';
            $multiChildA->value = 'a';

            $multiChildB = new Element;
            $multiChildB->name = 'multi';
            $multiChildB->value = 'b';

            $this->sut->addChild($singleChild);
            $this->sut->addChild($multiChildA);
            $this->sut->addChild($multiChildB);
        });

        test('returns attribute when name matches an existing attribute', function () {
            expect($this->sut->id?->value)->toBe('42');
        });

        test('returns single child element when name matches one child', function () {
            $single = $this->sut->single;

            expect($single)->toBeInstanceOf(Element::class);
            expect($single?->value)->toBe('single-value');
        });

        test('returns element list when name matches multiple children', function () {
            $multi = $this->sut->multi;

            expect($multi)->toBeInstanceOf(ElementList::class);
            expect($multi->records)->toHaveCount(2);
            expect(array_values(array_map(
                fn (Element $element) => $element->value,
                $multi->records
            )))->toBe(['a', 'b']);
        });

        test('returns null when attribute or child does not exist', function () {
            expect($this->sut->unknown)->toBeNull();
        });
    });

    describe('::__toString()', function () {
        beforeEach(function () {
            /** @var TestCase $this */
            $this->sut = new Element;
            $this->sut->name = 'tag';
        });

        describe('auto-close', function () {
            test('returns auto-close tag when no value and no children', function () {
                expect((string) $this->sut)->toBe('<tag/>');
            });

            test('returns auto-close tag with attribute when no value and no children', function () {
                $this->sut->addAttribute(new Attribute('id', '1', 'tag'));

                expect((string) $this->sut)->toBe('<tag id="1"/>');
            });

            test('returns auto-close tag with multiple attributes', function () {
                $this->sut->addAttribute(new Attribute('id', '1', 'tag'));
                $this->sut->addAttribute(new Attribute('status', 'active', 'tag'));

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
                $this->sut->addAttribute(new Attribute('id', '1', 'tag'));

                expect((string) $this->sut)->toBe('<tag id="1">content</tag>');
            });

            test('returns tag with value and multiple attributes', function () {
                $this->sut->value = 'content';
                $this->sut->addAttribute(new Attribute('id', '1', 'tag'));
                $this->sut->addAttribute(new Attribute('type', 'A', 'tag'));

                expect((string) $this->sut)->toBe('<tag id="1" type="A">content</tag>');
            });
        });

        describe('tag with children', function () {
            test('returns tag with single child', function () {
                $this->sut->name = 'root';

                $child = new Element;
                $child->name = 'item';
                $child->value = 'value';

                $this->sut->addChild($child);

                expect((string) $this->sut)->toBe('<root><item>value</item></root>');
            });

            test('returns tag with multiple children in insertion order', function () {
                $this->sut->name = 'root';

                $child1 = new Element;
                $child1->name = 'a';
                $child1->value = '1';

                $child2 = new Element;
                $child2->name = 'b';
                $child2->value = '2';

                $this->sut->addChild($child1);
                $this->sut->addChild($child2);

                expect((string) $this->sut)->toBe('<root><a>1</a><b>2</b></root>');
            });

            test('returns tag with nested children across multiple levels', function () {
                $this->sut->name = 'root';

                $middle = new Element;
                $middle->name = 'middle';

                $leaf = new Element;
                $leaf->name = 'leaf';
                $leaf->value = 'data';

                $middle->addChild($leaf);
                $this->sut->addChild($middle);

                expect((string) $this->sut)->toBe('<root><middle><leaf>data</leaf></middle></root>');
            });

            test('child with no value and no grandchildren becomes auto-close', function () {
                $this->sut->name = 'root';

                $child = new Element;
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
                $this->sut->addAttribute(new Attribute('ref', 'say "hi"', 'tag'));

                expect((string) $this->sut)->toBe('<tag ref="say &quot;hi&quot;"/>');
            });

            test('escapes ampersand in attribute value', function () {
                $this->sut->addAttribute(new Attribute('ref', 'A&B', 'tag'));

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
