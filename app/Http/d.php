<?php
session_start();

// Save the current error handler
$previousHandler = set_error_handler(function($errno, $errstr, $errfile, $errline) {
    if ($errno === E_WARNING) {
        throw new ErrorException($errstr, 0, $errno, $errfile, $errline);
    }
    return false; // Let PHP handle other errors
});
/*
DB_USERNAME=root3
DB_PASSWORD=4WRF7E.S;WWF<d,& */
//database connection
$db_con = mysqli_connect("159.89.237.194","root3","4WRF7E.S;WWF<d,&","edoproje_medu") or die('error connecting to database');
//$db_con = mysqli_connect("127.0.0.1","root3","4WRF7E.S;WWF<d,&","edoproje_medu") or die('error connecting to database');

$list = "style='display:none'";

if(isset($_POST['submit'])){
    $id = trim(strip_tags($_POST['school']));
    header("Location:index.php?id=".$id);
}


if(!empty($_GET['id'])){

    $school_id = $_GET['id'];

    $query1 = "SELECT school_address_lga FROM school_address WHERE school_address_school = '$school_id' ";
    $result_query1= mysqli_query($db_con, $query1) or die("could not execute query1");
    while ($row = mysqli_fetch_array($result_query1)) {
        $lga_id = $row['0'];
    }

    $query2 = "SELECT lga_name FROM lga WHERE lga_id = $lga_id ";
    $result_query2= mysqli_query($db_con, $query2) or die("could not execute query2");
    while ($row = mysqli_fetch_array($result_query2)) {
        $lga_name = $row['0'];
    }

    $query3 = "SELECT school_name, school_code FROM school WHERE school_id = '$school_id' ";
    $result_query3= mysqli_query($db_con, $query3) or die("could not execute query1");
    while ($row = mysqli_fetch_array($result_query3)) {
        $school_name = $row['0'];
        $school_code = $row['school_code'];
    }
    //print_r([$db_con,$school_id]);
    //die();


    $list = "";
}

//print_r([$lga_id,$lga_name,$school_name]);
//die();
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Grade Checker | By School</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="datatables/bootstrap.css">
<link rel="stylesheet" type="text/css" href="datatables/datatables.min.css"/>

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<script src="datatables/jquery.min.js"></script>
<script src="datatables/bootstrap.min.js"></script>
<script src="datatables/datatables.min.js"></script>
<script type="text/javascript">
  function downloadJSAtOnload() {
    var element = document.createElement("script");
    element.src = "defer.js";
    document.body.appendChild(element);
  }
  if (window.addEventListener)
    window.addEventListener("load", downloadJSAtOnload, false);
  else if (window.attachEvent)
    window.attachEvent("onload", downloadJSAtOnload);
  else window.onload = downloadJSAtOnload;
  var x = "EDO STATE OF NIGERIA\n MINISTRY OF EDUCATION\n 2025 PRIMARY SCHOOL CERTIFICATE EXAMINATION RESULTS \n School Name: <?php echo $school_name; ?> \n LGA: <?php echo $lga_name; ?>\n"
