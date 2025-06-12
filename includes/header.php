<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Flemington Properties - Real Estate Advisory</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        .hero-section {
            background: linear-gradient(135deg, #2c3e50 0%, #34495e 100%);
            color: white;
            min-height: 60vh;
            display: flex;
            align-items: center;
        }

        .logo-section {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .logo-icon {
            width: 50px;
            height: 50px;
            background: white;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #2c3e50;
            font-size: 24px;
        }

        .brand-text {
            font-size: 1.8rem;
            font-weight: bold;
            margin: 0;
        }

        .brand-subtitle {
            font-size: 0.9rem;
            opacity: 0.9;
            letter-spacing: 2px;
            margin: 0;
        }

        .hero-title {
            font-size: 4rem;
            font-weight: bold;
            line-height: 1.1;
            margin-bottom: 1.5rem;
        }

        .hero-subtitle {
            font-size: 1.5rem;
            margin-bottom: 1rem;
            opacity: 0.95;
        }

        .hero-description {
            font-size: 1.1rem;
            opacity: 0.9;
            max-width: 600px;
        }

        .content-section {
            background: #f8f9fa;
            padding: 80px 0;
        }

        .section-title {
            font-size: 1.8rem;
            font-weight: bold;
            color: #2c3e50;
            margin-bottom: 1.5rem;
        }

        .check-item {
            display: flex;
            align-items: center;
            margin-bottom: 0.8rem;
        }

        .check-icon {
            color: #27ae60;
            margin-right: 10px;
            font-size: 1.1rem;
        }

        .cta-button {
            background: #2c3e50;
            color: white;
            padding: 12px 30px;
            border: none;
            border-radius: 5px;
            font-weight: 600;
            text-decoration: none;
            display: inline-block;
            transition: all 0.3s ease;
        }

        .cta-button:hover {
            background: #34495e;
            color: white;
            transform: translateY(-2px);
        }

        .insight-box {
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }

        .footer-section {
            background: #2c3e50;
            color: white;
            padding: 40px 0;
        }

        @media (max-width: 768px) {
            .hero-title {
                font-size: 2.5rem;
            }

            .hero-subtitle {
                font-size: 1.2rem;
            }

            .brand-text {
                font-size: 1.4rem;
            }
        }

        .chart-container {
            position: relative;
            width: 100%;
            margin-top: 20px;
            background: linear-gradient(135deg, rgba(20, 30, 48, 0.9) 0%, rgba(30, 40, 60, 0.8) 100%);
            border-radius: 10px;
            padding: 20px;
            border: 1px solid rgba(255, 255, 255, 0.1);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        }

        .chart-title {
            font-size: 16px;
            font-weight: bold;
            margin-bottom: 10px;
            color: #FFFFFF;
            text-align: left;
        }

        .chart-source {
            font-size: 11px;
            color: rgba(255, 255, 255, 0.6);
            position: absolute;
            bottom: 8px;
            left: 20px;
        }
    </style>
</head>

<body>