# the reflectionClass component
This component provides additional methods for PHP RefectionClass.
There is no need to install it independently. This package will be used inside some other Terrazza Components.

```
$encoder            = (new ReflectionClassClassName());

echo $encoder->getClassName(Test::class, "mySubClass");
// Someother\Someother\mySubClass 

echo $encoder->getClassName(Test::class, "mySubClassAs");
// Someother\Someother\mySubClass

echo $encoder->getClassName(Test::class, "Someother\mySubClass");
// Someother\Someother\mySubClass

namespace Someother {
    class mySubClass {}
}
namespace Test {
    use Someother\mySubClass;
    use Someother\mySubClass as mySubClassAs;
    class myClass {
        private mySubClass $subclass;
        private mySubClassAs $subclassAs;
        private Someother\mySubClass $subclassFull;
    }
}
```
Based on Test::class the encoder will return the full namespace of a search class.
No matter if the class is implemented
- full qualified
- partial qualified
- qualified through an alias