</script>
    </head>
    <body>
        <div class="container my-5">
            <div class="text-center">
                <h6>EDO STATE OF NIGERIA</h6>
                <h6>MINISTRY OF EDUCATION</h6>
                <h6>2025 PRIMARY SCHOOL CERTIFICATE EXAMINATION RESULTS</h6>
            </div>
            <hr class="my-3">
             
           <!--<form method="post">
            <div class="col-5">
                <br>
                <select class="form-select" id="school" name="school">
                    <option value="" disabled selected>Select school</option>
                        
                        <?php
                        /*
                        //select primary schools
                        $primary_school = "SELECT * FROM school WHERE school_type = 2 ORDER BY school_name ASC";
                        
                        $result_primary = mysqli_query($db_con, $primary_school) or die("could not execute primary_school");
                            while ($row = mysqli_fetch_array($result_primary))
                                {
                                $name = $row["school_name"];
                                $id = $row["school_id"];
                                $link = "index.php?school_id=".$school_id;
                                
                                $link2= "new_result.php?id=".$school_id;

                                $querylg = "SELECT school_address_lga FROM school_address WHERE school_address_school = '$id' ";
                                $result_querylg= mysqli_query($db_con, $querylg) or die("could not execute query1");
                                while ($row = mysqli_fetch_array($result_querylg)) {
                                    if($row['0'] == 1 || $row['0'] == 9 || $row['0'] == 10 || $row['0'] == 16 || $row['0'] == 17 || $row['0'] == 18 || $row['0'] == 3 || $row['0'] == 4 || $row['0'] == 6 || $row['0'] == 7 || $row['0'] == 8 || $row['0'] == 13 || $row['0'] == 14 || $row['0'] == 15 || $row['0'] == 5 || $row['0'] == 12 || $row['0'] == 2 || $row['0'] == 11){
                                
                        ?>
                    <option value="<?php echo $id; ?>"><?php echo $name; ?></option>
                    <?php }}} */ ?>
                </select>
                <div class="my-2">
                <button type="submit" class="btn btn-success btn-sm" id="submit" name="submit">Query</button>
                </div>
            </div>
            </form>-->
             
            <br>
            <hr class="my-3">
            <div id="list" <?php echo $list; ?>>
                <div class="card shadow mb-4">
     
                    <div class="card-header">
                <div class="row align-items-center">
                    <div class="col-9">
                        <p><strong>LGA-NAME: </strong><?php echo $lga_name; ?></p>
                        <p><strong>SCH-NAME: </strong><?php echo $school_name; ?></p>
                    </div>
                    <div class="col-3">
                        <p><strong>LGA-CODE: </strong><?php echo $lga_id; ?></p>
                        <p><strong>SCH-CODE: </strong><?php echo $school_code; ?></p>
                    </div>
                                    </div>
                    </div>
                    
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered dt-responsive " id="myTable" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>EXAM. NO</th>
                                        <th>PUPIL'S NAME</th>
                                        <th>FINAL GRADE</th>
                                        
                                    </tr>
                                </thead>
                                <tbody>
                                    
                                <a href="<?php echo $link2; ?>" target="_blank" class="btn btn-secondary btn-sm"> </a>
                                    <?php
                                    //select students
                                    $student = "SELECT * FROM student WHERE student_school = $school_id and student_exam in(select exam_id from exam where exam_year ='2025') ORDER BY student_last_name ASC";
                                    $n= 1;
                                   // print_r($student);
                                    $result_student = mysqli_query($db_con, $student) or die("could not execute student");
                                    $studentIds=[];
                                    $rows=[];
                                    while ($row = mysqli_fetch_array($result_student))
                                    {
                                        $studentIds[]=$row["student_id"];
                                        $rows[]=$row;
                                    } 
                                    //print_r($studentIds);
                                    //die();
                                    //$student_ids = [1, 2, 3]; // Example array of student IDs

// Convert the student IDs array into a comma-separated string for the WHERE IN clause
$student_ids_string = implode(',', $studentIds); 
// SQL query to get the data, including WHERE IN and grouping by subject_id
$class1 = "
    SELECT 
        year_1_score, 
        year_2_score, 
        year_3_score, 
        exam_score, 
        subject_id, 
        student_id 
    FROM 
        new_subject_scores 
    WHERE 
        student_id IN ($student_ids_string)
    ORDER BY 
        subject_id ASC
";
$result_class1 = mysqli_query($db_con, $class1) or die("could not execute class1");
// Initialize an empty array to hold the grouped data
$grouped_results = [];

// Loop through the query result and group by subject_id
while ($row = mysqli_fetch_assoc($result_class1)) {
    $subject_id = $row['subject_id'];
    $student_id = $row['student_id'];

    // Create a unique key for each subject_id
    if (!isset($grouped_results[$student_id])) {
        $grouped_results[$student_id] = [];
    }

    // Add the score data for each student under the subject_id
    $grouped_results[$student_id][$subject_id] = [
        '0' => $row['year_1_score'],
        '1' => $row['year_2_score'],
        '2' => $row['year_3_score'],
        '3' => $row['exam_score'],
        '4'=>$row['subject_id'],
        'student_id'=>$student_id
    ];
}

