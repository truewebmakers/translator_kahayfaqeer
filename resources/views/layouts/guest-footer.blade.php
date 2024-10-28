  <!-- jquery-->
  <script src="{{ asset('assets/js/vendors/jquery/jquery.min.js')}}"></script>
  <!-- bootstrap js-->
  <script src="{{ asset('assets/js/vendors/bootstrap/dist/js/bootstrap.bundle.min.js')}}"></script>
  <script src="{{ asset('assets/js/vendors/bootstrap/dist/js/popper.min.js')}}"></script>
  <!--fontawesome-->
  <script src="{{ asset('assets/js/vendors/font-awesome/fontawesome-min.js')}}"></script>
  <!-- password_show-->

  <script src="{{ asset('assets/js/vendors/feather-icon/feather.min.js')}}"></script>
  <script src="{{ asset('assets/js/vendors/feather-icon/custom-script.js')}}"></script>

  <script src="{{ asset('assets/js/alert.js')}}"></script>


  {{-- <script src="{{ asset('assets/js/password.js')}}"></script> --}}
  <!-- custom script -->
  <script src="{{ asset('assets/js/script.js')}}"></script>

  <script>
    document.title = 'User List';
    document.addEventListener("DOMContentLoaded", function() {
    var showHideElements = document.querySelectorAll(".show-hide");
    var passwordInput = document.querySelector('input[name="password"]');
    var showHideSpan = document.querySelector(".show-hide span");
    var submitButton = document.querySelector('form button[type="submit"]');

    showHideElements.forEach(function(element) {
        element.style.display = "block";
    });
    showHideSpan.classList.add("show");

    showHideSpan.addEventListener("click", function() {
        if (showHideSpan.classList.contains("show")) {
            passwordInput.setAttribute("type", "text");
            showHideSpan.classList.remove("show");
        } else {
            passwordInput.setAttribute("type", "password");
            showHideSpan.classList.add("show");
        }
    });

    submitButton.addEventListener("click", function() {
        showHideSpan.classList.add("show");
        passwordInput.setAttribute("type", "password");
    });
});

</script>

</body>
</html>
