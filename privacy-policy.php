<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Privacy Policy - Flemington Properties</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        .hero-section {
            background: linear-gradient(135deg, #2c3e50 0%, #34495e 100%);
            color: white;
            padding: 60px 0;
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

        .page-title {
            font-size: 2.5rem;
            font-weight: bold;
            margin-top: 30px;
        }

        .content-section {
            background: #f8f9fa;
            padding: 60px 0;
        }

        .policy-container {
            background: white;
            border-radius: 10px;
            padding: 40px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        }

        .section-title {
            font-size: 1.5rem;
            font-weight: bold;
            color: #2c3e50;
            margin-bottom: 1.2rem;
            margin-top: 2rem;
        }

        .section-title:first-of-type {
            margin-top: 0;
        }

        .policy-text {
            color: #555;
            line-height: 1.7;
            margin-bottom: 1.5rem;
        }

        .footer-section {
            background: #2c3e50;
            color: white;
            padding: 40px 0;
        }

        .last-updated {
            font-style: italic;
            color: #777;
            margin-top: 40px;
            padding-top: 20px;
            border-top: 1px solid #eee;
        }

        .toc-container {
            background: #f8f9fa;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 30px;
        }

        .toc-title {
            font-weight: bold;
            margin-bottom: 15px;
            color: #2c3e50;
        }

        .toc-list {
            list-style-type: none;
            padding-left: 0;
        }

        .toc-list li {
            margin-bottom: 8px;
        }

        .toc-list a {
            color: #2c3e50;
            text-decoration: none;
        }

        .toc-list a:hover {
            text-decoration: underline;
        }

        .back-to-top {
            position: fixed;
            bottom: 20px;
            right: 20px;
            background: #2c3e50;
            color: white;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
            opacity: 0.8;
            transition: opacity 0.3s;
        }

        .back-to-top:hover {
            opacity: 1;
            color: white;
        }

        @media (max-width: 768px) {
            .policy-container {
                padding: 25px;
            }

            .page-title {
                font-size: 2rem;
            }
        }
    </style>
</head>

<body>
    <!-- Hero Section -->
    <section class="hero-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="logo-section mb-4">
                        <?php include('includes/logo.php')  ?>
                        <div>
                            <h1 class="brand-text">Flemington Properties</h1>
                            <p class="brand-subtitle">REAL ESTATE ADVISORY</p>
                        </div>
                    </div>

                    <h1 class="page-title">Privacy Policy</h1>
                    <p class="mb-0">How we collect, use, and protect your information</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Content Section -->
    <section class="content-section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <div class="policy-container">
                        <!-- Table of Contents -->
                        <div class="toc-container">
                            <div class="toc-title">Table of Contents</div>
                            <ul class="toc-list">
                                <li><a href="#introduction">1. Introduction</a></li>
                                <li><a href="#information-collection">2. Information We Collect</a></li>
                                <li><a href="#information-use">3. How We Use Your Information</a></li>
                                <li><a href="#information-sharing">4. Information Sharing and Disclosure</a></li>
                                <li><a href="#data-security">5. Data Security</a></li>
                                <li><a href="#cookies">6. Cookies and Tracking Technologies</a></li>
                                <li><a href="#your-rights">7. Your Rights and Choices</a></li>
                                <li><a href="#children">8. Children's Privacy</a></li>
                                <li><a href="#international">9. International Data Transfers</a></li>
                                <li><a href="#changes">10. Changes to This Privacy Policy</a></li>
                                <li><a href="#contact">11. Contact Us</a></li>
                            </ul>
                        </div>

                        <!-- Introduction -->
                        <h2 class="section-title" id="introduction">1. Introduction</h2>
                        <p class="policy-text">
                            Flemington Properties ("we," "our," or "us") is committed to protecting your privacy. This Privacy Policy explains how we collect, use, disclose, and safeguard your information when you visit our website, use our services, or communicate with us.
                        </p>
                        <p class="policy-text">
                            We value your trust and strive to be transparent about our data practices. By accessing or using our services, you agree to the terms of this Privacy Policy. If you do not agree with the terms of this Privacy Policy, please do not access the website or use our services.
                        </p>

                        <!-- Information Collection -->
                        <h2 class="section-title" id="information-collection">2. Information We Collect</h2>
                        <p class="policy-text">
                            We collect several types of information from and about users of our website and services, including:
                        </p>
                        <p class="policy-text">
                            <strong>Personal Information:</strong> This includes information that can identify you as an individual, such as your name, email address, postal address, phone number, and other identifiers.
                        </p>
                        <p class="policy-text">
                            <strong>Financial Information:</strong> When you engage our services, we may collect financial information necessary to process transactions, such as investment preferences, budget ranges, and financial goals.
                        </p>
                        <p class="policy-text">
                            <strong>Usage Information:</strong> We automatically collect information about your interactions with our website, including the pages you visit, the time and date of your visit, the time spent on those pages, and other statistics.
                        </p>
                        <p class="policy-text">
                            <strong>Device Information:</strong> We collect information about the device you use to access our website, including IP address, browser type, operating system, and other technical information.
                        </p>

                        <!-- Information Use -->
                        <h2 class="section-title" id="information-use">3. How We Use Your Information</h2>
                        <p class="policy-text">
                            We use the information we collect for various purposes, including:
                        </p>
                        <ul class="policy-text">
                            <li>To provide, maintain, and improve our services</li>
                            <li>To process transactions and send related information</li>
                            <li>To send administrative information, such as updates, security alerts, and support messages</li>
                            <li>To respond to your comments, questions, and requests</li>
                            <li>To provide customer support and personalized services</li>
                            <li>To send marketing communications, such as newsletters, market reports, and promotional materials</li>
                            <li>To monitor and analyze trends, usage, and activities in connection with our services</li>
                            <li>To detect, prevent, and address technical issues and fraudulent activities</li>
                            <li>To comply with legal obligations and enforce our terms and policies</li>
                        </ul>

                        <!-- Information Sharing -->
                        <h2 class="section-title" id="information-sharing">4. Information Sharing and Disclosure</h2>
                        <p class="policy-text">
                            We may share your information in the following circumstances:
                        </p>
                        <p class="policy-text">
                            <strong>Service Providers:</strong> We may share your information with third-party vendors, consultants, and other service providers who perform services on our behalf, such as payment processing, data analysis, email delivery, hosting services, and customer service.
                        </p>
                        <p class="policy-text">
                            <strong>Business Transfers:</strong> If we are involved in a merger, acquisition, financing, or sale of all or a portion of our assets, your information may be transferred as part of that transaction.
                        </p>
                        <p class="policy-text">
                            <strong>Legal Requirements:</strong> We may disclose your information if required to do so by law or in response to valid requests by public authorities (e.g., a court or government agency).
                        </p>
                        <p class="policy-text">
                            <strong>Protection of Rights:</strong> We may disclose your information to protect the rights, property, or safety of Flemington Properties, our clients, or others.
                        </p>
                        <p class="policy-text">
                            <strong>With Your Consent:</strong> We may share your information with your consent or at your direction.
                        </p>

                        <!-- Data Security -->
                        <h2 class="section-title" id="data-security">5. Data Security</h2>
                        <p class="policy-text">
                            We implement appropriate technical and organizational measures to protect the security of your personal information. However, please be aware that no method of transmission over the Internet or method of electronic storage is 100% secure.
                        </p>
                        <p class="policy-text">
                            While we strive to use commercially acceptable means to protect your personal information, we cannot guarantee its absolute security. You are responsible for maintaining the confidentiality of any passwords or account information.
                        </p>

                        <!-- Cookies -->
                        <h2 class="section-title" id="cookies">6. Cookies and Tracking Technologies</h2>
                        <p class="policy-text">
                            We use cookies and similar tracking technologies to track activity on our website and hold certain information. Cookies are files with a small amount of data that may include an anonymous unique identifier.
                        </p>
                        <p class="policy-text">
                            We use cookies for the following purposes:
                        </p>
                        <ul class="policy-text">
                            <li>To understand and save user preferences for future visits</li>
                            <li>To compile aggregate data about site traffic and site interactions</li>
                            <li>To enhance and personalize your user experience</li>
                            <li>To help us offer you relevant content and services</li>
                        </ul>
                        <p class="policy-text">
                            You can instruct your browser to refuse all cookies or to indicate when a cookie is being sent. However, if you do not accept cookies, you may not be able to use some portions of our website.
                        </p>

                        <!-- Your Rights -->
                        <h2 class="section-title" id="your-rights">7. Your Rights and Choices</h2>
                        <p class="policy-text">
                            Depending on your location, you may have certain rights regarding your personal information, including:
                        </p>
                        <ul class="policy-text">
                            <li>The right to access personal information we hold about you</li>
                            <li>The right to request correction of inaccurate personal information</li>
                            <li>The right to request deletion of your personal information</li>
                            <li>The right to object to processing of your personal information</li>
                            <li>The right to data portability</li>
                            <li>The right to withdraw consent</li>
                        </ul>
                        <p class="policy-text">
                            To exercise these rights, please contact us using the information provided in the "Contact Us" section below.
                        </p>

                        <!-- Children's Privacy -->
                        <h2 class="section-title" id="children">8. Children's Privacy</h2>
                        <p class="policy-text">
                            Our services are not intended for individuals under the age of 18. We do not knowingly collect personal information from children under 18. If we become aware that we have collected personal information from a child under 18 without verification of parental consent, we will take steps to remove that information from our servers.
                        </p>

                        <!-- International Transfers -->
                        <h2 class="section-title" id="international">9. International Data Transfers</h2>
                        <p class="policy-text">
                            Your information may be transferred to and processed in countries other than the country in which you reside. These countries may have data protection laws that are different from the laws of your country.
                        </p>
                        <p class="policy-text">
                            By using our services, you consent to the transfer of your information to countries outside your country of residence, including the United States, where our central database is operated.
                        </p>

                        <!-- Changes to Policy -->
                        <h2 class="section-title" id="changes">10. Changes to This Privacy Policy</h2>
                        <p class="policy-text">
                            We may update our Privacy Policy from time to time. We will notify you of any changes by posting the new Privacy Policy on this page and updating the "Last Updated" date.
                        </p>
                        <p class="policy-text">
                            You are advised to review this Privacy Policy periodically for any changes. Changes to this Privacy Policy are effective when they are posted on this page.
                        </p>

                        <!-- Contact Us -->
                        <h2 class="section-title" id="contact">11. Contact Us</h2>
                        <p class="policy-text">
                            If you have any questions about this Privacy Policy, please contact us:
                        </p>
                        <p class="policy-text">
                            <strong>Flemington Properties</strong><br>
                            123 Real Estate Avenue<br>
                            Suite 500<br>
                            New York, NY 10001<br>
                            Email: privacy@flemingtonproperties.com<br>
                            Phone: (123) 456-7890
                        </p>

                        <!-- Last Updated -->
                        <p class="last-updated">
                            Last Updated: June 12, 2025
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <?php require_once('includes/footer.php'); ?>

</body>

</html>