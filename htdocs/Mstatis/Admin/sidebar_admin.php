<?php
session_start(); // Ensure session is started
// Check if user is not logged in, redirect to login page
if (!isset($_SESSION['username'])) {
  header('location: index.php');
  exit(); // Stop further execution
}
$current_page = basename($_SERVER['PHP_SELF']);
require '../connect.php';

// Retrieve user details from the database
$username = $_SESSION['username'] ?? ''; // Ensure $_SESSION['username'] is set

$sql = "SELECT * FROM users WHERE username = '$username'";
$result = $connect->query($sql);

if ($result === false) {
    // Handle query error
    echo "Error: " . $connect->error;
} else {
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $username = $row['username'];
        // Assuming the column name is 'Location' in your table
        $location = $row['Location'] ?? '';
        // Assuming the column name is 'Image' in your table
        $imageData = $row['Image'] ?? '';
        // Set image URL
        $image_url = 'data:image/jpeg;base64,' . base64_encode($imageData);
        // Assuming the column name is 'email' in your table
        $email = $row['email'] ?? '';
        $password = $row['password'] ?? '';
    } else {
        echo "0 results";
    }
}

$connect->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
<link href="https://fonts.googleapis.com/css?family=Source+Serif+Pro:400,600&display=swap" rel="stylesheet">
<link rel="stylesheet" href="../sidebar/fonts/icomoon/style.css">
<link rel="stylesheet" href="../sidebar/css/owl.carousel.min.css">
<!-- Bootstrap CSS -->
<link rel="stylesheet" href="../sidebar/css/bootstrap.min.css">
<!-- Style -->
<link rel="stylesheet" href="../sidebar/css/style.css">
<title>Coming Soon</title>
<style>
  body {
    margin: 0;
    padding: 0;
    font-family: Arial, sans-serif;
    background-color: #f0f0f0;
    height: 100vh;
    display: flex;
    justify-content: center;
    align-items: center;
  }
  
  .container {
    text-align: center;
  }
  
  h1 {
    font-size: 3rem;
    margin-bottom: 20px;
    color: #333;
  }
  
  p {
    font-size: 1.2rem;
    margin-bottom: 40px;
    color: #555;
  }
  
  .subscribe {
    padding: 10px 20px;
    background-color: #007bff;
    color: #fff;
    text-decoration: none;
    border-radius: 5px;
    transition: background-color 0.3s ease;
  }
  
  .subscribe:hover {
    background-color: #0056b3;
  }
 
</style>
</head>
<body>
<aside class="sidebar">
    <div class="toggle">
        <a href="#" class="burger js-menu-toggle" data-toggle="collapse" data-target="#main-navbar">
            <span></span>
        </a>
    </div>
    <div class="side-inner">
        <div class="profile">
          
            <img src="<?php echo $image_url; ?>" alt="Profile Image" class="img-fluid">
            <h3 class="name"><?php echo $username; ?></h3>
            <span class="country"><?php echo $location; ?></span>
        </div>
        <div class="nav-menu">
            <ul>
                <li <?php if($current_page == 'TableShow.php') echo 'class="active"'; ?>><a href="TableShow.php"><span class="  mr-3"><i class="fa-solid fa-eye"></i></span>Data View</a></li>
                <li <?php if($current_page == 'Addrecords_admin.php') echo 'class="active"'; ?>><a href="AddRecords_admin.php"><span class="  mr-3"><i class="fa-solid fa-plus"></i></span>Add Records</a></li>
                <li <?php if($current_page == 'UpdateRecord_admin.php') echo 'class="active"'; ?>><a href="UpdateRecord_admin.php"><span class="  mr-3"><i class="fa-solid fa-pencil"></i></span>Update Record</a></li>
                <li><a href="Export_admin.php"><span class="mr-3"><i class="fa-solid fa-file-export"></i></span>Export_Data</a></li>
                <li><a href="User_logs.php"><span class="mr-3"><i class="fa-solid fa-users"></i></span>Users_log</a></li>

                <li <?php if($current_page == 'Graph_admin.php') echo 'class="active"'; ?>><a href="Graph_admin.php"><span class=" mr-3"><i class="fa-solid fa-chart-simple"></i></span>Graphs</a></li>
                <li <?php if($current_page == 'Profile_admin.php') echo 'class="active"'; ?>><a href="Profile_admin.php"><span class=" mr-3"><i class="fa-solid fa-user"></i></span>Profile</a></li>
                <li><a href="logout.php"><span class="icon-sign-out mr-3"></span>Sign out</a></li>
            </ul>
        </div>
    </div>
</aside>

<div class="overlay"></div> <!-- The overlay element -->

<!-- JavaScript to toggle the sidebar and overlay -->
<script>
  const sidebarToggle = document.querySelector('.js-menu-toggle');
  const overlay = document.querySelector('.overlay');

  sidebarToggle.addEventListener('click', function() {
    document.body.classList.toggle('sidebar-open');
  });
</script>

</body>
</html>
