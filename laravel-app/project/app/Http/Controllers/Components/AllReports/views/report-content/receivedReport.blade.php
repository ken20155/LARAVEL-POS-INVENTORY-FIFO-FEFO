        <h5 class="mb-20 text-center"><?= $title ?></h5>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th scope="col">Delivery/Batch ID</th>
                    <th scope="col">Product Name</th>
                    <th scope="col">Consignor Name</th>
                    <th scope="col">Date Received</th>
                    <th scope="col">Total Items Received</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                    if ($data) {
                        $x=1;
                        foreach ($data as $key => $R) {
                            $rem = $R->total_stocks - $R->dis_stocks;
                           ?>
                            <tr>
                                <td><?= $x++ ?></td>
                                <td><?= $R->product_name ?></td>
                                <td><?= $R->product_owner ?></td>
                                <td><?= date(LONGDATE,strtotime($R->updated_date_inv)) ?></td>
                                <td><?= $R->total_received ?></td>
                            </tr>
                           <?php
                        }
                    } 
                ?>
            </tbody>
        </table>