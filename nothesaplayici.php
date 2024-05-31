<!DOCTYPE html>
<html>
<head>
    <title>Genel Not Ortalaması Hesaplama</title>
    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            background-color: wheat;
            color: black;
            padding: 100px;
        }
        h1 {
            color: darkslateblue;
        }
        .dersler, .ders_sayisi {
            background-color: tomato;
            padding: 20px;
            margin-bottom: 40px;
            border-radius: 60px;
        }
        label {
            display: block;
            margin-bottom: 10px;
            font-weight: bold;
        }
        input[type="text"], input[type="number"] {
            width: 200px;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px;
            border-radius: 5px;
            box-sizing: border-box;
        }
        input[type="submit"] {
            background-color: black;
            color: white;
            padding: 12px 24px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s;
        }
        input[type="submit"]:hover {
            background-color: #45a049;
        }
        .result {
            background-color: white;
            padding: 20px;
            border-radius: 10px;
            margin-top: 20px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
        }
        .result h2 {
            margin-top: 0;
            color: palevioletred;
        }
        .grade {
            font-size: 18px;
            font-weight: bold;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <h1>Genel Not Ortalaması Hesaplama</h1>

    <?php 
    if (!isset($_POST['ders_sayisi']) && !isset($_POST['dersler'])): ?>
        <form method="post" class="ders_sayisi">
            <label for="ders_sayisi">Ders Sayısını Girin:</label>
            <input type="number" id="ders_sayisi" name="ders_sayisi" required min="1">
            <input type="submit" value="Ders Sayısını Belirle">
        </form>
    <?php 
    elseif (isset($_POST['ders_sayisi']) && !isset($_POST['dersler'])): 
        $ders_sayisi = intval($_POST['ders_sayisi']); 
    ?>
        <form method="post">
            <input type="hidden" name="ders_sayisi" value="<?php echo $ders_sayisi; ?>">
            <?php for ($i = 0; $i < $ders_sayisi; $i++): ?>
                <div class="dersler">
                    <h3>Ders <?php echo $i + 1; ?></h3>
                    <label>Ders Adı: <input type="text" name="dersler[<?php echo $i; ?>][ad]" required></label><br> 
                    <label>Kredi: <input type="number" name="dersler[<?php echo $i; ?>][kredi]" required></label><br>
                    <label>Vize Notu: <input type="number" name="dersler[<?php echo $i; ?>][vize]" required></label><br>
                    <label>Final Notu: <input type="number" name="dersler[<?php echo $i; ?>][final]" required></label><br>  
                </div>
            <?php endfor; ?>
            <input type="submit" value="Genel Ortalama Hesapla">
        </form>
    <?php 
    elseif (isset($_POST['dersler'])):
        $dersler = $_POST['dersler'];
        $toplamKredi = 0;
        $toplamAgirlikliNot = 0;

        foreach ($dersler as $ders) {
            $ad = htmlspecialchars($ders['ad']);
            $kredi = floatval($ders['kredi']);
            $vize = floatval($ders['vize']);
            $final = floatval($ders['final']);

            $ortalama = ($vize * 0.4) + ($final * 0.6);
            $agirlikliNot = $ortalama * $kredi;

            echo "<div class='result'><p>$ad: Ortalama = $ortalama</p></div>";

            $toplamKredi += $kredi;
            $toplamAgirlikliNot += $agirlikliNot;
        }

        if ($toplamKredi > 0) {
            $genelOrtalama = $toplamAgirlikliNot / $toplamKredi;

            if ($genelOrtalama >= 90) {
                $dortlukSistem = 4.0;
            } elseif ($genelOrtalama >= 80) {
                $dortlukSistem = 3.5;
            } elseif ($genelOrtalama >= 70) {
                $dortlukSistem = 3.0;
            } elseif ($genelOrtalama >= 60) {
                $dortlukSistem = 2.5;
            } elseif ($genelOrtalama >= 50) {
                $dortlukSistem = 2.0;
            } elseif ($genelOrtalama >= 45) {
                $dortlukSistem = 1.5;
            } elseif ($genelOrtalama >= 40) {
                $dortlukSistem = 1.0;
            } elseif ($genelOrtalama >= 35) {
                $dortlukSistem = 0.5;
            } else {
                $dortlukSistem = 0.0;
            }

            echo "<div class='result'><h2>Genel Ortalama: $genelOrtalama</h2>";
            echo "<div class='grade'>4'lük Sistem Notu: $dortlukSistem</div></div>";
        } else {
            echo "<div class='result'><h2>Geçerli kredi bilgisi girilmemiş.</h2></div>";
        }
    endif;
    ?>
</body>
</html>