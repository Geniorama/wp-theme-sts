<?php 

$curr_user = wp_get_current_user();
$curr_user_data = $curr_user->data;
?>

<div class="sts-content-dashboard__profile">
    <div class="sts-info-profile">
        <div class="sts-info-profile__avatar">
            <img src="https://images.unsplash.com/photo-1535713875002-d1d0cf377fde?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=880&q=80" class="sts-info-profile__avatar__img"  alt="">
        </div>

        <div class="sts-info-profile__info">
            <h2 class="sts-info-profile__info__name"><?php echo $curr_user->first_name . " " . $curr_user->last_name ?></h2>
            <p class="sts-info-profile__info__username">
                <span><b>Nombre de usuario: </b></span>
                <?php echo $curr_user_data->display_name; ?>
            </p>

            <p class="sts-info-profile__info__username">
                <span><b>Email usuario: </b></span>
                <?php echo $curr_user_data->user_email; ?>
            </p>
            <div class="sts-info-profile__info__numbers">
                <span class="sts-info-profile__info__numbers__height">
                    <span><b>Altura: </b></span>
                    <span class="sts-info-profile__info__numbers__height__digit">1,80</span>
                    <span class="sts-info-profile__info__numbers__height__sufix">Mts</span>
                </span>

                <span class="sts-info-profile__info__numbers__weight">
                    <span><b>Peso: </b></span>
                    <span class="sts-info-profile__info__numbers__weight__digit">75</span>
                    <span class="sts-info-profile__info__numbers__weight__sufix">kg</span>
                </span>
            </div>
        </div>
    </div>
</div>