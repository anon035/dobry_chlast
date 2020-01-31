<?php

namespace App;

use Throwable;
use VubEcard\VubEcard;
use VubEcard\VubException;

class PaymentManager
{
    /**
     * @var VubEcard $eCard
     */
    private $eCard;

    public function __construct()
    {
        $this->eCard = new VubEcard('', '');
        $this->eCard->setCallbackUrlSuccesfull(route('pay.success', [], true));
        $this->eCard->setCallbackUrlError(route('pay.error', [], true));
    }

    public function getPaymentForm(Payment $payment, $display = true)
    {
        $this->eCard->setOrderDetails($payment->id, $payment->sum);
        $form = $this->eCard->generateForm('order-pay', [
            'BillToName' => $payment->order->name,
            'BillToCity' => $payment->order->address,
            'email' => $payment->order->email,
            'tel' => $payment->order->phone,
            'lang' => 'en',
        ], [
            'name' => 'order-pay',
            'style' => ($display ? '' : 'display: none;'),
        ], [
            'value' => 'Pay',
            'class' => 'pay-form-btn',
        ]);

        return $form;
    }

    public function validatePost(Payment $payment, $post)
    {
        try {
            if ($invalidText = $this->isInvalidPayment($payment, $post)) {
                $this->throwError($payment->id, $post, $invalidText);
            }
            if (!$this->eCard->validateResponse($post)) {
                $this->throwError($payment->id, $post);
            }
        } catch (VubException $e) {
            $this->logException($e);
            return false;
        }

        return true;
    }

    private function isInvalidPayment(Payment $payment, $post)
    {
        $invalidText = '';

        if (abs($payment->sum - $post['amount']) > 0.001) {
            $invalidText = 'Paid amount isn\'t correct';
        }

        return $invalidText;
    }

    private function throwError($paymentId, $data, $errorText = '')
    {
        if (!$errorText) {
            $errorText = 'Invalid response';
        }
        $dumpedData = print_r($data, true);
        throw new VubException('PaymentId: ' . $paymentId . ' - ' . $errorText . ', data: ' . $dumpedData);
    }

    private function logException($e)
    {
        $filename = base_path('storage/logs/vub/' . date('Y-m-d_H-i-s') . '_error_log.txt');
        echo $e->getMessage();
        return file_put_contents($filename, $e->getMessage());
    }
}
