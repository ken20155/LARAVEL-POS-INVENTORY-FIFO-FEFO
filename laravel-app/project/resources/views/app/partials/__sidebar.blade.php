<div class="right-sidebar">
  <div class="sidebar-title">
    <h3 class="weight-600 font-16 text-blue">
      Layout Settings
      <span class="btn-block font-weight-400 font-12"
        >User Interface Settings</span
      >
    </h3>
    <div class="close-sidebar" data-toggle="right-sidebar-close">
      <i class="icon-copy ion-close-round"></i>
    </div>
  </div>
  <div class="right-sidebar-body customscroll">
    <div class="right-sidebar-body-content">
      <h4 class="weight-600 font-18 pb-10">Header Background</h4>
      <div class="sidebar-btn-group pb-30 mb-10">
        <a
          href="javascript:void(0);"
          class="btn btn-outline-primary header-white active"
          >White</a
        >
        <a
          href="javascript:void(0);"
          class="btn btn-outline-primary header-dark"
          >Dark</a
        >
      </div>

      <h4 class="weight-600 font-18 pb-10">Sidebar Background</h4>
      <div class="sidebar-btn-group pb-30 mb-10">
        <a
          href="javascript:void(0);"
          class="btn btn-outline-primary sidebar-light"
          >White</a
        >
        <a
          href="javascript:void(0);"
          class="btn btn-outline-primary sidebar-dark active"
          >Dark</a
        >
      </div>

      <h4 class="weight-600 font-18 pb-10">Menu Dropdown Icon</h4>
      <div class="sidebar-radio-group pb-10 mb-10">
        <div class="custom-control custom-radio custom-control-inline">
          <input
            type="radio"
            id="sidebaricon-1"
            name="menu-dropdown-icon"
            class="custom-control-input"
            value="icon-style-1"
            checked=""
          />
          <label class="custom-control-label" for="sidebaricon-1"
            ><i class="fa fa-angle-down"></i
          ></label>
        </div>
        <div class="custom-control custom-radio custom-control-inline">
          <input
            type="radio"
            id="sidebaricon-2"
            name="menu-dropdown-icon"
            class="custom-control-input"
            value="icon-style-2"
          />
          <label class="custom-control-label" for="sidebaricon-2"
            ><i class="ion-plus-round"></i
          ></label>
        </div>
        <div class="custom-control custom-radio custom-control-inline">
          <input
            type="radio"
            id="sidebaricon-3"
            name="menu-dropdown-icon"
            class="custom-control-input"
            value="icon-style-3"
          />
          <label class="custom-control-label" for="sidebaricon-3"
            ><i class="fa fa-angle-double-right"></i
          ></label>
        </div>
      </div>

      <h4 class="weight-600 font-18 pb-10">Menu List Icon</h4>
      <div class="sidebar-radio-group pb-30 mb-10">
        <div class="custom-control custom-radio custom-control-inline">
          <input
            type="radio"
            id="sidebariconlist-1"
            name="menu-list-icon"
            class="custom-control-input"
            value="icon-list-style-1"
            checked=""
          />
          <label class="custom-control-label" for="sidebariconlist-1"
            ><i class="ion-minus-round"></i
          ></label>
        </div>
        <div class="custom-control custom-radio custom-control-inline">
          <input
            type="radio"
            id="sidebariconlist-2"
            name="menu-list-icon"
            class="custom-control-input"
            value="icon-list-style-2"
          />
          <label class="custom-control-label" for="sidebariconlist-2"
            ><i class="fa fa-circle-o" aria-hidden="true"></i
          ></label>
        </div>
        <div class="custom-control custom-radio custom-control-inline">
          <input
            type="radio"
            id="sidebariconlist-3"
            name="menu-list-icon"
            class="custom-control-input"
            value="icon-list-style-3"
          />
          <label class="custom-control-label" for="sidebariconlist-3"
            ><i class="dw dw-check"></i
          ></label>
        </div>
        <div class="custom-control custom-radio custom-control-inline">
          <input
            type="radio"
            id="sidebariconlist-4"
            name="menu-list-icon"
            class="custom-control-input"
            value="icon-list-style-4"
            checked=""
          />
          <label class="custom-control-label" for="sidebariconlist-4"
            ><i class="icon-copy dw dw-next-2"></i
          ></label>
        </div>
        <div class="custom-control custom-radio custom-control-inline">
          <input
            type="radio"
            id="sidebariconlist-5"
            name="menu-list-icon"
            class="custom-control-input"
            value="icon-list-style-5"
          />
          <label class="custom-control-label" for="sidebariconlist-5"
            ><i class="dw dw-fast-forward-1"></i
          ></label>
        </div>
        <div class="custom-control custom-radio custom-control-inline">
          <input
            type="radio"
            id="sidebariconlist-6"
            name="menu-list-icon"
            class="custom-control-input"
            value="icon-list-style-6"
          />
          <label class="custom-control-label" for="sidebariconlist-6"
            ><i class="dw dw-next"></i
          ></label>
        </div>
      </div>

      <div class="reset-options pt-30 text-center">
        <button class="btn btn-danger" id="reset-settings">
          Reset Settings
        </button>
      </div>
    </div>
  </div>
