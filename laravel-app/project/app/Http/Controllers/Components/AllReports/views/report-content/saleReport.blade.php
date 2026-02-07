        <h5 class="mb-20 text-center"><?= $title ?></h5>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th scope="col">Date/Time</th>
                    <th scope="col">Product Name</th>
                    <th scope="col">Consignor Name</th>
                    <th scope="col">Category</th>
                    <th scope="col">Item Sold</th>
                    <th scope="col">Base Price</th>
                    <th scope="col">Mark-up Amount</th>
                    <th scope="col">Selling Price</th>
                    <th scope="col">Total Sale Amount</th>
                    <th scope="col">Total Comission</th>
                    
                    
                </tr>
            </thead>
            <tbody>
                <?php 
                    if ($data) {
                        $total_sold = 0;
                        $total_sale_amount = 0;
                        $com_amount_amount = 0;
                        $com_amount_total = 0;
                        $base_price_total = 0;
                        foreach ($data as $key => $R) {
                            $rem = $R->total_stocks - $R->dis_stocks;
                            $com_amount = $R->consumer_price-$R->price;
                            $base_price_total += $R->price;
                            $com_amount_total += $com_amount;
                            $total_sold += $R->sold_product;
                            $total_sale_amount += $R->consumer_price*$R->sold_product;
                            $com_amount_amount += $R->sold_product*$com_amount;
                           ?>
                            <tr>
                                <td><?= date(LONGDATE,strtotime($R->added_date)) ?></td>
                                <td><?= $R->product_name ?></td>
                                <td><?= $R->product_owner ?></td>
                                <td><?= $R->product_category ?></td>
                                <td><?= $R->sold_product ?></td>
                                <td><?= '₱'.number_format($R->price,2) ?></td>
                                <td><?= '₱'.number_format($R->consumer_price-$R->price,2) ?></td>
                                <td><?= '₱'.number_format($R->consumer_price,2) ?></td>
                                <td><?= '₱'.number_format($R->consumer_price*$R->sold_product,2) ?></td>
                                <td><?= '₱'.number_format($R->sold_product*$com_amount,2) ?></td>
                                
                                
                            </tr>
                           <?php
                        }
                        ?>
                        <tr>
                            <td>Total Item Sold:</td>
                            <td colspan="9"><?= number_format($total_sold,2) ?></td>
                        </tr>
                        <tr>
                            <td>Gross Sales (for Consignor):</td>
                            <td colspan="9"><?= number_format($base_price_total,2) ?></td>
                        </tr>
                        <tr>
                            <td>Total Markup Amount:</td>
                            <td colspan="9"><?= number_format($com_amount_total,2) ?></td>
                        </tr>
                        <tr>
                            <td>Gross Sales:</td>
                            <td colspan="9"><?= number_format($total_sale_amount,2) ?></td>
                        </tr>
                        <tr>
                            <td>Overall Commission:</td>
                            <td colspan="9"><?= number_format($com_amount_amount,2) ?></td>
                        </tr>
                        <?php
                    } 
                ?>
            </tbody>
        </table>
