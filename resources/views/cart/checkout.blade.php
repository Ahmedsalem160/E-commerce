@extends('layouts.app')
<!--  Style  -->
@section('style')
    
@endsection
<!-- Elements or the content   -->
@section('content')

 <div class="container">
     <div class="row">
         <div class="col-md-9">
             <div class="mb-4">
                 Total Amount is ${{$amount}}
                 <form action="/charge" method="post" id="payment-form">
                    @csrf
                    <div class="">
                    <input type="hidden" name="amount" value="{{$amount}}">
                      <label for="card-element">
                        Credit or debit card
                      </label>
                      <div id="card-element">
                        <!-- A Stripe Element will be inserted here. -->
                      </div>
                  
                      <!-- Used to display Element errors. -->
                      <div id="card-errors" role="alert"></div>
                    </div>
                  
                    <button class="btn btn-primary mt-3">Submit Payment</button>
                    <p id="loading" style="display:none;">Payment is in process . Please Wait....</p>
                  </form>
             </div>
         </div>
     </div>
 </div>

@endsection

<!--  Links > script  -->
@section('script')

<script src="https://js.stripe.com/v3/"></script>
<script>
  window.onload = function(){
    var stripe = Stripe('pk_test_DNuI2jPtiRReSETt5i2Y6mds00FwpuRSnH');
    var elements = stripe.elements();
    // default style
    var style = {
      base: {
        // Add your base input styles here. For example:
        fontSize: '16px',
        color: '#32325d',
      },
    };
    // using the style var
    var card = elements.create('card', {style: style});
    // Add an instance of the card Element into the `card-element` <div>.
    card.mount('#card-element');

      //HTML+JS
    // Create a token or display an error when the form is submitted. if(find->Error)
    var form = document.getElementById('payment-form');
    form.addEventListener('submit', function(event) {
      event.preventDefault();

      stripe.createToken(card).then(function(result) {
        if (result.error) {
          // Inform the customer that there was an error.
          var errorElement = document.getElementById('card-errors');
          errorElement.textContent = result.error.message;
        } else {
          // Send the token to your server.
          stripeTokenHandler(result.token);
        }
      });
    });
    //submit >> send to your server 
    function stripeTokenHandler(token) {
      // Insert the token ID into the form so it gets submitted to the server
      var form = document.getElementById('payment-form');
      var hiddenInput = document.createElement('input');
      hiddenInput.setAttribute('type', 'hidden');
      hiddenInput.setAttribute('name', 'stripeToken');
      hiddenInput.setAttribute('value', token.id);
      form.appendChild(hiddenInput);

      // Submit the form
      var loading = document.getElementById('loading');
      loading.style.display ="block";
      form.submit();
    }

  }
</script>
@endsection