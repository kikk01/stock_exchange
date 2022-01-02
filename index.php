<?php

    const COST_BY_SUPPORTS = [
        0 => ['amount' => 398, 'costType' => 0, 'costAmount' => 0.5],
        1 => ['amount' => 500, 'costType' => 1, 'costAmount' => 1.99],
        2 => ['amount' => 3330, 'costType' => 0, 'costAmount' => 0.5],
        3 => ['amount' => 7750, 'costType' => 1, 'costAmount' => 16.65],
        4 => ['amount' => 1000000000, 'costType' => 0, 'costAmount' => 0.22]
    ];

    $rate = (int) $_GET['rate'];
    $placement = (int) $_GET['placement'];
    $numberYear = (int) isset($_GET['year']) ? $_GET['year'] : 1;
    $numberDay = 254*$numberYear;
    $i = 0;

    while($i < $numberDay) {
        $costSupports = getCostSupport();
        calculPlacementAfterOrderCost();
        calculGain();
        $costSupports = getCostSupport();
        calculPlacementAfterOrderCost();
        echo $i > 1 && $i%254 === 0 ? 
            '<p style="color:red;font-weight:bold;text-align:center">
                ////////  Happy new ' . $i/254 . "years //////////
            </p>" : 
            '';
            
        echo  nl2br("jour " . $i . ": " . $placement  .  "\n");
        $i++;
    }

    echo '<p style="color:red;font-weight:bold">
        ####################### Congratulation, you win ' . 
        $placement . 
        " in " 
        . $numberYear . 
        ' years ####################
    </p>';

    function getCostSupport(): array
    {
        global $placement;
        return max(array_filter(
            COST_BY_SUPPORTS, function($supports) use($placement) {
                return $supports['amount'] > $placement;
            }
        ));
    }

    function calculPlacementAfterOrderCost(): void
    {
        global $placement, $costSupports;
        $placement = $costSupports['costType'] === 0 ? 
            $placement - ($placement*$costSupports['costAmount']/100) :
            $placement - $costSupports['costAmount']
        ;
    }

    function calculGain(): void
    {
        global $placement, $rate;
        $placement = $placement + ($placement*$rate/100);
    }

?>
