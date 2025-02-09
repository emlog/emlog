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
    private $app_name;

    function __construct($app_name)
    {
        $this->app_name = $app_name;
        $this->db = Database::getInstance();
        $this->table = DB_PREFIX . 'order';
    }

    function generateOrderNumber()
    {
        $microtime = microtime(true);
        $timestamp = str_replace('.', '', $microtime);
        $randomNumber = em_rand(100000, 999999);
        $orderNumber = $timestamp . $randomNumber;
        return $orderNumber;
    }

    function createOrder($uid, $pay_type, $sku_name, $sku_id, $price)
    {
        $order_id = $this->generateOrderNumber();
        $data = [
            'app_name' => $this->app_name,
            'order_id' => $order_id,
            'order_uid' => $uid,
            'pay_type' => $pay_type,
            'sku_name' => $sku_name,
            'sku_id' => $sku_id,
            'price' => $price,
            'update_time' => time(),
            'create_time' => time()
        ];
        $fields = implode(',', array_keys($data));
        $values = "'" . implode("','", array_map('addslashes', $data)) . "'";
        $sql = sprintf(
            "INSERT INTO `%s` (%s) VALUES (%s)",
            $this->table,
            $fields,
            $values
        );
        $this->db->query($sql);
        return $order_id;
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
        return $this->db->affected_rows() > 0;
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

    /**
     * 获取全部订单列表
     * @param int $page
     * @param int $perpage
     * @return array
     */
    function getOrders($page = 1, $perpage = 10)
    {
        $page = (int)$page;
        $perpage = (int)$perpage;

        $offset = ($page - 1) * $perpage;
        $sql = sprintf(
            "SELECT * FROM `%s` ORDER BY create_time DESC LIMIT %d OFFSET %d",
            $this->table,
            $perpage,
            (int)$offset
        );
        $result = $this->db->query($sql);
        $orders = [];
        while ($row = $this->db->fetch_array($result)) {
            $orders[] = $this->formatOrder($row);
        }
        return $orders;
    }

    /**
     * 获取当前应用的订单列表
     * @param int $page 页码
     * @param int $perpage 每页的订单数量
     * @return array 订单列表
     */
    function getAppOrders($page = 1, $perpage = 10)
    {
        $page = (int)$page;
        $perpage = (int)$perpage;

        $where = "WHERE app_name='$this->app_name'";
        $offset = ($page - 1) * $perpage;
        $sql = sprintf(
            "SELECT * FROM `%s` %s ORDER BY create_time DESC LIMIT %d OFFSET %d",
            $this->table,
            $where,
            (int)$perpage,
            (int)$offset
        );
        $result = $this->db->query($sql);
        $orders = [];
        while ($row = $this->db->fetch_array($result)) {
            $orders[] = $this->formatOrder($row);
        }
        return $orders;
    }

    /**
     * 根据用户ID获取订单列表
     * @param int $userId 用户ID
     * @param int $page 页码
     * @param int $perpage 每页的订单数量
     * @param bool $isPaid 是否只获取已经支付的订单
     * @param string $sku_name 是否只获取某个商品的订单
     * @return array 订单列表
     */
    function getOrdersByUserId($userId, $page = 1, $perpage = 10, $isPaid = false, $sku_name = '')
    {
        $userId = (int)$userId;
        $page = (int)$page;
        $perpage = (int)$perpage;

        $where = "WHERE order_uid=$userId AND app_name='$this->app_name'";
        if ($isPaid) {
            $where .= " AND pay_price > 0";
        }
        if ($sku_name) {
            $where .= " AND sku_name = '$sku_name'";
        }
        $offset = ($page - 1) * $perpage;
        $sql = sprintf(
            "SELECT * FROM `%s` %s ORDER BY create_time DESC LIMIT %d OFFSET %d",
            $this->table,
            $where,
            (int)$perpage,
            (int)$offset
        );
        $result = $this->db->query($sql);
        $orders = [];
        while ($row = $this->db->fetch_array($result)) {
            $orders[] = $this->formatOrder($row);
        }
        return $orders;
    }

    function isOrderPaid($orderId)
    {
        $order = $this->getOrderById($orderId);
        return $order && $order['pay_price'] >= $order['price'];
    }

    function hasPurchasedSku($userId, $skuId, $skuName = '')
    {
        $userId = (int)$userId;
        $skuId = (int)$skuId;

        $sql = sprintf(
            "SELECT COUNT(*) AS total FROM `%s` WHERE order_uid=%d AND sku_id=%d AND pay_price >= price",
            $this->table,
            $userId,
            $skuId
        );

        if (!empty($skuName)) {
            $skuName = addslashes($skuName);
            $sql .= sprintf(" AND sku_name='%s'", $skuName);
        }

        $result = $this->db->once_fetch_array($sql);
        return (int)$result['total'] > 0;
    }

    private function formatOrder($order)
    {
        $order['id'] = (int)$order['id'];
        $order['order_uid'] = (int)$order['order_uid'];
        $order['sku_id'] = (int)$order['sku_id'];
        $order['price'] = (float)$order['price'];
        $order['pay_price'] = (float)$order['pay_price'];
        $order['refund_amount'] = (float)$order['refund_amount'];
        $order['update_timestamp'] = $order['update_time'];
        $order['create_timestamp'] = $order['create_time'];
        $order['update_time'] = date('Y-m-d H:i:s', $order['update_time']);
        $order['create_time'] = date('Y-m-d H:i:s', $order['create_time']);
        $order['out_trade_no'] = (string)$order['out_trade_no'];
        $order['pay_type'] = (string)$order['pay_type'];
        $order['sku_name'] = (string)$order['sku_name'];
        return $order;
    }
}
