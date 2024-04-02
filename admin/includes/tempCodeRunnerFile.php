<?php
function getSalesToday($conn) {
    try {
        $today = date('Y-m-d');
        $stmt = $conn->prepare("SELECT SUM(price * quantity) AS total_sales FROM details LEFT JOIN sales ON sales.id=details.sales_id LEFT JOIN products ON products.id=details.product_id WHERE sales_date=:sales_date");
        $stmt->execute(['today' => $today]);
        $row = $stmt->fetch();
        return $row['total_sales'] ?? 0;
                
    } catch (PDOException $e) {
        return 0;
    }
}