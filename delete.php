<?php 
include 'header.php';
if (isset($_POST['submit'])) {
    $id = $_POST['id'];
    
    $sql = "DELETE FROM students WHERE id=$id";
    $result = $con->query($sql);
    if ($result) {
        //echo "<script>alter('Delete Successfully')</script>";
		//echo "<script>location.href='list.php'</script>";
        $_SESSION["success_massage"] = "Data deleted successfully";
        header("location:list.php");
    } else {
        //echo "<script>alter('Error occured')</script>";
        //echo "<script>location.href='list.php'</script>";
        $_SESSION["error_massage"] = "Failed to delete data";
        header("location:list.php");
    }
}
?>