<?php
  include 'includes/session.php';
	include 'includes/conn.php';
  include 'includes/header.php';

  $payer_fname = isset($user['firstname']) ? $user['firstname'] : '';
  $payer_lname = isset($user['lastname']) ? $user['lastname'] : '';
  $payer_email = isset($user['email']) ? $user['email'] : '';
  $payer_address = isset($user['address']) ? $user['address'] : '';
  $payer_postcode = isset($user['postcode']) ? $user['postcode'] : '';
  $payer_contact_info = isset($user['contact_info']) ? $user['contact_info'] : '';

?>

<body class="hold-transition skin-blue layout-top-nav">
<div class="wrapper">

    <?php include 'includes/navbar.php'; ?>
     
      <div class="content-wrapper">
        <div class="container">

          <!-- Main content -->
          <section class="content">
            <div class="row">
                <div class="col-sm-9">
                  <form name="" action="checkout2.php" method="POST" onSubmit="return checkit(this)">
                      <h2>Information</h2>
                      <div class="row">
                          <div class="col-md-6">
                              <h3>Payer Information</h3>
                              <!-- Payer Information Form Start -->
                              <div class="form-group">
                                  <label for="payer_fname">First Name</label>
                                  <input name="payer_fname" type="text" class="form-control" id="payer_fname" maxlength="20" value="<?php echo $payer_fname; ?>">
                              </div>
                              <div class="form-group">
                                  <label for="payer_lname">Last Name</label>
                                  <input name="payer_lname" type="text" class="form-control" id="payer_lname" maxlength="20" value="<?php echo $payer_lname; ?>">
                              </div>
                              <div class="form-group">
                                  <label for="payer_email">Email</label>
                                  <input name="payer_email" type="text" class="form-control" id="payer_email" maxlength="40" value="<?php echo $payer_email; ?>">
                              </div>
                              <div class="form-group">
                                  <label for="payer_address">Address</label>
                                  <input type="text" name="payer_address" class="form-control" id="payer_address" value="<?php echo $payer_address; ?>">
                              </div>
                              <div class="form-group">
                                  <label for="payer_postcode">Postcode</label>
                                  <input name="payer_postcode" type="text" class="form-control" id="payer_postcode" maxlength="6" value="<?php echo $payer_postcode; ?>">
                              </div>
                              <div class="form-group">
                                  <label for="payer_tel">Telephone Number</label>
                                  <input name="payer_tel" type="text" class="form-control" id="payer_tel" maxlength="20" value="<?php echo $payer_contact_info; ?>">
                              </div>
                              <div class="form-group">
                                  <label for="payer_content">Notes</label>
                                  <textarea name="payer_content" class="form-control" id="payer_content" rows="5"></textarea>
                              </div>
                              
                          </div>
                          <div class="col-md-6">
                              <h3>Receiver Information</h3>
                              <!-- Receiver Information Form Start -->
                              <div class="form-group">
                                  <label for="receiver_fname">first Name</label>
                                  <input name="receiver_fname" type="text" class="form-control" id="receiver_fname" maxlength="20">
                              </div>
                              <div class="form-group">
                                  <label for="receiver_lname">last name</label>
                                  <input name="receiver_lname" type="text" class="form-control" id="receiver_lname" maxlength="20">
                              </div>
                              <div class="form-group">
                                  <label for="receiver_email">Email</label>
                                  <input name="receiver_email" type="text" class="form-control" id="receiver_email" maxlength="40">
                              </div>
                              <div class="form-group">
                                  <label for="receiver_address">Address</label>
                                  <input type="text" name="receiver_address" class="form-control" id="receiver_address">
                              </div>
                              <div class="form-group">
                                  <label for="receiver_postcode">Postcode</label>
                                  <input name="receiver_postcode" type="text" class="form-control" id="receiver_postcode" maxlength="6">
                              </div>
                              <div class="form-group">
                                  <label for="receiver_tel">Telephone Number</label>
                                  <input name="receiver_tel" type="text" class="form-control" id="receiver_tel" maxlength="20">
                              </div>
                              <div class="form-group">
                                  <label for="receiver_content">Notes</label>
                                  <textarea name="receiver_content" class="form-control" id="receiver_content" rows="5"></textarea>
                              </div>
                          </div>
                      </div>
                      <button type="submit" class="btn btn-primary">Place Order</button>
                  </form>
                  <h1 class="page-header">YOUR CART</h1>
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
                        </tbody>
                      </table>
                      </div>
                  </div>
                </div>
            </div>
          </section>
         
        </div>
      </div>
    <?php $pdo->close(); ?>
</div>

<?php include 'includes/scripts.php'; ?>
<script>
$(function(){
    // JavaScript code for handling cart functionality
  getDetails();
	getTotal();
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
</script>
<script language="JavaScript" type="text/javascript">
function checkit(form) {
    if (form.payer_fname.value == '') {
        alert('Payer first name must be provided');
        return false;
    } else if (form.payer_lname.value == '') {
        alert('Payer last name must be provided');
        return false;
    } else if (form.payer_email.value == '') {
        alert('Payer email must be provided');
        return false;
    } else if (form.payer_address.value == '') {
        alert('Payer address must be provided');
        return false;
    } else if (form.payer_postcode.value == '') {
        alert('Payer postcode must be provided');
        return false;
    } else if (form.payer_tel.value == '') {
        alert('Payer telephone number must be provided');
        return false;
    } else if (form.receiver_fname.value == '') {
        alert('Receiver first name must be provided');
        return false;
    } else if (form.receiver_lname.value == '') {
        alert('Receiver last name must be provided');
        return false;
    } else if (form.receiver_email.value == '') {
        alert('Receiver email must be provided');
        return false;
    } else if (form.receiver_address.value == '') {
        alert('Receiver address must be provided');
        return false;
    } else if (form.receiver_postcode.value == '') {
        alert('Receiver postcode must be provided');
        return false;
    } else if (form.receiver_tel.value == '') {
        alert('Receiver telephone number must be provided');
        return false;
    }
    return true;
}
</script>
</body>
</html>
