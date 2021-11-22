<?php
namespace Terrazza\Component\ReflectionClass;
use RuntimeException;

interface ClassNameResolverInterface {
    /**
     * @param string $parentClass
     * @param string $findClass
     * @return string|null
     * @throws RuntimeException
     */
    public function getClassName(string $parentClass, string $findClass) :?string;
}