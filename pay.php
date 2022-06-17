<html>
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    <title>Infinite Investment - Automated Trading Solution</title>

    <!-- Bootstrap core CSS -->
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link rel="apple-touch-icon" sizes="180x180" href="assets/logo/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="assets/logo/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="assets/logo/favicon-16x16.png">
    </head>
    <body>
        <div class="container">
            <div class="row justify-content-evenly" style="padding: 100px">
                <div class="col-lg-4 align-self-center">
                        <div class="card text-white bg-dark mb-3" style="max-width: 540px; font-size: 14px;">
                            <div class="row g-0">
                                <div class="col-md-4 col-sm-12">
                                    <img src="assets/images/qr-code-img.jpg" class="img-fluid rounded-start" alt="Infinite Investment">
                                </div>
                                <div class="col-md-8 col-sm-12">
                                    <div class="card-body">
                                        <h5 class="card-title">Pay Account</h5>
                                        <p class="card-text"><small class="text-muted">Account Name: Infinite Investments</small></p>
                                        <p class="card-text"><small class="text-muted">Account Number: 921020043179277</small></p>
                                        <p class="card-text"><small class="text-muted">IFSC: UTIB0000286</small></p>
                                        <p class="card-text"><small class="text-muted">UPI: infinite.investments@axisbank</small></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                </div>
                <div class="col-lg-4 align-self-center">
                    <div class="card text-white bg-dark mb-3" style="max-width: 540px; font-size: 13px;">
                            <div class="row g-0">
                                <div class="col-md-12">
                                    <div class="card-body">
                                        <h5 class="card-title">
                                            Plan: 
                                            <?php 
                                                session_start();

                                                $plan = $_GET['plan'];
                                                $term = $_GET['term'];

                                                switch ($plan) {
                                                    case "ecash":
                                                        echo "Equity Cash";
                                                        $_SESSION['plan'] = "Equity Cash";

                                                        if($term == 1){
                                                        $_SESSION["amount"] = 7000.00;      
                                                        }else{
                                                        $_SESSION["amount"] = 15000.00;    
                                                        }
                                                        break;
                                                    case "eopt":
                                                        echo "Equity Options";
                                                        $_SESSION['plan'] = "Equity Options";
                                                        if($term == 1){
                                                        $_SESSION["amount"] = 11000.00;     
                                                        }else{
                                                        $_SESSION["amount"] = 23000.00;    
                                                        }
                                                        break;
                                                    case "iopt":
                                                        echo "Index Options";
                                                        $_SESSION['plan'] = "Index Options";
                                                        if($term == 1){
                                                        $_SESSION["amount"] = 11000.00;      
                                                        }else{
                                                        $_SESSION["amount"] = 23000.00;    
                                                        }
                                                        break;
                                                    case "stock":
                                                        echo "Stock and Index Features";
                                                        $_SESSION['plan'] = "Stock and Index Features";
                                                        if($term == 1){
                                                        $_SESSION["amount"] = 21000.00;      
                                                        }else{
                                                        $_SESSION["amount"] = 51000.00;    
                                                        }
                                                        break;
                                                    case "mcx":
                                                        echo "MCX";
                                                        $_SESSION['plan'] = "MCX";
                                                        if($term == 1){
                                                        $_SESSION["amount"] = 21000.00;      
                                                        }else{
                                                        $_SESSION["amount"] = 51000.00;    
                                                        }
                                                        break;            
                                                    default:
                                                        echo "Equity Cash";
                                                }
                                            ?> 
                                        </h5>
                                        <p class="card-text">
                                            Price: <?php echo($_SESSION['amount']); ?> +
                                            <?php 
                                            
                                                $price = $_SESSION['amount'];
                                                $gst = ($price/100) * 18;
                                                echo $gst; 
                                                $_SESSION['total'] = $price + $gst;
                                            ?> 
                                            <small class="text-muted">GST(18%)  </small>
                                         </p>
                                        <p class="card-text">Total: <?php echo $_SESSION['total']; ?> </p>
                                    </div>
                                    <div class="card-footer">
                                        <?php

                                        require('config.php');
                                        require('razorpay-php/Razorpay.php');
                                          

                                        // Create the Razorpay Order

                                        use Razorpay\Api\Api;

                                        $api = new Api($keyId, $keySecret);

                                        // Create an razorpay order using orders api
                                        

                                        $orderData = [
                                            'receipt'         => 'rcptid_11',
                                            'amount'          =>  100, // total rupees in paise
                                            'currency'        => 'INR'
                                        ];

                                        $razorpayOrder = $api->order->create($orderData);

                                        $razorpayOrderId = $razorpayOrder['id'];

                                        $_SESSION['razorpay_order_id'] = $razorpayOrderId;
                                        
                                        $displayAmount = $amount = $orderData['amount'];

                                        $checkout = 'manual';

                                        $data = [
                                            "key"               => $keyId,
                                            "amount"            => $amount,
                                            "name"              => "Infinite Investments Pvt Ltd.",
                                            "description"       => "Automated Trading Solution",
                                            "image"             => "https://cdn.razorpay.com/logos/FFATTsJeURNMxx_medium.png",
                                            "prefill"           => [
                                            "name"              => $_SESSION['plan'],
                                            "email"             => "support@infiniteinvestments.co.in",
                                            "contact"           => "9897865339",
                                            ],
                                            "notes"             => [
                                            "address"           => "9G/7 Ground Floor, Motilal Nehru Marg, Prayagraj",
                                            "merchant_order_id" => "12312321",
                                            ],
                                            "theme"             => [
                                            "color"             => "#99cc33"
                                            ],
                                            "order_id"          => $razorpayOrderId,
                                        ];

                                        if ($displayCurrency !== 'INR')
                                        {
                                            $data['display_currency'] = $displayCurrency;
                                            $data['display_amount'] = $displayAmount;
                                        }

                                        $json = json_encode($data);

                                        require("checkout/{$checkout}.php");
                                        ?>
                                    </div>
                                </div>
                            </div>
                    </div>
                </div> 
                <div class="col-lg-4 align-self-center">
                    <div class="card text-white bg-dark mb-3" style="max-width: 540px; font-size: 14px;">
                            <div class="row g-0">
                                <div class="col-md-12 col-sm-12">
                                    <div class="card-body">
                                        <h5 class="card-title">Pay Partial Amount</h5>
                                        <form><script src="https://checkout.razorpay.com/v1/payment-button.js" data-payment_button_id="pl_IjbYpaDiv8eAsc" async> </script> </form>
                                    </div>
                                </div>
                            </div>
                        </div>                  
                </div> 
            </div>
        </div>
    </body>
</html>  