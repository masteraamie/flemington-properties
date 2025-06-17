    <!-- Footer -->
    <footer class="footer-section">
        <div class="container">
            <div class="row">
                <div class="col-md-12 col-sm-12 mb-2">
                    <p class="mb-2">Flemington Properties Advisory | Registered RERA Partner | © 2025</p>
                </div>

                <div class="col-md-6 col-sm-12 mb-2">
                    <a href="https://www.facebook.com/profile.php?id=61571613819926" class="text-white text-decoration-none me-3"><i class="fab fa-facebook"></i></a>
                    <!-- <a href="#" class="text-white text-decoration-none me-3"><i class="fab fa-linkedin"></i></a> -->
                    <a href="https://www.instagram.com/flemingtonproperties" class="text-white text-decoration-none me-3"><i class="fab fa-instagram"></i></a>
                    <!-- <a href="#" class="text-white text-decoration-none me-3"><i class="fab fa-youtube"></i></a>
                    <a href="#" class="text-white text-decoration-none me-3"><i class="fab fa-twitter"></i></a> -->
                </div>

                <div class="row mb-3">
                    <div class="col-md-6 col-sm-12">
                        <p class="mb-0">
                            <a href="/privacy-policy" class="text-white text-decoration-none me-3">Privacy Policy</a>
                            <a href="/terms-and-conditions" class="text-white text-decoration-none me-3">Terms and Conditions</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <!-- Back to Top Button -->
    <a href="#" class="back-to-top">
        <i class="fas fa-arrow-up"></i>
    </a>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Back to top button functionality
        document.addEventListener('DOMContentLoaded', function() {
            const backToTopButton = document.querySelector('.back-to-top');

            // Show/hide button based on scroll position
            window.addEventListener('scroll', function() {
                if (window.pageYOffset > 300) {
                    backToTopButton.style.display = 'flex';
                } else {
                    backToTopButton.style.display = 'none';
                }
            });

            // Initially hide the button
            backToTopButton.style.display = 'none';

            // Smooth scroll to top when clicked
            backToTopButton.addEventListener('click', function(e) {
                e.preventDefault();
                window.scrollTo({
                    top: 0,
                    behavior: 'smooth'
                });
            });
        });
    </script>