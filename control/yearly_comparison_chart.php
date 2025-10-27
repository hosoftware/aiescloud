<!DOCTYPE html>
<html>
<head>
    <title>Yearly Comparison Line Chart</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f7f9fc;
            padding: 30px;
        }
        .chart-container {
            width: 80%;
            margin: auto;
            background: white;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }
    </style>
</head>
<body>

<div class="chart-container">
    <h2 style="text-align:center;">Yearly Enquiry vs Job Comparison</h2>
    <canvas id="lineChart"></canvas>
</div>

<?php
// Example data (You can fetch these from MySQL)
$years = ['2021', '2022', '2023', '2024', '2025'];
$enquiry = [120, 150, 180, 220, 260];
$jobs = [100, 130, 170, 200, 240];
?>

<script>
    // PHP → JavaScript
    const years = <?php echo json_encode($years); ?>;
    const enquiryData = <?php echo json_encode($enquiry); ?>;
    const jobData = <?php echo json_encode($jobs); ?>;

    // Create the chart
    const ctx = document.getElementById('lineChart').getContext('2d');
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: years,
            datasets: [
                {
                    label: 'Enquiry',
                    data: enquiryData,
                    borderColor: '#36A2EB',
                    backgroundColor: 'rgba(54, 162, 235, 0.2)',
                    borderWidth: 2,
                    tension: 0.4,
                    fill: true
                },
                {
                    label: 'Jobs',
                    data: jobData,
                    borderColor: '#FF6384',
                    backgroundColor: 'rgba(255, 99, 132, 0.2)',
                    borderWidth: 2,
                    tension: 0.4,
                    fill: true
                }
            ]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'bottom'
                },
                tooltip: {
                    mode: 'index',
                    intersect: false
                }
            },
            interaction: {
                mode: 'nearest',
                axis: 'x',
                intersect: false
            },
            scales: {
                y: {
                    beginAtZero: true,
                    title: {
                        display: true,
                        text: 'Amount (AED)'
                    }
                },
                x: {
                    title: {
                        display: true,
                        text: 'Year'
                    }
                }
            }
        }
    });
</script>

</body>
</html>