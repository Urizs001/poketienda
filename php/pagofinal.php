<script src="https://www.paypalobjects.com/api/checkout.js"></script>

<style>
    
    /* Media query for mobile viewport */
    @media screen and (max-width: 400px) {
        #paypal-button-container {
            width: 100%;
        }
    }
    
    /* Media query for desktop viewport */
    @media screen and (min-width: 400px) {
        #paypal-button-container {
            width: 250px;
            display: inline-block;
        }
    }
    
</style>

<div id="mensajepago">
    <h1>!Ya casi son tuyos¡</h1>
    <hr>
    <p>Estas a punto de pagar con paypal la cantidad de: 
        <?php if (isset($_SESSION['total'])) { echo "<h4> $" . number_format(htmlspecialchars($_SESSION['total']),2) . "</h4>";} ?>
        <div id="paypal-button-container"></div>
    <p>Los pokemones seran tuyos una vez procesado el pago</p>
    <strong>Para aclaraciones: poketienda@gmail.com</strong>
</div>
 
 
<script>
    paypal.Button.render({
        env: 'sandbox', // sandbox | production
        style: {
            label: 'checkout',  // checkout | credit | pay | buynow | generic
            size:  'responsive', // small | medium | large | responsive
            shape: 'pill',   // pill | rect
            color: 'silver'   // gold | blue | silver | black
        },
 
        // PayPal Client IDs - replace with your own
        // Create a PayPal app: https://developer.paypal.com/developer/applications/create
 
        client: {
            sandbox:    'AUyAHr5u2_L0jE6IEPiwaJA0OS9IYUn7SXODXzha9EnrEIe7MMy5ib5IlOrH1dOQ3uelPxRfePhkt4Dl',
            production: 'AcnXybMSBF6cmnxw9RVgWFnxw8Bq317lxeNX61gHAoEoK33G0H8ydU1_v-rZqd3ZkjO-9qkfJh1IULr7'
        },
 
        // Wait for the PayPal button to be clicked
 
        payment: function(data, actions) {
            return actions.payment.create({
                payment: {
                    transactions: [
                        {
                            amount: { total: '<?php echo $_SESSION['total'];?>', currency: 'MXN' }, 
                            description:"Compra de productos a poketienda:$<?php echo number_format($_SESSION['total'],2); ?>",
                            custom:"<?php echo $_SESSION["ids"]; ?>#<?php echo openssl_encrypt($_SESSION["idventa"],cod,key);?>"
                        }
                    ]
                }
            });
        },
 
        // Wait for the payment to be authorized by the customer
 
        onAuthorize: function(data, actions) {
            return actions.payment.execute().then(function() {
                console.log(data);
                window.location="php/verificador.php?paymentToken="+data.paymentToken+"&paymentID="+data.paymentID;
            });
        }
    
    }, '#paypal-button-container');
 
</script>