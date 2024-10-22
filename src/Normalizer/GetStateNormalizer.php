<?php

namespace Pada\Tinkoff\Payment\Normalizer;

use Pada\Tinkoff\Payment\Contract\GetStateInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

final class GetStateNormalizer implements NormalizerInterface
{
    use SetterTrait;

    public function normalize(mixed $object, string $format = null, array $context = []): float|int|bool|\ArrayObject|array|string|null
    {
        /** @var GetStateInterface $state */
        $state = $object;

        $data = [
            'TerminalKey' => $state->getTerminalKey(),
            'Token' => $state->getToken(),
            'PaymentId' => $state->getPaymentId(),
        ];

        $this->setIfNotNull('IP', $state->getIp(), $data);

        return $data;
    }

    public function supportsNormalization(mixed $data, string $format = null, array $context = []): bool
    {
        return $data instanceof GetStateInterface;
    }

    public function getSupportedTypes(?string $format): array
    {
        // TODO: Implement getSupportedTypes() method.
    }
}
