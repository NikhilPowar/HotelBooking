<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="bootstrap-3.3.7-dist/css/bootstrap.min.css">
  <script src="bootstrap-3.3.7-dist/js/jquery.min.js"></script>
  <script src="bootstrap-3.3.7-dist/js/bootstrap.min.js"></script>
  <link rel="stylesheet" type="text/css" href="form.css">
  <link rel="stylesheet" href="jquery-ui-themes-1.12.1/themes/overcast/jquery-ui.css">
  <link rel="stylesheet" type="text/css" href="pagelayout.css">
</head>
<body>
<?php
  require 'header.php';
  require 'sidebar.php';
  echo "<div id='container'>";
  session_start();
  if(!isset($_SESSION['username'])){
    echo "You are not logged in. Login Here ";
    echo '<a href="login.php">Login</a>';
    exit("");
  }
  require 'config.php';
?>
<script src="http://localhost/Project/jquery-ui-1.12.1/external/jquery/jquery.js"></script>
<script src="http://localhost/Project/jquery-ui-1.12.1/jquery-ui.js"></script>
<script>
$( function() {
  var dateFormat = "mm/dd/yy",
    from = $( "#from" ).datepicker({
        minDate: 0,
        changeMonth: true,
        changeYear: true,
        numberOfMonths: 1
      })
      .datepicker("setDate", new Date())
      .on( "change", function() {
        to.datepicker( "option", "minDate", getDate( this ) );
        updatePrice();
      }),
    to = $( "#to" ).datepicker({
      minDate: 0,
      changeMonth: true,
      changeYear: true,
      numberOfMonths: 1
    })
    .datepicker("setDate", new Date())
    .on( "change", function(){
      updatePrice();
    });

  $("#rooms").change( function(){
    updatePrice()
  });

  function updatePrice(){
    var days = (Math.round(($("#to").datepicker("getDate")-$("#from").datepicker("getDate"))/(1000*60*60*24))+1);
    var rooms = $('#rooms').val();
    $("#totalDays").attr('value', days);
    $("#totalPrice").attr('value', price * days * rooms);
  }

  function getDate( element ) {
    var date;
    try {
      date = $.datepicker.parseDate( dateFormat, element.value );
    } catch( error ) {
      date = null;
    }
    return date;
  }
} );
</script>

<?php

  $stmt = mysqli_stmt_init($conn);
  if(mysqli_stmt_prepare($stmt, "select name, price, description from hotels where hid=?")){
    mysqli_stmt_bind_param($stmt, "i", $hid);
    $hid=(int)$_GET['id'];
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $name, $price, $description);
    mysqli_stmt_fetch($stmt);
    echo "<script>
    var price = $price ;
    </script>";
    mysqli_stmt_close($stmt);
  }
  echo '<form method="post" action="payment.php?id='.$hid.'" class="form-horizontal">
    <form-header>
    <h2>Hotel : '.$name.'</h2>
    </form-header>
    <div class="container">
    <div class="form-group">
    <label for="from"><b>From Date</b></label>
    <span class="error">*</span>
    <input type="text" id="from" name="from" required>
    </div>

    <div class="form-group">
    <label for="to"><b>To Date</b></label>
    <span class="error">*</span>
    <input type="text" id="to" name="to" required>
    </div>

    <div class="form-group">
    <label><b>Rooms</b></label>
    <select name="rooms" id="rooms" required>
    <option selected value=1>1</option>
    <option value=2>2</option>
    <option value=3>3</option>
    <option value=4>4</option>
    </select>
    </div>

    <div class="form-group">
    <label><b>Total Days</b></label>
    <input type="text" name="totalDays" id="totalDays" readOnly value=1>
    </div>

    <div class="form-group">
    <label><b>Total Price</b></label>
    <input type="text" name="totalPrice" id="totalPrice" value=&#8377;'.$price.' readOnly>
    </div>

    <div class="form-group">
    <button type="submit">Book now</button><br>
    </div>

    </div>

    </form>';
    echo "</div>";
?>
</body>
</html>
