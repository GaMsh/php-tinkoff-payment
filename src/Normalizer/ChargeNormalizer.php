<?php

namespace Pada\Tinkoff\Payment\Normalizer;

use Pada\Tinkoff\Payment\Contract\ChargeInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

final class ChargeNormalizer implements NormalizerInterface
{
    public function normalize(mixed $object, string $format = null, array $context = []): float|int|bool|\ArrayObject|array|string|null
    {
        /** @var ChargeInterface $charge */
        $charge = $object;

        $data = [
            'TerminalKey' => $charge->getTerminalKey(),
            'Token' => $charge->getToken(),
            'PaymentId' => $charge->getPaymentId(),
            'RebillId' => $charge->getRebillId(),
        ];

        if (null !== $charge->getSendEmail()) {
            $data['SendEmail'] = $charge->getSendEmail();
            $data['InfoEmail'] = $charge->getInfoEmail();
        }

        if (null !== $charge->getIp()) {
            $data['Ip'] = $charge->getIp();
        }

        return $data;
    }

    public function supportsNormalization(mixed $data, string $format = null, array $context = []): bool
    {
        return $data instanceof ChargeInterface;
    }

    public function getSupportedTypes(?string $format): array
    {
        // TODO: Implement getSupportedTypes() method.
    }
}
