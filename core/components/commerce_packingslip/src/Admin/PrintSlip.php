<?php


namespace modmore\Commerce\PackingSlip\Admin;

use modmore\Commerce\Admin\Page;
use modmore\Commerce\Events\Admin\OrderItemDetail;

class PrintSlip extends Page {
    public $key = 'packingslip/print_slip';
    public $title = 'commerce_packingslip.print_slip';

    public function setUp()
    {
        $id = (int)$this->getOption('shipment');
        $c = $this->adapter->newQuery('comOrderShipment');
        $c->innerJoin('comOrder', 'Order');
        $c->where([
            'comOrderShipment.id' => $id,
            'Order.test' => $this->commerce->isTestMode(),
        ]);
        $shipment = $this->adapter->getObject('comOrderShipment', $c);

        if (!($shipment instanceof \comOrderShipment)) {
            return $this->returnError('Shipment not found');
        }

        $order = $shipment->getOrder();
        if (!$order) {
            return $this->returnError('Order not found for shipment');
        }

        $deliveryType = $shipment->getDeliveryType();
        if (!$deliveryType) {
            return $this->returnError('Delivery type not found for shipment');
        }

        $shippingMethod = $shipment->getShippingMethod(false);
        if (!$shippingMethod) {
            return $this->returnError('Shipping method nto found for shipment');
        }

        $preppedItems = [];
        $items = $shipment->getItems();
        foreach ($items as $item) {
            $ta = $item->toArray();
            $ta['extra'] = '';

            if ($product = $item->getProduct()) {
                $ta['product'] = $product->toArray();
                $ta['extra'] .= $product->getOrderDetailRow($item);
            }

            /** @var OrderItemDetail $event */
            $event = $this->commerce->dispatcher->dispatch(\Commerce::EVENT_DASHBOARD_ORDER_ITEM_DETAIL, new OrderItemDetail($item));
            foreach ($event->getRows() as $row) {
                $ta['extra'] .= $row;
            }

            $preppedItems[] = $ta;
        }

        $preppedTransactions = [];
        $transactions = $order->getTransactions();
        foreach ((array) $transactions as $transaction) {
            $preppedTransactions[] = $transaction->toArray();
        }

        $phs = [
            'shipment' => $shipment->toArray(),
            'order' => $order->toArray(),
            'delivery_type' => $deliveryType->toArray(),
            'shipping_method' => $shippingMethod->toArray(),
            'weight' => (string)$shipment->getWeight(),
            'shipping' => $order->getShippingAddress()->toArray(),
            'billing' => $order->getBillingAddress()->toArray(),
            'items' => $preppedItems,
            'transactions' => $preppedTransactions,

            'site_name' => $this->commerce->getOption('site_name'),
        ];


        echo $this->commerce->twig->render('packingslip/standard.twig', $phs);

        @session_write_close();
        exit();
    }
}
