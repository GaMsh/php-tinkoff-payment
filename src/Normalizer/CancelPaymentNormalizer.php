<?php

namespace Pada\Tinkoff\Payment\Normalizer;

use Pada\Tinkoff\Payment\Contract\CancelInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

final class CancelPaymentNormalizer implements NormalizerInterface
{
    use SetterTrait;
    use ReceiptNormalizerTrait;

    public function normalize(mixed $object, ?string $format = null, array $context = []): array|string|int|float|bool|\ArrayObject|null
    {
        /** @var CancelInterface $cancelPayment */
        $cancelPayment = $object;

        $data = [
            'TerminalKey' => $cancelPayment->getTerminalKey(),
            'Token' => $cancelPayment->getToken(),
            'PaymentId' => $cancelPayment->getPaymentId(),
        ];

        $this->setIfNotNull('IP', $cancelPayment->getIp(), $data);
        $this->setIfNotNull('Amount', $cancelPayment->getAmount(), $data);
        $this->setIfNotNull('Receipt', function () use ($cancelPayment) {
            if (null === $cancelPayment->getReceipt()) {
                return null;
            }
            return $this->normalizeReceipt($cancelPayment->getReceipt());
        }, $data);

        return $data;
    }

    public function supportsNormalization(mixed $data, ?string $format = null, array $context = []): bool
    {
        return $data instanceof CancelInterface;
    }

    public function getSupportedTypes(?string $format): array
    {
        return [
            CancelInterface::class => true,
        ];
    }
}
