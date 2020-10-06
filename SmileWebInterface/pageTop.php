<?php
// The file addAppAdmin.php is adapted from personal written code for the Module "Database and Information Management Systems (19/20)" with the course code COMP0022-PG taught at UCL

// Initiating necessary variables
$accountName="My Account";


// Retriving the Account name to display it on the pageTop. However, the client decided in the last iteration against it.
/*
    $query_name = "SELECT first_name, last_name FROM smiledatabase.admin WHERE admin_id='$userID'";
    $query_name_result=mysqli_query($link, $query_name);

    if($query_name_result == TRUE){
        $name_array=mysqli_fetch_array($query_name_result);
        if(strlen($name_array['first_name']) > 9){
            $accountName="Admin";
        }else{
            $accountName=$name_array['first_name'];
        }
    }else{
        $accountName="Admin";
    }
*/

    $active = "font-size: 18px; padding-left: 45px; padding-right: 15px; color:#6ac5fe; width: 120%;";
    $inactive = "font-size: 18px; padding-left: 45px; padding-right: 15px; color: #454546; width: 120%;";
?>
<nav class="navbar sticky-top navbar-expand-lg navbar-light bg-light">
    <div class= "container" style="margin-left: auto; margin-right: auto;">
    <a class="navbar-brand" href="index.php" style="padding-left:15px;"><kbd style="background-color: #6ac5fe; font-size: 30px;">Smile</kbd></a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item <?php if(basename($_SERVER["PHP_SELF"]) == 'index.php'){echo 'active';}?>">
                <a class="nav-link" href="index.php" style="<?php if(basename($_SERVER["PHP_SELF"]) == 'index.php'){echo $active;} else{echo $inactive;}?>">Home</a>
            </li>
            <li class="nav-item <?php if(basename($_SERVER["PHP_SELF"]) == '/educationalContent.php'){echo 'active';}?>">
                <a class="nav-link" href="educationalContent.php" style="<?php if(basename($_SERVER["PHP_SELF"]) == 'educationalContent.php'){echo $active;} else{echo $inactive;}?>"> Manage Content</a>
            </li>
            <li class="nav-item <?php if(basename($_SERVER["PHP_SELF"]) == 'userStatistics.php'){echo 'active';}?>">
                <a class="nav-link" href="userStatistics.php" style="<?php if(basename($_SERVER["PHP_SELF"]) == 'userStatistics.php'){echo $active;} else{echo $inactive;}?>">App Statistics</a>
            </li>    
            <li class="nav-item <?php if(basename($_SERVER["PHP_SELF"]) == 'manageAppAdmin.php'){echo 'active';}?>">
                <a class="nav-link" href="manageAppAdmin.php" style="<?php if(basename($_SERVER["PHP_SELF"]) == 'manageAppAdmin.php'){echo $active;} else{echo $inactive;}?>">Manage Admins</a>
            </li>
            <li class="nav-item <?php if(basename($_SERVER["PHP_SELF"]) == 'manageUserAccounts.php'){echo 'active';}?>">
                <a class="nav-link" href="manageUserAccounts.php" style="<?php if(basename($_SERVER["PHP_SELF"]) == 'manageUserAccounts.php'){echo $active;} else{echo $inactive;}?>">Manage Users</a>
            </li>
            <li class="nav-item dropdown <?php if(basename($_SERVER["PHP_SELF"]) == 'editProfile.php' || basename($_SERVER["PHP_SELF"]) == 'resetPassword.php' ){echo 'active';}?>">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="<?php if(basename($_SERVER["PHP_SELF"]) == 'editProfile.php' || basename($_SERVER["PHP_SELF"]) == 'resetPassword.php' ){echo $active;} else{echo $inactive;}?>">
                <?php echo $accountName; ?>
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                <a class="dropdown-item" onclick="window.location.href='editProfile.php'" style="font-size: 17px;">Manage Account</a>
                <a class="dropdown-item" onclick="window.location.href='resetPassword.php'" style="font-size: 17px;">Change Password</a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="logout.php" style="font-size: 17px;">Log Out</a>
                </div>
            </li>
        </ul>
    </div>
    </div>
</nav>