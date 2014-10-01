<link rel="stylesheet" type="text/css" href="view/stylesheet/stylesheet.css" />

<div id="content">
  <div > <!--class="box"-->
    <div class="heading">
      <h1><img src="view/image/report.png" alt="" /> <?php echo $heading_title; ?></h1>
    </div>
    <div class="content">
      <table class="list">
        <thead>
          <tr>
              <td class="left"><?php echo $column_manufacturer; ?></td>
              <td class="left"><?php echo $column_name; ?></td>
            <td class="right"><?php echo $column_price; ?></td>
            <td class="right"><?php echo $column_model; ?></td>
              <td class="right"><?php echo $column_date; ?></td>
              <td class="right"><?php echo $column_foundation; ?></td>
          </tr>
        </thead>
        <tbody>

          <?php  if ($products) { ?>
          <?php foreach ($products as $product) { ?>
          <tr>
              <td class="left"><?php echo $product['manufacturer']; ?></td>
              <td class="left"><?php echo $product['name']; ?></td>
            <td class="right"><?php echo $product['price']; ?></td>
              <td class="right"><?php echo $product['model']; ?></td>
              <td class="right"><?php echo $product['fecha']; ?></td>
              <td class="right"><?php echo $product['foundation']; ?></td>
          </tr>
          <?php } ?>
          <?php } else { ?>
          <tr>
            <td class="center" colspan="4"><?php echo $text_no_results; ?></td>
          </tr>
          <?php } ?>
        </tbody>
      </table>
    </div>
  </div>
</div>
