<?php
/**
 * @var $this \Cspray\Yape\EnumDefinition
 */
?>
namespace <?= $this->getNamespace() ?>;

use Cspray\Yape\Enum;
use Cspray\Yape\EnumTrait;
use Cspray\Yape\Exception\InvalidArgumentException;

final class <?= $this->getEnumName() ?> implements Enum {

    use EnumTrait;

    private $enumValue;

    private function __construct(string $enumValue) {
        $this->enumValue = $enumValue;
    }

    // It is imperative that if you add a new value post code generation you add the method name here!
    static protected function getAllowedValues() : array {
        return [<?php foreach($this->getEnumValues() as $enumValue): echo var_export($enumValue, true), ', '; endforeach; ?>];
    }

    <?php foreach($this->getEnumValues() as $enumValue): ?>
    public static function <?= $enumValue ?>() : self {
        return self::getSingleton(<?= var_export($enumValue, true) ?>);
    }

    <?php endforeach; ?>

    public function toString() : string {
        return $this->enumValue;
    }
}
