<?php


namespace App\Serializer;


use Ramsey\Uuid\UuidInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class UuidNormalizer implements NormalizerInterface
{
    /**
     * @inheritdoc
     */
    public function normalize($object, string $format = null, array $context = [])
    {
        return $object->toString();
    }

    /**
     * @inheritdoc
     */
    public function supportsNormalization($data, string $format = null)
    {
        return $data instanceof UuidInterface;
    }
}
