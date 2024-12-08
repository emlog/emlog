<?php

/**
 * Order model
 * @package EMLOG
 * @link https://www.emlog.net
 */

class Order_Model
{

    private $db;
    private $table;

    function __construct()
    {
        $this->db = Database::getInstance();
        $this->table = DB_PREFIX . 'order';
    }

    function getOrderById($orderId)
    {
        $orderId = addslashes($orderId);
        $sql = sprintf(
            "SELECT * FROM `%s` WHERE order_id='%s'",
            $this->table,
            $orderId
        );
        $order = $this->db->once_fetch_array($sql);
        return $order ? $this->formatOrder($order) : null;
    }

    function getOrdersByUserId($userId, $limit = 10, $offset = 0)
    {
        $userId = (int)$userId;
        $sql = sprintf(
            "SELECT * FROM `%s` WHERE order_uid=%d ORDER BY create_time DESC LIMIT %d OFFSET %d",
            $this->table,
            $userId,
            (int)$limit,
            (int)$offset
        );
        $result = $this->db->query($sql);
        $orders = [];
        while ($row = $this->db->fetch_array($result)) {
            $orders[] = $this->formatOrder($row);
        }
        return $orders;
    }

    function createOrder($data)
    {
        $fields = [
            'app_name',
            'order_id',
            'order_uid',
            'out_trade_no',
            'pay_type',
            'sku_name',
            'sku_id',
            'price',
            'pay_price',
            'refund_amount',
            'update_time',
            'create_time'
        ];
        $values = array_map('addslashes', [
            $data['app_name'],
            $data['order_id'],
            $data['order_uid'],
            $data['out_trade_no'],
            $data['pay_type'],
            $data['sku_name'],
            $data['sku_id'],
            $data['price'],
            $data['pay_price'],
            $data['refund_amount'],
            time(),
            time()
        ]);
        $sql = sprintf(
            "INSERT INTO `%s` (%s) VALUES ('%s')",
            $this->table,
            implode(',', $fields),
            implode("','", $values)
        );
        $this->db->query($sql);
        return $this->db->insert_id();
    }

    function updateOrder($orderId, $data)
    {
        $orderId = addslashes($orderId);
        $updates = [];
        foreach ($data as $key => $value) {
            $updates[] = sprintf("%s='%s'", $key, addslashes($value));
        }
        $updates[] = "update_time=" . time();
        $sql = sprintf(
            "UPDATE `%s` SET %s WHERE order_id='%s'",
            $this->table,
            implode(',', $updates),
            $orderId
        );
        $this->db->query($sql);
        return $this->db->affected_rows();
    }

    function deleteOrder($orderId)
    {
        $orderId = addslashes($orderId);
        $sql = sprintf("DELETE FROM `%s` WHERE order_id='%s'", $this->table, $orderId);
        $this->db->query($sql);
        return $this->db->affected_rows();
    }

    function isOrderPaid($orderId)
    {
        $order = $this->getOrderById($orderId);
        return $order && $order['pay_price'] >= $order['price'];
    }

    private function formatOrder($order)
    {
        $order['id'] = (int)$order['id'];
        $order['order_uid'] = (int)$order['order_uid'];
        $order['sku_id'] = (int)$order['sku_id'];
        $order['price'] = (float)$order['price'];
        $order['pay_price'] = (float)$order['pay_price'];
        $order['refund_amount'] = (float)$order['refund_amount'];
        $order['update_time'] = date('Y-m-d H:i:s', $order['update_time']);
        $order['create_time'] = date('Y-m-d H:i:s', $order['create_time']);
        return $order;
    }
}
