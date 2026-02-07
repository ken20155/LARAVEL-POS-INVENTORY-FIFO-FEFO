        <h5 class="mb-20 text-center"><?= $title ?></h5>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th scope="col">Product Name</th>
                    <th scope="col">Category</th>
                    <th scope="col">Initial Consigned Qty</th>
                    <th scope="col">Remaining Stock</th>
                    <th scope="col">Quantity Sold</th>
                    <th scope="col">Quantity Returned</th>
                    <th scope="col">Status</th>
                    <th scope="col">Last Sale Date</th>
                    <th scope="col">Base Price</th>
                    <th scope="col">Mark-up Price</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                    if ($data) {
                        foreach ($data as $key => $R) {
                            $rem = $R->total_stocks - $R->dis_stocks;
                           ?>
                            <tr>
                                <td scope="row"><?= $R->product_name ?></th>
                                <td><?= $R->product_category ?></td>
                                <td><?= $R->dis_stocks ?></td>
                                <td><?= $R->total_stocks - $R->dis_stocks ?></td>
                                <td><?= $R->sold_product ?></td>        
                                <td><?= $R->qty_return ?></td>
                                <td><?= $rem == 0 ? 'Sold Out' : 'In Stock' ?></td>
                                <td><?= date(LONGDATE,strtotime($R->last_sale_date)) ?></td>
                                <td><?= '₱'.number_format($R->price,2) ?></td>
                                <td><?= '₱'.number_format($R->consumer_price,2) ?></td>
                            </tr>
                           <?php
                        }
                    } 
                ?>
            </tbody>
        </table>