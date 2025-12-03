<?php

require_once '../../core/init.php';

if (isset($_GET['action']) && $_GET['action'] === 'logout') {
    logout();
    exit;
}

// 🚫 redirect check should happen BEFORE header.php
if ( !is_logged_in() ) {
  showalert("error", "Access Denied");
  redirect('http://localhost/hms/public/page-login.php');
  exit;
}

// If logged in, then check role
$baseurl = base_url($_SERVER['REQUEST_URI']);
$url = check_role($_SESSION['role_id']);

if ($baseurl != $url) {
    redirect($url);
    exit;
}

if (!has_permission('dashboard', 'can_view')) {
  showalert("error", "Access Denied");
  // redirect('http://localhost/hms/public/page-login.php');
  exit;
}

require_once('../includes/header.php');  // header + CSS/JS include

?>

<div id="content-container">
  
  <!-- Dynamic content yahan load hoga -->
</div>

<!-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> -->

<?php
require_once('../includes/footer.php');
?>
<script>
  console.log('<?php echo $baseurl; ?>');
  console.log('<?php echo $url; ?>');

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
    $(document).on('click', '.nav-link', function(e) {
      e.preventDefault();

      let href = $(this).attr('href'); // e.g. doctors/doctors.php

      // Page load + Save to localStorage
      loadPage(href);
    });

  });
</script>
