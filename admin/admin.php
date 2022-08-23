<?php
session_start();
include_once('../config.php');
if(!$_SESSION['username']){
	header('Location: ../index.php');
	die();
}else{


?>
<!DOCTYPE html>
<html lang="en">
  <?php include'head.php'; ?>

  <body class="app sidebar-mini rtl">
    <!-- Navbar-->
    <?php include'topnav.php'; ?>
    <!-- Sidebar menu-->
    <div class="app-sidebar__overlay" data-toggle="sidebar"></div>
    <?php include 'nav.php'; ?>
    <main class="app-content">
      <div class="app-title">
        <div>
          <h1><i class="fa fa-dashboard"></i> Dashboard</h1>
          <p>Admin Dashboard</p>
        </div>
        <ul class="app-breadcrumb breadcrumb">
          <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
          <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
        </ul>
      </div>
      <div class="row">
        <div class="col-md-6">
          <div class="tile">
            <h3 class="tile-title">Staff Employment Type</h3>
            <div class="embed-responsive embed-responsive-16by9">
              <canvas class="embed-responsive-item" id="pieChartDemo"></canvas>
            </div>
            <div class="row" style="margin-top:10px;">
              <div class="col-md-3"><span class="key" id="key1"></span> Casual</div>
              <div class="col-md-3"><span class="key" id="key2"></span> Part Time</div>
              <div class="col-md-3"><span class="key" id="key3"></span> Full Time</div>
              <div class="col-md-3"><span class="key" id="key4"></span> Temporary</div>
            </div>
          </div>
        </div>
      </div>

<!-- Table -->
      <div class="clearfix"></div>
        <div class="col-md-12">
          <div class="tile">
            <h3 class="tile-title">
              Employee's General Analysis
              <a href="addemployee.php" class="btn btn-primary btn-sm float-right">
                <i class="fa fa-user-plus"></i> Add New Employee
              </a>
            </h3>
            <div class="table-responsive">
              <table class="table">
                <thead>
                  <tr>
                    <th>ID</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Phone</th>
					          <th>Type</th>  
					          <th>Position</th>  
					          <th>Attendance/Mon</th>  
					          <th></th>  
                  </tr>
                </thead>
                <tbody id="employees">
                </tbody>
              </table>
            </div>
          </div>
        </div>
    </main>
	  
	  <script>
    if ( window.history.replaceState ) {
        window.history.replaceState( null, null, window.location.href);
    }
</script>
    <!-- Essential javascripts for application to work-->
    <script src="js/jquery-3.2.1.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/main.js"></script>
    <!-- The javascript plugin to display page loading on top-->
    <script src="js/plugins/pace.min.js"></script>
    <!-- Page specific javascripts-->
    <script type="text/javascript" src="js/plugins/chart.js"></script>
    <script type="text/javascript">
      function loadPieChat(piedata){
        var pdata = piedata;
        
        var ctxp = $("#pieChartDemo").get(0).getContext("2d");
        var pieChart = new Chart(ctxp).Pie(pdata);
      }

      function loadEmployees() {
        $.ajax({
          type:'post',
          url:'backend/statistics.php',
          data:{action:'fetch_employees_stats'},
          dataType:'json',
          success:function (res) {
            employees = '';
            res.employees.forEach(employee => {
              employees += `<tr>                   
                    <td>${employee.employee_id}</td>
                    <td>${employee.firstname}</td>
                    <td>${employee.lastname}</td>
                    <td>${employee.phone}</td>
                    <td>${employee.emp_type}</td>
                    <td>${employee.position}</td>
                    <td>${employee.stats}</td>
					          <td>
                    <a href="employee_details.php?empid=${employee.employee_id}"><i class="fa fa-eye mr-2"></i></a>
                      <a href="editemployee.php?empid=${employee.employee_id}"><i class="fa fa-edit"></i></a>
                    </td>
                  </tr>`;
            });
            $('#employees').html(employees)
          }
        })
      }
      loadEmployees();
      
    // Set Active Nav
    $('.app-menu > li:nth-child(1) a').addClass('active');
    function fetchStatistics() {
      $.ajax({
        type:'post',
        url:'backend/statistics.php',
        data:{action:'general'},
        dataType:'json',
        success:function (stats) {
          loadPieChat(stats.piedata);
          console.log(stats);
        }
      })
    }
    fetchStatistics();
    </script>
    
  </body>
</html>
<?php	
}
?>