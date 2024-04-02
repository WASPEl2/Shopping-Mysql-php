<?php
include 'includes/conn.php';
$conn = $pdo->open();

function getPdfGenerateValues($id, $conn)
{
    $stmt = $conn->prepare("SELECT * FROM sales LEFT JOIN users  ON sales.user_id=users.id WHERE sales.id=:id");
    $stmt->execute(['id' => $id]);
    $row = $stmt->fetch();
    return $row;
}

function getOrderItems($order_id,$sale_id, $conn)
{
    $stmt = $conn->prepare("SELECT *,details.id AS prodid, products.name AS prodname FROM details LEFT JOIN products ON products.id=details.product_id LEFT JOIN sales  ON sales.id=details.sales_id  WHERE user_id=:id AND sales.id=:sale_id");
    $stmt->execute(['id' => $order_id, 'sale_id'=>$sale_id]);
    $rows = $stmt->fetchAll();
    return $rows;
}

$result = getPdfGenerateValues($_GET["id"], $conn);
$orderItemResult = getOrderItems($result["user_id"],$_GET["id"], $conn);

if (! empty($result)) {
    
    require_once __DIR__ . "/includes/PDFService.php";
    $pdfService = new PDFService();
    $pdfService->generatePDF($result, $orderItemResult);
}

?>