<?php
include 'header.php';
$emailErr = '';
$errors = [];

$countries = $con->query("SELECT * from countries");

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
    if (empty($data["password"])) {
        $errors["password"] = "Password is required";
      }
    if (empty($data["gender"])) {
        $errors["gender"] = "Gender is required";
      }
      if (empty($data["religion"])) {
        $errors["religion"] = "Religion is required";
      }
      if (empty($data["hobbies"])) {
        $errors["hobbies"] = "Hobby is required";
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
      "name" => $_POST['name'],
      "email"  => $_POST['email'],
      "address"  => $_POST['address'],
      "password"  => md5($_POST['password']),
      "gender"  => $_POST['gender'],
      "religion"  => $_POST['religion'],
      "hobbies"  => implode(",", $_POST['hobbies']),
      "country_id" => $_POST['country_id'],
      "division_id" => $_POST['division_id'],
      "district_id" => $_POST['district_id'],
      "image" => fileUpload(),
      
    ];
    return $formated_data;

  }

  function insertData($insert_data ,$con){
    $sql= "insert into students 
        
    (`name` , `email`, `address`, `password`,`gender`,`religion`,`hobbies`,`country_id`,`division_id`,`district_id`, `image`) 
    
    values(
     '".$insert_data['name']."',
     '".$insert_data['email']."',
     '".$insert_data['address']."',
     '".$insert_data['password']."',
     '".$insert_data['gender']."',
     '".$insert_data['religion']."',
     '".$insert_data['hobbies']."',
     '".$insert_data['country_id']."',
     '".$insert_data['division_id']."',
     '".$insert_data['district_id']."',
     '".$insert_data['image']."'
    )";
  
    $result= $con->query($sql);
    return $result;
  }

if (isset($_POST['submit']))
{ 
  
  
    $errors = validateStudentInputData($_POST);
    if(empty($errors)){
        $insert_data = prepareInsertData($_POST);
       
        $result = insertData($insert_data, $con);
        if($result){
            $_SESSION["success_massage"] = "Data inserted successfully";
            header("location:list.php");
        }
        else {
            $_SESSION["error_massage"] = "Failed to insert data";
        }
    }    
}

?>
    <style>
        div{
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
        <div class="mb-3">
          <label for="exampleInputName" class="form-label">Name</label><br><br>
          <span style="color: red;" class="error"> <?php echo !empty($errors["name"]) ? $errors["name"] : "";?></span>
          <input type="text" placeholder="Enter your name" name="name" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" autocomplete="off">
       </div>
        <div class="mb-3">
          <label for="exampleInputEmail1" class="form-label">Email address</label><br><br>
          <span style="color: red;" class="error"> <?php echo !empty($errors["email"]) ? $errors["email"] : "";?></span>
          <input type="text" placeholder="Enter your mail address" name="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" autocomplete="off">
       </div>
       <div class="mb-3">
          <label for="exampleInputPassword1" class="form-label">Address</label><br><br>
          <span style="color: red;" class="error"> <?php echo !empty($errors["address"]) ? $errors["address"] : "";?></span>
          <textarea id="add" name="address" rows="4" cols="50" class="form-control" placeholder="Enter your address"></textarea>
          
       </div>
       <div class="mb-3">
          <label for="exampleInputPassword1" class="form-label">Password</label><br><br>
          <span style="color: red;" class="error"> <?php echo !empty($errors["password"]) ? $errors["password"] : "";?></span>
          <input type="password" placeholder="Enter a password" name="password" class="form-control" id="exampleInputPassword1" autocomplete="off">
       </div>
       <fieldset class="row mb-3">
       <span style="color: red;" class="error"> <?php echo !empty($errors["gender"]) ? $errors["gender"] : "";?></span><br>
    <legend class="col-form-label col-sm-2 pt-3">&nbsp;&nbsp;Gender</legend>
    <div class="col-sm-10">
    <?php foreach ($genders as $key=> $gender) { ?>
          
      <div class="form-check">
        <input class="form-check-input" type="radio" name="gender" value="<?php echo $key ?>">
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
          
        <option value="<?php echo $key ?>"><?php echo $religion ?></option>
        
      <?php } ?>
           

    </select>
  </div>
  
  <div class="mb-3">
   
    <label class="form-check-label" for="inlineFormCheck">
        Hobbies
      </label><br>
      <span style="color: red;" class="error"> <?php echo !empty($errors["hobbies"]) ? $errors["hobbies"] : "";?></span><br>
      
      <?php foreach ($hobbies as $hobby) { ?>
        
        <input class="form-check-input" name="hobbies[]" type="checkbox" value="<?php echo $hobby ?>"><?php echo $hobby ?> </input>
          
        <?php } ?>
    </div>
    <div class="mb-3">
      <select class="form-select" aria-label="Disabled select example" id="country_id" name="country_id">
        <option selected>Select a country</option>
        <?php foreach ($countries as $country) { ?>
          <option value="<?php echo $country['id'] ?>"><?php echo $country['name'] ?></option>
          
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
        <input name="image" class="form-control" type="file" id="formFileMultiple" multiple>
    </div>

    <button type="submit" name="submit" class="btn btn-primary">Submit</button>
  </div>

       
       </form>
     


    </body>
    <?php include 'footer.php';?>

    <script>
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
							        $('#division_id').append('<option value="'+value.id+'">'+value.name+'</option>')
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
							        $('#district_id').append('<option value="'+value.id+'">'+value.name+'</option>')
						});

                  },
                  error: function(jqXHR, textStatus, errorThrown){
                    console.log(textStatus, errorThrown);
                  }
              });
            }
   

          });
     </script>
