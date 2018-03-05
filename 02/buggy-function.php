<?php
public function completeOrder($order_id) {
	//Order status 2 = 'complete';
	$sql = "UPDATE order SET status_id = 2 WHERE order_id = " . $order_id;
	$result = mysql_query($sql);

	//Charge credit card
	$transaction = new Transaction();
	$transaction->cardholder = $_POST['cardholder'];
	$transaction->number = $_POST['number'];
	$transaction->exp_month = $_POST['exp_month'];
	$transaction->exp_year = $_POST['exp_year'];
	$transaction->cvv = $_POST['cvv'];
	$transaction->type = $_POST['type'];

	$transaction->charge();//Function returns transaction_id

	$sql2 = "UPDATE order SET transaction_id = " $transaction->charge();
	mysql_query($sql2);

	$mail = new PHPMailer(true);
	//Send email
    $mail->isSMTP();
    $mail->Host = 'smtp1.example.com;smtp2.example.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'user@example.com';
    $mail->Password = 'secret';
    $mail->SMTPSecure = 'tls';
    $mail->Port = 587;

    //Recipients
    $mail->setFrom('from@example.com', 'Mailer');

	$sql3 = "SELECT * FROM order WHERE order_id = " . $order_id;
	$order = mysql_query($sql2);
	$order = mysql_result($order);
    $mail->addAddress($order['email'], $order['customer_name']);

    $mail->addReplyTo('info@example.com', 'Information');
    $mail->isHTML(true);
    $mail->Subject = 'Your order is complete!';
    $mail->Body    = 'Thank you for completing your order with us! Here's your transaction ID: '.$transaction->getId();
    $mail->send();

    echo "Okay!";
}
?>