<?php
    // Connexion à la base de données
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "big_transport";

    try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $erreur) {
        echo "<div class='message erreur'>La connexion a échoué : " . $erreur->getMessage() . "</div>";
    }

    $message = "";

    if (isset($_POST['envoyer'])) {
        $name = htmlspecialchars($_POST['name']);
        $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
        $phone = htmlspecialchars($_POST['phone']);
        $messageContent = htmlspecialchars($_POST['message']);

        if ($name && $email && $phone && $messageContent) {
            try {
                $sql = "INSERT INTO utilisateurs (name, email, phone, message) VALUES (:name, :email, :phone, :message)";
                $stmt = $conn->prepare($sql);

                $stmt->bindParam(':name', $name);
                $stmt->bindParam(':email', $email);
                $stmt->bindParam(':phone', $phone);
                $stmt->bindParam(':message', $messageContent);
                
                $stmt->execute();
                $message = "<div class='message success'>Votre message a été envoyé avec succès !</div>";
            } catch (PDOException $e) {
                $message = "<div class='message erreur'>Erreur lors de l'envoi : " . $e->getMessage() . "</div>";
            }
        } else {
            $message = "<div class='message erreur'>Veuillez remplir tous les champs correctement.</div>";
        }
    }
    ?>

    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title></title>
    </head>
    <body>
    <?= $message ?>
    </body>
    </html>