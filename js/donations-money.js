const braintree = require("braintree");

const gateway = new braintree.BraintreeGateway({
  environment: braintree.Environment.Sandbox,
  merchantId: "vx32r6xn3xjsbdcj",
  publicKey: "c8rzrhwp5tpwbkwv",
  privateKey: "9747dccf799eb608b200304322066cd8"
});

var form = document.querySelector('#hosted-fields-form');
var submit = document.querySelector('input[type="submit"]');

braintree.client.create({
  authorization: 'sandbox_gpqy6ky8_vx32r6xn3xjsbdcj'
}, function (clientErr, clientInstance) {
  if (clientErr) {
    console.error(clientErr);
    return;
  }

  braintree.hostedFields.create({
    client: clientInstance,
    styles: '../css/donations-money.css',
    fields: {
      number: {
        selector: '#card-number',
        placeholder: 'Enter your card number'
      },
      cvv: {
        selector: '#cvv',
        placeholder: 'Enter CVV'
      },
      expirationDate: {
        selector: '#expiration-date',
        placeholder: 'Enter expiration date (mm/yy)'
      }
    }
  }, function (hostedFieldsErr, hostedFieldsInstance) {
    if (hostedFieldsErr) {
      console.error(hostedFieldsErr);
      return;
    }

    submit.removeAttribute('disabled');

    form.addEventListener('submit', function (event) {
      event.preventDefault();

      hostedFieldsInstance.tokenize({
        // cardholderName: event.target.cardholderName.value
      }, function (tokenizeErr, payload) {
        if (tokenizeErr) {
          console.error(tokenizeErr);
          return;
        }
        // this is where you would
        // send the nonce to your server.
        console.log('Got a nonce: ' + payload.nonce);
        document.getElementById("payment-message").innerHTML = "Payment successful!";
      });
    }, false);
  });
});

function openNav() {
  document.getElementById("myNav").style.width = "100%";
}

/* Close when someone clicks on the "x" symbol inside the overlay */
function closeNav() {
  document.getElementById("myNav").style.width = "0%";
}
