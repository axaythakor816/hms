<?php
require_once('../includes/header.php'); // CSS/JS include

require_once '../../core/init.php';

if (isset($_GET['action']) && $_GET['action'] === 'logout') {
    logout("Logout Successfully");
}

// Check Login
require_login();

// If logged in, then check role
$baseurl = base_url($_SERVER['REQUEST_URI']);
$url = check_role($_SESSION['role_id']);

// if ($baseurl != $url) {
//     redirect($url);
//     exit;
// }

if (!has_permission('dashboard', 'can_view')) {
  showalert("error", "Access Denied");
  // redirect('http://localhost/hms/public/page-login.php');
  exit;
}
require_once('../includes/header-bar.php');  // header + sidebar include


?>

<div id="content-container">
  
  <!-- Dynamic content yahan load hoga -->
</div>

<?php
require_once('../includes/footer.php');
?>
<script>
  console.log('<?php echo $baseurl; ?>');
  console.log('<?php echo $url; ?>');

  function loadPage(page) {
    $('#content-container').html('Loading...');
    // console.log(page);
    // Save current page (refresh ke liye)
    localStorage.setItem("currentPage", page);

    $.ajax({
      url: page,
      method: 'post',
      success: function(data) {
        $('#content-container').html(data);
      },
      error: function(xhr, status, error) {
        console.log("Ajax Error: ", error);
        console.log("Status: ", status);
        console.log("Response: ", xhr.responseText);
        $('#content-container').html('<p>Error loading page.</p>');
      }
    });
  }

  $(document).ready(function() {

    // On refresh — page restore
    let savedPage = localStorage.getItem("currentPage");

    if (savedPage) {
      loadPage(savedPage);
    } else {
      // loadPage("home.php"); // Default
      loadPage("<?php echo 'dashboard/' . check_role($_SESSION['role_id']);?>");  

    }

    // Sidebar links
    $(document).on('click', '.nav-link', function(e) {
      e.preventDefault();

      let href = $(this).attr('href'); // page url

      // Page load + Save to localStorage
      loadPage(href);
    });

  });
</script>
