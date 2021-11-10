<?php
namespace Terrazza\Component\ReflectionClass\Tests\ClassName;
use PHPUnit\Framework\TestCase;
use Terrazza\Component\ReflectionClass\ClassName as ReflectionClassClassName;
use Terrazza\Component\ReflectionClass\ReflectionClassClassNameException;
use Terrazza\Component\ReflectionClass\Tests\Examples\ClassName\ReflectionClassClassNameExampleItem;
use Terrazza\Component\ReflectionClass\Tests\Examples\ClassName\ReflectionClassClassNameExampleParentChildAlias;
use Terrazza\Component\ReflectionClass\Tests\Examples\ClassName\ReflectionClassClassNameExampleParentChildSameNamespace;
use Terrazza\Component\ReflectionClass\Tests\Examples\ClassName\ReflectionClassClassNameExampleParentChildSubAlias;
use Terrazza\Component\ReflectionClass\Tests\Examples\ClassName\ReflectionClassClassNameExampleParentChildSubNamespace;
use Terrazza\Component\ReflectionClass\Tests\Examples\ClassName\Sub\ReflectionClassClassNameExampleSubItem;

class ReflectionClassClassNameTest extends TestCase {

    function testSuccessfulDirect() {
        $encoder    = (new ReflectionClassClassName());
        $className  = $encoder->getClassName(ReflectionClassClassNameExampleParentChildSameNamespace::class,
            get_class($this)
        );
        $this->assertEquals(get_class($this), $className);
    }
    function testSuccessfulChildSameNamespace() {
        $encoder    = (new ReflectionClassClassName());
        $className  = $encoder->getClassName(
            ReflectionClassClassNameExampleParentChildSameNamespace::class,
            "ReflectionClassClassNameExampleItem"
        );
        $this->assertEquals(ReflectionClassClassNameExampleItem::class, $className);
    }

    function testSuccessChildAlias() {
        $encoder    = (new ReflectionClassClassName());
        $className  = $encoder->getClassName(
            ReflectionClassClassNameExampleParentChildAlias::class,
            "simpleItem"
        );
        /** additional test to prevent double loading $className */
        $className  = $encoder->getClassName(
            ReflectionClassClassNameExampleParentChildAlias::class,
            "simpleItem"
        );
        $this->assertEquals(ReflectionClassClassNameExampleItem::class, $className);
    }
    

    function testSuccessChildSubNamespace() {
        $className = (new ReflectionClassClassName())->getClassName(
            ReflectionClassClassNameExampleParentChildSubNamespace::class,
            "Sub\ReflectionClassClassNameExampleSubItem"
        );
        $this->assertEquals(ReflectionClassClassNameExampleSubItem::class, $className);
    }

    function testSuccessChildSubAlias() {
        $className = (new ReflectionClassClassName())->getClassName(
            ReflectionClassClassNameExampleParentChildSubAlias::class,
            "subItem\ReflectionClassClassNameExampleSubItem"
        );
        $this->assertEquals(ReflectionClassClassNameExampleSubItem::class, $className);
    }

    function testExceptionClass() {
        $this->expectException(ReflectionClassClassNameException::class);
        (new ReflectionClassClassName())->getClassName(
            "unknownParentClass",
            "ReflectionClassClassNameExampleItem"
        );
    }

    function testNotFound() {
        $className = (new ReflectionClassClassName())->getClassName(
            ReflectionClassClassNameExampleParentChildSameNamespace::class,
            "undefinedClass"
        );
        $this->assertNull($className);
    }

}