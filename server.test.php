<?php
$limit = 10;
$dbh = new PDO('mysql:dbname=vapezonepro;host=localhost', 'root', 'root');
$page = intval(@$_GET['page']);
$page = (empty($page)) ? 1 : $page;
$start = ($page != 1) ? $page * $limit - $limit : 0;
$sth = $dbh->prepare("SELECT * FROM `cscart_store_locations` LIMIT {$start}, {$limit}");
$sth->execute();
$items = $sth->fetchAll(PDO::FETCH_ASSOC);
$k = $start;
foreach ($items as $row) {
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
<?php
}
