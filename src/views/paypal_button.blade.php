
<script src="https://www.paypalobjects.com/api/checkout.js"></script>
<script>
var CREATE_PAYMENT_URL  = '{{ URL("paypal") }}/create';
var EXECUTE_PAYMENT_URL = '{{ URL("paypal") }}/execute';

$(document).ready(function () {
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
                    alert(data.text);
                    //toastr.error('Error', data.text);
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
                //console.log(data);
                if( data.state!="success" ){
                    //alert(data.error.msg+"! Please contact our administrator for help");
                    //toastr.error('Error', data.error.msg);
                    //console.log("error");
                    alert("fail: "+data.text);
                }
                else{
                    //generateID();
                    alert("Transaction complete. Thank you!");
                    //console.log("Thank you");
                    //toastr.success('Thank you!', 'see you soon!');
                }
                // The payment is complete!
                // You can now show a confirmation message to the customer
            });
        }

    }, '#paypal-button');
});
    
</script>


<div id="paypal-button"></div>

<input type="hidden" id="order_id" value="1234">
<input type="hidden" id="order_total" value="0.14">
