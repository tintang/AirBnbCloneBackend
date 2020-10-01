<?php /** @noinspection PhpComposerExtensionStubsInspection */


namespace App\Serializer;


use App\Adapter\SetCurrentUserInterface;
use Symfony\Component\Serializer\Normalizer\ContextAwareNormalizerInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerAwareInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerAwareTrait;

class SetUserNormalizer implements NormalizerAwareInterface, ContextAwareNormalizerInterface
{

    use NormalizerAwareTrait;

    public function supportsNormalization($data, string $format = null, array $context = [])
    {
        if (isset($context[md5(json_encode($data))])) {
            return false;
        }

        return $data instanceof SetCurrentUserInterface;
    }

    public function normalize($object, string $format = null, array $context = [])
    {
        $context[md5(json_encode($object))] = true;

        $data = $this->normalizer->normalize($object, $format, $context);
        unset($data['user']);
        return $data;
        
    }
}