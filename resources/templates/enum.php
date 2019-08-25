<?php
/**
 * @var $this \Cspray\Yape\EnumDefinition
 */
?>
namespace <?= $this->getNamespace() ?>;

use Cspray\Yape\Enum;

final class <?= $this->getEnumName() ?> implements Enum {

    private static $container = [];

    private $enumConstName;
    private $value;

    private function __construct(string $enumConstName, <?= $this->getValueType()->getValue() ?> $value) {
        $this->enumConstName = $enumConstName;
        $this->value = $value;
    }

    private static function getSingleton(...$constructorArgs) {
        $name = $constructorArgs[0];
        if (!isset(self::$container[$name])) {
            self::$container[$name] = new self(...$constructorArgs);
        }

        return self::$container[$name];
    }

<?php foreach($this->getEnumValues() as $enumValue): ?>
    public static function <?= $enumValue->getName() ?>() : <?= $this->getEnumName() ?> {
        return self::getSingleton(<?= var_export($enumValue->getName(), true) ?>, <?= var_export($enumValue->getValue(), true) ?>);
    }

<?php endforeach; ?>
    public function getValue() : <?= $this->getValueType()->getValue() ?> {
        return $this->value;
    }

    public function equals(<?= $this->getEnumName() ?> $<?= lcfirst($this->getEnumName()) ?>) : bool {
        return $this === $<?= lcfirst($this->getEnumName()) ?>;
    }

    public function toString() : string {
        return get_class($this) . '@' . $this->enumConstName;
    }

}
