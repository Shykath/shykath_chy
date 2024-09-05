<?php

include 'header.php';
$country_data = [];
$division_data = [] ;
$district_data  = [] ;
$countries = $con->query("SELECT * from countries");
$divisions = $con->query("SELECT * from divisions");
$districts = $con->query("SELECT * from districts");
if ($countries->num_rows > 0) {
  
  while ($row1 = $countries->fetch_assoc()) {
      $country_data[$row1["id"]] = $row1;
  }
}
//var_dump($country_data["1"]);
//exit;
if ($divisions->num_rows > 0) {
  
  while ($row2 = $divisions->fetch_assoc()) {
      $division_data[$row2["id"]] = $row2;
  }
}
if ($districts->num_rows > 0) {
  
  while ($row3 = $districts->fetch_assoc()) {
      $district_data[$row3["id"]] = $row3;
  }
}
//var_dump($_SESSION);
//exit;
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

{
    $sql= "select * from students";
    //$result = $con->query($sql);
    $result=$con->query($sql);
}

?>
    <body>
     <div class="container" my-5>
     <a href="create.php" class="btn btn-primary">Add student</a>
     <table class="table">
  <thead>
  <tr>
      <th scope="row">Sl</th>
      <th>Id</th>
      <th>Name</th>
      <th>Email</th>
      <th>Address</th>
      <th>Gender</th>
      <th>Religion</th>
      <th>Hobbies</th>
      <th>Country</th>
      <th>Division</th>
      <th>District</th>
      <th>Image</th>
      <th>Action</th>
    </tr>
  </thead>
  <tbody>
  <?php
               
               $no=1;
               while($row = $result->fetch_assoc()){
                
               ?>
                  <tr>
                   <td><?php echo $no++ ?></td>
                   <td><?php echo $row['id'] ?></td>
                   <td><?php echo $row['name'] ?></td>
                   <td><?php echo $row['email'] ?></td>
                   <td><?php echo $row['address'] ?></td>
                   <td><?php echo $genders[ $row['gender'] ]?></td>
                   <td><?php echo $religions[ $row['religion'] ]?></td>
                   <td><?php echo $row['hobbies']?></td>
                   <td><?= $country_data[$row['country_id']]['name'] ??"" ?></td>
                   <td><?= $division_data[$row['division_id']]['name'] ??"" ?></td>
                   <td><?= $district_data[$row['district_id']]['name'] ??"" ?></td>
                 <td >
                    
                      <img width="100" height="100"src='<?= $row['image'] ?>'>
                   </td>
                   <td>
      
                    <a href="edit.php?editid=<?php echo $row['id'] ?>" class = "btn btn-warning">
                    
                    Update
                    </a>
                      
                    
                    <button class="btn btn-danger"  onclick="deleteStudent(<?php echo $row['id'] ?>)" >
                      
                    
                    Delete 
                  
                  
                  
                   </button>
                   </td>
                  </tr>
                  <?php
                  }
                ?>
                
    
  </tbody>
</table>
     </div>

     <!-- Button trigger modal -->
<!-- Button trigger modal -->


<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Do you want to delete it?</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
      <form method="post" Action = "delete.php">
        <input type="hidden" id="delete_id" name="id" value="">

     
      </div>
      <div class="modal-footer">

        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" name="submit" class="btn btn-primary">Confirm</button>
      </div>
      </form>
    </div>
  </div>
</div>
</div>

    </body>
    <!-- Load jQuery first -->

<!-- Then load Bootstrap's JavaScript -->
    <?php include 'footer.php';?>

    <script type="text/javascript">
    function editStudent(id1) 
      {
         $('#edit_id').val(id1);
         $('#exampleModal1').modal('show');
      }
    
   
    

      function deleteStudent(id) 
      {
         $('#delete_id').val(id);
         $('#exampleModal').modal('show');
         //document.getElementById("#delete_id").val(id);
         //document.getElementById("#exampleModal").modal('show');
      }
    </script>
