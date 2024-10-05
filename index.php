<?php
// connection with database 
$host = "localhost"; // host name
$username = "root";
$passsword = '';
$dbname = 'company';
$con = mysqli_connect($host,$username,$passsword,$dbname);

//DELETE DATA
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $deleteQuery = "DELETE FROM `employees` WHERE id = $id";
    $delete = mysqli_query($con, $deleteQuery);
    header("Location: index.php ");
}
$name = '';
$email= '';
$phone= '';
$gender= '';
$empId = '';
$department= '';
$search='';
$message = '';
$mode = 'create';

//EDIT DATA
if (isset($_GET['edit'])) {
    $id = $_GET['edit'];
    // echo $id;
    $selectById = "SELECT * FROM `employees` where id = $id";
    $result = mysqli_query($con,$selectById);
    $row = mysqli_fetch_assoc($result);
    $name= $row['name'];
    $email= $row['email'];
    $phone= $row['phone'];
    $gender= $row['gender'];
    $department= $row['department'];
    $mode = 'update';
    $empId = $id;
}
if (isset($_POST['update'])) {
    # code...
    $name = $_POST['name'];
    $phone= $_POST['phone'];
    $email= $_POST['email'];
    $gender= $_POST['gender'];
    $department= $_POST['department'];
    $updateQuery = "UPDATE `employees` set `name` = '$name', email = '$email' ,phone = '$phone', gender = '$gender', department = '$department' where id = $empId";
    $update = mysqli_query($con, $updateQuery);
    header("LOcation: index.php");
}
//Create Data
if (isset($_POST['submit'])) {
    $name = $_POST['name'];
    $phone= $_POST['phone'];
    $email= $_POST['email'];
    $gender= $_POST['gender'];
    $department= $_POST['department'];

    // Check if email already exists 
    $checkEmailquery = "SELECT * FROM `employees` WHERE email = '$email'";
    $result = mysqli_query($con,$checkEmailquery);
    if (mysqli_num_rows($result)>0) {
        // echo "Error: Email already exists!";
        # code...
    }else{
        //insert data 
        $insertQuery = "INSERT INTO `employees` VALUES (NULL,'$name','$email','$phone','$gender','$department')";
        $insert = mysqli_query($con,$insertQuery);
    }
    
}
if (isset($_GET['asc'])) {
    if (!isset($_GET['orderBy'])) 
    {
        $message = 'Please Select Column to Order By';
    }else{
        $order = $_GET['orderBy'];
        $selectQuery = "SELECT *FROM `employees` ORDER BY $order Asc";
    }

}
if (isset($_GET['Desc'])) {
    if (!isset($_GET['orderBy'])) 
    {
        $message = 'Please Select Column To Order By';
    }else{
        $order = $_GET['orderBy'];
        $selectQuery = "SELECT *FROM `employees` ORDER BY $order Desc";
    }
   
}
//Read Data
$selectQuery = "SELECT * FROM `employees`";

// search 
if (isset($_GET['search'])) 
{
    
    $value = $_GET['search'];
    $search = $value;
    $selectQuery = "SELECT * FROM `employees` where `name` like '%$value%' or email like '%$value%' or department like '%$value%'";
}
// submit to Database 
$select = mysqli_query($con,$selectQuery);




 ?>
 <!DOCTYPE html>
 <html lang="en">
 <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
<style>
    body{
        background-color: #333;
        color : white;
    }
