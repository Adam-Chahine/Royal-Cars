<?php
require_once 'tcpdf/tcpdf.php';

include 'db.php';

// Fetch rented data
$sql = "SELECT * FROM month ";
$result = $conn->query($sql);

// Create PDF
$pdf = new TCPDF('L', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false); // Landscape orientation

// Document setup
$pdf->SetCreator('Royal Cars Rental System');
$pdf->SetAuthor('Royal Cars');
$pdf->SetTitle('Active Rentals Report');
$pdf->SetSubject('Current Vehicle Rentals');

// Margins
$pdf->SetMargins(10, 20, 10);
$pdf->SetHeaderMargin(5);
$pdf->SetFooterMargin(15);

// Add a page
$pdf->AddPage();

// Custom styles
$html = '
<style>
    .header {
        background-color: #1a2a6c;
        color: white;
        font-weight: bold;
        text-align: center;
        padding: 5px;
    }
    .title {
        color: #ff4d30;
        font-size: 16pt;
        text-align: center;
        margin-bottom: 10px;
    }
    .subtitle {
        color: #666;
        text-align: center;
        margin-bottom: 15px;
    }
    .column-header {
        background-color: #f0f0f0;
        color: #333;
        font-weight: bold;
        padding: 5px;
        text-align: center;
        border: 0.5px solid #ddd;
    }
    .data-row {
        padding: 5px;
        border: 0.5px solid #eee;
    }
    .odd-row {
        background-color: #f9f9f9;
    }
    .even-row {
        background-color: #ffffff;
    }
    .car-name {
        color: #ff4d30;
        font-weight: bold;
    }
    .price {
        color: #27ae60;
        font-weight: bold;
        text-align: right;
    }
    .status-active {
        color: #27ae60;
        font-weight: bold;
    }
    .contact-info {
        font-size: 9pt;
        line-height: 1.3;
    }
    .date-info {
        font-size: 9pt;
        line-height: 1.3;
    }
    .footer {
        font-size: 8pt;
        color: #666;
        text-align: center;
        border-top: 1px solid #eee;
        padding-top: 5px;
        margin-top: 10px;
    }
</style>

<div class="title">ROYAL CARS - ACTIVE RENTALS</div>
<div class="subtitle">Generated on '.date('F j, Y \a\t g:i A').'</div>

<table cellpadding="4" cellspacing="0">
    <thead>
        <tr>
            <th width="5%" class="column-header">ID</th>
            <th width="15%" class="column-header">Vehicle</th>
            <th width="15%" class="column-header">Client</th>
            <th width="12%" class="column-header">Contact</th>
            <th width="12%" class="column-header">Rental Period</th>
            <th width="15%" class="column-header">Locations</th>
            <th width="8%" class="column-header">Price</th>
            <th width="10%" class="column-header">Rented On</th>
        </tr>
    </thead>
    <tbody>';

// Data rows
$rowCount = 0;
while ($row = $result->fetch_assoc()) {
    $rowClass = ($rowCount % 2 == 0) ? 'odd-row' : 'even-row';
    
    $html .= '
    <tr class="data-row '.$rowClass.'">
        <td width="5%" align="center">'.$row['id'].'</td>
        <td width="15%" class="car-name">'.$row['car_name'].'</td>
        <td width="15%">'.$row['full_name'].'</td>
        <td width="12%" class="contact-info">
            <strong></strong> '.$row['email'].'<br>
            <strong></strong> '.$row['phone'].'
        </td>
        <td width="12%" class="date-info">
            <strong></strong> '.$row['pickup_date'].'<br>
            <strong></strong> '.$row['return_date'].'
        </td>
        <td width="15%">
            <strong>From:</strong> '.$row['pickup_location'].'<br>
            <strong>To:</strong> '.$row['return_location'].'
        </td>
        <td width="8%" class="price">'.$row['price'].' DH</td>
        <td width="10%" align="center">'.date('M j, Y', strtotime($row['rented_at'])).'</td>
    </tr>';
    $rowCount++;
}

$html .= '
    </tbody>
</table>

<div class="footer">
    Royal Cars Rental System | '.$rowCount.' Active Rentals | Generated on '.date('M j, Y').'
</div>';

// Write HTML content
$pdf->writeHTML($html, true, false, true, false, '');

// Output PDF
$pdf->Output('royal_cars_rentals '.date('Ymd_His').'.pdf', 'D');

$conn->close();
?>
