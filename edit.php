<?php
include 'header.php';
$country_data = [];
$countries = $con->query("SELECT * from countries");
if ($countries->num_rows > 0) {
  
  while ($row = $countries->fetch_assoc()) {
      $country_data[] = $row;
  }
}


$genders = [
    1 => "Male",
    2 => "Female",
    3 => "Other"
  ];
$hobbies = [
    "Reading",
    "Playing",
    "Swimming",
    "Cooking",
    "Dancing"
  ];
$religions = [
     1 => "Hindu",
     2 => "Muslim",
     3 => "Sikh",
     4 => "Christian"
  ];
$editid = $_GET['editid'];
if (!empty($editid)){
    $sql = "SELECT * FROM `students` where id = '$editid'";
    $student=$con->query($sql);
    $row = $student->fetch_assoc();
    $selected_hobbies = explode(",",$row["hobbies"]);
    //var_dump($selected_hobbies);
   // exit();
}
$emailErr = '';
$errors = [];
function validateStudentInputData($data) {
    $errors = [];
    if (empty($data["name"])) {
        $errors["name"] = "Name is required";
    } 

    if (empty($data["email"])) {
        $errors["email"] = "Email is required";
      } else {
        if (!filter_var($data["email"], FILTER_VALIDATE_EMAIL)) {
          $errors["email"] = "Invalid email format";
        }
    }
    if (empty($data["address"])) {
        $errors["address"] = "Address is required";
      }
    if (empty($data["gender"])) {
        $errors["gender"] = "Gender is required";
      }
    if (empty($data["religion"])) {
        $errors["religion"] = "Gender is required";
      }
      if (empty($data["hobbies"])) {
        $errors["Hobbies"] = "Hobby is required";
      }
      
      
      return $errors;
  }
  function fileUpload(){
    if (isset($_FILES['image']) && (!empty($_FILES['image']['name'])))
    {
      $image_name = time(). $_FILES['image']['name']; 
      $tamp_name = $_FILES['image']['tmp_name'];
      $uploc = "images/" .$image_name;
      if(!move_uploaded_file($tamp_name, $uploc)){
         $uploc = NULL;
      }
      return $uploc ;
  }
}
  function prepareInsertData($data){
    $formated_data = [
      "id" => $_POST['id'],
      "name" => $_POST['name'],
      "email"  => $_POST['email'],
      "address"  => $_POST['address'],
      "gender"  => $_POST['gender'],
      "religion"  => $_POST['religion'],
      "hobbies"  => implode(",",  $_POST['hobbies']),
      "country_id" => $_POST['country_id'],
      "division_id" => $_POST['division_id'],
      "district_id" => $_POST['district_id'],
      "image" => fileUpload(),
    ];
    return $formated_data;
  }
function updateData($data, $con, $id){
  $sql = "UPDATE students SET name='".$data['name']."', email='".$data['email']."' , address='".$data['address']."'  ,  
  gender= '".$data['gender']."', religion = '".$data['religion']."', 
  hobbies = '".$data['hobbies']."' , country_id = '".$data['country_id']."' ,
   division_id = '".$data['division_id']."' , district_id = '".$data['district_id']."', image ='".$data['image']."' WHERE id='$id'";
  $result=$con->query($sql);
  return $result;
}
if(isset($_POST['submit']))
{  
    $id = $_POST['id'];
    $errors = validateStudentInputData($_POST);
    if(empty($errors)){

        $input_data = prepareInsertData($_POST);
        $result = updateData($input_data, $con, $id);
        // var_dump($result);
        // exit;
       
        
    if($result){
        //echo "Data updated successfully";
        $_SESSION["success_massage"] = "Data updated successfully";
        header('Location:list.php');
    }
    else {
        //die(mysqli_error($con));
        $_SESSION["error_massage"] = "Failed to update data";
        header('Location:edit.php?editid='.$editid);
    }
    }
    
}
?>

