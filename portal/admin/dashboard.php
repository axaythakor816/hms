<?php

require_once '../../core/init.php';

if (isset($_GET['action']) && $_GET['action'] === 'logout') {
    logout();
    exit;
}
require_once('../includes/header.php');  // header + CSS/JS include

if (is_logged_in()) { 

  $baseurl = base_url($_SERVER['REQUEST_URI']);
  $url = check_role($_SESSION['role_id']);
  // if($baseurl != $url) {
  //   redirect(check_role($_SESSION['role_id']));
  // }

}else{
  showalert("error", "Access Denied");
  redirect("http://localhost/hms/public/page-login.php");
}
?>

<div id="content-container">
  <!-- Dynamic content yahan load hoga -->
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>

  function loadPage(page) {
    $('#content-container').html('Loading...');

    // Save current page (refresh ke liye)
    localStorage.setItem("currentPage", page);

    $.ajax({
      url: page,
      method: 'post',
      success: function(data) {
        $('#content-container').html(data);
      },
      error: function() {
        $('#content-container').html('<p>Error loading page.</p>');
      }
    });
  }

  $(document).ready(function() {

    // 🔥 On refresh — page restore
    let savedPage = localStorage.getItem("currentPage");

    if (savedPage) {
      loadPage(savedPage);
    } else {
      loadPage("home.php"); // Default
    }

    // Sidebar links
    $('.nav-link').click(function(e) {
      e.preventDefault();

      let href = $(this).attr('href'); // e.g. doctors/doctors.php

      // Page load + Save to localStorage
      loadPage(href);
    });

  });
</script>
<?php
require_once('../includes/footer.php');
?>
