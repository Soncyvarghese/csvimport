<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
<head>
	<link rel="stylesheet" href="<?php echo base_url('assets/bootstrap.min.css'); ?>">
	<link rel="stylesheet" href="<?php echo base_url('assets/dataTables.bootstrap.min.css') ?>">
</head>
<body>
<div id="messages"></div>
<div class="container">
	<h4>Import Users</h4>
	 <div class="row">       	
	     <div class="col-md-6" id="importFrm">
            <form action="<?php echo base_url('employee/import'); ?>" method="post" enctype="multipart/form-data" id="createForm">
                <input type="file" name="csv_file" id="csv_file" accept=".csv" required>
               
         </div>
    </div>
	<div class="row"> 
	<div class="col-md-3">      	
        <div style="margin-top:4px;">	
        	<?php for($i=1;$i<=5;$i++){ ?>
        		<select name="select_data[]" class="form-control select_data" required >
        			<option value="">Please Select</option>
        			<option value="emp_code">Employee Code</option>
        			<option value="emp_name">Name</option>
        			<option value="department">Department</option>
        			<option value="date_of_birth">Date of Birth</option>
        			<option value="joining_date">Joining Date</option>
        		</select>
        		<br>
        	<?php }?>   
    </div>
     <input type="submit" class="btn btn-sm btn-primary" name="importSubmit" value="IMPORT">
        </form>
			</div>
			<div class="col-md-1"> </div>
		<div class="col-md-8">  
			<div class="table">
				<table id="manageTable" class="table table-bordered"  width="100%">
					<thead>
						<tr style="background:#337ab7;color:#fff" >
							<th> EMPLOYEE CODE</th>
							<th>EMPLOYEE NAME</th> 							
							<th>DEPARTMENT</th>                                 
							<th>AGE</th>
							<th>EXPERIENCE</th>
						</tr>
						</thead>                          
					</table>
				</div>
			</div>
		</div>    
	</div>
</body>
</html>
<script src="<?php echo base_url('assets/jquery/jquery.min.js') ?>"></script>
<script src="<?php echo base_url('assets/jquery/jquery.dataTables.min.js') ?>"></script>
 
<script>

    var manageTable;
   $(document).ready(function () {      
       manageTable = $('#manageTable').DataTable({
            'ajax': '<?php echo base_url('employee/fetch_employeeData') ?>',
            'dom': 'bflrti',
			"bSort": false,

        });
    });
	
	$("#createForm").on('submit',(function(e) {
	  e.preventDefault();
	  $.ajax({
		   url: "<?php echo base_url('employee/import') ?>",
		   type: "POST",
		   data:  new FormData(this),
		   contentType: false,
			cache: false,
		   processData:false,
	  
			success: function(data)
			{		
		
			  if($.trim(data)=='Data Imported Successfully'){
				$('.select_data').val('');
			  }
			   $('#manageTable').DataTable().ajax.reload();
				$("#messages").html('<div class="alert alert-warning alert-dismissible" role="alert">' +
				'<strong>' + data +'</strong>'+
				'</div>');                
			  }			  
			});
	}));
   
    </script>
