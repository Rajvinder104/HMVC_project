<section id="footer" class="footer">
  <div class="footer-copy">
    <p>2023 © All rights reserved. Developed by WebrixSoft</p>
    <div>
</section>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
  $(document).ready(function() {
    $(".toggle").click(function() {
      $('#header').toggleClass("new_header");
      $('#footer').toggleClass("new_footer");
      $('#sidebar').toggleClass("new_sidebar");
      $('#main').toggleClass("new_main");
    });
  });
</script>

</body>

</html>