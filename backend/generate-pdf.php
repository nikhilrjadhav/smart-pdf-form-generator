<?php

require_once('../tcpdf/tcpdf.php');
require_once('config.php');
require_once('save-data.php');

// Get inputs
$name = $_POST['name'] ?? '';
$email = $_POST['email'] ?? '';
$agree = isset($_POST['agree']) ? 'Yes' : 'No';
$signature = $_POST['signature'] ?? '';

// --- Save Signature ---
$signature = str_replace('data:image/png;base64,', '', $signature);
$signature = str_replace(' ', '+', $signature);
$signatureData = base64_decode($signature);

$signatureFile = SIGNATURE_PATH . 'sign_' . time() . '.png';
file_put_contents($signatureFile, $signatureData);

// --- Create PDF ---
$pdf = new TCPDF();
$pdf->AddPage();

$pdf->SetFont('Helvetica', '', 12);

// Title
$pdf->Cell(0, 10, "Smart PDF Form", 0, 1, 'C');
$pdf->Ln(5);

// Content
$pdf->Cell(0, 10, "Name: $name", 0, 1);
$pdf->Cell(0, 10, "Email: $email", 0, 1);
$pdf->Cell(0, 10, "Agreement: $agree", 0, 1);

$pdf->Ln(10);
$pdf->Cell(0, 10, "Signature:", 0, 1);

// Add signature image
$pdf->Image($signatureFile, 15, 90, 60, 30);

// --- Save PDF ---
$pdfFileName = 'form_' . time() . '.pdf';
$pdfFilePath = PDF_PATH . $pdfFileName;

$pdf->Output($pdfFilePath, 'F');

// --- Save metadata ---
saveFormData([
    'name' => $name,
    'email' => $email,
    'agree' => $agree,
    'pdf' => $pdfFileName
]);

// --- Return file ---
header('Content-Type: application/pdf');
header('Content-Disposition: inline; filename="' . $pdfFileName . '"');

readfile($pdfFilePath);
exit;