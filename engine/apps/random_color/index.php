<?php

    $initial_seed = rand(100, 200);

    $bar_height = "360px";

    function deviate($color, $deviation){

        $return_val = 0;

        if($color + $deviation < 256){

            $return_val = $color + $deviation;

        }elseif($color - $deviation > 0){

            $return_val = $color - $deviation;

        }else{

            $return_val = $color;

        }

        return $return_val;
    }

    function rgb_to_hex($x, $y, $z){
        return sprintf("#%02x%02x%02x", $x, $y, $z);
    }

    $colors = [];

    for($i = 0; $i < 6; $i++){

        $x_dev = rand(0, 100);
        $y_dev = rand(0, 100);
        $z_dev = rand(0, 100);

        $x_val = deviate($initial_seed, $x_dev);
        $y_val = deviate($initial_seed, $y_dev);
        $z_val = deviate($initial_seed, $z_dev);

        $colors[] = [$x_val,$y_val,$z_val];
    }

?>

<a class="btn btn-floating right color-blue waves-effect waves-light" href="">
    <i class="material-icons">refresh</i>
</a>

<h4>Random Color Generator</h4>

<style>
    .bar{
        min-height:<?=$bar_height?>;
        line-height:<?=$bar_height?>;
        background:white;
        text-align:center;
        text-shadow:0px 0px 10px rgba(0,0,0, 1);
        font-weight:bolder;
        font-size:20px;
        cursor:pointer;
    }
</style>

<div class="row">
    <?php foreach($colors as $color): ?>
    <div class="col s2">
        <div class="bar" style="background:rgb(<?php echo implode(",", $color) ?>);">
        <?php
            echo rgb_to_hex($color[0], $color[1], $color[2]);
        ?>
        </div>
    </div>
    <?php endforeach; ?>
</div>

<script>
    $(".bar").on("click", function(){
        
    })
</script>