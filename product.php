<?php
// hiển thị thông tin chi tiết hàng hóa
if (isset($_GET['MSHH'])) {
    $query = $pdo->prepare('SELECT * FROM hanghoa WHERE MSHH = ?');
    $query->execute([$_GET['MSHH']]);
    $product = $query->fetch(PDO::FETCH_ASSOC);
    if (!$product) {
        exit('Không tồn tại hàng hóa này!');
    }
} else {
    exit('Không tồn tại hàng hóa này!');
}
?>
<?=template_header('Chi tiết sản phẩm')?>

<div class="product content-wrapper">
    <img src="./assets/imgs/<?=$product['HinhAnh']?>" width="500" height="500" alt="<?=$product['TenHH']?>">
    <div>
        <h1 class="name"><?=$product['TenHH']?></h1>
        <span class="price">
            &dollar;<?=$product['Gia']?>
        </span>
        <form action="index.php?page=cart" method="post">
            <input type="number" name="quantity" value="0" min="0" max="<?=$product['SoLuongHang']?>" placeholder="0" required>
            <input type="hidden" name="product_id" value="<?=$product['MSHH']?>">
            <input type="submit" value="Thêm vào giỏ">
        </form>
        <div class="description">
            <div> <b> Chi tiết sản phẩm:</b> </div>
            <br>
            <div>
                Tỷ lệ: <?=$product['MaLoaiHang']?> 
            </div>
            <textarea
                disabled
                style="
                border-style: none; 
                background: transparent; 
                resize: none;
                font-size: 20px;
                text-align: justify;
                width: 400px; 
                height: 200px; 
                "
            ><?=$product['GhiChu']?></textarea>
        </div>
    </div>
</div>

<?=template_footer()?>