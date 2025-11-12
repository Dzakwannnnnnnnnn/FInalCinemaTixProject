</div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
  // Highlight active menu
  document.addEventListener('DOMContentLoaded', function () {
    const currentPage = window.location.href;
    const navLinks = document.querySelectorAll('.nav-link');

    navLinks.forEach(link => {
      if (link.href === currentPage) {
        link.classList.add('active');
      }
    });
  });
</script>
</body>

</html>