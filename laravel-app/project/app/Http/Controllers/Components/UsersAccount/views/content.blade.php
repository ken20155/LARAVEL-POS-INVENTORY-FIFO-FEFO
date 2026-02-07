<div class="row" id="div_laravel_datatable">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">
                    <button type="button" class="btn btn-sm btn-primary" id="addNewAccount">Add New</button>
                    <button type="button" class="btn btn-sm btn-info" id="refrest-datatable">Refresh</button>
                </h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    {{-- <div > --}}
                        <table class="table table-bordered" id="laravel_datatable">
                        </table>
                    {{-- </div> --}}
                </div>
            </div>
        </div>
    </div>
</div>





<!-- Modal -->
<form action="" method="post" id="submit-form">
  <div class="modal fade" id="modal-view" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="staticBackdropLabel"><?= $title ?> - <span id="action-text"></span></h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body" id="modal-body">

        </div>
        <div class="modal-footer">
          <div id="footer-custom"></div>
          <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>
</form>

