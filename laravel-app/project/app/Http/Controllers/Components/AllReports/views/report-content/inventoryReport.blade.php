        <h5 class="mb-20 text-center"><?= $title ?></h5>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th scope="col">Consignor Name</th>
                    <th scope="col">Product Name</th>
                    <th scope="col">Category</th>
                    <th scope="col">Remaining Stock</th>
                    <th scope="col">Returned Stock</th>
                    <th scope="col">Sold</th>
                    <th scope="col">Mark-up Price</th>
                    <th scope="col">Mark-up Amount</th>
                    <th scope="col">Base Price</th>
                    <th scope="col">Date Received</th>
                    <th scope="col">Status</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                    if ($data) {
                        foreach ($data as $key => $R) {
                            $rem = $R->total_stocks - $R->dis_stocks;
                            if ($rem >= 0) {
                                # code...
                            
                           ?>
                            <tr>
                                <td><?= $R->product_owner ?></td>
                                <td scope="row"><?= $R->product_name ?></td>
                                <td><?= $R->product_category ?></td>
                                <td><?= $rem ?></td>
                                <td><?= $R->qty_return != null ? $R->qty_return : 0 ?></td>
                                <td><?= $R->sold_product ?></td>
                                <td><?= '₱'.number_format($R->consumer_price,2) ?></td>
                                <td><?= '₱'.number_format($R->consumer_price-$R->price,2) ?></td>
                                <td><?= '₱'.number_format($R->price,2) ?></td>
                                <td><?= date(LONGDATE,strtotime($R->added_date)) ?></td>
                                <td><?= $R->dis_stocks == $R->sold_product ? 'Sold Out' : 'In Stock' ?></td>
                            </tr>
                           <?php
                            }
                        }
                    } 
                ?>
            </tbody>
        </table>