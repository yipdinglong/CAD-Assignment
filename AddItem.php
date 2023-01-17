<?php $activePage = basename($_SERVER['PHP_SELF'], ".php"); ?>
<link rel="stylesheet" href="dist/css/alt/additem.css">
<?php include('Navbar.php'); ?>
<div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Report Lost Items</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="Dashboard.php">Home</a></li>
              <li class="breadcrumb-item active">Report Lost Item</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
    <div class="card" >
        
  <div class="card-body"">
  <form class="needs-validation" novalidate="" method="post"  enctype="multipart/form-data">
  <div class="form-group">
    <label for="LostItemName">Lost Item Name</label>
    <input type="text" class="form-control" id="getitemName" placeholder="Enter Item Name" style="width:50%;" required>
  </div>
  <div class="form-group">
    <label for="dateandtimefound">Date And Time Found</label>
    <input type="datetime-local" class="form-control" id="getdateandtime" style="width:50%;" required>
  </div>
  <div class="form-group">
    <label for="locationfound">Location Found</label>
    <input type="text" class="form-control" id="getlocationfound" placeholder="Enter Location Name" style="width:50%;" required>
  </div>
  <div class="form-group">
    <label for="reportedby">Reported By</label>
    <input type="text" class="form-control" id="getreportedby" placeholder="Who Found/Reported the Item" style="width:50%;" required>
  </div>
  <div class="form-group">
  <label for="formFile" >Lost Item Image</label>
  <input class="form-control" type="file" name="fileToUpload" id="fileToUpload" style="width:30%;" required>
</div>
<div class="form-group">
  <label for="itemdescription" >Lost Item Description</label>
  <textarea  class="form-control" id="itemdescription" style="width:50%;" required></textarea>
</div>
  <button type="submit" data-toggle="modal" data-target="#success_tic" class="btn btn-primary">Submit</button>

</form>
<div id="success" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-confirm">
                <div class="modal-content">
                <div class="modal-header">
				<div class="icon-box">
					<i class="material-icons">&#xE876;</i>
				</div>				
				<h4 class="modal-title w-100">Success!</h4>	
			</div>
			<div class="modal-body">
				<p class="text-center">New lost item has been added.</p>
			</div>
			<div class="modal-footer">
				<button class="btn btn-success btn-block" data-dismiss="modal">OK</button>
			</div>
                </div>
            </div>
        </div>
    </div>

  </div>
  </div>
</div>
<?php
if(isset($_POST["fileToUpload"])) {
    $target_dir = "upload/";
    $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
    // $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
  
    // if($check !== false) {
    // echo "File is an image - " . $check["mime"] . ".";
    // $uploadOk = 1;
    // } else {
    // echo "File is not an image.";
    // $uploadOk = 0;
    // }
    // Check if file already exists
    if (file_exists($target_file)) {
        echo "Sorry, file already exists.";
        $uploadOk = 0;
    }
    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
    echo "Sorry, your file was not uploaded.";
    // if everything is ok, try to upload file
    } else {
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
        echo "The file ". htmlspecialchars( basename( $_FILES["fileToUpload"]["name"])). " has been uploaded.";
    } else {
        echo "Sorry, there was an error uploading your file.";
    }
    }
    }
?>
<script>
  (function() {
 'use strict';
  window.addEventListener('load', function() {
   // Fetch all the forms we want to apply custom Bootstrap validation styles to
   var forms = document.getElementsByClassName('needs-validation');
   // Loop over them and prevent submission
   var validation = Array.prototype.filter.call(forms, function(form) {
      form.addEventListener('submit', function(event) {
       if (form.checkValidity() === false) {
         event.preventDefault();
         event.stopPropagation();
       }
        else if (form.checkValidity() == true) {
           var Itemname=document.getElementById('getitemName').value
           var Dateandtime=document.getElementById('getdateandtime').value
           var Location=document.getElementById('getlocationfound').value
           var Reportedby=document.getElementById('getreportedby').value
           var Itemlostimage=document.getElementById('fileToUpload').value
           var Description=document.getElementById('itemdescription').value
           var filename=Itemlostimage.split("\\").pop();
           var myHeaders = new Headers();
           myHeaders.append("Content-Type", "text/plain");
          //  Console.log(Itemname+Dateandtime+Location+Reportedby+Itemlostimage+Description)
          fetch('https://etdk4js0ug.execute-api.us-east-1.amazonaws.com/item/createlostitem', {
           method: 'POST',
           headers: myHeaders,
           body: JSON.stringify({
           "LostItemName": Itemname,
           "DateAndTimeFound": Dateandtime,
           "Location": Location,
           "ReportedBy": Reportedby,
           "Description": Description,
           "LostItemImage": "upload/" + filename
        }),
  })
  .then(function(response){
    return response.json()
  })
  .catch(error => console.error('Error:', error));
            $('#success').modal("show");
            event.preventDefault();   
        }
       form.classList.add('was-validated');
      }, false);
    });
  }, false);
})();
</script>
</div>
<?php include('Footer.php'); ?>

