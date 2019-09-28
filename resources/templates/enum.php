<?php
/**
 * @var $this \Cspray\Yape\EnumDefinition
 */
?>
namespace <?= $this->getNamespace() ?>;

use Cspray\Yape\Enum;
use Cspray\Yape\Exception\InvalidArgumentException;

final class <?= $this->getEnumName() ?> implements Enum {

    // It is imperative that if you add a new value post code generation you add the method name here!
    private const POSSIBLE_VALUES = [<?php foreach($this->getEnumValues() as $enumValue): echo var_export($enumValue, true), ', '; endforeach; ?>];

    private static $container = [];

    private $enumConstName;

    private function __construct(string $enumConstName) {
        $this->enumConstName = $enumConstName;
    }

    /**
    * Return a collection of all the possible values that this enum could have.
    *
    * @return <?= $this->getEnumName() ?>[]
    */
    public static function values() : array {
        self::primeContainer();
        return array_values(self::$container);
    }

    public static function valueOf(string $name) : self {
        self::primeContainer();
        if (!isset(self::$container[$name])) {
            $msg = sprintf('The value "%s" is not a valid %s name', $name, self::class);
            throw new InvalidArgumentException($msg);
        }
        return self::$container[$name];
    }

    <?php foreach($this->getEnumValues() as $enumValue): ?>
    public static function <?= $enumValue ?>() : self {
        return self::getSingleton(<?= var_export($enumValue, true) ?>);
    }

    <?php endforeach; ?>
    static private function getSingleton(string $name) {
        if (!isset(self::$container[$name])) {
            self::$container[$name] = new self($name);
        }

        return self::$container[$name];
    }

    static private function primeContainer() {
        if (count(self::$container) !== count(self::POSSIBLE_VALUES)) {
            foreach (self::POSSIBLE_VALUES as $enumValue) {
                self::$enumValue();
            }
        }
    }

    public function equals($<?= lcfirst($this->getEnumName()) ?>) : bool {
        return $this === $<?= lcfirst($this->getEnumName()) ?>;
    }

    public function toString() : string {
        return get_class($this) . '@' . $this->enumConstName;
    }

}
