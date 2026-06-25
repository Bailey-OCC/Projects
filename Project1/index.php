<!DOCTYPE html>
<!--
Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
Click nbfs://nbhost/SystemFileSystem/Templates/Project/PHP/PHPProject.php to edit this template
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <form method="post">
            <label>Name:</label>
            <input type="text" name="name">

            <br><br>

            <label>Gross Income:</label>
            <input type="text" name="income">

            <br><br>

            <label>Deductions:</label>
            <input type="text" name="deductions">

            <br><br>

            <input type="submit" value="Calculate Taxes">
        </form>
        
        <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST")
        {
            $name = $_POST["name"];
            $income = $_POST["income"];
            $deductions = $_POST["deductions"];
            
            if (!is_numeric($income) || !is_numeric($deductions))
            {
                echo '<p>Income and deductions must be numeric values';
            }
            else
            {
                $name = htmlspecialchars($name);
                
                $income = (float)$income;
                $deductions = (float)$deductions;
                
                if ($deductions < 15000)
                {
                    $deductions = 15000;
                }
                
                $agi = $income - $deductions;
                
                if ($agi < 0)
                {
                    $agi = 0;
                }
                
                $brackets = [
                    ["limit" => 12400,  "rate" => 0.10],
                    ["limit" => 50400,  "rate" => 0.12],
                    ["limit" => 105700, "rate" => 0.22],
                    ["limit" => 201775, "rate" => 0.24],
                    ["limit" => 256225, "rate" => 0.32],
                    ["limit" => 640600, "rate" => 0.35],
                    ["limit" => PHP_FLOAT_MAX, "rate" => 0.37]
                ];
                
                $previousLimit = 0;
                $totalTax = 0;
                $taxDetails = [];
                
                foreach ($brackets as $bracket)
                {
                    if ($agi > $previousLimit)
                    {
                        $taxableAmount = min($agi, $bracket["limit"]) - $previousLimit;
                        
                        $taxForBracket = $taxableAmount * $bracket["rate"];
                        
                        $taxDetails[] = [
                            "rate" => $bracket["rate"] * 100,
                            "taxable" => $taxableAmount,
                            "tax" => $taxForBracket
                        ];
                        
                        $totalTax += $taxForBracket;
                    }
                    
                    $previousLimit = $bracket["limit"];
                }
                
                $grossTaxPercent =
                        ($income > 0)
                        ? ($totalTax / $agi) * 100
                        : 0;
                
                $agiTaxPercent = 
                        ($income > 0)
                        ? ($totalTax / $income) * 100
                        : 0;
                
                echo "<hr>";
                
                echo "<h2>Tax Summary for {$name}</h2>";
                
                echo "<p><strong>Gross Income:</strong>" . number_format($income) . "</p>";
                
                echo "<p><strong>Deductions Used:</strong>" . number_format($income) . "</p>";
                
                echo "<strong>Adjusted Gross Income :</strong> $" . number_format($agi, 2);
                echo "<br><br>";
                
                foreach ($taxDetails as $detail)
                {
                    echo "Taxes Owed at {$detail['rate']}% bracket : $"
                        . number_format($detail['tax'], 2);
                    echo "<br>";
                }
                
                echo "<br>";

                echo "Total Taxes Owed : $" . number_format($totalTax, 2);
                echo "<br>";

                echo "Taxes Owed as percentage of gross income : "
                    . number_format($grossTaxPercent, 2) . "%";
                echo "<br>";

                echo "Taxes Owed as percentage of adjusted gross income : "
                    . number_format($agiTaxPercent, 2) . "%";
            }
        }
        ?>
    </body>
</html>
