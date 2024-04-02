<?php

class PDFService {

    function generatePDF($result, $orderItemResult) {
        require_once __DIR__ . '/../tcpdf/tcpdf.php';
        $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
        $pdf->SetHeaderData('', PDF_HEADER_LOGO_WIDTH, '', '', array(
            0,
            0,
            0
        ), array(
            255,
            255,
            255
        ));
        $pdf->SetTitle('Invoice - ' . $result["id"] . $result["user_id"]);
        $pdf->SetMargins(20, 10, 20, true);
        if (@file_exists(dirname(__FILE__) . '/lang/eng.php')) {
            require_once (dirname(__FILE__) . '/lang/eng.php');
            $pdf->setLanguageArray($l);
        }
        $pdf->SetFont('helvetica', '', 11);
        $pdf->AddPage();
        $orderedDate = date('d F Y', strtotime($result["sales_date"]));
        $due_date = date("d F Y", strtotime('+' . 30 . 'days', strtotime($orderedDate))); //TERM 30days

        require_once __DIR__ . './purchase-invoice-template.php';
        $html = getHTMLPurchaseDataToPDF($result, $orderItemResult, $orderedDate, $due_date);
        $filename = "Invoice-" . $result["id"] . $result["user_id"];
        $pdf->writeHTML($html, true, false, true, false, '');
        ob_end_clean();
        $pdf->Output($filename . '.pdf', 'I');
    }
}

?>