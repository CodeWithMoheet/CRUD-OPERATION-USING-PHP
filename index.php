<?php
$insert = false;
$update = false;
$delete = false;
//Connect to Database
$servername = "localhost";
$username = "root";
$password = "";
$database = "dbrizzu";

//Create a connection
$conn = mysqli_connect($servername, $username, $password, $database);
//handling error
//Die if connection was not sucessful

if (!$conn) {
    die("Sorry we failed to connect: " . mysqli_connect_error());
}
// else{
//     echo "Connection was sucessful <br>";
// }
if(isset($_GET['delete'])){
    $sno = $_GET['delete'];
    // echo $sno;
    $sql = "DELETE FROM `rizzu`WHERE `sno` = $sno";
    $result = mysqli_query($conn, $sql);
}
//request method
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['snoEdit'])) {
        //update the record
        $sno = $_POST["snoEdit"];
        $title = $_POST["titleEdit"];
        $description = $_POST["descriptionEdit"];

        // Sql query to be executed 
        $sql = "UPDATE `rizzu` SET `title` = '$title' , `description` = '$description' WHERE `rizzu`.`Sno` = $sno;"; //enter table name
        $result = mysqli_query($conn, $sql);
        if ($result) {
            $update = true;
        } else {
            echo "we could not update the record sucessfully";
        }
    } else {
        $title = $_POST["title"];
        $description = $_POST["description"];

        // Sql query to be executed 
        $sql = "INSERT INTO `rizzu` (`title` , `description`) VALUES ('$title', '$description')"; //enter table name
        $result = mysqli_query($conn, $sql);


        //Add a new trip table to the db
        if ($result) {
            $insert = true;
        } else {
            echo "The record was not inserted sucessfully sucessfull! beacuse of error ---->" . mysqli_error($conn);
        }
    }
}
?>


<!-- HTML STARTS FROM HERE -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD Operations</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="//cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">


</head>

<body>

    <!--  edit modal -->
    <!-- <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editModal">
  editModellabel
</button> -->

    <!--  Edit Modal -->
    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModallabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">edit this note</h5>
                    <button type="button" class="btn-close " data-bs-dismiss="modal" aria-label="Close"></button>
                </div> 
                <form action="/CRUD/index.php" method="POST">
                <div class="modal-body">
                   
                        <input type="hidden" name="snoEdit" id="snoEdit">
                        <div class="mb-3">
                            <label for="title" class="form-label"> Note Title</label>
                            <input type="text" class="form-control" id="titleEdit" name="titleEdit" aria-describedby="">
                            <!-- <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div> -->
                        </div>

                        <div class="form-group my-4">
                            <label for="description" class="mb-3">Note Description</label>
                            <textarea class="form-control" id="descriptionEdit" name="descriptionEdit"
                                rows="3"></textarea>
                        </div>

                        <!-- <button type="submit" class="btn btn-primary">Update Note</button> -->
                   
                </div>
                <div class="modal-footer d-block mr-auto">
                    <!-- <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button> -->
                    <button type="submit" class="btn btn-success">Update</button>
                </div>
                </form>
            </div>
        </div>
    </div>

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="#"><b>RIZZU</b> </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="#">Home</a>
                    </li>
                    
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="#">Contact Us</a>
                    </li>
                    
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="#">About Us</a>
                    </li>
                    

                </ul>
                <form class="d-flex">
                    <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                    <button class="btn btn-outline-light" type="submit">Search</button>
                </form>
            </div>
        </div>
    </nav>

    <!-- //adding alert after inserted -->
    <?php
    if ($insert) {

        echo " <div class='alert alert-success alert-dismissible fade show' role='alert'>
       <strong>Sucess!</strong> Your record has been inserted sucessfully
       <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
     </div>";

    }
    ?>
    <div class="container my-5">
        <h2>Add a Note</h2>
        <form action="/CRUD/index.php" method="POST">
            <div class="mb-3">
                <label for="title" class="form-label"> Note Title</label>
                <input type="text" class="form-control" id="title" name="title" aria-describedby="">
                <!-- <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div> -->
            </div>

            <div class="form-group my-4">
                <label for="description" class="mb-3">Note Description</label>
                <textarea class="form-control" id="description" name="description" rows="3"></textarea>
            </div>

            <button type="submit" class="btn btn-success">Add Note</button>
        </form>
    </div>
    <div class="container my-4">

        <!-- INSERT INTO `rizzu` (`Sno`, `Title`, `Description`, `tsstamp`) VALUES ('1', 'Going to mosque', 'going to mosque for prayer', current_timestamp()) -->


        <table class="table" id="myTable">
            <thead>
                <tr>
                    <th scope="col">Sno</th>
                    <th scope="col">Title</th>
                    <th scope="col">Description</th>
                    <th scope="col">Actions</th>
                </tr>
            </thead>
            <tbody>

                <?php
                $sql = "SELECT * FROM `rizzu`";
                $result = mysqli_query($conn, $sql);
                $sno = 0;
                while ($row = mysqli_fetch_assoc($result)) {
                    $sno = $sno + 1;
                    echo " <tr>
        <th scope='row'>" . $sno . "</th>
        <td>" . $row['Title'] . "</td>
        <td>" . $row['Description'] . "</td>
        <td> <button class='edit btn btn-sm btn-primary' id=" . $row['Sno'] . " >Edit</button> <button class='delete btn btn-sm btn-danger' id=d" . $row['Sno'] . " >Delete</button>  </td>
      </tr>";
                }

                ?>
            </tbody>
        </table>

    </div>
    <hr>
     <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
        crossorigin="anonymous"></script>

    <script src="https://code.jquery.com/jquery-3.7.0.min.js"
        integrity="sha256-2Pmvv0kuTBOenSvLm6bvfBSSHrUJ+3A7x6P5Ebd07/g=" crossorigin="anonymous"></script>
    <script src="//cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

    <script>let table = new DataTable('#myTable');</script>

    <script>var alertNode = document.querySelector('.alert')
var alert = bootstrap.Alert.getInstance(alertNode)
alert.close()</script>   

    <script>
        //for edit button
        edits = document.getElementsByClassName('edit');
        Array.from(edits).forEach((element) => {
            element.addEventListener("click", (e) => {
                console.log("edit",);
                tr = e.target.parentNode.parentNode;
                title = tr.getElementsByTagName("td")[0].innerText;
                description = tr.getElementsByTagName("td")[1].innerText;
                console.log(title, description);
                titleEdit.value = title;
                descriptionEdit.value = description;
                snoEdit.value = e.target.id;
                console.log(e.target.id)
                $('#editModal').modal('toggle');

            })
        })

        //for delete button
        deletes = document.getElementsByClassName('delete');
        Array.from(deletes).forEach((element)=>{
            element.addEventListener("click", (e)=>{
                console.log("edit", );
                sno = e.target.id.substr(1,);

                if (confirm("Are you sure you want to delete this note!")) {
                    console.log("yes");
                    window.location = `/CRUD/index.php?delete=${sno}`;
                    //TODO: use post req to submit a form
                }
                else {
                    console.log("no");
                }
            })
        })
    </script>

</body>

</html>

