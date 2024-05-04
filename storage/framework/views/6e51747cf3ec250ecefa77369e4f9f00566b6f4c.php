
<?php $__env->startSection('title', 'Sounds - All'); ?>
<?php $__env->startPush('headerscript'); ?>
<link href="<?php echo e(asset('skote/layouts/assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css')); ?>" rel="stylesheet" type="text/css" />
<link href="<?php echo e(asset('skote/layouts/assets/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css')); ?>" rel="stylesheet" type="text/css" />
<link href="<?php echo e(asset('skote/layouts/assets/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css')); ?>" rel="stylesheet" type="text/css" />
<style>
	.red-row {
	background-color: red !important;
	color:white !important;
	}
</style>
<?php $__env->stopPush(); ?>
<?php $__env->startSection('content'); ?>
<!-- ============================================================== -->
<!-- Start right Content here -->
<!-- ============================================================== -->
<meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
<div class="page-content">
	<!-- Start content -->
	<div class="">
		<div class="container-fluid">
			<?php if(session()->has('error')): ?>
			<div class="alert alert-danger">
				<?php echo e(session()->get('error')); ?>

			</div>
		<?php endif; ?>

		<?php if(session()->has('success')): ?>
			<div class="alert alert-success">
				<?php echo e(session()->get('success')); ?>

			</div>
		<?php endif; ?>
			<div class="row">
				<div class="col-12">
					<div class="page-title-box d-sm-flex align-items-center justify-content-between">
						<h4 class="mb-sm-0 font-size-18"><i class="bx bx-video-recording"></i> All Voice Files</h4>
						<div class="page-title-right">
							<a href="<?php echo e(route('sound.create')); ?>" class="btn btn-primary btn-sm"><i
								class="fa fa-plus"></i> Add Voice File</a>
						</div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-xs-12 col-md-12 col-lg-12 col-sm-12">
					<div class="card">
						<div class="card-body  overflow-x-auto">
							<div class="clearfix"></div>
							<form action="<?php echo e(request()->url()); ?>" id="searchForm" method="get">
					            <input type="hidden" name="sort_f" value="<?php if(isset(request()->sort_f)): ?> <?php echo e($sort_f); ?> <?php else: ?> id <?php endif; ?>" id="sort_f">
								<div class="row">
								    	<div class="col-sm-12">
								    <label>Show
									<select name="paginate" onchange="this.form.submit()"  id="paginate"
										class="form-control input-sm width-auto d-inline-block" style="width:auto">
									<option <?php if($paginate == 10): ?> selected <?php endif; ?> value="10">10</option>
									<option <?php if($paginate == 25): ?> selected <?php endif; ?> value="25">25</option>
									<option <?php if($paginate == 50): ?> selected <?php endif; ?> value="50">50</option>
									<option <?php if($paginate == 100): ?> selected <?php endif; ?> value="100">100</option>
									</select> entries</label>
								
								
								</div>
								</div>
							</form>
							<table class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0"
								width="100%" id="datatable">
								<thead>
									<tr>
										<th>S.NO.</th>
										<th>File Name</th>
										<th>Type</th>
										<th>Uploaded By</th>
										<th>Duration</th>
										<th>Upload Date</th>
										<th>Aproved Date</th>
										<th>Action</th>
									</tr>
								</thead>
								<tbody>
									<?php $__currentLoopData = $sound; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $r): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
									<tr>
										<td class="product-p">
											<span class="product-price-wrapper">
											<span class=""><?php echo e($loop->iteration); ?></span>
											</span>
										</td>
										<td class="product-headline text-left wide-column">
											<span class="product-price-wrapper">
											<?php echo e($r->name); ?>

											</span>
										</td>
										<td class="product-headline text-left wide-column">
											<span class="product-price-wrapper">
											<?php echo e($r->type); ?>

											</span>
										</td>
										<?php
										$user_detail   =   App\Models\User::where('id',$r->user_id)->first();
										?>
										<td class="product-headline text-left wide-column">
											<span class="product-price-wrapper">
											<?php echo e(@$user_detail->first_name); ?> <?php echo e(@$user_detail->last_name); ?>

											</span>
										</td>
										<td class="product-headline text-left wide-column">
											<span class="product-price-wrapper">
											<?php echo e($r->duration); ?>

											</span>
										</td>
										<td class="product-headline text-left wide-column">
											<span class="product-price-wrapper">
											<?php echo e(date('d-m-Y H:i:s ',strtotime($r->created_at))); ?>

											</span>
										</td>
										<td class="product-headline text-left wide-column">
											<span class="product-price-wrapper">
											<?php echo e(date('d-m-Y H:i:s ',strtotime($r->updated_at))); ?>

											</span>
										</td>
										<td class="product-headline text-left wide-column d-flex cl-gap-5">
											<!-- center modal -->
											<button type="button" style="padding: 0; color: #50a5f1;  background: none;  border: 0px; " class="btn btn-primary waves-effect waves-light f-17" data-bs-toggle="modal" data-bs-target=".bs-example-modal-center<?php echo e($r->id); ?>"><i class="bx bx bx-play"></i></button>
											<div class="modal fade bs-example-modal-center<?php echo e($r->id); ?>" tabindex="-1" role="dialog" aria-hidden="true">
												<div class="modal-dialog modal-dialog-centered">
													<div class="modal-content">
														<div class="modal-header">
															<h5 class="modal-title">Voice Clip</h5>
															<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
														</div>
														<div class="modal-body">
															<audio controls>
																<source src="<?php echo e(asset($r->voiceclip)); ?>" type="audio/ogg">
																Your browser does not support the audio tag.
															</audio>
														</div>
													</div>
												</div>
											</div>
											<div id="<?php echo e($r->id); ?>">
												
												<?php if($r->status == 0 && $r->provider != 'Videocon'): ?>
												<a class="text-danger" onclick="statusUpdate(<?php echo e($r->id); ?>)" title="Pending"> <i class=""><img width="15" height="15" src="https://img.icons8.com/ios-glyphs/30/FA5252/hourglass--v1.png" alt="hourglass--v1"></i></a>
												<?php else: ?>
												<?php if($r->provider == 'Videocon' && $r->status == 0): ?>
												<a class="text-danger" disabled title="Pending"> <i class=""><img width="15" height="15" src="https://img.icons8.com/ios-glyphs/30/FA5252/hourglass--v1.png" alt="hourglass--v1"></i></a>
												<?php else: ?>
												<a class="text-success" title="Approved"><i class="bx bx-check-double f-17"></i> </a>
												<?php endif; ?>
												<?php endif; ?>
											</div>
											<a class="" href="<?php echo e(asset($r->voiceclip)); ?>" title="Download File" download="<?php echo e($r->voiceclip); ?>">
											<i class="bx bx-download f-17" ></i>
											</a>
										</td>
									</tr>
									<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
								</tbody>
							</table>
							<div style="float: right;">
								<?php echo e($sound->appends(request()->input())->links()); ?>

							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- container -->
	</div>
	<!-- content -->
