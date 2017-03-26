<?php
  session_start();
  if(!isset($_SESSION['username'])){
    echo "You are not logged in. Login Here ";
    echo '<a href="login.php">Login</a>';
    exit("");
  }
  require 'config.php';
?>
<link rel="stylesheet" type="text/css" href="form.css">
<link rel="stylesheet" href="http://localhost/Project/jquery-ui-themes-1.12.1/themes/ui-lightness/jquery-ui.css">
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
      .on( "change", function() {
        to.datepicker( "option", "minDate", getDate( this ) );
      }),
    to = $( "#to" ).datepicker({
      minDate: 0,
      changeMonth: true,
      changeYear: true,
      numberOfMonths: 1
    })
    .on( "change", function() {
      // from.datepicker( "option", "maxDate", getDate( this ) );
      var days = (Math.round(($("#to").datepicker("getDate")-$("#from").datepicker("getDate"))/(1000*60*60*24))+1);
      $("#totalDays").attr('value', days);
      $("#totalPrice").attr('value', price * days);
    });

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
  if(mysqli_stmt_prepare($stmt, "select name, price from hoteldetails where hid=?")){
    mysqli_stmt_bind_param($stmt, "i", $hid);
    $hid=(int)$_GET['id'];
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $name, $price);
    mysqli_stmt_fetch($stmt);
    echo "Hotel : $name <br>Price per day : $price<br>";
    echo "<script>
    var price = $price ;
    </script>";
    mysqli_stmt_close($stmt);
  }
  echo '<form method="post" action="payment.php?id='.$hid.'">
    <div class="container">

    <label for="from"><b>From Date</b></label>
    <input type="text" id="from" name="from" onchange="" placeholder="From">

    <label for="to"><b>To Date</b></label>
    <input type="text" id="to" name="to" onchange="" placeholder="To"><br>

    <label><b>Total Days</b></label>
    <input type="text" name="totalDays" id="totalDays" placeholder="Total Days" readOnly>

    <label><b>Total Price</b></label>
    <input type="text" name="totalPrice" id="totalPrice" placeholder="Total Price" readOnly>

    <button type="submit">Book now</button><br>

    </div>

    </form>';
  echo "<a href='homepage.php'>Back to Search</a>";
?>