</style> 
</head>
 <body>
    <div class="container py-2">
        <div class="card bg-dark text-light">
            <div class="card-body">
                <form method='POST'>
                <div class="row">
                <div class="col-md-6 mb-3">
                        <label for="neme" class='form-label'>Name</label>
                        <input type="text" value= "<?= $name?>"id= "name" name='name' class= "form-control">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="email" class='form-label'>Email</label>
                        <input type="email" value= "<?= $email?>"id = "email" name='email'class= "form-control">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="phone" class='form-label'>Phone</label>
                        <input type="text" id="phone"  value= "<?= $phone?> " name='phone' class= "form-control">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="gender" class='form-label'>Gender</label>
                        <select  id="gender" name='gender' class="form-select">
                            <?php if ($gender == 'male'):?>
                                <option disabled >Choose</option>
                                <option value="male"selected>Male</option>
                                <option value="female">Female</option>
                            <?php elseif ($gender == 'female'):?>
                                <option disabled >Choose</option>
                                <option value="male">Male</option>
                                <option value="female"selected>Female</option>
                            <?php else:?>
                                <option disabled selected>Choose</option>
                                <option value="male">Male</option>
                                <option value="female">Female</option>
                            <?php endif;?>    
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="department" class='form-label'>Department</label>
                        <input type="text" value= "<?= $department?>" id="department" name='department' class= "form-control">
                    </div>
                    <div class="col-12 text-center">
                        <?php if($mode == 'update'):?>
                            <button class="btn btn-warning" name = "update">UPDATE</button>
                            <a href="index.php" class="btn btn-secondary">Cancle</a>
                        <?php else:?>    
                        <button class="btn btn-primary" name='submit'>Submit</button>
                        <?php endif;?>
                    </div>
                
                </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Search bar -->
    <div class="container py-2">
        <div class="card bg-dark text-light">
            <div class="card-body">
                
            <h2 class="text-center">filters</h2>
                <form>
                    <div class="mb-3">
                        <label for="search" class="form-label">Search</label>
                        <div class="input-group">
                            <input type="text" class="form-control" value="<?=$search?>" name="search" id="search" > 
                            <button class="btn btn-primary">Search</button>
                        </div>
                    </div>
                </form>
                <!-- Order  -->
                <form>
                    <h5 class="text-danger"><?=$message?></h5>
                    <div class="row align-items-center">
                        <div class="col-md-8 mb-3">
                            <label for="orderBy">Order By</label>
                            <select name="orderBy" id="orderBy" class="form-select">
                                <option disabled selected>Choose... </option>
                                <option value="id">Id </option>
                                <option value="name">Name</option>
                                <option value="email">Email</option>
                                <option value="phone">Phone</option>
                                <option value="gender">Gender</option>
                                <option value="department">Department </option>

                            </select>
                        </div>
                        <div class="col-md-4 md-3">
                            <button class="btn btn-info" name="asc">Ascending</button>                                
                            <button class="btn btn-info"name="Desc">Descending</button>

                        </div>
                    </div>

                </form>
                <a href="./index.php" class="btn btn-secondary">Cancle</a>

                </div>
        </div>
    </div>
    <div class="container py-2">
        <div class="card bg-dark">
            
            <table class="table table-dark">
                <thead>
                    <tr>
                        <th>index</th>
                        <th>name</th>
                        <th>email</th>
                        <th>phone</th>
                        <th>gender</th>
                        <th>department</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Data LOOP -->
                     <?php foreach($select as $index=>$emp):?>
                    <tr>
                    <td><?= $index + 1?></td>
                    <td><?= $emp['name']?></td>
                    <td><?= $emp['email']?></td>
                    <td><?= $emp['phone']?></td>
                    <td><?= $emp['gender']?></td>
                    <td><?= $emp['department']?></td>
                    <td>
                        <!-- <form >
                            <input type="text" name= "delete" hidden value="<?= $emp['id']?>">
                            <button class="btn btn-danger">DELETE</button>

                        </form> -->
                        <a href="?edit=<?= $emp['id']?> "class="btn btn-warning"">EDIT</a>
                        <a href="?delete=<?= $emp['id']?> "class="btn btn-danger"">DELETE</a>
                    </td>
                    </tr>
                    <?php endforeach;?>
                    <!-- End of loop -->

                    
                </tbody>
            </table>
        </div>
    </div>
  

 </body>
 </html>

