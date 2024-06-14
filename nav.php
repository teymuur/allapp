
<head>
    <link rel="stylesheet" href="css/nav_styles.css">
</head>
<nav class="navbar">
    <div class="navbar-left">
    <a href="index.php">Home</a>
    </div>
    <div class="navbar-right">
        
    <div class="dropdown">
  <a class="dropbtn"><?php echo $_SESSION['username']?></a>
  <div class="dropdown-content">
    <a href="profile.php?u=<?php echo $_SESSION['username']?>">Profile</a>
    <a href="inbox.php">Inbox</a>
    <a href="logout.php">Logout</a>
  </div>
</div>
    </div>

</nav>