// Now $grouped_results will contain data grouped by subject_id
//print_r($grouped_results); // Just to see the output structure

                                    foreach($rows as $row)   
                                    //while ($row = mysqli_fetch_array($result_student))
                                            {
                                            $student_name = $row[4]." ".$row[5]." ".$row[6];
                                            $student_id = $row["student_id"];
                                            $count= sprintf( '%04d', $n++ );
                                            $exam_no= $lga_id."/".$school_code."/".$count;

                                            
                                            $counter = 0;
                                            $one = 0;
                                            $two = 0;
                                            $three = 0;
                                            $four = 0;
                                            $five = 0;
                                            $six = 0;
                                            $seven = 0;

                                            if(!isset($grouped_results[$student_id])){
                                                $grade = 'Abs';
                                            }else{
                                                
                                                    $ts=0;//total subject
                                                    $tn=0;//total null
                                                    foreach($grouped_results[$student_id] as $row){
                                                    //while ($row = mysqli_fetch_array($result_class1)) {
                                                        if($row[3] != 0 && is_numeric($row[3]) && $row[3] != "" && $row[4] == 19 ){
                                                            $r3 = (float)$row[3];

                                                            $one = ((((float)$row[0] / 100) * 5) + (((float)$row[1] / 100) * 12.5) + (((float)$row[2] / 100) * 12.5) + $r3);
                                                         
                                                            $counter++;
                                                            $total_grade = ($one??0);
                                                        }else if($row[3] != 0 && is_numeric($row[3]) && $row[3] != "" && $row[4] == 20 ){

                                                            $r3 = (float)$row[3]; 
                                                            $two = ((((float)$row[0] / 100) * 5) + (((float)$row[1] / 100) * 12.5) + (((float)$row[2] / 100) * 12.5) + $r3);
                                                         
                                                            $counter++;
                                                            $total_grade = ($one??0) + ($two??0);

                                                            $ts++;
                                                            if(is_null($row[3]) || $row[3] == 0){
                                                                $tn++;
                                                            }
                                                        }else if($row[3] != 0 && is_numeric($row[3]) && $row[3] != "" && $row[4] == 21 ){

                                                            $r3 = (float)$row[3]; 
                                                            $three = ((((float)$row[0] / 100) * 5) + (((float)$row[1] / 100) * 12.5) + (((float)$row[2] / 100) * 12.5) + $r3);
                                                         
                                                            $counter++;
                                                            $total_grade = ($one??0) + ($two??0)+ ($three??0);

                                                            $ts++;
                                                            if(is_null($row[3]) || $row[3] == 0){
                                                                $tn++;
                                                            }
                                                        }else if($row[3] != 0 && is_numeric($row[3]) && $row[3] != "" && $row[4] == 22 ){

                                                            $r3 = (float)$row[3];

                                                            $four = ((((float)$row[0] / 100) * 5) + (((float)$row[1] / 100) * 12.5) + (((float)$row[2] / 100) * 12.5) + $r3);
                                                        

                                                            $counter++;
                                                            $total_grade = ($one??0) + ($two??0)+ ($three??0)+ ($four??0);

                                                            $ts++;
                                                            if(is_null($row[3]) || $row[3] == 0){
                                                                $tn++;
                                                            }
                                                        }else if($row[3] != 0 && is_numeric($row[3]) && $row[3] != "" && $row[4] == 23 ){

                                                            $r3 = (float)$row[3];

                                                            $five = ((((float)$row[0] / 100) * 5) + (((float)$row[1] / 100) * 12.5) + (((float)$row[2] / 100) * 12.5) + $r3);
                                                            $counter++;
                                                            $total_grade = ($one??0) + ($two??0)+ ($three??0)+ ($four??0)+ ($five??0);

                                                            
                                                            $ts++;
                                                            if(is_null($row[3]) || $row[3] == 0){
                                                                $tn++;
                                                            } 

                                                        }else if($row[3] != 0 && is_numeric($row[3]) && $row[3] != "" && $row[4] == 24 ){

                                                            $r3 = (float)$row[3]; 
                                                            $six = ((((float)$row[0] / 100) * 5) + (((float)$row[1] / 100) * 12.5) + (((float)$row[2] / 100) * 12.5) + $r3);
                                                         
                                                            $counter++;
                                                            $total_grade = ($one??0) + ($two??0)+ ($three??0)+ ($four??0)+ ($five??0)+ ($six??0);

                                                            $ts++;
                                                            if(is_null($row[3]) || $row[3] == 0){
                                                                $tn++;
                                                            }
                                                        }else if($row[3] != 0 && is_numeric($row[3]) && $row[3] != "" && $row[4] == 26 ){

                                                            $r3 = (float)$row[3];

                                                            $seven = ((((float)$row[0] / 100) * 5) + (((float)$row[1] / 100) * 12.5) + (((float)$row[2] / 100) * 12.5) + $r3);
                                                            $counter++;
                                                            $total_grade = ($one??0) + ($two??0)+ ($three??0)+ ($four??0)+ ($five??0)+ ($six??0)+ ($seven??0);

                                                            $ts++;
                                                            if(is_null($row[3]) || $row[3] == 0){
                                                                $tn++;
                                                            } 

                                                        }
                                                        

                                                    }
                                                    if ($one < 40 || $two < 40) {
                                                        $grade = 'Fail';
                                                    } else {
                                                        //  echo $total_grade;
                                                        $avg = $total_grade / $counter;
                                                        if ($avg > 69){
                                                            $grade = 'Distinction';}
                                                        else if($avg > 59){$grade = 'Credit';}
                                                        else if($avg > 49){$grade = 'Merit';}
                                                        else if($avg > 39){$grade = 'Pass';}
                                                        else if($avg < 40){$grade = 'Fail';}
                                                    }

                                                    if($ts==$tn){
                                                        $grade = 'Abs';
                                                    }
                                                
                                            }

                                            /*
                                            //Scores
                                            $class1 = "SELECT year_1_score, year_2_score, year_3_score, exam_score, subject_id FROM new_subject_scores WHERE student_id = $student_id ORDER BY subject_id ASC";
                                            $result_class1 = mysqli_query($db_con, $class1) or die("could not execute class1");
                                                if(mysqli_num_rows($result_class1) == 0){
                                                    $grade = 'Abs';
                                                }else{
                                                    $ts=0;//total subject
                                                    $tn=0;//total null
                                                    while ($row = mysqli_fetch_array($result_class1)) {
                                                        if($row[3] != 0 && is_numeric($row[3]) && $row[3] != "" && $row[4] == 19 ){
                                                            $one = ((((float)$row[0] / 100) * 5) + (((float)$row[1] / 100) * 12.5) + (((float)$row[2] / 100) * 12.5) + $r3);
                                                            $counter++;
                                                            $total_grade = ($one??0);
                                                        }else if($row[3] != 0 && is_numeric($row[3]) && $row[3] != "" && $row[4] == 20 ){
                                                            $two = ((((float)$row[0] / 100) * 5) + (((float)$row[1] / 100) * 12.5) + (((float)$row[2] / 100) * 12.5) + $r3);
                                                            $counter++;
                                                            $total_grade = ($one??0) + ($two??0);

                                                            $ts++;
                                                            if(is_null($row[3]) || $row[3] == 0){
                                                                $tn++;
                                                            }
                                                        }else if($row[3] != 0 && is_numeric($row[3]) && $row[3] != "" && $row[4] == 21 ){
                                                            $three = ((((float)$row[0] / 100) * 5) + (((float)$row[1] / 100) * 12.5) + (((float)$row[2] / 100) * 12.5) + $r3);
                                                            $counter++;
                                                            $total_grade = ($one??0) + ($two??0)+ ($three??0);

                                                            $ts++;
                                                            if(is_null($row[3]) || $row[3] == 0){
                                                                $tn++;
                                                            }
                                                        }else if($row[3] != 0 && is_numeric($row[3]) && $row[3] != "" && $row[4] == 22 ){
                                                            $four = ((((float)$row[0] / 100) * 5) + (((float)$row[1] / 100) * 12.5) + (((float)$row[2] / 100) * 12.5) + $r3);
                                                            $counter++;
                                                            $total_grade = ($one??0) + ($two??0)+ ($three??0)+ ($four??0);

                                                            $ts++;
                                                            if(is_null($row[3]) || $row[3] == 0){
                                                                $tn++;
                                                            }
                                                        }else if($row[3] != 0 && is_numeric($row[3]) && $row[3] != "" && $row[4] == 23 ){
                                                            $five = ((((float)$row[0] / 100) * 5) + (((float)$row[1] / 100) * 12.5) + (((float)$row[2] / 100) * 12.5) + $r3);
                                                            $counter++;
                                                            $total_grade = ($one??0) + ($two??0)+ ($three??0)+ ($four??0)+ ($five??0);
                                                            
                                                            $ts++;
                                                            if(is_null($row[3]) || $row[3] == 0){
                                                                $tn++;
                                                            }
                                                        }else if($row[3] != 0 && is_numeric($row[3]) && $row[3] != "" && $row[4] == 24 ){
                                                            $six = ((((float)$row[0] / 100) * 5) + (((float)$row[1] / 100) * 12.5) + (((float)$row[2] / 100) * 12.5) + $r3);
                                                            $counter++;
                                                            $total_grade = ($one??0) + ($two??0)+ ($three??0)+ ($four??0)+ ($five??0)+ ($six??0);

                                                            $ts++;
                                                            if(is_null($row[3]) || $row[3] == 0){
                                                                $tn++;
                                                            }
                                                        }else if($row[3] != 0 && is_numeric($row[3]) && $row[3] != "" && $row[4] == 26 ){
                                                            $seven = ((((float)$row[0] / 100) * 5) + (((float)$row[1] / 100) * 12.5) + (((float)$row[2] / 100) * 12.5) + $r3);
                                                            $counter++;
                                                            $total_grade = ($one??0) + ($two??0)+ ($three??0)+ ($four??0)+ ($five??0)+ ($six??0)+ ($seven??0);

                                                            $ts++;
                                                            if(is_null($row[3]) || $row[3] == 0){
                                                                $tn++;
                                                            }
                                                        }
                                                        

                                                    }
                                                    if ($one < 40 || $two < 40) {
                                                        $grade = 'Fail';
                                                    } else {
                                                        //  echo $total_grade;
                                                        $avg = $total_grade / $counter;
                                                        if ($avg > 69){
                                                            $grade = 'Distinction';}
                                                        else if($avg > 59){$grade = 'Credit';}
                                                        else if($avg > 49){$grade = 'Merit';}
                                                        else if($avg > 39){$grade = 'Pass';}
                                                        else if($avg < 40){$grade = 'Fail';}
                                                    }

                                                    if($ts==$tn){
                                                        $grade = 'Abs';
                                                    }
                                                }*/
                                                    
                                    ?>
                                    <tr>
                                        <td><?php echo $exam_no; ?></td>
                                        <td><?php echo $student_name; ?></td>
                                        <td><?php echo $grade; ?></td>
                                        <td><a href="<?php if($grade == 'Abs'){ echo '#';}else{ echo "new_result_single.php?serial=$count&id=$student_id";} ?>" target="_blank" class="btn btn-secondary btn-sm"> <!--<?= "{$avg} = {$total_grade} / {$counter}"; ?>--></a></td>
                                    </tr>
                            <?php } ?>
                                            
                                </tbody>
                            </table>
                            
                        </div>
                    </div>
                </div>
                <!--End of DataTable-->
            </div>
        </div>
    </body>
</html>
<?php

// Restore the previous error handler
restore_error_handler();

?>
