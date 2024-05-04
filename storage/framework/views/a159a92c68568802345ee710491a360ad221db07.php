
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
<style>
    .paging_simple_numbers{
        display: none !important;
    }
    .dataTables_info{
        display: none !important;
    }
    .dataTables_filter{
        display: none !important;
    }
    .dataTables_length{
        display: none !important;
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
				<div class="col-xs-12 col-md-12 col-lg-12 col-sm-12">
					<div class="card">
						<div class="card-body table-responsive">
							<div class="clearfix"></div>
							<?php
                                if($sort_by == 'asc'){
                                  $sort = 'desc';
                                }
                                elseif($sort_by == 'desc'){
                                $sort = 'asc';
                                }else{
                                $sort = 'asc';
                                 }
                            ?>
							<form action="<?php echo e(request()->url()); ?>" id="searchForm" method="get">
								<input type="hidden" value="<?php echo e($sort); ?>" name="sort_by" id="sort_by">
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
								
										<div style="float: right;">
											<label>Search:<input type="search" value="<?php echo e($search); ?>" name="search" class="form-control input-sm" placeholder=""></label>
										</div>
									</div>
								</div>
							</form>

							<table
								class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0"
								width="100%" id="datatable">
								<thead>
									<tr role="row">
										<th class="<?php if($sort_f == 'id' && $sort_by == 'desc'): ?> sorting_desc <?php elseif($sort_f == 'id' && $sort_by == 'asc'): ?> sorting_asc <?php else: ?> sorting <?php endif; ?>" onclick="ascDescFilter('id');">
											S.NO.
										</th>
										<th class="<?php if($sort_f == 'created_at' && $sort_by == 'desc'): ?> sorting_desc <?php elseif($sort_f == 'created_at' && $sort_by == 'asc'): ?> sorting_asc <?php else: ?> sorting <?php endif; ?>" onclick="ascDescFilter('created_at');">
											Date 
										</th>
										<th class="<?php if($sort_f == 'cli' && $sort_by == 'desc'): ?> sorting_desc <?php elseif($sort_f == 'cli' && $sort_by == 'asc'): ?> sorting_asc <?php else: ?> sorting <?php endif; ?>" onclick="ascDescFilter('cli');">
											Dialler 
										</th>
										<th class="<?php if($sort_f == 'mobile_no' && $sort_by == 'desc'): ?> sorting_desc <?php elseif($sort_f == 'mobile_no' && $sort_by == 'asc'): ?> sorting_asc <?php else: ?> sorting <?php endif; ?>" onclick="ascDescFilter('mobile_no');">
											Dailing 
										</th>
										<th class="<?php if($sort_f == 'call_duration' && $sort_by == 'desc'): ?> sorting_desc <?php elseif($sort_f == 'call_duration' && $sort_by == 'asc'): ?> sorting_asc <?php else: ?> sorting <?php endif; ?>" onclick="ascDescFilter('call_duration');">
											Duration 
										</th>
										<th class="<?php if($sort_f == 'status' && $sort_by == 'desc'): ?> sorting_desc <?php elseif($sort_f == 'status' && $sort_by == 'asc'): ?> sorting_asc <?php else: ?> sorting <?php endif; ?>" onclick="ascDescFilter('status');">
											Status 
										</th>
										<th class="<?php if($sort_f == 'call_start_ts' && $sort_by == 'desc'): ?> sorting_desc <?php elseif($sort_f == 'call_start_ts' && $sort_by == 'asc'): ?> sorting_asc <?php else: ?> sorting <?php endif; ?>" onclick="ascDescFilter('call_start_ts');">
											Call Start Time 
										</th>
										<th class="<?php if($sort_f == 'call_connect_ts' && $sort_by == 'desc'): ?> sorting_desc <?php elseif($sort_f == 'call_connect_ts' && $sort_by == 'asc'): ?> sorting_asc <?php else: ?> sorting <?php endif; ?>" onclick="ascDescFilter('call_connect_ts');">
											Call Connect Time
										</th>
										<th class="<?php if($sort_f == 'call_end_ts' && $sort_by == 'desc'): ?> sorting_desc <?php elseif($sort_f == 'call_end_ts' && $sort_by == 'asc'): ?> sorting_asc <?php else: ?> sorting <?php endif; ?>" onclick="ascDescFilter('call_end_ts');">
											Call End Time
										</th>
										<th class="<?php if($sort_f == 'call_remarks' && $sort_by == 'desc'): ?> sorting_desc <?php elseif($sort_f == 'call_remarks' && $sort_by == 'asc'): ?> sorting_asc <?php else: ?> sorting <?php endif; ?>" onclick="ascDescFilter('call_remarks');">
											Call Remarks
										</th>
										<th>Action</th>
									</tr>
								</thead>
								<tbody>
									<?php if(count($campaigndata) != 0): ?>
									<?php $__currentLoopData = $campaigndata; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $r): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
									<tr>
										<td><?php echo e(($key+1) + ($campaigndata->currentPage() - 1)*$campaigndata->perPage()); ?></td>
										<td class="product-headline text-left wide-column">
											<span class="product-price-wrapper">
											<?php echo e(date('d-m-Y', strtotime($r->created_at))); ?>

											</span>
										</td>
										<td class="product-headline text-left wide-column">
											<span class="product-price-wrapper">
											<?php echo e($r->cli); ?>

											</span>
										</td>
										<td class="product-headline text-left wide-column">
											<span class="product-price-wrapper">
											<?php echo e($r->mobile_no); ?>

											</span>
										</td>
										<td class="product-headline text-left wide-column">
											<span class="product-price-wrapper">
											<?php echo e($r->call_duration); ?>

											</span>
										</td>
										<td class="product-headline text-left wide-column">
											<span class="product-price-wrapper">
											<?php if($r->status == 1 ): ?>
												Answered
											<?php else: ?>
												Not Answerd
											<?php endif; ?>
											</span>
										</td>
										<td class="product-headline text-left wide-column">
											<span class="product-price-wrapper">
											<?php echo e($r->call_start_ts); ?>

											</span>
										</td>
										<td class="product-headline text-left wide-column">
											<span class="product-price-wrapper">
											<?php echo e($r->call_connect_ts); ?>

											</span>
										</td>
										<td class="product-headline text-left wide-column">
											<span class="product-price-wrapper">
											<?php echo e($r->call_end_ts); ?>

											</span>
										</td>
										<td class="product-headline text-left wide-column">
											<span class="product-price-wrapper">
											<?php echo e($r->call_remarks); ?>

											</span>
										</td>
										<td class="product-headline text-left wide-column">
											<?php if($r->status == 0): ?>
											<a class="btn btn-primary" onclick="ConfirmDialog('all',<?php echo e($r->id); ?>)">Resend <?php echo e($r->id); ?></a>
											<?php endif; ?>
										</td>
										
									</tr>
									<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
									<?php else: ?>
									<tr class="odd">
										<td valign="top" colspan="12"
											class="dataTables_empty text-center">No data
											available in table
										</td>
									</tr>
									<?php endif; ?>
								</tbody>
							</table>
							<div style="float: right;">
								<?php echo e($campaigndata->appends(request()->input())->links()); ?>

							</div>
						</div>
					</div>
				</div>
			</div>
		</div>		
	</div>
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

	function downloadFile(campaignId) {
	    $.ajaxSetup({
	      headers: {
	        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	      }
	    });
	
	    $.ajax({
	        url: "<?php echo e(url('admin/campaign/downloadFile')); ?>/"+campaignId,
	        method: 'GET',
	        success: function(response) {
	            if(response == 1){
	
	            }
	        },
	        error: function(xhr, status, error) {
	            console.error('Error updating player ID:', error);
	        }
	    });
	}

	$('.number').keyup(function(e) {
	    if (/\D/g.test(this.value)) {
	        this.value = this.value.replace(/\D/g, '');
	    }
	});

	function ascDescFilter(id){
		$('#sort_f').val(id);
		$('#searchForm').submit();
	}

	function ConfirmDialog(type,id) {
		$('.btn-close').trigger('click');
		$('<div></div>').appendTo('body')
		.html('<div><h6></h6></div>')
		.dialog({
		modal: true,
		title: 'Are you Sure? ',
		zIndex: 10000,
		autoOpen: true,
		width: 'auto',
		resizable: false,
		buttons: {
			Yes: function(sucesss) {
				$(this).remove();
				$.ajax({
				url: "<?php echo e(url('admin/campaign/resend')); ?>/"+id,
				method: 'GET',
				success: function(response) {
					if(response == 1){
					
					}
					window.location.reload();
				},
				error: function(xhr, status, error) {
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
<?php $__env->stopPush(); ?>
<?php echo $__env->make('admin.layout.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH F:\xampp\htdocs\myvoicecall\resources\views/admin/campaign/view.blade.php ENDPATH**/ ?>