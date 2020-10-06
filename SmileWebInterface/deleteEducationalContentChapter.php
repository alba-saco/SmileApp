<?php
// The visual display of the table in this file has been adapted from https://datatables.net/manual/installation
// The Javascript Function Datatable has been adapted from https://datatables.net/manual/installation

// Start the session
session_start();

// Ensure the user is logged in
if (!isset($_SESSION['userID'])){
    header("location: login.php");
}

// Get the databse connection
include "config.php";
// Get Connection and Functionality to delete blob from blob storage
include "blobConfig.php";

//Identify the user
$userID = $_SESSION['userID'];

//initiating variables
$error_message = "";
$styleDisappear = "";
$chapterExist = "";
$validSubmission = "";

// Retrieving the existing categories and respective chapters from the database, for which quizzes exist
$catchap_query = "SELECT catchap.catCategoryID AS categoryID, catchap.chapChapterID AS chapterID, category_name, chapter_title, chapter_number, reading_image_url AS readingImageURL,catchap.chapter_image_url AS chapterImageURL
                  FROM smiledatabase.content
                  INNER JOIN(
                  SELECT *
                      FROM(
                      SELECT cat.category_id AS catCategoryID, category_name, chap.chapter_id AS chapChapterID, chap.category_id AS chapCategoryID, chapter_title, chapter_number, chapter_image_url 
                      FROM smiledatabase.chapter as chap
                      LEFT JOIN smiledatabase.category AS cat ON cat.category_id = chap.category_id
                      ) AS catchap
                  ) catchap ON catchap.chapChapterID = content.chapter_id";

