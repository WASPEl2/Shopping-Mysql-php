<?php

function getTotalSales($conn) {
    try {
        $stmt = $conn->prepare("SELECT SUM(price * quantity) AS total_sales FROM details LEFT JOIN products ON products.id=details.product_id");
        $stmt->execute();
        $row = $stmt->fetch();
        return $row['total_sales'] ?? 0;
    } catch (PDOException $e) {
        return 0;
    }
}

function getNumberOfProducts($conn) {
    try {
        $stmt = $conn->prepare("SELECT COUNT(*) AS num_products FROM products");
        $stmt->execute();
        $row = $stmt->fetch();
        return $row['num_products'] ?? 0;
    } catch (PDOException $e) {
        return 0;
    }
}

function getNumberOfUsers($conn) {
    try {
        $stmt = $conn->prepare("SELECT COUNT(*) AS num_users FROM users");
        $stmt->execute();
        $row = $stmt->fetch();
        return $row['num_users'] ?? 0;
    } catch (PDOException $e) {
        return 0;
    }
}

function getSalesToday($conn) {
    try {
        $today = date('Y-m-d');
        $stmt = $conn->prepare("SELECT SUM(price * quantity) AS total_sales FROM details LEFT JOIN sales ON sales.id=details.sales_id LEFT JOIN products ON products.id=details.product_id WHERE sales_date=:today");
        $stmt->execute(['today' => $today]);
        $row = $stmt->fetch();
        return $row['total_sales'] ?? 0;
    } catch (PDOException $e) {
        return 0;
    }
}

function getDailySales($conn ,$select_days) {
    try {
        $dailySales = array();
        $totalSales = 0;
        $numSales = 0;
        
        for ($i = 0; $i < $select_days; $i++) {
            $date = date('Y-m-d', strtotime("-$i days"));
            $stmt = $conn->prepare("SELECT SUM(price * quantity) AS total_sales, COUNT(*) AS num_sales FROM details LEFT JOIN sales ON sales.id=details.sales_id LEFT JOIN products ON products.id=details.product_id WHERE sales_date=:date ORDER BY sales_date desc");
            $stmt->execute(['date' => $date]);
            $row = $stmt->fetch();
            $totalSales += $row['total_sales'];
            $numSales += $row['num_sales'];
            $dailySales[$date] = $row['total_sales'];
        }
        
        return array('total' => $totalSales, 'count' => $numSales, 'daily_sales' => $dailySales);
    } catch (PDOException $e) {
        return false;
    }
}


?>
