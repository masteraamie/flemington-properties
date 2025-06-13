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

            .hero-section {
                padding: 3rem 1rem 3rem 1rem;
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

        .dubai-areas-section {
            background: white;
            padding: 80px 0;
        }

        .areas-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            grid-auto-rows: 200px;
            gap: 20px;
            max-width: 1200px;
            margin: 0 auto;
        }

        .area-card {
            position: relative;
            border-radius: 15px;
            overflow: hidden;
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
        }

        .area-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
        }

        .large-card {
            grid-row: span 2;
            grid-column: span 2;
        }

        .medium-card {
            grid-row: span 2;
        }

        .small-card {
            grid-row: span 1;
        }

        .area-overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(135deg, rgba(44, 62, 80, 0.7) 0%, rgba(52, 73, 94, 0.5) 100%);
            display: flex;
            align-items: flex-end;
            padding: 25px;
            transition: all 0.3s ease;
        }

        .area-card:hover .area-overlay {
            background: linear-gradient(135deg, rgba(44, 62, 80, 0.8) 0%, rgba(52, 73, 94, 0.6) 100%);
        }

        .area-content {
            color: white;
            width: 100%;
        }

        .property-count {
            font-size: 14px;
            opacity: 0.9;
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
        }

        .area-name {
            font-size: 1.8rem;
            font-weight: bold;
            margin-bottom: 15px;
            color: white;
        }

        .more-details-btn {
            background: rgba(255, 255, 255, 0.2);
            border: 1px solid rgba(255, 255, 255, 0.3);
            color: white;
            padding: 8px 15px;
            border-radius: 25px;
            font-size: 12px;
            font-weight: 600;
            letter-spacing: 0.5px;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 8px;
            backdrop-filter: blur(10px);
        }

        .more-details-btn:hover {
            background: rgba(255, 255, 255, 0.3);
            border-color: rgba(255, 255, 255, 0.5);
            transform: translateX(5px);
        }

        .more-details-btn i {
            font-size: 10px;
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .areas-grid {
                grid-template-columns: 1fr;
                grid-auto-rows: 250px;
            }

            .large-card,
            .medium-card,
            .small-card {
                grid-row: span 1;
                grid-column: span 1;
            }

            .area-name {
                font-size: 1.5rem;
            }

            .dubai-areas-section {
                padding: 60px 0;
            }
        }

        @media (max-width: 992px) {
            .large-card {
                grid-column: span 1;
            }
        }
    </style>
</head>

