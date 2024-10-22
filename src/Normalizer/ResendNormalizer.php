<?php

namespace Pada\Tinkoff\Payment\Normalizer;

use Pada\Tinkoff\Payment\Model\Resend\Resend;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

final class ResendNormalizer implements NormalizerInterface
{
    public function normalize(mixed $object, ?string $format = null, array $context = []): array|string|int|float|bool|\ArrayObject|null
    {
        /** @var Resend $resend */
        $resend = $object;
        return [
            'TerminalKey' => $resend->getTerminalKey(),
            'Token' => $resend->getToken(),
        ];
    }

    public function supportsNormalization(mixed $data, ?string $format = null, array $context = []): bool
    {
        return $data instanceof Resend;
    }

    public function getSupportedTypes(?string $format): array
    {
        return [
            Resend::class => true,
        ];
    }
}