</div>
<?php $__env->stopSection(); ?>
<?php $__env->startPush('footerscript'); ?>
<script src="<?php echo e(asset('skote/layouts/assets/libs/datatables.net/js/jquery.dataTables.min.js')); ?>"></script>
<script src="<?php echo e(asset('skote/layouts/assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js')); ?>"></script>
<script src="<?php echo e(asset('skote/layouts/assets/js/pages/datatables.init.js')); ?>"></script> 
<!-- Responsive examples -->
<script src="<?php echo e(asset('skote/layouts/assets/libs/datatables.net-responsive/js/dataTables.responsive.min.js')); ?>"></script>
<script src="<?php echo e(asset('skote/layouts/assets/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js')); ?>"></script>
<link href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css" rel="stylesheet" />
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
<script>
	$("#datatable").dataTable({
	   "processing": false, // for show progress bar
		"paging": false, // for disable paging
		"filter": false,
		"ordering": false, // this is for disable sort order
    "orderMulti": false, // for disable multiple column at once
	});
	/* function statusUpdate(soundid) {
	   $.ajaxSetup({
	      headers: {
	        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	      }
	    });
	
	    $.ajax({
	        url: "<?php echo e(url('admin/sound/approveStatus')); ?>/"+soundid,
	        method: 'GET',
	        data: { soundid: soundid },
	        success: function(response) {
	            if(response == 1){
	                $('#'+soundid).html('');
	                $('#'+soundid).html('<a class="text-success" title="Approved"><i class="bx bx-check-double f-17"></i> </a>');
	            }
	        },
	        error: function(xhr, status, error) {
	            console.error('Error updating player ID:', error);
	        }
	    });
	} */
 
	$('.modal').on('hide.bs.modal', function () { //Change #myModal with your modal id
      	$('audio').each(function(){
       		this.pause(); // Stop playing
        	this.currentTime = 0; // Reset time
      }); 
	})
 function statusUpdate(soundid) {
	$('.btn-close').trigger('click');
  	$('<div></div>').appendTo('body')
    .html('<div><h6>Are you Sure?</h6></div>')
    .dialog({
      modal: true,
      title: '',
      zIndex: 10000,
      autoOpen: true,
      width: 'auto',
      resizable: false,
      buttons: {
        Yes: function(sucesss) {
			$(this).remove();
		 $.ajaxSetup({
	      headers: {
	        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	      }
	    });
	
	    $.ajax({
	        url: "<?php echo e(url('admin/sound/approveStatus')); ?>/"+soundid,
	        method: 'GET',
	        data: { soundid: soundid },
	        success: function(response) {
	            if(response == 1){
	                $('#'+soundid).html('');
	                $('#'+soundid).html('<a class="text-success" title="Approved"><i class="bx bx-check-double f-17"></i> </a>');
                           $("<div></div>").dialog({
        title: 'Sound Successfully Approved',
        resizable: true,
        modal: true,
        autoOpen: true,
        buttons: {
            'Ok': function () {

                $(this).dialog('close');
            }
        }
    });        
	            }
	        },
	        error: function(xhr, status, error) {
                  $("<div></div>").dialog({
        title: 'Error updating player ID:'+ error,
        resizable: true,
        modal: true,
        autoOpen: true,
        buttons: {
            'Ok': function () {

                $(this).dialog('close');
            }
        }
    });
	            console.error('Error updating player ID:', error);
	        }
	    });
        },
        No: function() {
			$(this).remove();
     
        }
      },
      close: function(event, ui) {
        $(this).remove();
      }
    });
};
</script>


<script>
	$('.number').keyup(function(e) {
	    if (/\D/g.test(this.value)) {
	        this.value = this.value.replace(/\D/g, '');
	    }
	});
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('admin.layout.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH F:\xampp\htdocs\myvoicecall\resources\views/admin/sound/index.blade.php ENDPATH**/ ?>