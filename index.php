<?php
include("Config/conn.php");

class action{
    public function show(){
    $obj = new connected();
    $query = $obj->dbConn->prepare("SELECT * FROM `projectform`");
    $query->execute();
    $Alldata = $query->fetchAll(PDO::FETCH_ASSOC);   
    return $Alldata ; 
    }
}?>
<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();


?>
<!DOCTYPE html>
<html>
<head>
  <title>Project Form</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background-color: pink;
      margin: 0;
      padding: 0;
    }

    .form1{
      max-width: 600px;
      margin: 0 auto;
      padding: 20px;
      background-color: #fff;
      box-shadow: 0px 2px 4px rgba(0, 0, 0, 0.1);
      border-radius: 5px;
    }

    .hidden {
      display: none;
    }

    h2 {
      color: #333;
    }

    label {
      font-weight: bold;
      margin-right: 10px;
    }

    input[type="text"],
    input[type="date"],
    select {
      width: 100%;
      padding: 8px;
      margin-bottom: 15px;
      border: 1px solid #ccc;
      border-radius: 3px;
    }

    select {
      height: 34px;
    }

    input[type="submit"] {
      background-color: #007bff;
      color: #fff;
      border: none;
      border-radius: 3px;
      padding: 10px 20px;
      cursor: pointer;
    }

    input[type="submit"]:hover {
      background-color: #0056b3;
    }
    .block{
    width: 90%;
    height: 70px;
    background-color: rgb(19, 19, 117);
    display: flex;
    padding: 30px;
    margin-left: 40px;
    padding-top: 30px;
}
.div4{
     background-color: white;
     width: 70%;
     height: 25%;
     padding: 20px;
     margin-left: 10px;
     margin-top: 1%;
  
     
}
.new1{
  background-color: rgb(236, 179, 23);
    color: white;
    padding: 2px 50px 2px 50px;
    cursor: pointer;
    height: 60%;
    margin-top: 11px;
    margin-left: 3px;

}
  </style>
  <script>


    function showdata() {
          var x = document.getElementById("showdata");
          if (x.style.display === "none") {
            x.style.display = "block";
          } else {
            x.style.display = "none";
          }
      }
    function toggleForm() {
      var form = document.getElementById("projectForm");
      form.classList.toggle("hidden");
    }

    function editform() {
      var form = document.getElementById("editproject");
      form.classList.toggle("hidden");
    }

    function showlist() {
  var form = document.getElementById("datashow");
  form.submit();
}

document.getElementById("showlist").addEventListener("click", showlist);

function editProject(uniqueID) {
        var editForm = document.getElementById("editForm");
        
        editForm.innerHTML = "Editing project with ID: " + uniqueID;
        editForm.style.display = "block";}
  </script>
</head>
<body>
  <div class="block">
    <input class="div4" id="searchInput" type="text" name="text" placeholder="search the data" >
    
        <!-- <button class="new1" id="search" onclick="filterTable()">Search here</button> -->
    </div>
  <div class="form1">
    <?php
     if(isset($_SESSION["msg"])){
        echo $_SESSION["msg"];
    }
    session_destroy();
    ?><br>
    
    <button id="saveForm" onclick="toggleForm()">Add New</button>
    
    <button onclick="showdata()"  id="showlist">Show List</button>


        
<form style="display:none;" action="Controller/control.php" id="datashow" method="POST">
<input type="submit" name="show">
</form>

    <form action="Controller/control.php" id="projectForm" class="hidden" method="POST" >
     
      <label for="thoughtBy">Thought By:</label>
      <input type="text" id="thoughtBy" name="thoughtBy" required><br>

      <label for="projectName">Project Name:</label>
      <input type="text" id="projectName" name="projectName" required><br>

      <label for="discussDate">To be discussed on:</label>
      <input type="date" id="discussDate" name="discussDate" required><br>

      <label for="status">Status:</label>
      <select style="width:103%" id="status" name="status">
        <option value="pending">Pending</option>
        <option value="in_progress">In Progress</option>
        <option value="completed">Completed</option>
      </select><br>

      <input id="formbtn" type="submit" name="submit" value="Save">
      
    </form>
    <div id="editForm" style="display: none;">
    


</div>
    <?php
   $obj = new action();
   
   $data= $obj->show();;
   if(isset($_SESSION['data'])){
   $data=$_SESSION["data"];
   }
       


   echo "<table id='showdata'>";
   echo "<tr><th>Select</th><th>Id</th><th>Thought By</th><th>Project Name</th><th>Discuss Date</th><th>Status</th><th>Action</th></tr>";
   
   $counter = 0;
   
   foreach ($data as $project) {
       $uniqueID = 'project_' . $counter++;
       echo "<tr>";
   
       echo "<td><button id='newpage'><a href='View/file.php?id=" . $project['id'] . "'><input type='checkbox' name='selectedProjects[]' value='" . $project['id'] . "' data-id='" . $project['id'] . "'></a></button></td>";
       echo "<td>" . $project['id'] . "</td>";
       echo "<td>" . $project['ThoughtBy'] . "</td>";
       echo "<td>" . $project['ProjectName'] . "</td>";
       echo "<td>" . $project['DiscussDate'] . "</td>";
       echo "<td>" . $project['Status'] . "</td>";
       echo '<td><button data-status="' . $project['Status'] . '" data-name="' . $project['ProjectName'] . '" data-thought="' . $project['ThoughtBy'] . '" id="EditForm' . $project['id'] . '" onclick="toggleForm(); valueChange(\'EditForm' . $project['id'] . '\')">Edit</button></td>';

       echo "</tr>";
   }
   echo "</table>";

?>

  </div>

  <script>
  function filterTable() {
    var input, filter, table, tr, td, i, txtValue;
    input = document.getElementById("searchInput");
    filter = input.value.toLowerCase();
    table = document.getElementById("showdata");
    tr = table.getElementsByTagName("tr");

    for (i = 0; i < tr.length; i++) {
      tdProjectName = tr[i].getElementsByTagName("td")[2];
      tdStatus = tr[i].getElementsByTagName("td")[3];
      if (tdProjectName && tdStatus) {
        txtValueProjectName = tdProjectName.textContent || tdProjectName.innerText;
        txtValueStatus = tdStatus.textContent || tdStatus.innerText;
        if (txtValueProjectName.toLowerCase().indexOf(filter) > -1 || txtValueStatus.toLowerCase().indexOf(filter) > -1) {
          tr[i].style.display = "";
        } else {
          tr[i].style.display = "none";
        }
      }
    }
  }

  
  function valueChange(id){
  button = document.getElementById(id);

    btn = document.getElementById("formbtn");
    btn.value = "Edit";
    btn.name = "Editform";
    thoughtBy = document.getElementById("thoughtBy");
    name1 = document.getElementById("projectName");
    status1 = document.getElementById("status");


   
  var status = button.getAttribute('data-status');
  var name = button.getAttribute('data-name');
  var thought = button.getAttribute('data-thought');

  thoughtBy.value = thought;
  name1.value = name;
  status1.value = status;

  }
  // document.getElementById("EditForm").addEventListener("click", valueChange);

  function valueChange1(){
    btn = document.getElementById("formbtn");
    btn.value = "save";
    btn.name = "submit";
  }
  document.getElementById("saveForm").addEventListener("click", valueChange1);

  // Attach the filterTable function to the "keyup" event of the search input
  document.getElementById("searchInput").addEventListener("keyup", filterTable);
  </script>
</body>
</html>