if(mysqli_query($link, $catchap_query)){
    $catchap_query_result = mysqli_query($link, $catchap_query);
    
    if(mysqli_num_rows($catchap_query_result) < 1){  
        $error_message = "You cannot delete a chapter, as you have not uploaded any educational content yet.";
        $styleDisappear = '"display:none;"';
        $chapterExist = False;  
    }
}else{
    $error_message = "Sorry, an error occurred connecting to the database. Please, try again later.";
    $styleDisappear = "'display:none;'";
    $chapterExist = "error";
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $chapter_id = $_POST['identifier'];
  $query_chapter = "DELETE FROM smiledatabase.chapter WHERE chapter_id = '$chapter_id'";
  $query_content = "DELETE FROM smiledatabase.content WHERE chapter_id='$chapter_id'";
  $query_quiz = "DELETE FROM smiledatabase.quiz WHERE chapter_id='$chapter_id'";

  if((mysqli_query($link, $query_quiz))){
  if((mysqli_query($link, $query_content))){
    //Deleting the content image from the Blob Storage
    $containerNameContent = "readingimages";
    $contentImageURL = $_POST['readingImage'];
    deleteBlob($containerNameContent, $contentImageURL);
      if(mysqli_query($link, $query_chapter)){
        //Deleting the content image from the Blob Storage
        $containerNameChapter = "chapterimages";
        $chapterImageURL = $_POST['chapterImage'];
        deleteBlob($containerNameChapter, $chapterImageURL);
        $validSubmission = True;
        header("location: deleteEducationalContentChapter.php?success='True'");
      }else{
        $validSubmission = False;
        $error_message = "*An error ocurred attempting to delete the SmileChapter. Only the content of the chapter has been deleted, but not the chapter itself. Please, fix this inconsistency in the database. Please, try again later.";
      }
  }else{
    $validSubmission = False;
    $error_message = "*An error ocurred attempting to delete the SmileChapter. Only, the quiz associated to the chapter was alraedy deleted. Please, try again later.";
  }
}
else{
  $validSubmission = False;
  $error_message = "*An error ocurred attempting to delete the quiz associated to the SmileChapter, causing the remaining request not to be executed. Please, try again later.";
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
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.css">
    <title>Delete Educational Content</title>
  </head>
  <body>
  <?php include_once "pageTop.php"; ?>
    <div class = "container" style = "margin-top:30px">
    <?php
      //Displays, in case of a successful or a faulty error form submission.
      if(isset($_GET['success'])=="True"){
        $validSubmission = True;
      }
      if($validSubmission === True){
        echo '<div class="alert alert-success">
                    <small><strong>The chapter has been successfully deleted from the database!</strong></small>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>';
        $validSubmission = "";
    }
    elseif($validSubmission === False){
        echo '<div class="alert alert-danger">
                    <small><strong>'.$error_message.'</strong></small>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>';
        $validSubmission = "";
    }else{
        echo '';
    }
    //Displays, in case an no chapters have been created yet or an error occurred retrieving those
        if($chapterExist === False){
            echo '<div class="row justify-content-center">
                <div class="col-sm-3" style="margin-top:100px; text-align: center;">
                    <h3 style="color:#d6efff">Manage Content</h3>
                    <svg class="bi bi-caret-down" width="3.5em" height="3.5em" viewBox="0 0 16 16" fill="currentColor" style="color:#6ac5fe;"  xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M3.204 5L8 10.481 12.796 5H3.204zm-.753.659l4.796 5.48a1 1 0 001.506 0l4.796-5.48c.566-.647.106-1.659-.753-1.659H3.204a1 1 0 00-.753 1.659z" clip-rule="evenodd"/>
                    </svg>
                    <h3 style="color:#6ac5fe">Manage <kbd style="background-color: #6ac5fe">Smile</kbd>&nbsp;Chapters</h3>
                </div>
                <div class="col-sm-9" style="margin-top:150px; text-align: center;">
                    <div class="alert alert-secondary" style="text-align: center;">
                        <h6><strong>'.$error_message.'</strong></h6>
                    </div>
                </div>
                </div>';
            $chapterExist = "";
        }
        elseif($chapterExist == "error"){
            echo '<div class="row justify-content-center">
                <div class="col-sm-3" style="margin-top:100px">
                    <h1 style="color:#6ac5fe">Manage <kbd style="background-color: #6ac5fe">Smile</kbd>&nbsp;chapters<br>here.</h1>
                </div>
                <div class="col-sm-9" style="margin-top:150px">
                    <div class="alert alert-danger" style="text-align: center;">
                        <h6><strong>'.$error_message.'</strong></h6>
                    </div>
                </div>
                </div>';
            $chapterExist = "";
        }else{
            echo '';
        }
      ?>
    <div class="row justify-content-center" style=<?php echo $styleDisappear; ?>>
        <div class="col-sm-3" style="margin-top:160px; text-align: center;">
          <h3 style="color:#d6efff">Manage Content</h3>
          <svg class="bi bi-caret-down" width="3.5em" height="3.5em" viewBox="0 0 16 16" fill="currentColor" style="color:#6ac5fe;"  xmlns="http://www.w3.org/2000/svg">
            <path fill-rule="evenodd" d="M3.204 5L8 10.481 12.796 5H3.204zm-.753.659l4.796 5.48a1 1 0 001.506 0l4.796-5.48c.566-.647.106-1.659-.753-1.659H3.204a1 1 0 00-.753 1.659z" clip-rule="evenodd"/>
          </svg>
          <h3 style="color:#6ac5fe">Manage <kbd style="background-color: #6ac5fe">Smile</kbd>&nbsp;Chapters</h3>
        </div>
        <div class="col-sm-9" style="margin-top:30px">
          <div class = "jumbotron rounded-lg" style = "padding-top:0;padding-right:0;padding-left:0; margin-top:30px; padding-bottom:10px; background-color:white; border: solid; border-color:#6ac5fe; border-width: 4px;">
            <div class = "jumbotron jumbotron-fluid" style="background-color:#6ac5fe; padding-top:10px; padding-bottom:5px; text-align: center" >
              <h2 style = "color:white">Smile Chapters</h2>
            </div>
                <?php
                if($catchap_query_result == TRUE){
                  if (mysqli_num_rows($catchap_query_result) >= 1){
                    $counter = 0;  
                    echo
                          '<div style="display: block; max-height: 400px; overflow-y: auto;  margin-top: 40px; margin-bottom: 20px; margin-left: 40px; margin-right: 40px;">
                          <table id="userTable" align = "center" class="table table-hover" style = "background-color:#f8f9fa; border-width: 4px;">
                          <thead>
                          <tr style="text-align: center;">
                            <th align="left" scope="col">Category&nbsp;Name</th>
                            <th align="left" scope="col">Chapter&nbsp;Title</th>
                            <th align="left" scope="col">Chapter&nbsp;Number</th>
                            <th align="left" scope="col">Has&nbsp;Quiz</th>
                            <th align="left" scope="col">Action</th>
                          </tr>
                          </thead>
                          <tbody>';
                      while ($row_chapters = mysqli_fetch_array($catchap_query_result))
                        {
                          $query_number_quizzes = "SELECT chapter_id, COUNT(chapter_id) as number_of_quizzes FROM smiledatabase.quiz WHERE chapter_id = ".$row_chapters['chapterID']." GROUP BY chapter_id";
                          if(mysqli_query($link, $query_number_quizzes)){
                            $result_query_number_quizzes = mysqli_query($link, $query_number_quizzes);
                            $number_quizzes_array = mysqli_fetch_array($result_query_number_quizzes);

                            if($number_quizzes_array['number_of_quizzes'] >= 1){
                              $number_quizzes = "yes";
                            }else{
                              $number_quizzes = "no";
                            }
                          }else{
                            $number_quizzes = "n. a.";
                          }
                          $counter++;
                          echo'<tr class=""table table-hover">
                                <td align="center">'.$row_chapters['category_name'].'</td>
                                <td align="center">'.$row_chapters['chapter_title'].'</td>
                                <td align="center">'.$row_chapters['chapter_number'].'</td>
                                <td align="center">'.$number_quizzes.'</td>
                                <td align="center">
                                  <form id="contentForm" method="POST" action="'.htmlspecialchars($_SERVER["PHP_SELF"]).'" enctype="multipart/form-data" autocomplete="off">
                                    <input type="hidden" id="identifier" name="identifier" value="'.$row_chapters['chapterID'].'">
                                    <input type="hidden" id="readingImage" name="readingImage" value="'.$row_chapters['readingImageURL'].'">
                                    <input type="hidden" id="chapterImage" name="chapterImage" value="'.$row_chapters['chapterImageURL'].'">
                                    <button class="btn btn-primary" type="submit" style="background-color: #ffffff !important;"><img src="images/delete.png" style="height: 30px; widht: 30px; object-fit: contain;" alt="Delete Image"></button>
                                    </form>
                                </td>
                              </tr>';      
                          }
                      echo '</tbody>
                            </table>
                            </div>';  
                    }
                }
                ?>
            </div>
          </div>
      </div>
    </div>
  </div>
       <!-- Integrating Javascript library from Bootstrap (jQuery, Popper.js and Javascript sublibraries)-->
       <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.js"></script>
    <script>
      $(document).ready( function () {
        $('#userTable').DataTable();
      } );
    </script>
    <?php include "pageFooter.php"; ?>
  </body>
</html>