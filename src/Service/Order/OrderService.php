<?php 
namespace App\Service\Order;


class OrderService 
{
    const STATUS_WAITING = 0;
    const STATUS_DELIVERY = 1;
    const STATUS_FINISHED = 2;
    const STATUS_REFUND = 3;
}