<?php

namespace Pada\Tinkoff\Payment\Normalizer;

use Pada\Tinkoff\Payment\Contract\CheckOrderInterface;
use Pada\Tinkoff\Payment\Model\CheckOrder\CheckOrderResult;
use Pada\Tinkoff\Payment\Model\CheckOrder\Payment;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

final class CheckOrderNormalizer implements NormalizerInterface, DenormalizerInterface
{
    public function normalize(mixed $object, string $format = null, array $context = []): float|int|bool|\ArrayObject|array|string|null
    {
        /** @var CheckOrderInterface $checkOrder */
        $checkOrder = $object;

        return [
            'TerminalKey' => $checkOrder->getTerminalKey(),
            'Token' => $checkOrder->getToken(),
            'OrderId' => $checkOrder->getOrderId(),
        ];
    }

    public function supportsNormalization(mixed $data, $format = null, array $context = []): bool
    {
        return $data instanceof CheckOrderInterface;
    }

    /**
     * @ret CheckOrderResult
     */
    public function denormalize(mixed $data, string $type, string $format = null, array $context = []): mixed
    {
        $checkOrderResponse = new CheckOrderResult();

        $checkOrderResponse->setOrderId($data['OrderId'] ?? '');
        $checkOrderResponse->setSuccess($data['Success'] ?? false);
        $checkOrderResponse->setErrorCode($data['ErrorCode'] ?? '-999');
        $checkOrderResponse->setMessage($data['Message'] ?? null);
        $checkOrderResponse->setDetails($data['Details'] ?? null);

        $dataPayments = $data['Payments'] ?? [];
        $payments = [];
        foreach ($dataPayments as $dataPayment) {
            $payment = new Payment();
            $payment->setPaymentId($dataPayment['PaymentId'] ?? -1);
            $payment->setAmount($dataPayment['Amount'] ?? null);
            $payment->setStatus($dataPayment['Status'] ?? '');
            $payment->setRRN($dataPayment['RRN'] ?? null);
            $payment->setSuccess($dataPayment['Success'] ?? 'false');
            $payment->setErrorCode($dataPayment['ErrorCode'] ?? '-999');
            $payment->setMessage($dataPayment['Message'] ?? '');
            $payments[] = $payment;
        }
        $checkOrderResponse->setPayments($payments);

        return $checkOrderResponse;
    }

    public function supportsDenormalization(mixed $data, string $type, string $format = null, array $context = []): bool
    {
        return CheckOrderResult::class === $type;
    }

    public function getSupportedTypes(?string $format): array
    {
        // TODO: Implement getSupportedTypes() method.
    }
}