<body>
    <!-- Hero Section -->
    <section class="hero-section">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-8">
                    <div class="logo-section mb-4">
                        <div class="logo-icon">
                            <i class="fas fa-home"></i>
                        </div>
                        <div>
                            <h1 class="brand-text">Flemington Properties</h1>
                            <p class="brand-subtitle">REAL ESTATE ADVISORY</p>
                        </div>
                    </div>

                    <h1 class="hero-title">WHERE DATA<br>DRIVES DECISIONS.</h1>
                    <h2 class="hero-subtitle">Your Trusted Partner in Real Estate Strategy.</h2>
                    <p class="hero-description">
                        We don't sell hype. We deliver clarity, confidence, and results — powered by numbers.
                    </p>
                </div>
                <div class="col-lg-4 text-end">
                    <div class="chart-container">
                        <div class="chart-title">10-Year AROI</div>
                        <canvas id="aroiChart"></canvas>
                        <div class="chart-source">Source: Flemington Research, 2025</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Content Section -->
    <section class="content-section">
        <div class="container">
            <div class="row">
                <!-- What We Do -->
                <div class="col-lg-6 mb-5">
                    <h3 class="section-title">WHAT WE DO</h3>
                    <p class="mb-4"><strong>Insightful Real Estate Advisory built for:</strong></p>

                    <ul class="list-unstyled">
                        <li class="mb-3">
                            <strong>• Investors</strong><br>
                            <span class="text-muted">looking to maximize ROI</span>
                        </li>
                        <li class="mb-3">
                            <strong>• Homebuyers</strong><br>
                            <span class="text-muted">seeking value and timing</span>
                        </li>
                        <li class="mb-3">
                            <strong>• Developers</strong><br>
                            <span class="text-muted">evaluating land, location, and viability</span>
                        </li>
                        <li class="mb-4">
                            <strong>• Institutions</strong><br>
                            <span class="text-muted">needing due diligence & forecasting</span>
                        </li>
                    </ul>

                    <h4 class="section-title mt-5">OUR APPROACH</h4>
                    <p class="mb-3"><strong>Analytics First. Emotion Second.</strong></p>
                    <ul class="list-unstyled">
                        <li class="mb-2">• Market Entry Timing</li>
                        <li class="mb-2">• Growth Zone Identification</li>
                        <li class="mb-2">• Risk-Adjusted Return Projections</li>
                        <li class="mb-2">• Portfolio Performance Audits</li>
                    </ul>
                </div>

                <!-- Why Flemington Properties -->
                <div class="col-lg-6 mb-5">
                    <h3 class="section-title">WHY FLEMINGTON PROPERTIES?</h3>

                    <div class="check-item">
                        <i class="fas fa-check check-icon"></i>
                        <span>100% Independent Advice</span>
                    </div>
                    <div class="check-item">
                        <i class="fas fa-check check-icon"></i>
                        <span>Custom Investment Dashboards</span>
                    </div>
                    <div class="check-item">
                        <i class="fas fa-check check-icon"></i>
                        <span>Quarterly Trend Reports</span>
                    </div>
                    <div class="check-item mb-4">
                        <i class="fas fa-check check-icon"></i>
                        <span>Expert Team with Finance & Real Estate Credentials</span>
                    </div>

                    <h4 class="section-title mt-5">SAMPLE INSIGHTS</h4>
                    <div class="insight-box">
                        <p class="mb-3">Properties within 5km of new metro projects have seen a 24% CAGR over 3 years — but only in low-supply corridors.</p>
                        <p class="mb-0">In 2024, rental yields in Tier-2 cities outperformed Tier-1 by 1.3% on average — driven by hybrid worktrends.</p>
                    </div>

                    <a href="#" class="cta-button mb-4">
                        Download Full 2025 Market Outlook <i class="fas fa-arrow-right ms-2"></i>
                    </a>
                </div>
            </div>

            <!-- Dubai Areas Section -->
            <section class="dubai-areas-section">
                <div class="container">
                    <div class="row mb-5">
                        <div class="col-lg-8 mx-auto text-center">
                            <h2 class="section-title">Explore Dubai's Prime Locations</h2>
                            <p class="lead">Discover investment opportunities across Dubai's most sought-after neighborhoods. From luxury waterfront properties to bustling business districts, find the perfect location for your next investment.</p>
                        </div>
                    </div>

                    <div class="areas-grid">
                        <!-- Business Bay -->
                        <div class="area-card large-card" style="background-image: url('/placeholder.svg?height=400&width=600');">
                            <div class="area-overlay">
                                <div class="area-content">
                                    <span class="property-count">12 Properties</span>
                                    <h3 class="area-name">Business Bay</h3>
                                    <button class="more-details-btn">
                                        <span>MORE DETAILS</span>
                                        <i class="fas fa-play"></i>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Dubai Marina -->
                        <div class="area-card medium-card" style="background-image: url('/placeholder.svg?height=350&width=500');">
                            <div class="area-overlay">
                                <div class="area-content">
                                    <span class="property-count">8 Properties</span>
                                    <h3 class="area-name">Dubai Marina</h3>
                                    <button class="more-details-btn">
                                        <span>MORE DETAILS</span>
                                        <i class="fas fa-play"></i>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Downtown Dubai -->
                        <div class="area-card medium-card" style="background-image: url('/placeholder.svg?height=400&width=600');">
                            <div class="area-overlay">
                                <div class="area-content">
                                    <span class="property-count">15 Properties</span>
                                    <h3 class="area-name">Downtown Dubai</h3>
                                    <button class="more-details-btn">
                                        <span>MORE DETAILS</span>
                                        <i class="fas fa-play"></i>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Palm Jumeirah -->
                        <div class="area-card large-card" style="background-image: url('/placeholder.svg?height=350&width=500');">
                            <div class="area-overlay">
                                <div class="area-content">
                                    <span class="property-count">6 Properties</span>
                                    <h3 class="area-name">Palm Jumeirah</h3>
                                    <button class="more-details-btn">
                                        <span>MORE DETAILS</span>
                                        <i class="fas fa-play"></i>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Dubai Hills -->
                        <div class="area-card large-card" style="background-image: url('/placeholder.svg?height=250&width=400');">
                            <div class="area-overlay">
                                <div class="area-content">
                                    <span class="property-count">4 Properties</span>
                                    <h3 class="area-name">Dubai Hills</h3>
                                    <button class="more-details-btn">
                                        <span>MORE DETAILS</span>
                                        <i class="fas fa-play"></i>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Jumeirah Beach Residence -->
                        <div class="area-card medium-card" style="background-image: url('/placeholder.svg?height=250&width=400');">
                            <div class="area-overlay">
                                <div class="area-content">
                                    <span class="property-count">7 Properties</span>
                                    <h3 class="area-name">JBR</h3>
                                    <button class="more-details-btn">
                                        <span>MORE DETAILS</span>
                                        <i class="fas fa-play"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Call to Action Section -->
            <div class="row mt-5">
                <div class="col-lg-8">
                    <h3 class="section-title">LET'S TALK STRATEGY</h3>
                    <p class="mb-4">Whether you're buying your first asset or restructuring a portfolio — start with intelligence, not instinct.</p>
                    <button type="button" class="cta-button me-3 border-0" data-bs-toggle="modal" data-bs-target="#consultationModal">BOOK A FREE CONSULTATION</button>
                    <p class="mt-3 mb-0">
                        You can also reach us directly at <a href="mailto:ub@flemington.ae" class="text-decoration-none">ub@flemington.ae</a>
                    </p>
                </div>
            </div>
        </div>
    </section>

    <?php require_once('includes/footer.php'); ?>

    <!-- Consultation Modal -->
    <div class="modal fade" id="consultationModal" tabindex="-1" aria-labelledby="consultationModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header" style="background-color: #2c3e50; color: white;">
                    <h5 class="modal-title" id="consultationModalLabel">Book Your Free Consultation</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <p class="mb-4">Please fill out the form below and our real estate advisory team will contact you within 24 hours to schedule your consultation.</p>

                    <form id="consultationForm" class="needs-validation" novalidate>
                        <div class="row g-3">
                            <div class="col-md-6 mb-3">
                                <label for="firstName" class="form-label">First Name*</label>
                                <input type="text" class="form-control" id="firstName" required>
                                <div class="invalid-feedback">
                                    Please provide your first name.
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="lastName" class="form-label">Last Name*</label>
                                <input type="text" class="form-control" id="lastName" required>
                                <div class="invalid-feedback">
                                    Please provide your last name.
                                </div>
                            </div>
                        </div>

                        <div class="row g-3">
                            <div class="col-md-6 mb-3">
                                <label for="email" class="form-label">Email Address*</label>
                                <input type="email" class="form-control" id="email" required>
                                <div class="invalid-feedback">
                                    Please provide a valid email address.
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="phone" class="form-label">Phone Number*</label>
                                <input type="tel" class="form-control" id="phone" required>
                                <div class="invalid-feedback">
                                    Please provide your phone number.
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="investmentType" class="form-label">Investment Type</label>
                            <select class="form-select" id="investmentType">
                                <option selected disabled value="">Choose...</option>
                                <option>Residential Property</option>
                                <option>Commercial Property</option>
                                <option>Land Development</option>
                                <option>Portfolio Management</option>
                                <option>Other</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="budget" class="form-label">Investment Budget Range</label>
                            <select class="form-select" id="budget">
                                <option selected disabled value="">Choose...</option>
                                <option>Under $250,000</option>
                                <option>$250,000 - $500,000</option>
                                <option>$500,000 - $1,000,000</option>
                                <option>$1,000,000 - $5,000,000</option>
                                <option>Over $5,000,000</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="message" class="form-label">Additional Information</label>
                            <textarea class="form-control" id="message" rows="4" placeholder="Tell us about your investment goals or any specific questions you have..."></textarea>
                        </div>

                        <div class="mb-3 form-check">
                            <input type="checkbox" class="form-check-input" id="privacyPolicy" required>
                            <label class="form-check-label" for="privacyPolicy">I agree to the privacy policy and terms of service*</label>
                            <div class="invalid-feedback">
                                You must agree before submitting.
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" style="background-color: #2c3e50; border: none;" onclick="submitForm()">Submit Request</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Success Modal -->
    <div class="modal fade" id="successModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header" style="background-color: #27ae60; color: white;">
                    <h5 class="modal-title">Request Submitted!</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <div class="text-center mb-4">
                        <i class="fas fa-check-circle" style="font-size: 3rem; color: #27ae60;"></i>
                    </div>
                    <h4 class="text-center">Thank You!</h4>
                    <p class="text-center">Your consultation request has been successfully submitted. A member of our team will contact you within 24 hours to schedule your free consultation.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Form validation
        (function() {
            'use strict'

            // Fetch all forms to which we want to apply validation
            var forms = document.querySelectorAll('.needs-validation')

            // Loop over them and prevent submission
            Array.prototype.slice.call(forms)
                .forEach(function(form) {
                    form.addEventListener('submit', function(event) {
                        if (!form.checkValidity()) {
                            event.preventDefault()
                            event.stopPropagation()
                        }

                        form.classList.add('was-validated')
                    }, false)
                })
        })()

        // Form submission handler
        function submitForm() {
            const form = document.getElementById('consultationForm');

            if (form.checkValidity()) {
                // Hide consultation modal
                const consultationModal = bootstrap.Modal.getInstance(document.getElementById('consultationModal'));
                consultationModal.hide();

                // Show success modal
                const successModal = new bootstrap.Modal(document.getElementById('successModal'));
                successModal.show();

                // Reset form
                form.reset();
                form.classList.remove('was-validated');

                // In a real application, you would send the form data to your server here
                // For example:
                // const formData = new FormData(form);
                // fetch('/submit-consultation', {
                //     method: 'POST',
                //     body: formData
                // });
            } else {
                form.classList.add('was-validated');
            }
        }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Chart initialization with enhanced Chart.js implementation
        document.addEventListener('DOMContentLoaded', function() {
            const ctx = document.getElementById('aroiChart').getContext('2d');
            const aroiChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: ['Tier-1', 'Tier-2', 'Tier-3'],
                    datasets: [{
                        label: '10-Year AROI',
                        data: [5.6, 7.2, 9.2],
                        fill: false,
                        tension: 0.4,
                        borderColor: '#7fa6bd',
                        backgroundColor: '#7fa6bd',
                        pointRadius: 5,
                        pointHoverRadius: 6,
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: false,
                            min: 1.5,
                            max: 9.5,
                            ticks: {
                                callback: function(value) {
                                    return value + ' %';
                                },
                                color: 'white'
                            },
                            grid: {
                                color: '#444'
                            }
                        },
                        x: {
                            ticks: {
                                color: 'white'
                            },
                            grid: {
                                display: false
                            }
                        }
                    },
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    return context.raw + ' %';
                                }
                            }
                        }
                    }
                }
            });
        });
    </script>
</body>

</html>