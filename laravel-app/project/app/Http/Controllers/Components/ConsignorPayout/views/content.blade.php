<div class="row" id="div_laravel_datatable">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">
                    <button type="button" class="btn btn-sm btn-info" id="refrest-datatable">Refresh</button>
                </h4>
            </div>
            <div class="card-body">

              <input type="hidden" name="">

              <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                <li class="nav-item">
                  <a class="nav-link active status-tab-change" id="pills-home-tab" data-toggle="pill" href="#pills-home" role="tab" data-status="PENDING" aria-controls="pills-home" aria-selected="true">PENDING</a>
                </li>
                {{-- <li class="nav-item">
                  <a class="nav-link status-tab-change" id="pills-profile-tab" data-toggle="pill" href="#pills-profile" role="tab" data-status="PARTIAL" aria-controls="pills-profile" aria-selected="false">PARTIAL</a>
                </li> --}}
                <li class="nav-item">
                  <a class="nav-link status-tab-change" id="pills-contact-tab" data-toggle="pill" href="#pills-contact" role="tab" data-status="PAID" aria-controls="pills-contact" aria-selected="false">PAID</a>
                </li>
              </ul>
              <div class="tab-content" id="pills-tabContent">
                <div class="tab-pane fade show active" id="pills-homes" role="tabpanel" aria-labelledby="pills-home-tab">

                <div class="table-responsive">
                      <table class="table table nowrap" id="laravel_datatable">
                      </table>
                </div>


                </div>
                {{-- <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">...</div>
                <div class="tab-pane fade" id="pills-contact" role="tabpanel" aria-labelledby="pills-contact-tab">...</div> --}}
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

