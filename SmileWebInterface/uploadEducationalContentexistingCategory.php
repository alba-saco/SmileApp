<?php
// The method of validating an image upload has been adapted from https://www.youtube.com/watch?v=JaRq73y5MJk
// The function safeStrInput has been adapted from personal written code for the Module "Database and Information Management Systems (19/20)" with the course code COMP0022-PG taught at UCL

function safeStrInput($inputName, $placeholderValue){
  if(!isset($_POST[$inputName]) || empty($_POST[$inputName])){
      echo "placeholder=".$placeholderValue;
      }else{
          echo "value=".$_POST[$inputName];}
}


// Start the session
session_start();

// Ensure the user is logged in
if (!isset($_SESSION['userID'])){
    header("location: login.php");
}

// Get the databse connection
include "config.php";
// Get Connection and Functionality to upload to the blob storage
include "blobConfig.php";

//Identify the user
$userID = $_SESSION['userID'];

// Initiating Variables
$newCategory = true;

 //define error variables
 $categoryErr = $categoryTitleErr = $categoryImageErr = $categoryNameErr = $chapterTitleErr = $chapterNumberErr = $chapterImageErr = $readingErr = $videoURLErr = $videoTextErr = $readingImageErr = "";
 $errorMessage = $categoryListError =  "";

 //Input variables:
 $category = $categoryTitle = $category = $categoryImage = $categoryName = $chapterTitle = $chapterNumber =  $chapterImage = $reading = $videoURL = $videoText = $readingImage = "";
 $validSubmission = "";

// Retrieving existing category titles for the dropdown menu
$query_categoryTitles = "SELECT category_id, category_name FROM smiledatabase.category";
if(mysqli_query($link, $query_categoryTitles)){
 $query_categoryTitles_result = mysqli_query($link, $query_categoryTitles);
 if($query_categoryTitles_result == ""){
   $categoryListError = "*Note, there are no categories existing yet. Please, add a new category.";
 }
}else{
  $categoryListError = "*An error occurred retrieving existing categories. At the moment you can only add a new category.";
}

// Logic for the form submission to insert new content into the database
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // General processing for new content,which occurs independent of a new category selection

