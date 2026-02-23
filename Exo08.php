<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TableauDesFactures</title>
</head>
<body>
    <main>
        <table border='1'>
            <tr>
                <th>Article</th>
                <th>Prix unitaire</th>
                <th>Quantités</th>
                <th>Sous total HT</th>
                <th>Sous total TTC</th>
            </tr>
        
        <?php
                $commande = [
                    ["nom" => "Cyber Race", "prix_unitaire" => 49.99, "quantite" => 2],
                    ["nom" => "Manette Pro", "prix_unitaire" => 59.99, "quantite" => 1],
                    ["nom" => "Carte Mémoire 128Go", "prix_unitaire" => 24.99, "quantite" => 3]
                ];
        
                $tva = 20;

            function calculerTTC ($prixHT, $tva){
                return $prixHT * (1 + $tva / 100);
            }

                $totalHT = 0;
                $totalTTC = 0;
                $sousTotalHT = 0;
                $sousTotalTTC = 0;

            foreach ($commande as $article) {
                $sousTotalHT = $article["prix_unitaire"] * $article["quantite"];
                $sousTotalTTC = calculerTTC($sousTotalHT, $tva);

                $totalHT += $sousTotalHT;
                $totalTTC += $sousTotalTTC;

                echo "<tr>
                        <td>{$article['nom']}</td>
                        <td>{$article['prix_unitaire']} €</td>
                        <td>{$article['quantite']}</td>
                        <td>{$sousTotalHT} €</td>
                        <td>{$sousTotalTTC} €</td>
                    </tr>";
            }

            $totalTVA = $totalTTC - $totalHT;

        ?>

            <tr>
                <td colspan="4">Total HT</td>
                <td><?= $totalHT ?> €</td>
            </tr>
            <tr>
                <td colspan="4">Total TVA (20%)</td>
                <td><?= $totalTVA ?> €</td>
            </tr>
            <tr>
                <td colspan="4">Total TTC</td>
                <td><?= $totalTTC ?> €</td>
            </tr>

        </table>
    </main>
</body>
</html>