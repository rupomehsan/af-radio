<html>
<head>
    <title>Wyre widget</title>
</head>
<body>
<button id='buy'>Buy</button>
<div id="wyre-dropin-widget-container"></div>

<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://verify.sendwyre.com/js/verify-module-init-beta.js"></script>
<script type="text/javascript">
    (function($) {

        // debit card popup
        var widget = new Wyre({
            env: 'test',
            reservation: 'EFR2WLGEDAMYU6QEAXFF',
            /*A reservation id is mandatory. In order for the widget to open properly you must use a new, unexpired reservation id. Reservation ids are only valid for 15 minutes. A new reservation must also be made if a transaction fails.*/
            operation: {
                type: 'debitcard-hosted-dialog'
            }
        });

        widget.on("paymentSuccess", function (e) {
            console.log("paymentSuccess", e );
        });

        $('#buy').click(function(){
            widget.open();
        })

    })(jQuery);


</script>
</body>
</html>
