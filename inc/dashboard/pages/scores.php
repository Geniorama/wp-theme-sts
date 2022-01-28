<?php 

$curr_user = wp_get_current_user();
$curr_user_data = $curr_user->data;
?>

<ul class="sts-breadcrums-dashboard">
    <li class="sts-breadcrums-dashboard__item"><a href="#" class="sts-breadcrums-dashboard__link">Personal records</a></li>
    <!-- <li class="sts-breadcrums-dashboard__separator">|</li> -->
</ul>

<div class="sts-content-dashboard__scores">
    <h2 class="sts-scores-title">Natación</h2>
    <?php

        $natacion_25_mts = get_field('distancia_25_mts', "user_" . $curr_user_data->ID);
        $natacion_50_mts = get_field('distancia_50_mts', "user_" . $curr_user_data->ID);
        $natacion_100_mts = get_field('distancia_100_mts', "user_" . $curr_user_data->ID);
        $natacion_200_mts = get_field('distancia_200_mts', "user_" . $curr_user_data->ID);
   
        ?>
        <div class="sts-wrap-tables">
            <?php if($natacion_25_mts): ?>
                <div class="sts-category-table" id="dist-25-mts">
                    <h3 class="sts-heading-table">
                    <i class="ri-pin-distance-line"></i>
                    Distancia: 25 metros</h3>
                    <table class="sts-table-scores">
                    <tr>
                        <th>Estilo</th>
                        <th>Tiempo</th>
                        <th>Fecha</th>
                    </tr>
                    <?php foreach($natacion_25_mts as $row): ?>
                        <tr>    
                            <td><?php echo $row['estilo']; ?></td>
                            <td><?php echo $row['tiempo']; ?></td>
                            <td><?php echo $row['fecha']; ?></td>
                        </tr>
                    <?php endforeach; ?>
                    </table>
                </div>
            <?php endif; ?>

            <?php if($natacion_50_mts): ?>
                <div class="sts-category-table" id="dist-50-mts">
                    <h3 class="sts-heading-table">
                    <i class="ri-pin-distance-line"></i>    
                    Distancia: 50 metros</h3>
                    <table class="sts-table-scores">
                    <tr>
                        <th>Estilo</th>
                        <th>Tiempo</th>
                        <th>Fecha</th>
                    </tr>
                    <?php foreach($natacion_50_mts as $row): ?>
                        <tr>    
                            <td><?php echo $row['estilo']; ?></td>
                            <td><?php echo $row['tiempo']; ?></td>
                            <td><?php echo $row['fecha']; ?></td>
                        </tr>
                    <?php endforeach; ?>
                    </table>
                </div>
            <?php endif; ?>

            <?php if($natacion_100_mts): ?>
                <div class="sts-category-table" id="dist-100-mts">
                    <h3 class="sts-heading-table">
                    <i class="ri-pin-distance-line"></i>
                    Distancia: 100 metros</h3>
                    <table class="sts-table-scores">
                    <tr>
                        <th>Estilo</th>
                        <th>Tiempo</th>
                        <th>Fecha</th>
                    </tr>
                    <?php foreach($natacion_100_mts as $row): ?>
                        <tr>    
                            <td><?php echo $row['estilo']; ?></td>
                            <td><?php echo $row['tiempo']; ?></td>
                            <td><?php echo $row['fecha']; ?></td>
                        </tr>
                    <?php endforeach; ?>
                    </table>
                </div>
            <?php endif; ?>

            <?php if($natacion_200_mts): ?>
                <div class="sts-category-table" id="dist-200-mts">
                    <h3 class="sts-heading-table">
                    <i class="ri-pin-distance-line"></i>
                    Distancia: 200 metros</h3>
                    <table class="sts-table-scores">
                    <tr>
                        <th>Estilo</th>
                        <th>Tiempo</th>
                        <th>Fecha</th>
                    </tr>
                    <?php foreach($natacion_200_mts as $row): ?>
                        <tr>    
                            <td><?php echo $row['estilo']; ?></td>
                            <td><?php echo $row['tiempo']; ?></td>
                            <td><?php echo $row['fecha']; ?></td>
                        </tr>
                    <?php endforeach; ?>
                    </table>
                </div>
            <?php endif; ?>

        </div>
        <?php
    
    ?>
</div>