</div>

<div class="left-side-bar">
  <div class="brand-logo">
    <a href="index.html">
      <img src="<?= $logo ?>" alt="" class="dark-logo" />
      <img
        src="<?= $logo ?>"
        alt=""
        class="light-logo"
      />
    </a>
    <div class="close-sidebar" data-toggle="left-sidebar-close">
      <i class="ion-close-round"></i>
    </div>
  </div>
  <div class="menu-block customscroll">
    <div class="sidebar-menu">
      <ul id="accordion-menu">
        <li>
          <a href="dashboard" class="dropdown-toggle no-arrow">
            <span class="micon bi bi-house"></span>
            <span class="mtext">Dashboard</span>
          </a>
        </li>
        <li>
          <div class="sidebar-small-cap">Managements</div>
        </li>
        <?php 
        extract($session);
        if ($session['user_role'] == 1) {
          ?>
          <li>
            <a href="users-account" class="dropdown-toggle no-arrow">
              <span class="micon bi bi-people"></span>
              <span class="mtext">User Account</span>
            </a>
          </li>
          <li>
            <a href="received-inventory" class="dropdown-toggle no-arrow">
              <span class="micon bi bi-boxes"></span>
              <span class="mtext">Received Products</span>
            </a>
          </li>
          <li>
            <a href="product-inventory-consignee" class="dropdown-toggle no-arrow">
              <span class="micon bi bi-boxes"></span>
              <span class="mtext">Products Inventory</span>
            </a>
          </li>
          <li>
            <a href="pos-system" class="dropdown-toggle no-arrow">
              <span class="micon bi bi-boxes"></span>
              <span class="mtext">View Deck POS</span>
            </a>
          </li>
          <li>
            <a href="consignor-payout" class="dropdown-toggle no-arrow">
              <span class="micon bi bi-cash"></span>
              <span class="mtext">Consignor Payout</span>
            </a>
          </li>
          <li class="dropdown">
            <a href="javascript:;" class="dropdown-toggle" data-option="off">
              <span class="micon bi bi-textarea-resize"></span><span class="mtext">Reports</span>
            </a>
            <ul class="submenu" style="display: none;">
              <li><a href="form-basic.html">Consignee</a></li>
              <li><a href="form-wizard.html">Consignor</a></li>
              <li><a href="all-reports">General Report</a></li>
            </ul>
          </li>

          <?php
        }else{
          ?>
            <li>
              <a href="products" class="dropdown-toggle no-arrow">
                <span class="micon bi bi-boxes"></span>
                <span class="mtext">Products</span>
              </a>
            </li>
            <li>
              <a href="product-inventory" class="dropdown-toggle no-arrow">
                <span class="micon bi bi-boxes"></span>
                <span class="mtext">Products Inventory</span>
              </a>
            </li>
            <li>
              <a href="add-supply" class="dropdown-toggle no-arrow">
                <span class="micon bi bi-boxes"></span>
                <span class="mtext">Add Supply</span>
              </a>
            </li>
            <li>
              <a href="consignor-payout" class="dropdown-toggle no-arrow">
                <span class="micon bi bi-cash"></span>
                <span class="mtext">Consignor Payout</span>
              </a>
            </li>
            <li>
              <a href="all-reports" class="dropdown-toggle no-arrow">
                <span class="micon bi bi-file-earmark-text"></span>
                <span class="mtext">Reports</span>
              </a>
            </li>
          <?php
        }
        ?>

        {{-- <li>
          <div class="sidebar-small-cap">Reports</div>
        </li>
        <?php if ($session['user_role'] == 1) { ?>
        <li>
          <a href="inventory-reports" class="dropdown-toggle no-arrow">
            <span class="micon bi bi-file-earmark-text"></span>
            <span class="mtext">Inventory</span>
          </a>
        </li>
        <?php }else{ ?>
          
        <?php } ?> --}}

        {{-- <li>
          <a href="order" class="dropdown-toggle no-arrow">
            <span class="micon bi bi-cart-check"></span>
            <span class="mtext">Orders</span>
          </a>
        </li>
        <li>
          <a href="to-pay" class="dropdown-toggle no-arrow">
            <span class="micon bi bi-cash"></span>
            <span class="mtext">To Pay</span>
          </a>
        </li>
        <li>
          <a href="payments-paid" class="dropdown-toggle no-arrow">
            <span class="micon bi bi-cash"></span>
            <span class="mtext">Payments</span>
          </a>
        </li>
        <li>
          <a href="products" class="dropdown-toggle no-arrow">
            <span class="micon bi bi-boxes"></span>
            <span class="mtext">Products</span>
          </a>
        </li>
        <li>
          <a href="chats" class="dropdown-toggle no-arrow">
            <span class="micon bi bi-chat-text"></span>
            <span class="mtext">Chats</span>
          </a>
        </li> --}}
      </ul>
    </div>
  </div>
</div>
<div class="mobile-menu-overlay"></div>
