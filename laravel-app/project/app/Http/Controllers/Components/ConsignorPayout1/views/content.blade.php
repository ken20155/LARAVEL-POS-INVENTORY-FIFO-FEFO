<style>
  .tables {
    font-size: 18px;
  }
  .tables th {
    font-size: 18px;
    font-weight: bold;
  }
  .tables td {
    font-size: 13px;
  }
  .input-group .form-control {
    font-size: 13px;
  }
  .table th,
.table td {
    font-size: 18px; /* Adjusts font size for table cells */
    padding: 8px; /* Adjusts padding for better spacing */
}

.btn-sm {
    font-size: 12px; /* Adjusts button font size */
    padding: 4px 8px; /* Adjusts button padding */
}

.input-group .form-control-sm {
    font-size: 12px; /* Adjusts input font size */
    height: 30px; /* Ensures consistent input height */
    max-width: 50px; /* Prevents input from expanding too much */
}

.input-group-btn .btn-sm {
    width: 30px; /* Ensures button width is uniform */
    height: 30px; /* Ensures button height matches input */
    line-height: 1; /* Aligns button text properly */
}

/* Card Styles */
.card {
    font-size: 14px; /* Adjusts text size in cards */
    width: 100%; /* Ensures cards use full width of column */
}

.card-title {
    font-size: 16px; /* Slightly larger title */
    font-weight: bold;
}

.card-text {
    font-size: 13px; /* Adjusted for consistency */
}

.card .btn {
    font-size: 12px;
    padding: 6px 10px; /* Makes button more compact */
}

/* Responsive Adjustments */
@media (max-width: 768px) {
    .col-4 {
        width: 100%; /* Stack cards on smaller screens */
        margin-bottom: 10px;
    }
}
</style>

<div class="row">
  <div class="col-8">
    <div style="border: 1px solid rgb(35, 27, 27);padding:20px;border-radius:10px;">
      <div class="row">
        <div class="col-12 mb-3">
          <div class="input-group">
            <span class="input-group-text" id="basic-addon1">Search</span>
            <input type="search" class="form-control allSelectedProducts" id="search_product_input" name="search_product">
          </div>
        </div>
      </div>
      <div class="row" id="generateStockProducts">
      </div>
    </div>
  </div>
  <div class="col-4" >
    <div style="border: 1px solid rgb(35, 27, 27);padding:5px;border-radius:10px;">
      {{-- <table class="table" >
        <thead>
          <tr>
            <th scope="col" style="width:30%;font-size: 18px; !important">Product</th>
            <th scope="col"  style="width:50%;font-size: 18px; !important"class="text-center">QTY</th>
            <th scope="col"  style="width:20%;font-size: 18px; !important"class="text-right">Price / Each</th>
            <th scope="col"  style="width:25%;font-size: 18px; !important"class="text-right">Sub Total</th>
            <th scope="col" style="width:5%;font-size: 18px; !important"></th>
          </tr>
        </thead>
        <tbody id="generateStockProductsSelected" style="font-size: 18px; !important">

        </tbody>
      </table>

       --}}


       <div class="accordion" id="generateStockProductsSelected">

      </div>

    </div>
  </div>
  

</div>