// Storing the selected category ID in a variable for later use
    $categoryID = $_POST['category'];

  if (empty($_POST['chapterTitle'])){
    $chapterTitleErr = "*Chapter Title Required";
  }
  else{
      $provided_chapter_title = $_POST['chapterTitle'];
      $chapter_title_query = "SELECT category_id, chapter_title FROM smiledatabase.chapter WHERE(category_id = '$categoryID' AND chapter_title='$provided_chapter_title')";
      $chapter_title_result = mysqli_query($link, $chapter_title_query);
      if(mysqli_num_rows($chapter_title_result) >= 1){
        $chapterTitleErr = "*The provided chapter title already exists for this category";
      }else{
        $chapterTitle = $_POST['chapterTitle'];
      } 
  }
  if (empty($_POST['chapterNumber'])){
    $chapterNumberErr = "*Chapter Number Required";
  }
  else{
    $provided_chapter_number = $_POST['chapterNumber'];
    $chapter_number_query = "SELECT category_id, chapter_number FROM smiledatabase.chapter WHERE(category_id = '$categoryID' AND chapter_number='$provided_chapter_number')";
    $chapter_number_result = mysqli_query($link, $chapter_number_query);
    if(mysqli_num_rows($chapter_number_result) >= 1){
      $chapterNumberErr = "*The provided chapter number already exists for this category";
    }else{
      $chapterNumber = $_POST['chapterNumber'];
    } 
  }
  // User forgets to upload a picture of the chapter
  if (empty($_FILES['chapterImage'])){
    $chapterImageErr = "*Chapter Image Required";
  }
  else{
      $chapImageName = $_FILES['chapterImage']['name'];
      $chapImageTempLocName = $_FILES["chapterImage"]["tmp_name"];

      // Checking for the correct file type (Source: https://www.youtube.com/watch?v=JaRq73y5MJk)
      $chapImageExtension = explode('.', $chapImageName);
      $chapImageActExtension = strtolower(end($chapImageExtension));
      $chapAllowedExt = array('jpg', 'jpeg', 'png', 'pdf');
      
      //Checks if the selected image type is allowed
      if(in_array($chapImageActExtension, $chapAllowedExt)){
          //Checks if there was an error in the uploading process
          if($_FILES['chapterImage']['error'] === 0){
              //Checks if the image size is too large
              if($_FILES['chapterImage']['size'] < 10000000){
                  $chapImageCheck = 1;
                  // Provide unique Name for each image
                  $chapImageNewName = uniqid('', true).".".$chapImageActExtension;
                  $chapImageDestination = "uploadedChapterImages/".$chapImageNewName;
              }else{
                  $chapterImageErr = "*Your image file size is too big.";
              }
          }else{
              $chapterImageErr = '*There was an error uploading your image, please try again.';
          }  
      }else{
          $chapterImageErr = '*You cannot upload this file type. Only ".jpg", ".jpeg", ".png", ".pdf" file types are allowed.';
      }
    }

    if (empty($_POST['reading'])){
      $readingErr = "*Reading Required";
    }
    else{
        $reading = $_POST['reading'];
    }

    // User forgets to upload a picture of the reading
  if (empty($_FILES['readingImage'])){
    $readImageErr = "*Reading Image Required";
    }
    else{
        $readImageName = $_FILES['readingImage']['name'];
        $readImageTempLocName = $_FILES["readingImage"]["tmp_name"];

        // Checking for the correct file type (Source: https://www.youtube.com/watch?v=JaRq73y5MJk)
        $readImageExtension = explode('.', $readImageName);
        $readImageActExtension = strtolower(end($readImageExtension));
        $readAllowedExt = array('jpg', 'jpeg', 'png', 'pdf');
        
        //Checks if the selected image type is allowed
        if(in_array($readImageActExtension, $readAllowedExt)){
            //Checks if there was an error in the uploading process
            if($_FILES['readingImage']['error'] === 0){
                //Checks if the image size is too large
                if($_FILES['readingImage']['size'] < 10000000){
                    $readImageCheck = 1;
                    // Provide unique Name for each image
                    $readImageNewName = uniqid('', true).".".$readImageActExtension;
                    $readImageDestination = "uploadedReadingImages/".$readImageNewName;
                }else{
                    $readingImageErr = "*Your image file size is too big.";
                }
            }else{
                $readingImageErr = '*There was an error uploading your image, please try again.';
            }  
        }else{
            $readingImageErr = '*You cannot upload this file type. Only ".jpg", ".jpeg", ".png", ".pdf" file types are allowed.';
        }
      }

      if (empty($_POST['video_url'])){
        $videoURLErr = "*Video URL Required";
      }
      else{
          $videoURL = $_POST['video_url'];
      }

      if (empty($_POST['videoText'])){
        $videoTextErr = "*Video Description Required";
      }
      else{
          $videoText = $_POST['videoText'];
      }

  // creating the MySQL query
 
    if(empty($chapterTitleErr) && empty($chapterNumberErr) && empty($chapterImageErr) && empty($readingErr) && empty($readingImageErr) && empty($videoURLErr) && empty($videoTextErr)){
      
      // Inserting the Chapter into the Database
      $chapterQuery = "INSERT INTO smiledatabase.chapter (category_id, chapter_title, chapter_number, chapter_image_url) VALUES ('$categoryID', '$chapterTitle', '$chapterNumber', '$chapImageNewName')";
      if(mysqli_query($link, $chapterQuery)){
        //Check that image is allowed to be uploaded to server
        if($chapImageCheck ===1){
            // Move image from temporary location to destination file on local machine destination
            //move_uploaded_file($chapImageTempLocName, $chapImageDestination);
            // Move category image to Microsoft Azure Blob Storage
            $blobChapContainerDestination = "chapterimages";
            uploadBlob($blobChapContainerDestination, $chapImageTempLocName, $chapImageNewName, $chapImageActExtension);
        }

          //Inserting the Content into the Database
          //Retrieving the last inserted ID of the last used database connection
          $chapterID = mysqli_insert_id($link);
          $contentQuery = "INSERT INTO smiledatabase.content (chapter_id, reading, reading_image_url, video_url, video_description) VALUES ('$chapterID', '$reading', '$readImageNewName', '$videoURL', '$videoText')";
          if(mysqli_query($link, $contentQuery)){
            //Check that image is allowed to be uploaded to server
            if($readImageCheck ===1){
                // Move image from temporary location to destination file on local machine destination
                //move_uploaded_file($readImageTempLocName, $readImageDestination);
                // Move category image to Microsoft Azure Blob Storage
                $blobReadContainerDestination = "readingimages";
                uploadBlob($blobReadContainerDestination, $readImageTempLocName, $readImageNewName, $readImageActExtension);
              }

              $validSubmission = True;
          }
          else{
              $errorMessage = "*An error ocurred when inserting the new content into the database. Please, try later again.";
          }
      }
      else{
          $errorMessage = "*An error ocurred when inserting the new chapter into the database. Please, try later again.";
      }
    }else{
      $errorMessage = "*An error ocurred in one of the input fields. Please, check the input fields.";
    }
}

