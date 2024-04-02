<?php
include 'includes/session.php';
include 'includes/conn.php';
include 'includes/header.php';
require_once('./tcpdf/tcpdf.php');

// Fetching form data
$payer_fname = $_POST['payer_fname'];
$payer_lname = $_POST['payer_lname'];
$payer_email = $_POST['payer_email'];
$payer_address = $_POST['payer_address'];
$payer_postcode = $_POST['payer_postcode'];
$payer_tel = $_POST['payer_tel'];
$payer_content = $_POST['payer_content'];

$receiver_fname = $_POST['receiver_fname'];
$receiver_lname = $_POST['receiver_lname'];
$receiver_email = $_POST['receiver_email'];
$receiver_address = $_POST['receiver_address'];
$receiver_postcode = $_POST['receiver_postcode'];
$receiver_tel = $_POST['receiver_tel'];
$receiver_content = $_POST['receiver_content'];

include 'includes/scripts.php'; 
$date = date('Y-m-d');

$conn = $pdo->open();

try{
  
  $stmt = $conn->prepare("INSERT INTO sales (user_id, payer_fname, payer_lname, payer_email, payer_address, payer_postcode, payer_tel, payer_content, receiver_fname, receiver_lname, receiver_email, receiver_address, receiver_postcode, receiver_tel, receiver_content, sales_date) 
                            VALUES (:user_id, :payer_fname, :payer_lname, :payer_email, :payer_address, :payer_postcode, :payer_tel, :payer_content, :receiver_fname, :receiver_lname, :receiver_email, :receiver_address, :receiver_postcode, :receiver_tel, :receiver_content, :sales_date)");
  $stmt->execute([
      'user_id' => $user['id'], 
      'payer_fname' => $payer_fname, 
      'payer_lname' => $payer_lname, 
      'payer_email' => $payer_email, 
      'payer_address' => $payer_address, 
      'payer_postcode' => $payer_postcode, 
      'payer_tel' => $payer_tel, 
      'payer_content' => $payer_content, 
      'receiver_fname' => $receiver_fname, 
      'receiver_lname' => $receiver_lname, 
      'receiver_email' => $receiver_email, 
      'receiver_address' => $receiver_address, 
      'receiver_postcode' => $receiver_postcode, 
      'receiver_tel' => $receiver_tel, 
      'receiver_content' => $receiver_content, 
      'sales_date' => $date
  ]);
  $salesid = $conn->lastInsertId();
}
catch(PDOException $e){
  $_SESSION['error'] = $e->getMessage();
}

$pdo->close();

?>

<body class="hold-transition skin-blue layout-top-nav">
  <div class="wrapper">
    <?php include 'includes/navbar.php'; ?>
    <div class="content-wrapper">
      <div class="container">
        <section class="content">
          <div class="row">
            <div class="col-md-8 mx-auto">
              <form name="" action="checkout2.php" method="POST">
                <h2>Information</h2>
                <div class="row">
                  <div class="col-md-6">
                    <h3>Payer Information</h3>
                    <div class="form-group">
                      <label for="payer_fname">First Name</label>
                      <?php echo $payer_fname; ?>
                    </div>
                    <div class="form-group">
                      <label for="payer_lname">Last Name</label>
                      <?php echo $payer_lname; ?>
                    </div>
                    <div class="form-group">
                      <label for="payer_email">Email</label>
                      <?php echo $payer_email; ?>
                    </div>
                    <div class="form-group">
                      <label for="payer_address">Address</label>
                      <?php echo $payer_address; ?>
                    </div>
                    <div class="form-group">
                      <label for="payer_postcode">Postcode</label>
                      <?php echo $payer_postcode; ?>
                    </div>
                    <div class="form-group">
                      <label for="payer_tel">Telephone Number</label>
                      <?php echo $payer_tel; ?>
                    </div>
                    <div class="form-group">
                      <label for="payer_content">Notes</label>
                      <?php echo $payer_content; ?>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <h3>Receiver Information</h3>
                    <div class="form-group">
                      <label for="receiver_fname">First Name</label>
                      <?php echo $receiver_fname; ?>
                    </div>
                    <div class="form-group">
                      <label for="receiver_lname">Last Name</label>
                      <?php echo $receiver_lname; ?>
                    </div>
                    <div class="form-group">
                      <label for="receiver_email">Email</label>
                      <?php echo $receiver_email; ?>
                    </div>
                    <div class="form-group">
                      <label for="receiver_address">Address</label>
                      <?php echo $receiver_address; ?>
                    </div>
                    <div class="form-group">
                      <label for="receiver_postcode">Postcode</label>
                      <?php echo $receiver_postcode; ?>
                    </div>
                    <div class="form-group">
                      <label for="receiver_tel">Telephone Number</label>
                      <?php echo $receiver_tel; ?>
                    </div>
                    <div class="form-group">
                      <label for="receiver_content">Notes</label>
                      <?php echo $receiver_content; ?>
                    </div>
                  </div>
                </div>
                  <input name="payer_fname" type="hidden" value="<?php echo $payer_fname; ?>">
                  <input name="payer_lname" type="hidden" value="<?php echo $payer_lname; ?>">
                  <input name="payer_email" type="hidden" value="<?php echo $payer_email; ?>">
                  <input name="payer_address" type="hidden" value="<?php echo $payer_address; ?>">
                  <input name="payer_postcode" type="hidden" value="<?php echo $payer_postcode; ?>">
                  <input name="payer_tel" type="hidden" value="<?php echo $payer_tel; ?>">
                  <input name="payer_content" type="hidden" value="<?php echo $payer_content; ?>">
                  <input name="receiver_fname" type="hidden" value="<?php echo $receiver_fname; ?>">
                  <input name="receiver_lname" type="hidden" value="<?php echo $receiver_lname; ?>">
                  <input name="receiver_email" type="hidden" value="<?php echo $receiver_email; ?>">
                  <input name="receiver_address" type="hidden" value="<?php echo $receiver_address; ?>">
                  <input name="receiver_postcode" type="hidden" value="<?php echo $receiver_postcode; ?>">
                  <input name="receiver_tel" type="hidden" value="<?php echo $receiver_tel; ?>">
                  <input name="receiver_content" type="hidden" value="<?php echo $receiver_content; ?>">
                  <input name="salesid" id="salesid" type="hidden" value="<?php echo $salesid; ?>">
              </form>
              <h1 class="page-header mt-4">Product</h1>
              <div class="box box-solid">
                <div class="box-body">
                  <table class="table table-bordered">
                    <thead>
                      <th>Photo</th>
                      <th>Name</th>
                      <th>Price</th>
                      <th width="20%">Quantity</th>
                      <th>Subtotal</th>
                    </thead>
                    <tbody id="tbody">
                      <!-- Populate table with cart items -->
                    </tbody>
                  </table>
                </div>
              </div>
              <a target="_blank"
                        title="Generate Invoice"
                        href="./invoice.php?id=<?php echo $salesid;?>">Print PDF</a>
            </div>
          </div>
        </section>
      </div>
    </div>
  </div>
</body>


<?php include 'includes/scripts.php'; ?>
<script>
var salesid = $('#salesid').val();

$(function(){
  
  getDetails();
	// getTotal();
  deleteCartItems();
});

function getDetails(){
	$.ajax({
		type: 'POST',
		url: 'checkout_details.php',
		dataType: 'json',
		success: function(response){
			$('#tbody').html(response);
			getCart();
		}
	});
}

function deleteCartItems() {
    $.ajax({
        type: 'POST',
        url: 'delete_cart_items.php?id='+salesid, 
        success: function(response) {
        },
        error: function(XMLHttpRequest, textStatus, errorThrown) { 
            alert("Status: " + textStatus); alert("Error: " + errorThrown); 
        } 

    });
}

function getTotal(){
	$.ajax({
		type: 'POST',
		url: 'cart_total.php',
		dataType: 'json',
		success:function(response){
			total = response;
		}
	});
}

document.getElementById('printPdfButton').addEventListener('click', function() {
    // AJAX request to fetch PDF data
    $.ajax({
        type: 'POST',
        url: 'invoice.php?id='+salesid,
        data: $('form').serialize(), // Send form data
        success: function(response) {
            // Create a blob from the base64 encoded PDF data
            var blob = b64toBlob(response, 'application/pdf');
            // Create object URL from blob
            var url = URL.createObjectURL(blob);
            // Open the PDF in a new tab
            window.open(url, '_blank');
        }
    });
});

// Function to convert base64 to blob
function b64toBlob(b64Data, contentType) {
    var sliceSize = 512;
    var byteCharacters = atob(b64Data);
    var byteArrays = [];
    for (var offset = 0; offset < byteCharacters.length; offset += sliceSize) {
        var slice = byteCharacters.slice(offset, offset + sliceSize);
        var byteNumbers = new Array(slice.length);
        for (var i = 0; i < slice.length; i++) {
            byteNumbers[i] = slice.charCodeAt(i);
        }
        var byteArray = new Uint8Array(byteNumbers);
        byteArrays.push(byteArray);
    }
    var blob = new Blob(byteArrays, { type: contentType });
    return blob;
}
</script>


<script>

</script>

