<!DOCTYPE html>
<html>
<head>
	<title>PayPal Test</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<script
        src="https://code.jquery.com/jquery-3.3.1.min.js"
        integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
        crossorigin="anonymous"></script>

	<!-- Latest compiled and minified CSS -->
	<!-- Bootstrap -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css" />
	<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>

	<script src="https://www.paypalobjects.com/api/checkout.js"></script>

</head>

<script>
function generateID(){
	$("#order_id").val( parseInt((new Date().getTime() / 1000).toFixed(0)) );
}
$(document).ready(function () {
	generateID();
	$("#order_total").focus();
});

var CREATE_PAYMENT_URL  = '{{ URL("skygdi/paypal/test")}}/create';
var EXECUTE_PAYMENT_URL = '{{ URL("skygdi/paypal/test")}}/execute';

paypal.Button.render({
    env: "{{$_ENV['PAYPAL_ENV']}}", // 'production' Or 'sandbox'
    commit: true, // Show a 'Pay Now' button
    payment: function() {
    	var order_id = $("#order_id").val();
    	var order_total = $("#order_total").val();
        return paypal.request({
            method: 'post',
            url: CREATE_PAYMENT_URL,
            data:{
        		'order_id':order_id,
        		'order_total':order_total
            },
            headers: {
                'x-csrf-token': '{{ csrf_token() }}'
            }
        }).then(function(data) {
            if( data.state=="error" ){
                toastr.error('Error', data.text);
                return false;
            }
            else{
                return data.id;
            }
        });
    },

    onAuthorize: function(data) {
        return paypal.request({
            method: 'post',
            url: EXECUTE_PAYMENT_URL,
            headers: {
                'x-csrf-token': '{{ csrf_token() }}'
            },
            data:{
                'paymentID': data.paymentID,
                'payerID':   data.payerID
            }
        }).then(function(data) {
            if( data.error!=null ){
                //alert(data.error.msg+"! Please contact our administrator for help");
                toastr.error('Error', data.error.msg);
                return;
            }
            else{
            	generateID();
                //alert("Thank you!");
                toastr.success('Thank you!', 'see you soon!');
            }
            // The payment is complete!
            // You can now show a confirmation message to the customer
        });
    }

}, '#paypal-button');

    
</script>

<body>
	
<div class="container" style="margin-top:50px;">
	<div class="row">
		<div class="col-md-12">
			<form>
			<div class="form-row">
				<div class="form-group col-md-3">
					<label for="order_id">Order ID</label>
					<input type="text" class="form-control" id="order_id" value="1234">
				</div>
				<div class="form-group col-md-3">
					<label for="order_total">Order Total</label>
					
					<div class="input-group mb-3">
						<div class="input-group-prepend">
							<span class="input-group-text">$</span>
						</div>
						<input type="text" class="form-control" id="order_total" value="0.14">
					</div>


				</div>

				<div class="form-group col-md-3" style="padding-top: 36px;">
					<div id="paypal-button"></div>
				</div>
			</div>
			</form>

		</div>
	</div>
</div>
</body>
</html>