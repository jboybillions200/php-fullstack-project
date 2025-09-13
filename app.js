// Make sure this is placed after the script that sets dynamicAmount in your HTML

const paypalButtons = window.paypal.Buttons({
    style: {
        shape: "pill",
        layout: "vertical",
        color: "silver",
        label: "paypal",
    },

    // Create the order with PayPal directly (no server needed)
    createOrder: function (data, actions) {
        return actions.order.create({
            purchase_units: [{
                amount: {
                    value: dynamicAmount // dynamically injected from PHP
                }
            }]
        });
    },

    // Capture the order after approval
    onApprove: function (data, actions) {
        return actions.order.capture().then(function (details) {
            const transaction = details.purchase_units[0].payments.captures[0];
            
            // Redirect to server for final processing
            window.location.href = "server/complete_payment.php?transaction_id=" 
                + transaction.id 
                + "&order_id=" 
                + orderId;
        });
    },
    

    onError: function (err) {
        console.error("PayPal Checkout Error:", err);
    }
});

// Render PayPal button inside container
paypalButtons.render("#paypal-button-container");
