<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8"  />
  <title>From The Book</title>
  <link rel="stylesheet" href="css.css" />
  <style>
    body {
      font-family: ubuntu, arial;
    }
    div#main {
      border: 1px solid #444;
      border-radius: 5px;
      padding: 15px 20px;
      text-align: right;
    }
    input {
      font-size: 1rem;
      height: 20px;
      margin: 5px 10px;
      background-color: #aaa;
      border-color: #444;
    }
    button {
      font-size: 1rem;
      margin: 15px 10px;
    }
  </style>
  <script>
    function validg(inn) {
      let v = inn.value;
      let arr = ["2","3","3.5","4","4.5","5"];
      if (arr.indexOf(v)<0) {
        alert("NOT CORRECT!\nCORRECT INPUT: 2, 3, 3.5, 4, 4.5 or 5");
        inn.value = "";
        inn.style.borderColor = "red";
      }
      else {
        inn.style.borderColor = "#444";
      }
    }
  </script>
</head>
<body>
  <div id="main">
    <h2 id="h2old">OLD GRADES</h2>
    <?php
      if($_GET) {
        $grades=0;              // number of correct grades
        $gradesum=0;            // sum of correct grades
        $gradearray=[2,3,3.5,4,4.5,5];  // array of correct grades
        for($i=1; $i<6; $i++) {
          $grade = 0;                   // grade reset
          if($_GET["grade".$i]) {       
            $grade = (int)$_GET["grade".$i];
            if(in_array($grade,$gradearray)) {
              $grades++; 
            }
            else {
              $grade = 0;
            }
          }
          
          $gradesum += $grade;
          echo "Old grade no ".$i.": <b>".$grade."</b><br />";
        }
        echo "<br />All correct grades: ".$grades.".<br />";
        if($grades) {
          echo "<br />Average grade: ".$gradesum / $grades.".<br />";
        } 
      }    
    ?>
    <h2>NEW GRADES</h2>
    <form method="get">
    <?php
      for($i=1; $i<6; $i++) {
        echo "Grade no ".$i.":";
        echo "<input type='text' name='grade".$i."' onchange='validg(this)'><br />";
      }
    ?>
      <button type="submit"> - SEND - </button>
    </form>  
  </div>
</body>
</html>
