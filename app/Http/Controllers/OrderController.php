<?php

namespace App\Http\Controllers;

use App\Mail\NewOrderMail;
use App\Mail\OrderResponseMail;
use App\Mail\OrderSummaryMail;
use App\Order;
use App\User;
use App\OrderItem;
use App\Payment;
use App\PaymentManager;
use App\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class OrderController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, User $user = null)
    {
        $message = $request->query('message', false);
        if ($user) {
            $orders = $user->orders;
        } else {
            $orders = Order::latest()->get();
        }
        return view('admin.order.index', compact('orders', 'message'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $orderItems = $request->products;
        if ($orderItems) {
            $requestedProducts = Product::whereIn('id', array_keys($orderItems))->get();
        } else {
            $requestedProducts = Product::where('id', -1)->get();
        }
        $notInStockProducts = [];
        $productCount = [];
        $productSum = [];
        $totalSum = 0;

        $vipCount = 0;
        $nvipCount = 0;
        $productDeleted = false;

        foreach ($requestedProducts as $product) {
            if ($product->is_vip) {
                $vipCount++;
            } else {
                $nvipCount++;
            }
            $id = $product->id;
            if ($product->stock < $orderItems[$id]) {
                $notInStockProducts[] = $product;
                $productCount[$id] = $product->stock;
            } else {
                $productCount[$id] = $orderItems[$id];
            }
        }
        $isVip = false;
        if ($vipCount) {
            $vip = Auth::check() && Auth::user()->vip;
            $beforeCount = $requestedProducts->count();
            $requestedProducts = $requestedProducts->filter(function ($product) use ($vip, $nvipCount) {
                $productIsVip = $product->is_vip;
                if ($vip) {
                    if ($nvipCount) {
                        return $productIsVip;
                    }
                    return true;
                } else {
                    return !$productIsVip;
                }
            });
            if ($beforeCount != $requestedProducts->count()) {
                $productDeleted = true;
            }
            if ($vip) {
                $isVip = true;
            }
        }
        foreach ($requestedProducts as $product) {
            $prodSum = ($productCount[$id] * (float) str_replace(',', '.', $product->price));
            $productSum[$product->id] = $prodSum;
            $totalSum += $prodSum;
        }

        return view('checkout', ['user' => (Auth::check() ? Auth::user() : null), 'products' => $requestedProducts, 'productCount' => $productCount, 'productSum' => $productSum, 'notInStock' => $notInStockProducts, 'totalSum' => $totalSum, 'isVip' => $isVip, 'productDeleted' => $productDeleted]);
        // nechytat!!! bo ce zahlusim
        // fragile, ^ this way up
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (!($request->has('products') && $request->products)) {
            abort(404);
        }
        $user = (Auth::check() && Auth::user()) ? Auth::user() : null;
        if ($user) {
            $userId = $user->id;
            $user->name = $request->name;
            $user->email = $request->email;
            $user->address = $request->address;
            $user->phone = $request->phone;
            $user->gdpr = $request->gdpr;
            $user->save();
        } else {
            $userId = null;
        }
        $order = new Order([
            'user_id' => $userId,
            'address' => $request->address,
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'note' => $request->note,
            'card' => $request->card,
            'delivery' => $request->delivery
        ]);
        $order->save();
        foreach ($request->products as $id => $count) {
            if ($count > 0) {
                $orderItem = new OrderItem([
                    'order_id' => $order->id,
                    'product_id' => $id,
                    'count' => $count,
                    ]);
                    $orderItem->save();
                }
        }
        if ($order->card) {
            $paySum = 0;
            if ($order->is_vip) {
                $paySum = $request->pay_sum;
            } else {
                $paySum = $order->sum;
            }
            $paySum = preg_replace('/\s+/', '', $paySum);
            $paySum = str_replace(',', '.', $paySum);
            if (substr_count($paySum, '.') > 1) {
                abort(404);
            }
            $paySum = number_format($paySum, 2, '.', '');
            if (!$paySum) {
                abort(404);
            }
            return redirect()->route('orders.pay', ['order' => $order])->with('pay_sum', $paySum);
        } else {
            return $this->payOrder($order);
        }
    }

    public function pay(Request $request, Order $order, PaymentManager $paymentManager)
    {
        if ($order->paid) {
            return view('order-pay', ['alreadyPaid' => true]);
        }
        $sum = 0;
        if ($request->has('pay_sum')) {
            $sum = $request->pay_sum;
        } else {
            $sum = session('pay_sum');
        }
        if (!$sum) {
            abort(404);
        }
        if (($order->paid_sum + $sum) > $order->sum) {
            return view('order-pay', ['sumTooHigh' => true]);
        }
        $payment = $order->payments()->create([
            'sum' => $sum
        ]);
        $form = $paymentManager->getPaymentForm($payment);

        return view('order-pay', ['form' => $form]);
    }

    public function tryAgain(Payment $payment, PaymentManager $paymentManager)
    {
        $form = $paymentManager->getPaymentForm($payment, false);
        return view('order-error', ['form' => $form]);
    }

    public function success(Request $request, PaymentManager $paymentManager)
    {
        return $this->paymentResponse($request, $paymentManager);
    }

    public function error(Request $request, PaymentManager $paymentManager)
    {
        return $this->paymentResponse($request, $paymentManager);
    }

    private function paymentResponse(Request $request, PaymentManager $paymentManager)
    {
        $post = $request->all();
        $payment = Payment::findOrFail($post['oid']);
        if ($paymentManager->validatePost($payment, $post)) {
            $payment->paid = true;
            $payment->save();
            return $this->payOrder($payment->order);
        } else {
            return redirect()->route('orders.error', ['payment' => $payment]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function show(Order $order)
    {
        return view('admin.order.show', ['order' => $order]);
    }

    public function processDisplay(Order $order)
    {
        if ($order->process) {
            return redirect()->route('orders.index');
        }
        return view('admin.order.process', ['order' => $order]);
    }

    public function process(Request $request, Order $order)
    {
        $process = 0;
        $process = $request->process;
        $order->process = $process;
        $order->save();
        Mail::to($order->email)->send(new OrderResponseMail($order, $request->response));
        return redirect()->route('orders.index', ['message' => $process]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function destroy(Order $order)
    {
        $order->delete();
        return redirect()->route('orders.index');
    }

    private function payOrder(Order $order)
    {
        if (!$order->reserved_products) {
            foreach ($order->items as $item) {
                $count = $item->count;
                $item->product->stock -= $count;
                $item->product->save();
            }
            $order->reserved_products = true;
            $order->save();
        }
        Mail::to($order->email)->send(new OrderSummaryMail($order));
        Mail::to(env('MAIL_USERNAME', 'obchod@dobry-chlast.sk'))->send(new NewOrderMail($order));
        return redirect()->route('orders.success');
    }
}
