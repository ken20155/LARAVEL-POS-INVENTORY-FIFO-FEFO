<table class="table table-hover table-bordered">
    <thead class="table-warning">
      <tr>
        <th scope="col">Qty Return Stocks</th>
        <th scope="col">Date and Time Return</th>
        <th scope="col">Reason Return</th>
      </tr>
    </thead>
    <tbody>
        <?php
        if ($data) {
            foreach ($data as $key => $R) {
            ?> 
                <tr>
                    <th scope="row" class="text-center"><?=$R->qty_return?></th>
                    <td><?=date(LONGDATETIME,strtotime($R->date_time_return))?></td>
                    <td><?=$R->reason_return?></td>
                </tr>
            <?php
            }
        }
        ?> 

    </tbody>
  </table>