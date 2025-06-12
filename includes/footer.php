    <!-- Footer -->
    <footer class="footer-section">
        <div class="container">
            <div class="row">
                <div class="col-md-8">
                    <p class="mb-2">Flemington Properties Advisory | Registered RERA Partner | © 2025</p>
                </div>

                <div class="d-flex justify-content-between">
                    <div>
                        <p class="mb-0">
                            <a href="/privacy-policy" class="text-white text-decoration-none me-3">Privacy Policy</a>
                            <a href="/terms-and-conditions" class="text-white text-decoration-none me-3">Terms and Conditions</a>                            
                        </p>
                    </div>
                    <div>
                        <p class="mb-0">
                            <a href="#" class="text-white text-decoration-none me-3">LinkedIn</a>
                            <a href="#" class="text-white text-decoration-none me-3">Twitter</a>
                            <a href="#" class="text-white text-decoration-none">Blog</a>
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