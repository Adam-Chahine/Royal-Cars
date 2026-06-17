<?php
session_start();
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: admin.php");
    exit;
}

include 'db.php';

$result = $conn->query("SELECT * FROM month");

// Total number of month cars
$totalQuery = $conn->query("SELECT COUNT(*) AS total FROM month");
$totalRented = $totalQuery->fetch_assoc()['total'];

// Total revenue
$priceQuery = $conn->query("SELECT SUM(price) AS total_price FROM month");
$totalPrice = $priceQuery->fetch_assoc()['total_price'];

// Most month car
$bestCarQuery = $conn->query("
    SELECT car_name, COUNT(*) AS count 
    FROM month 
    GROUP BY car_name 
    ORDER BY count DESC 
    LIMIT 1
");
$bestCar = $bestCarQuery->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Rented Cars - Royal Cars Admin</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        :root {
            --primary: #ff4d30;
            --primary-dark: #e63946;
            --secondary: #1a2a6c;
            --light: #ffffff;
            --light-gray: #f8f8f8;
            --medium-gray: #e0e0e0;
            --dark-gray: #777777;
            --text: #333333;
            --success: #28a745;
        }

        body {
            font-family: 'Montserrat', Arial, sans-serif;
            background-color: var(--light-gray);
            color: var(--text);
            margin: 0;
            padding: 0;
        }

        .admin-container {
            max-width: 1200px;
            margin: 40px auto;
            padding: 30px;
            background-color: var(--light);
            border-radius: 10px;
            box-shadow: 0 5px 25px rgba(0, 0, 0, 0.1);
        }

        .admin-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            padding-bottom: 20px;
            border-bottom: 1px solid var(--medium-gray);
        }

        .admin-header h1 {
            color: var(--primary);
            margin: 0;
            font-size: 2rem;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .back-link {
            color: var(--primary);
            font-weight: 600;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 8px 15px;
            border-radius: 5px;
            transition: all 0.3s ease;
        }

        .back-link:hover {
            color: var(--primary-dark);
            background-color: rgba(255, 77, 48, 0.1);
            text-decoration: none;
        }

        .button-column {
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            /* or center if you want them centered */
            gap: 12px;
            /* spacing between buttons */
        }

        .download-btn {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            background-color: var(--success);
            color: white;
            padding: 12px 24px;
            text-decoration: none;
            border-radius: 8px;
            font-weight: 600;
            transition: all 0.3s ease;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }

        .download-btn:hover {
            background-color: #218838;
            transform: translateY(-2px);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
        }

        .clear-btn {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            background-color: #e63946;
            color: white;
            padding: 12px 24px;
            text-decoration: none;
            border-radius: 8px;
            font-weight: 600;
            transition: all 0.3s ease;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
            border: none;
            cursor: pointer;
        }

        .clear-btn:hover {
            background-color: rgb(209, 35, 35);
            transform: translateY(-2px);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
        }

        .rentals-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            background: var(--light);
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            overflow: hidden;
        }

        .rentals-table th {
            background-color: var(--secondary);
            color: white;
            padding: 15px;
            text-align: left;
            font-weight: 600;
            position: sticky;
            top: 0;
        }

        .rentals-table td {
            padding: 12px 15px;
            border-bottom: 1px solid var(--medium-gray);
            vertical-align: top;
        }

        .rentals-table tr:nth-child(even) {
            background-color: var(--light-gray);
        }

        .rentals-table tr:hover {
            background-color: rgba(255, 77, 48, 0.05);
        }

        .empty-state {
            text-align: center;
            padding: 40px;
            color: var(--dark-gray);
            grid-column: 1 / -1;
        }

        .empty-state i {
            font-size: 3rem;
            color: var(--medium-gray);
            margin-bottom: 20px;
        }

        .status-badge {
            display: inline-block;
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 600;
        }

        .status-active {
            background-color: #d4edda;
            color: #155724;
        }

        @media (max-width: 992px) {
            .rentals-table {
                display: block;
                overflow-x: auto;
            }
        }

        @media (max-width: 768px) {
            .admin-container {
                padding: 20px;
                margin: 20px;
            }

            .admin-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 15px;
            }

            .rentals-table th,
            .rentals-table td {
                padding: 10px;
                font-size: 0.85rem;
            }

        }
    </style>
</head>

