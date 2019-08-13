namespace <?= $this->getNamespace() ?>;

final class <?= $this->getEnumName() ?> {

<?php foreach($this->getEnumValues() as $enumValue): ?>
    private static $<?= lcfirst($enumValue) ?>;
<?php endforeach; ?>

    private $value;

    private function __construct(string $value) {
        $this->value = $value;
    }

<?php foreach($this->getEnumValues() as $enumValue): ?>
    public static function <?= $enumValue ?>() : <?= $this->getEnumName() ?> {
        if (!isset(self::$<?= lcfirst($enumValue) ?>)) {
            self::$<?= lcfirst($enumValue) ?> = new self('<?= $enumValue ?>');
        }

        return self::$<?= lcfirst($enumValue) ?>;
    }

<?php endforeach; ?>
    public function getValue() : string {
        return $this->value;
    }

}