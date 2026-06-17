<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Rented Cars - Royal Cars Admin</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="css/viewres.css">
</head>

<body>
    <div class="admin-container">
        <div class="admin-header">
            <h1><i class="fas fa-car"></i> Active Rentals</h1>
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
                        <span class="stat-label">Total Rentals</span>
                        <span class="stat-value"><?= $totalRented ?></span>
                    </div>
                </div>

                <div class="stat-card revenue-stats">
                    <div class="stat-icon"><i class="fas fa-coins"></i></div>
                    <div class="stat-content">
                        <span class="stat-label">Total Revenue</span>
                        <span class="stat-value"><?= $totalPrice ?: 0 ?> DH</span>
                    </div>
                </div>

                <div class="stat-card topcar-stats">
                    <div class="stat-icon"><i class="fas fa-star"></i></div>
                    <div class="stat-content">
                        <span class="stat-label">Top Car</span>
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
                <a href="download_rented.php" class="action-btn download-btn">
                    <i class="fas fa-file-pdf"></i> Export PDF
                </a>
                <a href="month.php" class="action-btn month-btn">
                    <i class="fas fa-calendar-alt"></i> Monthly View
                </a>
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
            background: #FFC107;
        }

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
        }

        .download-btn {
            background: var(--success);
            color: white;
        }

        .month-btn {
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

        .month-btn:hover {
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