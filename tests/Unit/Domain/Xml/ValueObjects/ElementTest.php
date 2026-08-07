<?php

declare(strict_types=1);

use BradiApi\Domain\Common\ValueObjects\Result;
use BradiApi\Domain\Xml\ValueObjects\Attribute;
use BradiApi\Domain\Xml\ValueObjects\AttributeList;
use BradiApi\Domain\Xml\ValueObjects\Element;
use BradiApi\Domain\Xml\ValueObjects\ElementList;
use BradiApi\Infra\Parses\XmlStringIterator;
use BradiApi\Tests\Doubles\Domain\Xml\FakeXmlIterator;
use BradiApi\Tests\TestCase;

describe('Element', function () {
    test('Should succeed if is declared', function () {
        $nameSpace = 'BradiApi\Domain\Xml\ValueObjects';
        $sut = $nameSpace . '\\Element';
        expect(class_exists($sut))->toBeTrue();
    });

    describe('properties', function () {
        describe('$name', function () {
            test('Should be declared', function () {
                $sut = new Element;
                expect($sut)->toHaveProperty('name');
            });

            test('Should be a string', function () {
                $reflection = new ReflectionClass(Element::class);
                $sut = $reflection->getProperty('name')->getType();
                expect((string) $sut)->toBe('string');
            });

            test('Should be required', function () {
                $reflection = new ReflectionClass(Element::class);
                $sut = $reflection->getProperty('name')->getType();
                expect($sut->allowsNull())->toBeFalse();
            });
        });

        describe('$value', function () {
            test('Should be declared', function () {
                $sut = new Element;
                expect($sut)->toHaveProperty('value');
            });

            test('Should be a string', function () {
                $reflection = new ReflectionClass(Element::class);
                $sut = $reflection->getProperty('value')->getType();
                expect($sut->getName())->toBe('string');
            });

            test('Should be optional', function () {
                $reflection = new ReflectionClass(Element::class);
                $sut = $reflection->getProperty('value')->getType();
                expect($sut->allowsNull())->toBeTrue();
            });

            test('Should default to null', function () {
                $sut = new Element;
                expect($sut->value)->toBeNull();
            });
        });

        describe('$attributes', function () {
            test('Should be declared', function () {
                $sut = new Element;
                expect($sut)->toHaveProperty('attributes');
            });

            test('Should be an AttributeList', function () {
                $reflection = new ReflectionClass(Element::class);
                $sut = $reflection->getProperty('attributes')->getType();
                expect($sut->getName())->toBe(AttributeList::class);
            });

            test('Should start empty', function () {
                $sut = new Element;
                expect($sut->attributes->records)->toBe([]);
            });
        });

        describe('$children', function () {
            test('Should be declared', function () {
                $sut = new Element;
                expect($sut)->toHaveProperty('children');
            });

            test('Should be an ElementList', function () {
                $reflection = new ReflectionClass(Element::class);
                $sut = $reflection->getProperty('children')->getType();
                expect($sut->getName())->toBe(ElementList::class);
            });

            test('Should start empty', function () {
                $sut = new Element;
                expect($sut->children->records)->toBe([]);
            });
        });
    });

    describe('methods', function () {
        describe('__construct()', function () {
            test('Should use XmlStringIterator by default', function () {
                $reflection = new ReflectionClass(Element::class);
                $sut = $reflection->getConstructor()->getParameters()[0];
                expect($sut->getDefaultValue())->toBeInstanceOf(XmlStringIterator::class);
            });

            test('Should keep the iterator as a private readonly dependency', function () {
                $reflection = new ReflectionClass(Element::class);
                $sut = $reflection->getProperty('iterator');
                expect($sut->isPrivate())->toBeTrue();
                expect($sut->isReadOnly())->toBeTrue();
            });

            test('Should parse through the injected iterator instead of the default one', function () {
                $sut = new Element(new FakeXmlIterator);

                $parsingResponse = $sut->parse('<root id="10"><item>1</item></root>');

                expect($parsingResponse->isSuccess())->toBeTrue();
                expect($sut->name)->toBe('');
                expect($sut->value)->toBe('');
                expect($sut->attributes->records)->toBe([]);
                expect($sut->children->records)->toBe([]);
            });
        });

        describe('add()', function () {
            beforeEach(function () {
                /** @var TestCase $this */
                $this->sut = new Element;
                $this->sut->name = 'root';
            });

            test('Should store an Attribute in the attributes list', function () {
                $attribute = new Attribute('id', '42', 'root');

                $this->sut->add($attribute);

                expect($this->sut->attributes->records)->toHaveCount(1);
                expect($this->sut->attributes->records[0])->toBe($attribute);
                expect($this->sut->children->records)->toBe([]);
            });

            test('Should store an Element in the children list', function () {
                $child = new Element;
                $child->name = 'item';

                $this->sut->add($child);

                expect($this->sut->children->records)->toHaveCount(1);
                expect($this->sut->children->records[0])->toBe($child);
                expect($this->sut->attributes->records)->toBe([]);
            });

            test('Should store every Element of an ElementList in the children list', function () {
                $first = new Element;
                $first->name = 'item';
                $first->value = '1';

                $second = new Element;
                $second->name = 'item';
                $second->value = '2';

                $this->sut->add(new ElementList([$first, $second]));

                expect($this->sut->children->records)->toHaveCount(2);
                expect($this->sut->children->records[0])->toBe($first);
                expect($this->sut->children->records[1])->toBe($second);
            });

            test('Should throw when an attribute name already exists', function () {
                $this->sut->add(new Attribute('id', '42', 'root'));

                expect(fn () => $this->sut->add(new Attribute('id', '43', 'root')))
                    ->toThrow(InvalidArgumentException::class, "Attribute with name 'id' already exists.");
            });

            test('Should throw when the same Element instance is added twice', function () {
                $child = new Element;
                $child->name = 'item';

                $this->sut->add($child);

                expect(fn () => $this->sut->add($child))
                    ->toThrow(InvalidArgumentException::class, 'The same Element instance is already present in this list.');
            });
        });

        describe('remove()', function () {
            beforeEach(function () {
                /** @var TestCase $this */
                $this->sut = new Element;
                $this->sut->name = 'root';
            });

            test('Should remove an Attribute', function () {
                $attribute = new Attribute('id', '42', 'root');
                $this->sut->add($attribute);

                $this->sut->remove($attribute);

                expect($this->sut->attributes->records)->toBe([]);
                expect($this->sut->isSet('id'))->toBeFalse();
            });

            test('Should remove an Element', function () {
                $child = new Element;
                $child->name = 'item';
                $this->sut->add($child);

                $this->sut->remove($child);

                expect($this->sut->children->records)->toBe([]);
                expect($this->sut->isSet('item'))->toBeFalse();
            });

            test('Should keep the remaining children as a packed list', function () {
                $names = ['first', 'second', 'third'];
                foreach ($names as $name) {
                    $child = new Element;
                    $child->name = $name;
                    $this->sut->add($child);
                }

                $this->sut->remove($this->sut->second);

                expect(array_keys($this->sut->children->records))->toBe([0, 1]);
                expect(array_map(fn (Element $element) => $element->name, $this->sut->children->records))
                    ->toBe(['first', 'third']);
            });

            test('Should do nothing when the Attribute is absent', function () {
                $attribute = new Attribute('id', '42', 'root');
                $this->sut->add($attribute);

                $this->sut->remove(new Attribute('status', 'ok', 'root'));

                expect($this->sut->attributes->records)->toHaveCount(1);
                expect($this->sut->attributes->records[0])->toBe($attribute);
            });

            test('Should do nothing when the Element is absent', function () {
                $child = new Element;
                $child->name = 'item';
                $this->sut->add($child);

                $absent = new Element;
                $absent->name = 'item';

                $this->sut->remove($absent);

                expect($this->sut->children->records)->toHaveCount(1);
                expect($this->sut->children->records[0])->toBe($child);
            });
        });

        describe('replace()', function () {
            beforeEach(function () {
                /** @var TestCase $this */
                $this->sut = new Element;
                $this->sut->name = 'root';
            });

            test('Should swap an Element for another', function () {
                $oldChild = new Element;
                $oldChild->name = 'old';
                $this->sut->add($oldChild);

                $newChild = new Element;
                $newChild->name = 'new';
                $newChild->value = 'value';

                $this->sut->replace($oldChild, $newChild);

                expect($this->sut->children->records)->toHaveCount(1);
                expect($this->sut->isSet('old'))->toBeFalse();
                expect($this->sut->new?->value)->toBe('value');
            });

            test('Should swap an Attribute for another', function () {
                $oldAttribute = new Attribute('id', '42', 'root');
                $this->sut->add($oldAttribute);

                $this->sut->replace($oldAttribute, new Attribute('id', '43', 'root'));

                expect($this->sut->attributes->records)->toHaveCount(1);
                expect($this->sut->id?->value)->toBe('43');
            });

            test('Should throw when replacing an Element with an Attribute', function () {
                $child = new Element;
                $child->name = 'item';
                $this->sut->add($child);

                expect(fn () => $this->sut->replace($child, new Attribute('id', '42', 'root')))
                    ->toThrow(InvalidArgumentException::class, 'Cannot replace an Element with an Attribute or vice versa.');
            });

            test('Should throw when replacing an Attribute with an Element', function () {
                $attribute = new Attribute('id', '42', 'root');
                $this->sut->add($attribute);

                $child = new Element;
                $child->name = 'item';

                expect(fn () => $this->sut->replace($attribute, $child))
                    ->toThrow(InvalidArgumentException::class, 'Cannot replace an Element with an Attribute or vice versa.');
            });
        });

        describe('isSet()', function () {
            beforeEach(function () {
                /** @var TestCase $this */
                $this->sut = new Element;
                $this->sut->name = 'root';
                $this->sut->add(new Attribute('id', '42', 'root'));

                $child = new Element;
                $child->name = 'item';
                $this->sut->add($child);
            });

            test('Should return true when an attribute matches the name', function () {
                expect($this->sut->isSet('id'))->toBeTrue();
            });

            test('Should return true when a child element matches the name', function () {
                expect($this->sut->isSet('item'))->toBeTrue();
            });

            test('Should return false when nothing matches the name', function () {
                expect($this->sut->isSet('unknown'))->toBeFalse();
            });
        });

        describe('parse()', function () {
            beforeEach(function () {
                /** @var TestCase $this */
                $this->sut = new Element;
            });

            test('Should return a failure Result when the candidate is not a valid xml string', function () {
                $parsingResponse = $this->sut->parse(['not-an-xml']);

                expect($parsingResponse)->toBeInstanceOf(Result::class);
                expect($parsingResponse->isFailure())->toBeTrue();
            });

            test('Should return a successful Result holding itself', function () {
                $parsingResponse = $this->sut->parse('<root><item>1</item></root>');

                expect($parsingResponse)->toBeInstanceOf(Result::class);
                expect($parsingResponse->isSuccess())->toBeTrue();
                expect($parsingResponse->getData())->toBe($this->sut);
            });

            test('Should parse name value attributes and children recursively', function () {
                $candidate = '<root id="10" status="ok"><item>1</item><item>2</item><meta><flag>true</flag></meta></root>';

                $parsingResponse = $this->sut->parse($candidate);

                expect($parsingResponse->isSuccess())->toBeTrue();
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

            test('Should parse a self-closing tag keeping its attributes', function () {
                $parsingResponse = $this->sut->parse('<item id="1"/>');

                expect($parsingResponse->isSuccess())->toBeTrue();
                expect($this->sut->name)->toBe('item');
                expect($this->sut->value)->toBe('');
                expect($this->sut->attributes->records)->toHaveCount(1);
                expect($this->sut->attributes->id?->value)->toBe('1');
                expect($this->sut->children->records)->toBe([]);
            });

            test('Should parse a self-closing tag written with a trailing space', function () {
                $parsingResponse = $this->sut->parse('<item id="1" />');

                expect($parsingResponse->isSuccess())->toBeTrue();
                expect($this->sut->name)->toBe('item');
                expect($this->sut->attributes->id?->value)->toBe('1');
                expect($this->sut->children->records)->toBe([]);
            });

            test('Should parse nested tags sharing the same name', function () {
                $parsingResponse = $this->sut->parse('<root><item><item>inner</item></item></root>');

                expect($parsingResponse->isSuccess())->toBeTrue();
                expect($this->sut->children->records)->toHaveCount(1);
                expect($this->sut->item)->toBeInstanceOf(Element::class);
                expect($this->sut->item?->item?->value)->toBe('inner');
            });
        });

        describe('__get()', function () {
            beforeEach(function () {
                /** @var TestCase $this */
                $this->sut = new Element;
                $this->sut->name = 'root';

                $this->sut->add(new Attribute('id', '42', 'root'));

                $singleChild = new Element;
                $singleChild->name = 'single';
                $singleChild->value = 'single-value';

                $multiChildA = new Element;
                $multiChildA->name = 'multi';
                $multiChildA->value = 'a';

                $multiChildB = new Element;
                $multiChildB->name = 'multi';
                $multiChildB->value = 'b';

                $this->sut->add($singleChild);
                $this->sut->add($multiChildA);
                $this->sut->add($multiChildB);
            });

            test('Should return the attribute when the name matches an existing attribute', function () {
                expect($this->sut->id?->value)->toBe('42');
            });

            test('Should return a single child element when the name matches one child', function () {
                $single = $this->sut->single;

                expect($single)->toBeInstanceOf(Element::class);
                expect($single?->value)->toBe('single-value');
            });

            test('Should return an element list when the name matches multiple children', function () {
                $multi = $this->sut->multi;

                expect($multi)->toBeInstanceOf(ElementList::class);
                expect($multi->records)->toHaveCount(2);
                expect(array_values(array_map(
                    fn (Element $element) => $element->value,
                    $multi->records
                )))->toBe(['a', 'b']);
            });

            test('Should return null when the attribute or child does not exist', function () {
                expect($this->sut->unknown)->toBeNull();
            });
        });

        describe('__toString()', function () {
            beforeEach(function () {
                /** @var TestCase $this */
                $this->sut = new Element;
                $this->sut->name = 'tag';
            });

            describe('auto-close', function () {
                test('Should return an auto-close tag when there is no value and no children', function () {
                    expect((string) $this->sut)->toBe('<tag/>');
                });

                test('Should return an auto-close tag with attribute when there is no value and no children', function () {
                    $this->sut->add(new Attribute('id', '1', 'tag'));

                    expect((string) $this->sut)->toBe('<tag id="1"/>');
                });

                test('Should return an auto-close tag with multiple attributes', function () {
                    $this->sut->add(new Attribute('id', '1', 'tag'));
                    $this->sut->add(new Attribute('status', 'active', 'tag'));

                    expect((string) $this->sut)->toBe('<tag id="1" status="active"/>');
                });
            });

            describe('tag with value', function () {
                test('Should return the tag with a simple value', function () {
                    $this->sut->value = 'content';

                    expect((string) $this->sut)->toBe('<tag>content</tag>');
                });

                test('Should return the tag with value and attribute', function () {
                    $this->sut->value = 'content';
                    $this->sut->add(new Attribute('id', '1', 'tag'));

                    expect((string) $this->sut)->toBe('<tag id="1">content</tag>');
                });

                test('Should return the tag with value and multiple attributes', function () {
                    $this->sut->value = 'content';
                    $this->sut->add(new Attribute('id', '1', 'tag'));
                    $this->sut->add(new Attribute('type', 'A', 'tag'));

                    expect((string) $this->sut)->toBe('<tag id="1" type="A">content</tag>');
                });
            });

            describe('tag with children', function () {
                test('Should return the tag with a single child', function () {
                    $this->sut->name = 'root';

                    $child = new Element;
                    $child->name = 'item';
                    $child->value = 'value';

                    $this->sut->add($child);

                    expect((string) $this->sut)->toBe('<root><item>value</item></root>');
                });

                test('Should return the tag with multiple children in insertion order', function () {
                    $this->sut->name = 'root';

                    $child1 = new Element;
                    $child1->name = 'a';
                    $child1->value = '1';

                    $child2 = new Element;
                    $child2->name = 'b';
                    $child2->value = '2';

                    $this->sut->add($child1);
                    $this->sut->add($child2);

                    expect((string) $this->sut)->toBe('<root><a>1</a><b>2</b></root>');
                });

                test('Should return the tag with nested children across multiple levels', function () {
                    $this->sut->name = 'root';

                    $middle = new Element;
                    $middle->name = 'middle';

                    $leaf = new Element;
                    $leaf->name = 'leaf';
                    $leaf->value = 'data';

                    $middle->add($leaf);
                    $this->sut->add($middle);

                    expect((string) $this->sut)->toBe('<root><middle><leaf>data</leaf></middle></root>');
                });

                test('Should return an auto-close child when it has no value and no grandchildren', function () {
                    $this->sut->name = 'root';

                    $child = new Element;
                    $child->name = 'empty';

                    $this->sut->add($child);

                    expect((string) $this->sut)->toBe('<root><empty/></root>');
                });
            });

            describe('special characters', function () {
                test('Should not escape ampersand in value', function () {
                    $this->sut->value = 'A&B';

                    expect((string) $this->sut)->toBe('<tag>A&B</tag>');
                });

                test('Should not escape less-than in value', function () {
                    $this->sut->value = '5<3';

                    expect((string) $this->sut)->toBe('<tag>5<3</tag>');
                });

                test('Should not escape greater-than in value', function () {
                    $this->sut->value = '5>3';

                    expect((string) $this->sut)->toBe('<tag>5>3</tag>');
                });

                test('Should not escape double quotes in attribute value', function () {
                    $this->sut->add(new Attribute('ref', 'say "hi"', 'tag'));

                    expect((string) $this->sut)->toBe('<tag ref="say "hi""/>');
                });

                test('Should keep an already escaped value unchanged', function () {
                    $this->sut->value = 'A&amp;B';

                    expect((string) $this->sut)->toBe('<tag>A&amp;B</tag>');
                });

                test('Should return the source xml untouched after a parse round-trip', function () {
                    $candidate = '<root ref="A&amp;B"><tag>5&lt;3</tag></root>';

                    $sut = new Element;
                    $sut->parse($candidate);

                    expect((string) $sut)->toBe($candidate);
                });
            });

            describe('null and empty value', function () {
                test('Should treat null value as auto-close when there are no children', function () {
                    $this->sut->value = null;

                    expect((string) $this->sut)->toBe('<tag/>');
                });

                test('Should treat empty string value as auto-close when there are no children', function () {
                    $this->sut->value = '';

                    expect((string) $this->sut)->toBe('<tag/>');
                });
            });
        });
    });
});
