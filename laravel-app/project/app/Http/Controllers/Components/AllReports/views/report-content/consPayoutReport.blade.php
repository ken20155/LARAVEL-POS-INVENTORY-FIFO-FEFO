        <h5 class="mb-20 text-center"><?= $title ?></h5>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th scope="col">Consignor Name</th>
                    <th scope="col">Product Name</th>
                    <th scope="col">Product ID</th>
                    <th scope="col">Mark-up Price</th>
                    <th scope="col">Base Price</th>
                    <th scope="col">Sold</th>
                    <th scope="col">Comission Amount</th>
                    <th scope="col">Mark-up Amount</th>
                    <th scope="col">Calculated Payout Due</th>
                    <th scope="col">Total Payout Due</th>
                    <th scope="col">Total Paid</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                    if ($data) {
                        foreach ($data as $key => $R) {
                            $rem = $R->total_stocks - $R->dis_stocks;
                            $com_amount = $R->consumer_price-$R->price;
                           ?>
                            <tr>
                                <td><?= $R->product_owner ?></td>
                                <td><?= $R->product_name ?></td>
                                <td><?= $R->product_id ?></td>
                                <td><?= '₱'.number_format($R->consumer_price,2) ?></td>
                                <td><?= '₱'.number_format($R->price,2) ?></td>
                                <td><?= number_format($R->sold_product) ?></td>
                                <td><?= '₱'.number_format($R->sold_product*$com_amount,2) ?></td>
                                
                                <td><?= '₱'.number_format($R->price*$R->sold_product,2) ?></td>
                                <td><?= $R->status_trans == 'PENDING' ? '₱'.number_format($R->sub_total_trans,2) : 0;  ?></td>
                                <td><?= $R->status_trans == 'PAID' ? '₱'.number_format($R->sub_total_trans,2) : 0;  ?></td>
                            </tr>
                           <?php
                        }
                    } 
                ?>
            </tbody>
        </table>