
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
				<div class="col-12">
					<div class="page-title-box d-sm-flex align-items-center justify-content-between">
						<h4>Campaign</h4>
						<a href="<?php echo e(route('campaign.create')); ?>" class="btn btn-primary btn-sm"><i
							class="fa fa-plus"></i> Create Campaign</a>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-xs-12 col-md-12 col-lg-12 col-sm-12">
					<div class="card">
						<div class="card-body">
							<div class="clearfix"></div>
							<?php
                                if($sort_by == 'asc'){
                                  $sort = 'desc';
                                }
                                elseif($sort_by == 'desc'){
                                $sort = 'asc';
                                }else{
                                $sort = 'desc';
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
									<label>Search:<input type="search" value="<?php echo e($search); ?>" name="search" class="form-control input-sm"
										placeholder=""></label>
								</div>
								</div>
								</div>
							</form>
							<table class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0"
								width="100%" id="datatable">
								<thead>
									<tr>
										<th class="<?php if($sort_f == 'id' && $sort_by == 'desc'): ?> sorting_desc <?php elseif($sort_f == 'id' && $sort_by == 'asc'): ?> sorting_asc <?php else: ?> sorting <?php endif; ?>" onclick="ascDescFilter('id');">
											S.NO.
										</th>
										<th class="<?php if($sort_f == 'created_at' && $sort_by == 'desc'): ?> sorting_desc <?php elseif($sort_f == 'created_at' && $sort_by == 'asc'): ?> sorting_asc <?php else: ?> sorting <?php endif; ?>" onclick="ascDescFilter('created_at');">
											Date 
										</th>
										<th class="<?php if($sort_f == 'campaign_name' && $sort_by == 'desc'): ?> sorting_desc <?php elseif($sort_f == 'campaign_name' && $sort_by == 'asc'): ?> sorting_asc <?php else: ?> sorting <?php endif; ?>" onclick="ascDescFilter('campaign_name');">
											Campaign Name
									
										</th>
										<th class="<?php if($sort_f == 'created_by' && $sort_by == 'desc'): ?> sorting_desc <?php elseif($sort_f == 'created_by' && $sort_by == 'asc'): ?> sorting_asc <?php else: ?> sorting <?php endif; ?>" onclick="ascDescFilter('created_by');">
											Created By
									
										</th>
										<th class="<?php if($sort_f == 'total_count' && $sort_by == 'desc'): ?> sorting_desc <?php elseif($sort_f == 'total_count' && $sort_by == 'asc'): ?> sorting_asc <?php else: ?> sorting <?php endif; ?>" onclick="ascDescFilter('total_count');">
											Total Count
									
										</th>
										<th class="<?php if($sort_f == 'deliverCount' && $sort_by == 'desc'): ?> sorting_desc <?php elseif($sort_f == 'deliverCount' && $sort_by == 'asc'): ?> sorting_asc <?php else: ?> sorting <?php endif; ?>" onclick="ascDescFilter('deliverCount');">
											Answered
										</th>
										<th class="<?php if($sort_f == 'notDeliverCount' && $sort_by == 'desc'): ?> sorting_desc <?php elseif($sort_f == 'notDeliverCount' && $sort_by == 'asc'): ?> sorting_asc <?php else: ?> sorting <?php endif; ?>" onclick="ascDescFilter('notDeliverCount');">
											Not Answered
										</th>
										<th>
										    Campign Id
										</th>
										<th>
										    ID Token
										</th>
										<th>Action</th>
									</tr>
								</thead>
								<tbody>
									<?php $__currentLoopData = $campaign; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $r): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
									<tr>
										<td class="product-p">
											<span class="product-price-wrapper">
											<span class=""><?php echo e(($key+1) + ($campaign->currentPage() - 1)*$campaign->perPage()); ?></span>
											</span>
										</td>
										<td class="product-headline text-left wide-column">
											<span class="product-price-wrapper">
											<?php echo e(date('d-m-Y', strtotime($r->created_at))); ?>

											</span>
										</td>
										<td class="product-headline text-left wide-column">
											<span class="product-price-wrapper">
											<?php echo e($r->campaign_name); ?>

											</span>
										</td>
                                        <?php
										$user_detail  =  App\Models\User::where('id',$r->user_id)->first()
										?>
                                        <td class="product-headline text-left wide-column">
											<span class="product-price-wrapper">
											<?php echo e($user_detail->first_name); ?> <?php echo e($user_detail->last_name); ?>

											</span>
										</td>
										<td class="product-headline text-left wide-column">
											<span class="product-price-wrapper">
											<?php echo e($r->total_count); ?>

											</span>
										</td>
										<td class="product-headline text-left wide-column">
											<span class="product-price-wrapper">
												<?php echo e($r->success_count); ?>

											</span>
										</td>
										<td class="product-headline text-left wide-column">
											<span class="product-price-wrapper">
											<?php echo e($r->failed_count); ?>

											</span> 
										</td>
										<td class="product-headline text-left wide-column">
											<span class="product-price-wrapper">
											<?php echo e($r->campaignID); ?>

											</span>
										</td>
										<td class="product-headline text-left wide-column">
											<span class="product-price-wrapper" style="word-break:break-all">
											<?php echo e($r->idToken); ?>

											</span>
										</td>
                                        <td class="product-headline text-left wide-column">
											<a href="<?php echo e(url('admin/campaign/downloadFile',$r->id)); ?>" class="btn btn-success btn-sm btn-rounded waves-effect waves-light" title="Download Report"> <i class="bx bx-download f-17 mr-1"></i> </a>
                                            <a href="<?php echo e(route('campaign.show', $r->id)); ?>" class="btn btn-primary btn-sm btn-rounded waves-effect waves-light" title="View Details" target="_blank">  <i class="fas fa-eye"></i></a>

											<a href="<?php echo e(url('admin/campaign/campaignStartStop/start', $r->id)); ?>" class="btn btn-success btn-sm btn-rounded waves-effect waves-light" title="Download Report"> Start </a>

                                            <a href="<?php echo e(url('admin/campaign/campaignStartStop/stop', $r->id)); ?>" class="btn btn-primary btn-sm btn-rounded waves-effect waves-light" title="View Details"> Pause </a>

											<button type="button" class="btn btn-primary waves-effect waves-light" data-bs-toggle="modal" data-bs-target=".bs-example-modal-center<?php echo e($r->id); ?>">Retry</button>
											
											<?php if($r->returncreditflag != 1): ?>
											<a href="<?php echo e(url('admin/campaign/refundCredit',$r->id)); ?>" class="btn btn-success btn-sm btn-rounded waves-effect waves-light" title="Refund Credit"> Refund Credit (<?php echo e($r->failed_count); ?>)</a>
											<?php else: ?>
								 				<a href="javascript:void(0);" class="btn btn-success btn-sm btn-rounded waves-effect waves-light">Refund Done </a>
											<?php endif; ?>

											<div class="modal fade bs-example-modal-center<?php echo e($r->id); ?>" tabindex="-1" role="dialog" aria-hidden="true">
												<div class="modal-dialog modal-dialog-centered<?php echo e($r->id); ?>">
													<div class="modal-content">
														<div class="modal-header">
															<h5 class="modal-title">On which number you want to retry</h5>
															<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
														</div>
														<div class="modal-body">
															<a class="btn btn-primary" onclick="ConfirmDialog('all',<?php echo e($r->id); ?>)">All numbers</a>
															<a class="btn btn-primary" onclick="ConfirmDialog('answered', <?php echo e($r->id); ?>)">Answered</a>
															<a class="btn btn-primary" onclick="ConfirmDialog('notanswered', <?php echo e($r->id); ?>)">Not Answered</a>
														</div>
													</div>
												</div>
											</div>
										</td> 
									</tr>
									<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
								</tbody>
							</table>
							<div style="float: right;">
								<?php echo e($campaign->appends(request()->input())->links()); ?>

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
	</script>
<script>


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
	        url: "<?php echo e(url('admin/campaign/retryCampaign')); ?>/"+type+"/"+id,
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

	$('.number').keyup(function(e) {
	    if (/\D/g.test(this.value)) {
	        this.value = this.value.replace(/\D/g, '');
	    }
	});
</script>

<script>
	 function ascDescFilter(id){
            $('#sort_f').val(id);
            $('#searchForm').submit();
        }
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('admin.layout.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH F:\xampp\htdocs\myvoicecall\resources\views/admin/campaign/index.blade.php ENDPATH**/ ?>