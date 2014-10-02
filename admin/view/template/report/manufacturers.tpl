<?php echo $header; ?>
<div id="content">
  <div class="breadcrumb">
    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
    <?php } ?>
  </div>
  <div class="box">
    <div class="heading">
      <h1><img src="view/image/report.png" alt="" /> <?php echo $heading_title; ?></h1>
    </div>
    <div class="content">
        <table class="form">
            <tr>
                <td style="text-align: right;">
                    <a onclick="window.location='index.php?route=report/product_purchased_percent/foundation&token=<?php echo $token; ?>'" class="button"><?php echo "Show All"; ?></a>
                    <a onclick="window.location='index.php?route=report/product_purchased_percent/reportcsv&token=<?php echo $token; ?>'" class="button"><?php echo "Generate CSV Report"; ?></a>
                </td>

            </tr>
        </table>

        <table class="list">
        <thead>
          <tr>
              <td class="left"><?php echo $column_name; ?></td>
            <td class="left"><?php echo "Percentage"; ?></td>

          </tr>
        </thead>
        <tbody>

          <?php  if ($manufacturers) { ?>
          <?php foreach ($manufacturers as $product) { ?>
          <tr id="<?php echo $product['manufacturer_id']; ?>" onclick="window.location='index.php?route=report/product_purchased_percent/foundation&token=<?php echo $token; ?>&id_found='+this.id">
              <td class="left"><?php echo $product['name']; ?></td>
            <td class="left">$ <?php echo $product['percent']; ?> %</td>

          </tr>

          <?php } ?>

          <?php } else { ?>
          <tr>
            <td class="center" colspan="4"><?php echo $text_no_results; ?></td>
          </tr>
          <?php } ?>
        </tbody>
      </table>
      <div class="pagination"></div>
    </div>
  </div>
</div>

<?php echo $footer; ?>