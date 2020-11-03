require.config({
  paths: {
    braintreeClient: 'https://js.braintreegateway.com/web/3.68.0/js/client.min',
    hostedFields: 'https://js.braintreegateway.com/web/3.68.0/js/hosted-fields.min'
  }
});

require(['braintreeClient', 'hostedFields'], function (client, hostedFields) {
  client.create({
    authorization: 'sandbox_gpqy6ky8_vx32r6xn3xjsbdcj'
  }, function (err, clientInstance) {
    hostedFields.create(/* ... */);
  });
});

function openNav() {
  document.getElementById("myNav").style.width = "100%";
}

/* Close when someone clicks on the "x" symbol inside the overlay */
function closeNav() {
  document.getElementById("myNav").style.width = "0%";
}
