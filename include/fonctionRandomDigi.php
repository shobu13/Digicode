<?php 
// Fonction qui permet de générer aléatoirement un digi en héxadécimale
function RandomDigi() 
{
    $code = "";
    $pull = "ABCDEF";

    for ($i=0; $i < 6; $i++)
    {
        $mix = rand(0, 1);

        if($mix == 1)
        {
            $code = $code . $extract = rand(1, 9);
        }
        else
        {
            $extract = rand(0,5);
            $code = $code . substr($pull, $extract, 1);
        }
    }
    return $code;
}
?>