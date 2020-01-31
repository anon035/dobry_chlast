<?php

namespace App\Mail;

use App\Order;
use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class OrderResponseMail extends Mailable
{
    use Queueable, SerializesModels;

    public $order;

    public $response;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Order $order, $response)
    {
        $this->order = $order;
        $this->response = $response;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        if ($this->order->process == 1) {
            $subject = 'Your order was accepted';
            $view = 'mail.order.response.accept';
        } elseif ($this->order->process == 2) {
            $subject = 'Your order was declined';
            $view = 'mail.order.response.decline';
        } else {
            abort(500);
        }
        return $this
            ->subject($subject)
            ->view($view);
    }
}