<body>
    <div class="admin-container">
        <div class="admin-header">
            <h1><i class="fas fa-calendar-alt"></i> Monthly Rentals</h1>
            <a href="admin.php" class="back-link">
                <i class="fas fa-arrow-left"></i> Back to Admin Panel
            </a>
        </div>

        <div class="dashboard-summary">
            <!-- Stats Cards -->
            <div class="stats-grid">
                <div class="stat-card rental-stats">
                    <div class="stat-icon"><i class="fas fa-car"></i></div>
                    <div class="stat-content">
                        <span class="stat-label">Month Rentals</span>
                        <span class="stat-value"><?= $totalRented ?></span>
                    </div>
                </div>

                <div class="stat-card revenue-stats">
                    <div class="stat-icon"><i class="fas fa-coins"></i></div>
                    <div class="stat-content">
                        <span class="stat-label">Month Revenue</span>
                        <span class="stat-value"><?= $totalPrice ?: 0 ?> DH</span>
                    </div>
                </div>

                <div class="stat-card topcar-stats">
                    <div class="stat-icon"><i class="fas fa-trophy"></i></div>
                    <div class="stat-content">
                        <span class="stat-label">Top Car This Month</span>
                        <span class="stat-value">
                            <?= $bestCar ? htmlspecialchars($bestCar['car_name']) : 'N/A' ?>
                            <?php if ($bestCar): ?>
                                <span class="rental-count"><?= $bestCar['count'] ?>x</span>
                            <?php endif; ?>
                        </span>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="action-buttons">
                <a href="download_month.php" class="action-btn download-btn">
                    <i class="fas fa-file-pdf"></i> Export PDF
                </a>
                <form action="clear_month.php" method="post" onsubmit="return confirm('Are you sure you want to delete all records? This action cannot be undone.')">
                    <button type="submit" class="action-btn clear-btn">
                        <i class="fas fa-trash-alt"></i> Clear All
                    </button>
                </form>
            </div>
        </div>
    </div>

    <style>
        .dashboard-summary {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 20px;
            margin-bottom: 25px;
            background: rgba(255, 255, 255, 0.05);
            padding: 15px;
            border-radius: 12px;
        }

        .stats-grid {
            display: flex;
            gap: 15px;
            flex-wrap: wrap;
            flex-grow: 1;
        }

        .stat-card {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 16px;
            border-radius: 10px;
            background: rgba(255, 255, 255, 0.1);
            min-width: 180px;
            transition: all 0.3s ease;
        }

        .stat-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .stat-icon {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 14px;
            color: white;
        }

        .rental-stats .stat-icon {
            background: var(--primary);
        }

        .revenue-stats .stat-icon {
            background: var(--secondary);
        }

        .topcar-stats .stat-icon {
            background: #FF914D;
        }

        /* Changed to orange for "top" distinction */

        .stat-content {
            display: flex;
            flex-direction: column;
        }

        .stat-label {
            font-size: 13px;
            color: var(--text-light);
            font-weight: 500;
        }

        .stat-value {
            font-size: 16px;
            font-weight: 600;
            color: var(--text);
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .rental-count {
            background: var(--primary);
            color: white;
            font-size: 11px;
            padding: 2px 6px;
            border-radius: 10px;
        }

        .action-buttons {
            display: flex;
            gap: 12px;
            flex-shrink: 0;
        }

        .action-btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 10px 16px;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.3s ease;
            border: none;
            cursor: pointer;
        }

        .download-btn {
            background: var(--success);
            color: white;
        }

        .clear-btn {
            background: #e63946;
            color: white;
        }

        .action-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
        }

        .download-btn:hover {
            background: #218838;
        }

        .clear-btn:hover {
            background: #d62230;
        }

        @media (max-width: 768px) {
            .dashboard-summary {
                flex-direction: column;
                align-items: stretch;
            }

            .action-buttons {
                width: 100%;
                justify-content: flex-end;
            }
        }

        @media (max-width: 480px) {
            .stats-grid {
                flex-direction: column;
            }

            .stat-card {
                width: 100%;
            }

            .action-buttons {
                flex-direction: column;
            }

            .action-btn {
                justify-content: center;
            }
        }
    </style>

    <?php if ($result->num_rows > 0): ?>
        <div style="overflow-x: auto;">
            <table class="rentals-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Car</th>
                        <th>Client</th>
                        <th>Contact</th>
                        <th>Dates</th>
                        <th>Locations</th>
                        <th>Price</th>
                        <th>Rented At</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?= $row['id'] ?></td>
                            <td><strong><?= htmlspecialchars($row['car_name']) ?></strong></td>
                            <td>
                                <?= htmlspecialchars($row['full_name']) ?><br>
                                <span class="status-badge status-active">
                                    <i class="fas fa-check-circle"></i> Active
                                </span>
                            </td>
                            <td>
                                <?= htmlspecialchars($row['email']) ?><br>
                                <?= htmlspecialchars($row['phone']) ?>
                            </td>
                            <td>
                                <strong>Pickup:</strong> <?= $row['pickup_date'] ?><br>
                                <strong>Return:</strong> <?= $row['return_date'] ?>
                            </td>
                            <td>
                                <strong>From:</strong> <?= htmlspecialchars($row['pickup_location']) ?><br>
                                <strong>To:</strong> <?= htmlspecialchars($row['return_location']) ?>
                            </td>
                            <td><?= htmlspecialchars($row['price']) ?> DH</td>
                            <td><?= $row['rented_at'] ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    <?php else: ?>
        <div class="empty-state">
            <i class="fas fa-car"></i>
            <h3>No Active Rentals</h3>
            <p>There are currently no cars being rented.</p>
        </div>
    <?php endif; ?>
    </div>
</body>

</html>