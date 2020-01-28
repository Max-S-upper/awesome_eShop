<?php


namespace application\controllers;

use application\models\BoughtProductAttribute;
use application\models\Order;
use application\models\User;
use application\models\UserOrder;

class OrderController
{
    public function order()
    {
        $phoneNumber = array_key_exists('phoneNumber', $_POST) ? $_POST['phoneNumber'] : '';
        $userId = array_key_exists('userId', $_POST) ? $_POST['userId'] : '';
        $productId = array_key_exists('productId', $_POST) ? $_POST['productId'] : '';
        $quantity = array_key_exists('quantity', $_POST) ? $_POST['quantity'] : '';
        $attributes = array_key_exists('attributes', $_POST) ? $_POST['attributes'] : '';
        $price = array_key_exists('price', $_POST) ? $_POST['price'] : '';
        $note = array_key_exists('note', $_POST) ? $_POST['note'] : '';
        if ($phoneNumber) {
            $user = new User();
            $user->id = $userId;
            $user->phone = $phoneNumber;
            $user->save();
        }

        $userOrder = new UserOrder();
        $userOrder->user_id = $userId;
        $userOrder->note = $note;
        $userOrder->save();

        $orderId = $userOrder->getLastIdByUserId($userId);
        $order = new Order();
        $order->productId = $productId;
        $order->orderId = $orderId;
        $order->quantity = $quantity;
        $order->price = $price;
        $testData = $order->save();

        foreach ($attributes as $attributeId) {
            $boughtProductAttribute = new BoughtProductAttribute();
            $boughtProductAttribute->product_id = $productId;
            $boughtProductAttribute->attribute_id = $attributeId;
            $boughtProductAttribute->order_id = $orderId;
            $boughtProductAttribute->save();
        }
    }
}