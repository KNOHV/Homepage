<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // 1. Daten aus dem Formular abgreifen und säubern
    $order_id   = htmlspecialchars($_POST['order_id']);
    $order_date = htmlspecialchars($_POST['order_date']);
    $full_name  = htmlspecialchars($_POST['full_name']);
    $email      = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $address    = htmlspecialchars($_POST['address']);
    $message    = htmlspecialchars($_POST['message']);

    // 2. Empfänger (Deine Adresse für die Benachrichtigung)
    $to_admin = "Reklamation@kummers-onlinehandel.de "; 
    $subject_admin = "Neuer Widerruf eingegangen: Best. " . $order_id;

    // 3. E-Mail Inhalt für den Kunden zusammenbauen
    $subject_customer = "Bestätigung: Dein Widerruf zu Bestellung " . $order_id;
    $headers = "From: Dein Shop Name <no-reply@deinshop.de>\r\n";
    $headers .= "Reply-To: support@deinshop.de\r\n";
    $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";

    $customer_body = "Hallo " . $full_name . ",\n\n"
                   . "hiermit bestätigen wir den Erhalt Ihres Widerrufs.\n\n"
                   . "Details zum Widerruf:\n"
                   . "----------------------------\n"
                   . "Bestellnummer: " . $order_id . "\n"
                   . "Bestelldatum: " . $order_date . "\n"
                   . "Anschrift: " . $address . "\n"
                   . "Anmerkung: " . $message . "\n"
                   . "----------------------------\n\n"
                   . "Wir werden Ihren Widerruf schnellstmöglich bearbeiten.\n"
                   . "Bitte senden Sie die Ware (falls bereits erhalten) innerhalb von 14 Tagen zurück.\n\n"
                   . "Herzliche Grüße,\n"
                   . "Dein Shop-Team";

    // 4. E-Mails versenden
    // Bestätigung an Kunden
    mail($email, $subject_customer, $customer_body, $headers);
    
    // Info an dich selbst
    mail($to_admin, $subject_admin, "Ein Widerruf von " . $full_name . " ist eingegangen.", $headers);

    // 5. Weiterleitung zur Bestätigungsseite
    echo "<h2>Vielen Dank! Ihr Widerruf wurde erfolgreich übermittelt.</h2>";
    echo "<p>Sie erhalten in Kürze eine Bestätigung per E-Mail.</p>";
} else {
    echo "Fehler: Das Formular muss gesendet werden.";
}
?>
 