?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Integrating the Bootstrap CSS Library-->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="SmileCustom.css" type="text/css">
    <title>Upload Educational Content</title>
  </head>
  <body>
    <?php include_once "pageTop.php"; ?>
    <div class = "container" style = "margin-top:30px">
      <?php
          //Displays, in case of a successful or a faulty error form submission.
          if($validSubmission === True){
            echo '<div class="alert alert-success">
                        <small><strong>The chapter has been successfully submitted to the database and added to the respective category!</strong></small>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>';
            $validSubmission = "";
            }else{
                echo '';
            }
        ?>
        <div class="row justify-content-center">
            <div class="col-sm-4" style="margin-top:440px; text-align: center;">
              <h1 style="color:#d6efff">Manage Content</h1>
              <svg class="bi bi-caret-down" width="3.5em" height="3.5em" viewBox="0 0 16 16" fill="currentColor" style="color:#6ac5fe;"  xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" d="M3.204 5L8 10.481 12.796 5H3.204zm-.753.659l4.796 5.48a1 1 0 001.506 0l4.796-5.48c.566-.647.106-1.659-.753-1.659H3.204a1 1 0 00-.753 1.659z" clip-rule="evenodd"/>
              </svg>
              <h1 style="color:#6ac5fe">Upload <kbd style="background-color: #6ac5fe">Smile</kbd>&nbsp;Content</h1>
            </div>
            <div class="col-sm-8" style="margin-top:30px">
                <div class = "jumbotron rounded-lg" style = "padding-top:0;padding-right:0;padding-left:0; margin-top:30px; padding-bottom:10px; background-color:white; border: solid; border-color:#6ac5fe; border-width: 4px;">
                    <div class = "jumbotron jumbotron-fluid" style="background-color:#6ac5fe; padding-top:10px; padding-bottom:5px; text-align: center" >
                    <h2 style = "color:white">Upload Content to an Existing Category</h2>
                </div>
                <form id="contentForm" method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" enctype="multipart/form-data">
                        <div style="margin-left: 30px; margin-right: 30px;">
                            
                            <div class="form-group">
                                <label for="category">Select a Category</label>
                                <br>
                                <select class="form-control" name="category" id="category" onclick="insertCategoryName()">
                                <?php 
                                while ($category_list = mysqli_fetch_array($query_categoryTitles_result)){
                                  echo('<option value='.$category_list['category_id'].'>'.$category_list['category_name'].'</option>');
                                }?>
                                </select>
                                <div class="invalid-feedback d-block"><?php echo $categoryListError; ?></div>
                            </div>
                            <div class="form-group">
                                <label for="name">Chapter Title (max. 50 characters)</label>
                                <br>
                                <input class="form-control" type="text" name="chapterTitle" id="chapterTitle" maxlength="50" <?php safeStrInput("chapterTitle", "Chapter Title");?>>
                                <div class="invalid-feedback d-block"><?php echo $chapterTitleErr; ?></div>
                            </div>
                            <div class="form-group">
                                <label for="name">Chapter Number</label>
                                <br>
                                <input class="form-control" type="text" name="chapterNumber" id="chapterNumber" maxlength="5" <?php safeStrInput("chapterNumber", "Chapter Number");?>>
                                <div class="invalid-feedback d-block"><?php echo $chapterNumberErr; ?></div>
                            </div>
                            <div class="form-group">
                                <label for="productPicture">Upload Chapter Image</label>
                                <br>
                                <input class="form-control-file" type="file" name="chapterImage" id="chapterImage">
                                <div class="invalid-feedback d-block"><?php echo $chapterImageErr; ?></div>
                            </div>
                            <div class="form-group">
                                <label for="productText">Insert Text of Reading</label>
                                <br>
                                <textarea class="form-control" id = "reading" name="reading" placeholder="Insert reading here" rows="6" cols="25"><?php if(!isset($_POST['reading']) || empty($_POST['reading'])){}else{echo $_POST["reading"];}?></textarea>
                                <div class="invalid-feedback d-block"><?php echo $readingErr; ?></div>
                            </div>
                            <div class="form-group">
                                <label for="productPicture">Upload Supporting Image for Reading</label>
                                <br>
                                <input class="form-control-file" type="file" name="readingImage" id="readingImage">
                                <div class="invalid-feedback d-block"><?php echo $readingImageErr; ?></div>
                            </div>
                            <div class="form-group">
                                <label for="name">Insert an "embeded" URL of Video
                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#insertVideo" style="background-color: #ffffff !important;">
                                  <svg class="bi bi-info-circle" style="color:#6ac5fe;" width="1.5em" height="1.5em" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" d="M8 15A7 7 0 108 1a7 7 0 000 14zm0 1A8 8 0 108 0a8 8 0 000 16z" clip-rule="evenodd"/>
                                    <path d="M8.93 6.588l-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533L8.93 6.588z"/>
                                    <circle cx="8" cy="4.5" r="1"/>
                                  </svg>
                                </button>
                                </label>
                                <!-- Modal Starts-->
                                <div class="modal fade" id="insertVideo" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                      <div class="modal-dialog modal-dialog-centered" role="document">
                                        <div class="modal-content">
                                          <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLongTitle">Inserting the Correct Video Link</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                              <span aria-hidden="true">&times;</span>
                                            </button>
                                          </div>
                                          <div class="modal-body">
                                          In order to correctly insert a video into the Smile App, the correct sharing link of the video has to be used.
                                          <br><br>The correct link is the "embed" video link, not the standard "watch link". An example:<br>
                                          <br>Watch Link: https://www.youtube.com/watch?v=XewbmK0kmpI
                                          <br> Notice the word <b>watch</b>.
                                          <br><br>Embed Link: https://www.youtube.com/embed/XewbmK0kmpI
                                          <br> Notice the word <b>embed</b>.
                                          <br><br>How to generate the embed link:
                                          <br><br>1. Manually adjust the normal watch link, which you can see in your browser if you watch the video.
                                          <br>Take the watch link, replace "watch?v=" with "embed/" in the link and you are ready to go.
                                          <br><br>2. Copy the Embed link out of the sharing option of the video platfrom.
                                          <br>Click on "Share" -> Click on Embed -> Copy out the video link, which is written in quotations after "src", and you are ready to go.
                                          </div>
                                          <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                          </div>
                                        </div>
                                      </div>
                                    </div>
                                <!-- Modal Ends"--> 
                                <br>
                                <input class="form-control" type="text" name="video_url" id="video_url" <?php safeStrInput("video_url", "URL of Video");?>>
                                <div class="invalid-feedback d-block"><?php echo $videoURLErr; ?></div>
                            </div>
                            <div class="form-group">
                                <label for="productText">Insert Video Description Text</label>
                                <br>
                                <textarea class="form-control" id = "videoText" name="videoText" placeholder="Video Description" rows="3" cols="25"><?php if(!isset($_POST['videoText']) || empty($_POST['videoText'])){}else{echo $_POST["videoText"];}?></textarea>
                                <div class="invalid-feedback d-block"><?php echo $videoTextErr; ?></div>
                            </div>
                            
                            <button class="btn btn-primary" type="submit">Submit</button>
                        </div>
                    </form>
                  <div class="invalid-feedback d-block" style="padding-left:30px;"><?php echo $errorMessage;?></div>
            </div>
        </div>
    </div>
  </div>
     <!-- Integrating Javascript library from Bootstrap (jQuery, Popper.js and Javascript sublibraries)-->
      <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <?php include "pageFooter.php"; ?>
  </body>
  <?php
// Close the connection to database
mysqli_close($link);
?>
</html>