<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vapezzone</title>
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <?php
    $dbh = new PDO('mysql:dbname=vapezonepro;host=localhost', 'root', 'root');
    $sth = $dbh->prepare("SELECT * FROM `cscart_store_locations` LIMIT 10");
    $sth->execute();
    $items = $sth->fetchAll(PDO::FETCH_ASSOC);
    $sth = $dbh->prepare("SELECT COUNT(`id`) FROM `cscart_store_locations`");
    $sth->execute();
    $total = $sth->fetch(PDO::FETCH_COLUMN);

    $amt = ceil($total / 10);
    ?>
    <div class="header">
        <a href="" class="header_logo">LOGO</a>
        <li class="header_catalog">
            <a class="header_catalog_link">
                <img src="images/burger.svg" alt="" class="burger-img"> КАТАЛОГ
            </a>
            <ul class="header_catalog_nav">
                <li><a href="">Ссылка 1</a></li>
                <li><a href="">Ссылка 2</a></li>
                <li><a href="">Ссылка 3</a></li>
                <li><a href="">Ссылка 4</a></li>
                <li><a href="">Ссылка 5</a></li>
                <li><a href="">Ссылка 6</a></li>
                <li><a href="">Ссылка 7</a></li>
                <li><a href="">Ссылка 8</a></li>
            </ul>
        </li>
        <li class="header_search">
            <input type="text" placeholder="Искать ...">
            <button type="submit"><img src="images/loop.svg" alt=""></button>
        </li>
        <div class="header_basket-profile">
            <li class="header_basket">
                <a href=""><img src="images/basket.svg" alt=""></a>
            </li>
            <li class="header_profile">
                <a href=""><img src="images/profile.svg" alt=""></a>
            </li>
        </div>
    </div>
    <div class="table">
        <div class="table-wrap">
            <div class="table_head">
                <div class="table_head_productId">
                    ID Продукта
                </div>
                <div class="table_head_productStatus">
                    Статус продукта
                </div>
                <div class="table_head_productQuantity">
                    Общее количество
                </div>
            </div>
            <div class="table_content">
                <?php
                $k = 0;
                foreach ($items as $row) :
                    $k = $k + 1;
                ?>
                    <div class="table_content_row">
                        <div class="table_content_fieldNubmer">
                            <?php echo $k; ?>
                        </div>
                        <div class="table_content_productId">
                            <?php echo $row['store_location_id']; ?>
                        </div>
                        <div class="table_content_productStatus">
                            <?php $status = $row['status'];
                            if ($status == 'A') {
                                echo "Доступен для заказа";
                            } else {
                                echo "Не доступен для заказа";
                            }
                            ?>
                        </div>
                        <div class="table_content_productQuantity">
                            <?php echo $row['position']; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
    <div class="update_table">
        <a data-page="1" data-max="<?php echo $amt; ?>" id="showmore-button" href="#">Обновить список</a>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script>
        $ = jQuery;
        $(document).ready(function() {
            $('.header_catalog_link').on('click', function() {
                if (!$(this).parents('.header_catalog').hasClass('active')) {
                    $(this).parents('.header_catalog').addClass('active').find('ul.header_catalog_nav').css('display', 'flex');
                } else {
                    $(this).parents('.header_catalog').removeClass('active').find('ul.header_catalog_nav').fadeOut();
                }
            });
            $(function() {
                $('#showmore-button').click(function() {
                    var $target = $(this);
                    var page = $target.attr('data-page');
                    page++;
                    $.ajax({
                        url: '/server.test.php?page=' + page,
                        dataType: 'html',
                        success: function(data) {
                            $('.table .table_content').append(data);
                        }
                    });

                    $target.attr('data-page', page);
                    if (page == $target.attr('data-max')) {
                        $target.hide();
                    }

                    return false;
                });
            });
        });
    </script>
</body>

</html>