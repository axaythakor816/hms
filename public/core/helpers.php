<?php

function filteration($data){
    foreach($data as $key => $value){
        // 'site_title':
        $value=trim($value);
        $value=stripslashes($value);
        $value=htmlspecialchars($value);
        $value=strip_tags($value);

        $data[$key]=$value;
    }
    return $data;
}

function select($sql, $values, $datatypes) {
    $conn = $GLOBALS['conn'];
    if($stmt = mysqli_prepare($conn,$sql)) {
        mysqli_stmt_bind_param($stmt, $datatypes, ...$values);
        if(mysqli_stmt_execute($stmt)) {
            $res = mysqli_stmt_get_result($stmt);
            mysqli_stmt_close($stmt);
            return $res;
        } else {
            mysqli_stmt_close($stmt);
            die("Query cannot be executed - select");
        }
    } else {
        die("Query cannot be prepared - select");
    }
}


function redirect($url) {
    echo "<script>
        window.location.href='$url';
        </script>";
}
function alert($type, $msg) {
    $bs_class = ($type == "success") ? "alert-success" : "alert-danger";

    echo <<<alert
    <div class="alert $bs_class alert-dismissible fade show custom-alert" role="alert">
      <strong class="me-3">$msg</strong> 
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
  alert;
}

?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
</script>
<script>
function alert(type, msg,position='body') {
    let bs_class = (type == "success") ? 'alert-success' : 'alert-danger';
    let element = document.createElement('div');
    element.innerHTML = `
         <div class="alert ${bs_class}  alert-dismissible fade show" role="alert">
      <strong class="me-3">${msg}</strong> 
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
        `;
        
      if(position=='body'){
        document.body.append(element);
        element.classList.add('custom-alert');
      }
      else{
        document.getElementById(position).appendChild(element);
      }
        
        setTimeout(remAlert,2000);
}

function remAlert(){
  document.getElementsByClassName('alert')[0].remove();
}


function setActive() {
  // Get the navbar container (adjust ID if needed)
  let navbar = document.getElementById('navbar-menu');
  if (!navbar) return; // Safety check

  // Get all anchor tags inside the navbar
  let a_tags = navbar.getElementsByTagName('a');

  // Get current page filename (e.g. "page-about2.php")
  let currentFile = window.location.pathname.split("/").pop();

  for (let i = 0; i < a_tags.length; i++) {
    let file = a_tags[i].getAttribute("href").split("/").pop();

    // Match the current file name with the link href
    if (file === currentFile) {
      a_tags[i].classList.add("active");
    } else {
      a_tags[i].classList.remove("active");
    }
  }
}

document.addEventListener("DOMContentLoaded", setActive);

</script>
