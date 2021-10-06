<?php

namespace Terrazza\Component\ReflectionClass\ClassName;

interface ReflectionClassClassNameInterface {
    /**
     * @param string $parentClass
     * @param string $findClass
     * @return string|null
     * @throws ReflectionClassClassNameException
     */
    public function getClassName(string $parentClass, string $findClass) :?string;
}