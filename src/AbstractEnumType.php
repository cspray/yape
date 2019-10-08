<?php declare(strict_types=1);

namespace Cspray\Yape;

use Cspray\Yape\Exception\InvalidArgumentException;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\ConversionException;
use Doctrine\DBAL\Types\Type;

/**
 *
 * @package Cspray\Yape\Doctrine
 * @license See LICENSE in source root
 */
abstract class AbstractEnumType extends Type {

    /**
     * Gets the SQL declaration snippet for a field of this type.
     *
     * @param mixed[] $fieldDeclaration The field declaration.
     * @param AbstractPlatform $platform The currently used database platform.
     *
     * @return string
     */
    public function getSQLDeclaration(array $fieldDeclaration, AbstractPlatform $platform) {
        return $platform->getVarcharTypeDeclarationSQL(['length' => 255]);
    }

    /**
     * @param AbstractPlatform $platform
     * @return bool
     */
    public function requiresSQLCommentHint(AbstractPlatform $platform) {
        return true;
    }

    /**
     * @param mixed $value
     * @param AbstractPlatform $platform
     * @return mixed|null
     * @throws ConversionException
     */
    public function convertToDatabaseValue($value, AbstractPlatform $platform) {
        $type = $this->getSupportedEnumType();
        if (is_null($value)) {
            return null;
        } else if ($value instanceof $type) {
            return $value->toString();
        } else {
            throw ConversionException::conversionFailedInvalidType($value, $this->getName(), [$this->getSupportedEnumType()]);
        }

    }

    /**
     * @param mixed $value
     * @param AbstractPlatform $platform
     * @return mixed|null
     * @throws ConversionException
     */
    public function convertToPHPValue($value, AbstractPlatform $platform) {
        $type = $this->getSupportedEnumType();
        if (is_null($value)) {
            return null;
        } else if (is_string($value)) {
            try {
                return ($type . '::valueOf')($value);
            } catch (InvalidArgumentException $invalidArgumentException) {
                throw ConversionException::conversionFailed($value, $this->getName());
            }
        } else if ($value instanceof $type) {
            return $value;
        } else {
            throw ConversionException::conversionFailedInvalidType($value, $this->getName(), ['string']);
        }
    }

    /**
     * @return string
     */
    abstract protected function getSupportedEnumType() : string;
}