<style>
        div {
             padding-top: 10px;
             padding-right: 10px;
             padding-bottom: 10px;
             padding-left: 10px;
        }
    </style>
    <body>
     <div class="container" my-5>
        <a href="list.php" class="btn btn-primary">Show List</a>
        <form method="post" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?php echo $editid; ?>">
        <div class="mb-3">
          <label for="exampleInputName" class="form-label">Name</label><br><br>
          <span style="color: red;" class="error"> <?php echo !empty($errors["name"]) ? $errors["name"] : "";?></span>
          <input type="text" placeholder="Enter your name" name="name" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" autocomplete="off" value=<?php echo $row['name'] ?? "";?>>
       </div>
        <div class="mb-3">
          <label for="exampleInputEmail1" class="form-label">Email address</label><br><br>
          <span style="color: red;" class="error"> <?php echo !empty($errors["email"]) ? $errors["email"] : "";?></span>
          <input type="text" placeholder="Enter your mail address" name="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" autocomplete="off" value=<?php echo $row['email'] ?? "";?>>
       </div>
       <div class="mb-3">
          <label for="exampleInputPassword1" class="form-label">Address</label><br><br>
          <span style="color: red;" class="error"> <?php echo !empty($errors["address"]) ? $errors["address"] : "";?></span>
          <textarea id="add" name="address" rows="4" cols="50" class="form-control">
          <?php echo $row['address'] ?? "";?>
          </textarea>
          
       </div>
       <fieldset class="row mb-3">
    <legend class="col-form-label col-sm-2 pt-3">&nbsp;&nbsp;Gender</legend>
    <div class="col-sm-10">
    
    <?php foreach ($genders as $key=> $gender) { ?>
          
          <div class="form-check">
          <span style="color: red;" class="error"> <?php echo !empty($errors["gender"]) ? $errors["gender"] : "";?></span>
            
            <input class="form-check-input" type="radio" name="gender" <?php echo ($key==$row["gender"]) ? "checked":"" ?> value = "<?php echo $key ?>">
           
            <label class="form-check-label" for="gridRadios1">
              <?php echo $gender ?>
            </label>
          </div>
              
            <?php } ?>
    </div>
  </fieldset>

  <div class="col-12">
    <label class="mb-4" for="inlineFormSelectPref">Religion</label></label>
    <select class="form-select" name="religion">

      <?php foreach ($religions as $key=> $religion) { ?>
          
        <option <?php echo ($key==$row["religion"]) ? "selected":"" ?> value="<?php echo $key ?>"><?php echo $religion ?></option>
        
      <?php } ?>
           

    </select>
  </div>

  <div class="mb-3">
    <label class="form-check-label" for="inlineFormCheck">
        Hobbies &emsp;&emsp;
      </label>
      <?php foreach ($hobbies as $hobby) 
      
      { ?>
        
        <input <?php echo in_array($hobby,$selected_hobbies) ? 'checked':'' ?> class="form-check-input" name="hobbies[]" type="checkbox" value="<?php echo $hobby ?>"><?php echo $hobby ?> </input>
        
        <?php } 
       ?>
    </div>
    <div class="mb-3">
      <select class="form-select" aria-label="Disabled select example" id="country_id" name="country_id">
        <option selected>Select a country</option>
        <?php foreach ($country_data as $country) { ?>
          <option <?= ($country['id'] == $row["country_id"]) ? "selected":"" ?> value="<?php echo $country['id'] ?>"><?php echo $country['name'] ?></option>
          
        <?php } ?>
      </select>
      
    </div>
    <div class="mb-3">
      <select class="form-select" aria-label="Default select example" id="division_id" name="division_id">
        <option selected>Division</option>
       
      </select>
    </div>
    <div class="mb-3" >
      <select class="form-select" aria-label="Default select example" id="district_id" name="district_id">
        <option selected>District</option>
      </select>
    </div>
    <div class="mb-3">
        <label for="formFileMultiple" class="form-label">Upload file</label>
        <input name="image" class="form-control" type="file" value=<?php echo $row['image'] ?? "";?> id="formFileMultiple" multiple >
        <img width="100" height="100"src='<?= $row['image'] ?>'>
    </div>

    <button type="submit" name="submit" class="btn btn-primary">Submit</button>
  </div>
       
       </form>
     </div>
    </body>
    <?php include 'footer.php';?>
    <script>
         $(document).ready(function(){
            $("#country_id").trigger("change");
            });

         $("#country_id").on('change', function(){  
            var countryId = $(this).val();
            if(countryId){
              $.ajax({
                  type: "GET",
                  dataType: "json",
                  url: "division.php?country_id=" + countryId,
                  success: function(data)
                  {
                    $('#division_id').empty();
                    $.each(data,function(key,value){
                      //console.log(value);
                      var check = '';
                      var division_id = '<?= $row['division_id']?>';
                      if(division_id && division_id == value.id)
                     {
                       check = 'selected'; 
                     }
                     
							        $('#division_id').append('<option '+check+' value="'+value.id+'">'+value.name+'</option>')
						});
                   $("#division_id").trigger("change");
                  },
                  error: function(jqXHR, textStatus, errorThrown){
                    console.log(textStatus, errorThrown);
                  }
              });
            }
   

          });
         
         
          
          $("#division_id").on('change', function(){  
            var divisionId = $(this).val();
            if(divisionId){
              $.ajax({
                  type: "GET",
                  dataType: "json",
                  url: "district.php?division_id=" + divisionId,
                  success: function(data)
                  {
                    $('#district_id').empty();
                    $.each(data,function(key,value){
                      //console.log(value);
                      var check = '';
                      var district_id = '<?= $row['district_id']?>';
                      if(district_id && district_id == value.id)
                     {
                       check = 'selected'; 
                     }
                     
							        $('#district_id').append('<option '+check+' value="'+value.id+'">'+value.name+'</option>')
						});
                   $("#district_id").trigger("change");
                  },
                  error: function(jqXHR, textStatus, errorThrown){
                    console.log(textStatus, errorThrown);
                  }
              });
            }
   

          });
     </script>
