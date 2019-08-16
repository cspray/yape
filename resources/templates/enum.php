namespace <?= $this->getNamespace() ?>;

use Cspray\Yape\Enum;
use Cspray\Yape\HasSingletonContainer;
use Cspray\Yape\InvalidEnumValueException;

final class <?= $this->getEnumName() ?> implements Enum {

    use HasSingletonContainer;

    private static $valueMap = [
<?php foreach($this->getEnumValues() as $enumValue): ?>
        '<?= $enumValue ?>' => '<?= $enumValue ?>',
<?php endforeach; ?>
    ];

    private $value;

    private function __construct(string $value) {
        $this->value = $value;
    }

    public static function fromValue(string $value) : <?= $this->getEnumName() ?> {
        if (!isset(self::$valueMap[$value])) {
            $msg = 'Attempted to create an enum of type %s with an invalid value, "%s"';
            throw new InvalidEnumValueException(sprintf($msg, self::class, $value));
        }
        $method = self::$valueMap[$value];
        return self::$method();
    }

<?php foreach($this->getEnumValues() as $enumValue): ?>
    public static function <?= $enumValue ?>() : <?= $this->getEnumName() ?> {
        return self::getSingleton('<?= $enumValue ?>');
    }

<?php endforeach; ?>
    public function getValue() : string {
        return $this->value;
    }

    public function equals(<?= $this->getEnumName() ?> $<?= lcfirst($this->getEnumName()) ?>) : bool {
        return $this === $<?= lcfirst($this->getEnumName()) ?>;
    }

    public function toString() : string {
        return get_class($this) . '@' . $this->getValue();
    }

}