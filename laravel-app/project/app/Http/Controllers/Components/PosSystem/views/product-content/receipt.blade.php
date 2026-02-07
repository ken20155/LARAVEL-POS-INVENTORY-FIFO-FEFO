<div style="font-family: Arial, sans-serif; max-width: 400px; margin: auto; border: 1px dashed #000; padding: 20px; text-align: center;">

  <h2 style="margin: 0;">Receipt of Sale</h2>
  <h1 style="margin: 5px 0;">View Deck</h1>
  <p style="margin: 5px 0;">Lanise, Claveria, Misamis Oriental</p>

  <hr style="border-top: 1px dashed black; margin: 20px 0;">

  <div style="display: flex; justify-content: space-between; margin-bottom: 10px;">
    <strong><?= date(LONGDATE) ?></strong>
    <strong><?= date(TIMEF) ?></strong>
  </div>

  <hr style="border-top: 1px dashed black; margin: 10px 0;">

  <table style="width: 100%; text-align: left; border-collapse: collapse;">
    <thead>
      <tr>
        <th style="padding-bottom: 5px;">QTY</th>
        <th style="padding-bottom: 5px;">ITEM</th>
        <th style="text-align: right; padding-bottom: 5px;">AMT</th>
      </tr>
    </thead>
    <tbody>
<?php 
if ($product) {
   foreach ($product as $key => $R) {
     ?>
      <tr>
        <td><?= $R['qty'] ?></td>
        <td><strong><?= $R['product_name'] ?></strong></td>
        <td style="text-align: right;"><?= $R['subtotal'] ?></td>
      </tr>
     <?php
   }
}    
?>





    </tbody>
  </table>

  <hr style="border-top: 1px dashed black; margin: 20px 0;">

  <table style="width: 100%; text-align: left;">
    <tr>
      <td><strong>TOTAL</strong></td>
      <td style="text-align: right;"><?= $detail['total'] ?></td>
    </tr>
    <tr>
      <td><strong>CASH</strong></td>
      <td style="text-align: right;"><?= $detail['input_amount'] ?></td>
    </tr>
    <tr>
      <td><strong>CHANGE</strong></td>
      <td style="text-align: right;"><?= $detail['change_amount'] ?></td>
    </tr>
  </table>

  <hr style="border-top: 1px dashed black; margin: 20px 0;">

  <h2 style="margin-top: 30px;">THANK YOU!<br>UNOFFICIAL RECEIPT</h2>

</div>
