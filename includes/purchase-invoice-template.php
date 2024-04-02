<?php
function getHTMLPurchaseDataToPDF($result, $orderItemResult, $orderedDate, $due_date)
{
ob_start();

?>
<html>
<head>Receipt of Purchase - <?php  echo $result["id"] . $result["user_id"]; ?>
</head>
<body>
    <div style="text-align:right;">
        <b>Sender:</b> SamShop
    </div>
    <div style="text-align: left;border-top:1px solid #000;">
        <div style="font-size: 24px;color: #666;">INVOICE</div>
    </div>
    <table style="line-height: 1.5;">
        <tr><td><b>Invoice:</b> #<?php echo $result["id"] . $result["user_id"];; ?>
            </td>
            <td style="text-align:right;"><b>Receiver:</b></td>
        </tr>
        <tr>
            <td><b>Date:</b> <?php echo $orderedDate; ?></td>
            <td style="text-align:right;"><?php echo $result["firstname"] . ' ' . $result["lastname"]; ?></td>
        </tr>
        <tr>
            <td><b>Payment Due:</b><?php echo $due_date; ?>
            </td>
            <td style="text-align:right;"><?php echo $result["contact_info"]; ?></td>
        </tr>
    <tr>
    <td></td>
    <td style="text-align:right;"><?php echo $result["address"]; ?></td>
    </tr>
    </table>

<div></div>
    <div style="border-bottom:1px solid #000;">
        <table style="line-height: 2;">
            <tr style="font-weight: bold;border:1px solid #cccccc;background-color:#f2f2f2;">
                <td style="border:1px solid #cccccc;width:200px;">Item Description</td>
                <td style = "text-align:right;border:1px solid #cccccc;width:85px">Price ($)</td>
                <td style = "text-align:right;border:1px solid #cccccc;width:75px;">Quantity</td>
                <td style = "text-align:right;border:1px solid #cccccc;">Subtotal ($)</td>
            </tr>
<?php
$total = 0;

foreach ($orderItemResult as $k => $v) {
    $price = $orderItemResult[$k]["price"] * $orderItemResult[$k]["quantity"];
    $total += $price;
    ?>
    <tr> <td style="border:1px solid #cccccc;"><?php echo $orderItemResult[$k]["prodname"]; ?></td>
                    <td style = "text-align:right; border:1px solid #cccccc;"><?php echo number_format($orderItemResult[$k]["price"], 2); ?></td>
                    <td style = "text-align:right; border:1px solid #cccccc;"><?php echo $orderItemResult[$k]["quantity"]; ?></td>
                    <td style = "text-align:right; border:1px solid #cccccc;"><?php echo number_format($price, 2); ?></td>
               </tr>
<?php
}
?>
<tr style = "font-weight: bold;">
    <td></td><td></td>
    <td style = "text-align:right;">Total ($)</td>
    <td style = "text-align:right;"><?php echo number_format($total, 2); ?></td>
</tr>
</table></div>
<p><u>Kindly make your payment to</u>:<br/>
Bank: KTB<br/>
Account number: 679-5-17622-3<br/>
PromptPay: 0616953710<br/>
Onwer: Aekapab Sukkasem
</p>
<p><i>Note: Please send proof of money transfer via email to aekapab10@gmail.com</i></p>
</body>
</html>

<?php
return ob_get_clean();
}
?>