<?php 
  if($this->session->userdata('revert_data')==""){
    $this->session->set_userdata('revert_data',0);
  }
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Office Pointer | Pointer by Telkom Indonesia</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.5 -->
  <link rel="stylesheet" href="<?php echo base_url('assets/jqwidgets/styles/jqx.base.css');?>" type="text/css" />
  <link rel="stylesheet" href="<?php echo base_url('assets/bootstrap/css/bootstrap.css');?>">
  <link rel="stylesheet" href="<?php echo base_url('assets/css/additional.css');?>">
  <link rel="stylesheet" href="<?php echo base_url('assets/plugins/Font-Awesome-master/css/font-awesome.min.css');?>">
  <link rel="stylesheet" href="<?php echo base_url('assets/dist/css/AdminLTE.css');?>">
  <link rel="stylesheet" href="<?php echo base_url('assets/dist/css/skins/_all-skins.min.css');?>">
  <link rel="stylesheet" href="<?php echo base_url('assets/plugins/iCheck/flat/blue.css');?>">
  <link rel="stylesheet" href="<?php echo base_url('assets/plugins/morris/morris.css');?>">
  <link rel="stylesheet" href="<?php echo base_url('assets/plugins/jvectormap/jquery-jvectormap-1.2.2.css');?>">
  <link rel="stylesheet" href="<?php echo base_url('assets/plugins/datepicker/datepicker3.css');?>">
  <link rel="stylesheet" href="<?php echo base_url('assets/plugins/daterangepicker/daterangepicker-bs3.css');?>">
  <link rel="stylesheet" href="<?php echo base_url('assets/plugins/datatables/dataTables.bootstrap.css');?>">
  <link href="<?php echo base_url('assets/favicon.png');?>" rel="shortcut icon">
  <link href="<?php echo base_url('assets/favicon.png');?>" rel="favicon">
<script src="<?php echo base_url('assets/plugins/jQuery/jQuery-2.1.4.min.js');?>"></script>
<!-- jQuery UI 1.11.4 -->
<script src="<?php echo base_url('assets/plugins/jQueryUI/jquery-ui.min.js');?>"></script>
<script src="<?php echo base_url('assets/plugins/datatables/jquery.dataTables.min.js');?>"></script>
<script src="<?php echo base_url('assets/plugins/datatables/dataTables.bootstrap.min.js');?>"></script>
<script src="<?php echo base_url('assets/js/notification.js');?>"></script>
<script src="https://cdn.datatables.net/fixedcolumns/3.1.0/js/dataTables.fixedColumns.min.js"></script>

<script type="text/javascript" src="<?php echo base_url('assets/jqwidgets/jqxcore.js');?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/jqwidgets/jqxdata.js');?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/jqwidgets/jqxtree.js');?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/jqwidgets/jqxcheckbox.js');?>"></script>
<script type="text/javascript">
    function get_activity_info (id) {
    $.ajax({
      url:'<?php echo base_url("marketing/get_last_activity");?>/'+id,
      type:'GET',
      success:function(balik){
        $("#detail_fol_"+id).html(balik);       
      }
    });
  }

  function get_user_assign(){
    $.ajax({
      url:'<?php echo base_url("operational/get_user_assign");?>',
      type:'GET',
      dataType:'json',
      success:function(data){

          var source =
                {
                    datatype: "json",
                    datafields: [
                        { name: 'id' },
                        { name: 'parentid' },
                        { name: 'text' },
                        { name: 'value' }
                    ],
                    id: 'id',
                    localdata: data
                };
                // create data adapter.
                var dataAdapter = new $.jqx.dataAdapter(source);
                // perform Data Binding.
                dataAdapter.dataBind();
                // get the tree items. The first parameter is the item's id. The second parameter is the parent item's id. The 'items' parameter represents 
                // the sub items collection name. Each jqxTree item has a 'label' property, but in the JSON data, we have a 'text' field. The last parameter 
                // specifies the mapping between the 'text' and 'label' fields.  
                var records = dataAdapter.getRecordsHierarchy('id', 'parentid', 'items', [{ name: 'text', map: 'label'}]);
                $('#user_assign_id').jqxTree({ checkboxes:true,source: records, width: '300px'});
                $('#user_assign_id').jqxTree('expandAll');
                $('#user_assign_id').jqxTree({ hasThreeStates: true });
                $('#user_assign_id').on('checkChange',function (event)
                {
                var items = $('#user_assign_id').jqxTree('getCheckedItems');
                  
                var nilai = "";
                for(var data in items) {
                    nilai += items[data].id+",";
                }
                  $("#id_user").val(nilai);
                });  
      }
    });
  }
