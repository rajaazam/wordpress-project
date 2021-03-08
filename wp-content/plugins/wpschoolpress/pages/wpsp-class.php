<?php
if (!defined( 'ABSPATH' ) )exit('No Such File');
wpsp_header();
	if( is_user_logged_in() ) {
		global $current_user, $wpdb;
		$current_user_role=$current_user->roles[0];
		if( $current_user_role=='administrator' || $current_user_role=='teacher')
		{
			wpsp_topbar();
			wpsp_sidebar();
			wpsp_body_start();
			$filename	=	'';
			$header	=	'Classes';
			if( isset($_GET['tab'] ) && sanitize_text_field($_GET['tab']) == 'addclass' ) {
				$header	=	$label	=	__( 'Add New Class', 'WPSchoolPress');
				$filename	=	WPSP_PLUGIN_PATH .'includes/wpsp-classForm.php';				
			}elseif((isset($_GET['id']) && is_numeric($_GET['id'])))  {
				$header	=	$label	=	__( 'Update Class', 'WPSchoolPress');
				$filename	=	WPSP_PLUGIN_PATH .'includes/wpsp-classForm.php';				
			}
		?>  
		<?php 
		if( !empty( $filename) ) {
			include_once ( $filename );
		} else {
		?>
		<div class="wpsp-card">
			<div class="wpsp-card-head">                                   
                <h3 class="wpsp-card-title">Class List</h3>	
				<?php  if( $current_user_role=='administrator' ) { ?>
								<!-- <div class="subject-head" style="margin-bottom:10px;">
									<a class="wpsp-btn wpsp-btn-success pull-right" href="<?php echo wpsp_admin_url();?>sch-class&tab=addclass"><i class="fa fa-plus"></i> Add Class</a>
								</div> -->
				<?php } ?>
            </div>
			<div class="wpsp-card-body">
				<table class="wpsp-table" id="class_table" cellspacing="0" width="100%" style="width:100%">
					<thead>
					<tr>
						<th class="nosort">#</th>
						<th>Class Number</th>
						<th>Class Name</th>
						<th>Teacher Incharge</th>
						<th>Number of Students</th>
						<th>Capacity</th>
						<th>Location</th>
						<?php  if( $current_user_role=='administrator' ) { ?> <th class="nosort" align="center">Action</th> <?php } ?>			
					</tr>
					</thead>
					<tbody>
									<?php
									$ctable=$wpdb->prefix."wpsp_class";
									$stable=$wpdb->prefix."wpsp_student";
									$wpsp_classes =$wpdb->get_results("select * from $ctable order by cid DESC");
									$sno=1;
									$teacher_table=	$wpdb->prefix."wpsp_teacher";
									$teacher_data = $wpdb->get_results("select wp_usr_id,CONCAT_WS(' ', first_name, middle_name, last_name ) AS full_name from $teacher_table order by tid");
									$teacherlist	=	array();
									if( !empty( $teacher_data ) ) {
										foreach( $teacher_data  as $value )
											$teacherlist[$value->wp_usr_id] = $value->full_name;
									}									
									foreach ($wpsp_classes as $wpsp_class) 
									{
										$cid=intval($wpsp_class->cid);
										$class_students_count = $wpdb->get_var( "SELECT COUNT(`wp_usr_id`) FROM $stable WHERE class_id = '$cid'" );
										$teach_id= intval($wpsp_class->teacher_id);
										$teachername	=	'';
									?>
										<tr id="<?php echo intval($wpsp_class->cid);?>" class="pointer">
											<td><?php echo $sno;?><td><?php echo  $wpsp_class->c_numb;?> </td> 
											<td><?php echo $wpsp_class->c_name;?></td>
											<td><?php echo isset( $teacherlist[$teach_id] ) ? $teacherlist[$teach_id] : '';?></td>
											<td><?php echo $class_students_count;?></td>
											<td><?php echo $wpsp_class->c_capacity;?></td>
											<td><?php echo $wpsp_class->c_loc;?></td>
											<?php  if( $current_user_role=='administrator' ) { ?>
												<td align="center">
													<div class="wpsp-action-col"> 
													<a href="<?php echo wpsp_admin_url();?>sch-class&id=<?php echo $wpsp_class->cid."&edit=true";?>" title="Edit">
													<i class="icon dashicons dashicons-edit wpsp-edit-icon"></i></a>
													
													<a href="javascript:;" id="d_teacher" class="wpsp-popclick" data-pop="DeleteModal" title="Delete" data-id="<?php echo $wpsp_class->cid;?>" >
	                                				<i class="icon dashicons dashicons-trash wpsp-delete-icon" data-id="<?php echo $wpsp_class->cid;?>"></i>
	                                				</a>
	                                				</div>
													<!-- <a href="javascript:;" title="Edit"><i class="fa fa-pencil btn btn-warning  ClassEditBt" cid="<?php echo $wpsp_class->cid;?>"></i></a> -->
													<!-- <a class="edit-btn" href="<?php echo wpsp_admin_url();?>sch-class&id=<?php echo intval($wpsp_class->cid).'&edit=true';?>"><i class="fa fa-pencil wpsp-btn wpsp-btn-warning "></i></a>
													
													<a href="javascript:;" title="Delete"><i class="fa fa-trash wpsp-btn wpsp-btn-danger  ClassDeleteBt delete-btn" data-id="<?php echo intval($wpsp_class->cid);?>" ></i></a> -->	
												</td>
											<?php } ?>	
										</tr>
									<?php	
										$sno++;
									}
									?>
								</tbody>
				</table>
			</div>
		</div>		
		
		<?php  } if( $current_user_role=='administrator' ) { ?>
		<!-- <div class="modal fade" id="AddModal" tabindex="-1" role="dialog" aria-labelledby="AddModal" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="col-md-12">
						<div class="box box-success">
							<div class="box-header">
								<h3 class="box-title">New test Entry</h3>
							</div>
								<form name="ClassAddForm" id="ClassAddForm" method="post">
									<?php //include( WPSP_PLUGIN_PATH.'/includes/wpsp-classForm.php'); ?>
								</form>
						</div>
					</div>					
				</div>
			</div>
		</div>
		<div class="modal fade" id="EditModal" tabindex="-1" role="dialog" aria-labelledby="EditModal" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="col-md-12">
						<div class="box box-success">
							<div class="box-header">
								<h3 class="box-title">Edit Class Info</h3>
							</div>
							<form name="ClassEditForm" id="ClassEditForm" method="post">
								<input type="hidden" name="cid" value="">
								<?php //include( WPSP_PLUGIN_PATH .'/includes/wpsp-classForm.php'); ?>
							</form>
						</div>
					</div>					
				</div>
			</div>
		</div> --><!-- /.modal -->
		<!--<div class="modal fade" id="InfoModal" tabindex="-1" role="dialog" aria-labelledby="InfoModal" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="wpsp-col-md-12">
						<div class="box box-success">
							<div class="box-header">
								<h3 class="box-title" id="InfoModalTitle"></h3>
							</div>
							<div id="InfoModalBody" class="box-body">
							</div>
						</div>
					</div>					
				</div>
			</div>
		</div>--><!-- /.modal -->
		<?php  } ?>
		<?php
			//include_once ( $filename );	
			wpsp_body_end();
			wpsp_footer();
		}
		else if($current_user_role=='parent' || $current_user_role='student')
		{
			wpsp_topbar();
			wpsp_sidebar();
			wpsp_body_start();
			?>
			<!-- <section class="content-header">
				<h1>Classes</h1>
				<ol class="breadcrumb">
					<li><a href="<?php echo wpsp_admin_url();?>sch-dashboard"><i class="fa fa-dashboard"></i> Dashboard</a></li>
					<li><a href="<?php echo wpsp_admin_url();?>sch-class">Classes</a></li>
				</ol>
			</section> -->
			<!-- <section class="content"> -->
				<div class="wpsp-row">
					<div class="wpsp-col-md-12">
						<div class="wpsp-card">
						<div class="wpsp-card-head ui-sortable-handle">
                                    <h3 class="wpsp-card-title">Classe Details </h3>
                                    <!-- tools box -->
                                  
                                    <!-- /. tools -->
                                </div>
							<div class="wpsp-card-body">
							<!-- <div class="wpsp-table-responsive"> -->							
								<table id="class_table" class="wpsp-table wpsp-table-bordered wpsp-table-striped" cellspacing="0" width="100%" style="width:100%">
									<thead>
									<tr>
										<th class="nosort">#</th>
										<th>Class Number</th>
										<th>Class Name</th>
										<th>Teacher Incharge</th>
										<th>Number of Students</th>
										<th>Location</th>
									</tr>
									</thead>
									<tbody>
									<?php
									$ctable=$wpdb->prefix."wpsp_class";
									$stable=$wpdb->prefix."wpsp_student";
									$teacher_table=	$wpdb->prefix."wpsp_teacher";
									$teacher_data = $wpdb->get_results("select wp_usr_id,CONCAT_WS(' ', first_name, middle_name, last_name ) AS full_name from $teacher_table order by tid");
									$teacherlist	=	array();
									if( !empty( $teacher_data ) ) {
										foreach( $teacher_data  as $value )
											$teacherlist[$value->wp_usr_id] = $value->full_name;
									}		
									if( $current_user_role=='student' ) {
										$wpsp_classes =$wpdb->get_results("SELECT cls.* FROM $ctable cls, $stable st where st.wp_usr_id = $current_user->ID AND st.class_id=cls.cid");
									} else {
										$wpsp_classes =$wpdb->get_results("SELECT DISTINCT cls.* FROM $ctable cls, $stable st where st.parent_wp_usr_id = $current_user->ID AND st.class_id=cls.cid");
									}
									$sno=1;
									foreach ($wpsp_classes as $wpsp_class)
									{
										$cid = intval($wpsp_class->cid);
										$class_students_count = $wpdb->get_var( "SELECT COUNT(`wp_usr_id`) FROM $stable WHERE class_id = '$cid'" );
										$teach_id= intval($wpsp_class->teacher_id);
										$teacher=get_userdata($teach_id);
										?>
										<tr id="<?php echo  intval($wpsp_class->cid);?>" class="pointer">
											<td><?php echo $sno;?><td><?php echo  $wpsp_class->c_numb;?> </td>
											<td><?php echo $wpsp_class->c_name;?></td>
										    <td><?php echo isset( $teacherlist[$teach_id] ) ? $teacherlist[$teach_id] : '';?></td>
											<td><?php echo $class_students_count;?></td>
											<td><?php echo $wpsp_class->c_loc;?></td>
										</tr>
										<?php
										$sno++;
									}
									?>
									</tbody>
								</table>
								</div>	
							</div>
						</div>
					</div>
				<!-- </div> -->
			<!-- </section> -->
			<?php
			wpsp_body_end();
			wpsp_footer();
		}
	}
	else{
		//Include Login Section
		include_once( WPSP_PLUGIN_PATH .'/includes/wpsp-login.php');
	}
?>