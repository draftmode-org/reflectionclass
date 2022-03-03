<?php
namespace Terrazza\Component\ReflectionClass\Tests\ClassNameResolver;
use PHPUnit\Framework\TestCase;
use RuntimeException;
use Terrazza\Component\ReflectionClass\ClassNameResolver;
use Terrazza\Component\ReflectionClass\Tests\_Examples\ClassNameResolver\ClassNameResolverExampleItem;
use Terrazza\Component\ReflectionClass\Tests\_Examples\ClassNameResolver\ClassNameResolverExampleParentChildAlias;
use Terrazza\Component\ReflectionClass\Tests\_Examples\ClassNameResolver\ClassNameResolverExampleParentChildSameNamespace;
use Terrazza\Component\ReflectionClass\Tests\_Examples\ClassNameResolver\ClassNameResolverExampleParentChildSubAlias;
use Terrazza\Component\ReflectionClass\Tests\_Examples\ClassNameResolver\ClassNameResolverExampleParentChildSubNamespace;
use Terrazza\Component\ReflectionClass\Tests\_Examples\ClassNameResolver\Sub\ClassNameResolverExampleSubItem;

class ClassNameResolverTest extends TestCase {

    function testSuccessfulDirect() {
        $encoder    = (new ClassNameResolver());
        $className  = $encoder->getClassName(ClassNameResolverExampleParentChildSameNamespace::class,
            get_class($this)
        );
        $this->assertEquals(get_class($this), $className);
    }

    function testSuccessfulChildSameNamespace() {
        $encoder    = (new ClassNameResolver());
        $className  = $encoder->getClassName(
            ClassNameResolverExampleParentChildSameNamespace::class,
            "ClassNameResolverExampleItem"
        );
        $this->assertEquals(ClassNameResolverExampleItem::class, $className);
    }

    function testSuccessChildAlias() {
        $encoder    = (new ClassNameResolver());
        $className  = $encoder->getClassName(
            ClassNameResolverExampleParentChildAlias::class,
            "simpleItem"
        );
        /** additional test to prevent double loading $className */
        $className  = $encoder->getClassName(
            ClassNameResolverExampleParentChildAlias::class,
            "simpleItem"
        );
        $this->assertEquals(ClassNameResolverExampleItem::class, $className);
    }
    

    function testSuccessChildSubNamespace() {
        $className = (new ClassNameResolver())->getClassName(
            ClassNameResolverExampleParentChildSubNamespace::class,
            "Sub\ClassNameResolverExampleSubItem"
        );
        $this->assertEquals(ClassNameResolverExampleSubItem::class, $className);
    }

    function testSuccessChildSubAlias() {
        $className = (new ClassNameResolver())->getClassName(
            ClassNameResolverExampleParentChildSubAlias::class,
            "subItem\ClassNameResolverExampleSubItem"
        );
        $this->assertEquals(ClassNameResolverExampleSubItem::class, $className);
    }

    function testExceptionClass() {
        $this->expectException(RuntimeException::class);
        (new ClassNameResolver())->getClassName(
            "unknownParentClass",
            "ClassNameResolverExampleItem"
        );
    }

    function testNotFound() {
        $className = (new ClassNameResolver())->getClassName(
            ClassNameResolverExampleParentChildSameNamespace::class,
            "undefinedClass"
        );
        $this->assertNull($className);
    }

}