</script>
</head>
<body class="hold-transition skin-blue sidebar-mini fixed" style="background:lightgray;">

<div class="wrapper">

  <header class="main-header">
    <!-- Logo -->
    <a href="<?php echo base_url() ;?>" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><b>O</b>P</span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"><b>Office</b>Pointer</span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top" role="navigation">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
        <span class="sr-only">Toggle navigation</span>
      </a>

      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
        <?php 
          if(in_array($this->session->userdata('group'), array('Service Operation'))){
          ?>
          <li class="dropdown tasks-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <i class="fa fa-plane"></i>
              <span id="label_issued_log" class="label label-success">0</span>
            </a>
            <ul class="dropdown-menu">
              <li class="header">Issued Log</li>
              <li>
                <!-- inner menu: contains the actual data -->
                <ul class="menu" id="issued_log_data">
                </ul>
              </li>
              <li class="footer"><a target="_blank" href="https://admin.pointer.co.id/airline/admin/selling">View all</a></li>
            </ul>
          </li>
          <!-- Tasks: style can be found in dropdown.less -->
          <li class="dropdown messages-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <i class="fa fa-hourglass-half"></i>
              <span id="label_processing_log" class="label label-danger">0</span>
            </a>
            <ul class="dropdown-menu">
              <li class="header">Processing</li>
              <li>
                <!-- inner menu: contains the actual data -->
                <ul class="menu" id="processing_log_data">
                </ul>
              </li>
              <li class="footer">
                <a href="https://admin.pointer.co.id/airline/admin/viewbooks">View all</a>
              </li>
            </ul>
          </li>
          <li class="dropdown messages-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <i class="fa fa-exclamation-circle"></i>
              <span id="label_revert_log" class="label label-danger">0</span>
            </a>
            <ul class="dropdown-menu">
              <li class="header">Revert GA &amp; JT, Please Check</li>
              <li>
                <!-- inner menu: contains the actual data -->
                <ul class="menu" id="revert_log_data">
                </ul>
              </li>
              <li class="footer">
                <a href="<?php echo base_url("operational/all_error");?>">View all</a>
              </li>
            </ul>
          </li>
          <li class="dropdown messages-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <i class="fa fa-credit-card"></i>
              <span id="label_deposit_data" class="label label-danger">0</span>
            </a>
            <ul class="dropdown-menu">
              <li class="header">Deposit Vendor</li>
              <li>
                <!-- inner menu: contains the actual data -->
                <ul class="menu" id="deposit_data">
                </ul>
              </li>
              <li class="footer">
                <a href="https://admin.pointer.co.id/finance/airline/collection">View all</a>
              </li>
            </ul>
          </li>
          <?php } ?>
          <!-- Messages: style can be found in dropdown.less-->
          <!-- User Account: style can be found in dropdown.less -->
          <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <img src="<?php echo $this->session->userdata('picture');?>" class="user-image" alt="User Image">
              <span class="hidden-xs"><?php echo $this->session->userdata('nama');?></span>
            </a>
            <ul class="dropdown-menu">
              <!-- User image -->
              <li class="user-header">
                <img src="<?php echo $this->session->userdata('picture');?>" class="img-circle" alt="User Image">

                <p>
                  <?php echo $this->session->userdata('nama')." - ".$this->session->userdata('divisi');?>
                  <small><?php echo $this->session->userdata('group');?></small>
                </p>
              </li>
              <!-- Menu Body 
              <li class="user-body">
                <div class="row">
                  <div class="col-xs-4 text-center">
                    <a href="#">Followers</a>
                  </div>
                  <div class="col-xs-4 text-center">
                    <a href="#">Sales</a>
                  </div>
                  <div class="col-xs-4 text-center">
                    <a href="#">Friends</a>
                  </div>
                </div>
                <!-- /.row 
              </li>
               <!-- Menu Footer-->
              <li class="user-footer">
                <div class="pull-left">
                  <a href="<?php echo base_url('settings/edit_profile');?>" class="btn btn-default btn-flat">Edit Profile</a>
                </div>
                <div class="pull-right">
                  <a href="<?php echo base_url('login/logout');?>" class="btn btn-default btn-flat">Sign out</a>
                </div>
              </li>
            </ul>
          </li>
        </ul>
      </div>
    </nav>
  </header>