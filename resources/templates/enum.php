<?php
/**
 * @var $this \Cspray\Yape\EnumDefinition
 */
?>
namespace <?= $this->getEnumClass()->getNamespace() ?>;

use Cspray\Yape\Enum;
use Cspray\Yape\EnumTrait;

final class <?= $this->getEnumClass()->getClassName() ?> implements Enum {

    use EnumTrait;

<?php foreach($this->getEnumValues() as $enumValue): ?>
    public static function <?= $enumValue ?>() : self {
        return self::getSingleton(<?= var_export($enumValue, true) ?>);
    }

<?php endforeach; ?>
    // It is imperative that if you add a new value post code generation you add the method name here!
    static protected function getAllowedValues() : array {
        return [<?php foreach($this->getEnumValues() as $enumValue): echo var_export($enumValue, true), ', '; endforeach; ?>];
    }

}
