
<?php $__env->startSection('title', 'bbps - profile'); ?>
<?php $__env->startPush('headerscript'); ?>


<?php $__env->stopPush(); ?>
<?php $__env->startSection('content'); ?>
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                            <div class="col-12">
                                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                                    <h4 class="mb-sm-0 font-size-18"><i class="bx bx-user-circle"></i> Profile</h4>

                                    

                                </div>
                            </div>
                        </div>
        <div class="row">
            <div class="flash-message">
                <?php $__currentLoopData = ['danger', 'warning', 'success', 'info']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $msg): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php if(Session::has('alert-' . $msg)): ?>
                        <section>
                            <div class="row">
                                <div class="col-sm-12 col-lg-12">
                                    <center>
                                        <div data-example-id="simple-alerts" class="bs-example">
                                            <div role="alert" class="alert alert-success">
                                                <strong>Thank you your request has been Submitted
                                                    Successfully! Please wait untill your Request Approves!
                                                </strong>
                                            </div>
                                        </div>
                                    </center>
                                </div>
                            </div>
                        </section>
                    <?php endif; ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div> <!-- end .flash-message -->
        </div>
        
        <div class="row">
            
    <div class="col-lg-12">
        <div class="dashboard-tab cart-wrapper p-5 bg-white rounded-lg shadow-xs mb-3">
            <!--<div class="row">-->
            <!--    <div class="col-lg-4 offset-sm-4 text-center">-->
            <!--        <h2 class="text-center" style="margin-top: 25px;"><strong style="color: #33439b;">Profile-->
            <!--                Details</strong></h2>-->

            <!--    </div>-->
            <!--</div>-->
            <form method="post" action="<?php echo e(url('admin/adminupdateprofile')); ?>" enctype="multipart/form-data">
                <?php echo csrf_field(); ?>
                <div class="row">
                    <div class="col-sm-6 ">
                        <div class="form-group fg-line">
                            <label class="fg-label">First Name</label>
                            <input type="text" name="name" value="<?php echo e(old('name', Auth::user()->first_name)); ?>"
                                class="form-control">

                        </div>
                    </div>
                     <div class="col-sm-6 mb-3 ">
                        <div class="form-group fg-line">
                            <label class="fg-label">Last Name</label>
                            <input type="text" name="last_name" value="<?php echo e(old('name', Auth::user()->last_name)); ?>"
                                class="form-control">

                        </div>
                    </div>
                </div>
                <div class="row">
                    <?php
                        $userdetail = App\Models\UserDetail::where('user_id', Auth::user()->id)->first();
                    ?>

                     <div class="col-sm-6 mb-3 ">
                        <div class="form-group fg-line">
                            <label class="fg-label">Aadhar No.</label>
                            <input type="text" name="aadhar_no" value="<?php echo e($userdetail->aadhar_no); ?>"
                                class="form-control">

                        </div>
                    </div>

                     <div class="col-sm-6 mb-3 ">
                        <div class="form-group fg-line">
                            <label class="fg-label">Phone No</label>
                            <input type="text" name="phone_no" value="<?php echo e($userdetail->phone_no); ?>" class="form-control">

                        </div>
                    </div>
                </div>
                <div class="row">
                     <div class="col-sm-6 mb-3 ">
                        <div class="form-group fg-line">
                            <label class="fg-label">D.O.B</label>
                            <input type="date" name="dob" value="<?php echo e($userdetail->dob); ?>" class="form-control">

                        </div>
                    </div>
                     <div class="col-sm-6 mb-3 ">
                        <div class="form-group fg-line">
                            <label class="fg-label">Address</label>
                            <input type="text" name="address" value="<?php echo e($userdetail->address); ?>" class="form-control">

                        </div>
                    </div>
                </div>
                <div class="row">
                     <div class="col-sm-6 mb-3 ">
                        <div class="form-group fg-line">
                            <label class="fg-label">City</label>
                            <input type="text" name="city" value="<?php echo e($userdetail->city); ?>" class="form-control">

                        </div>
                    </div>
                     <div class="col-sm-6 mb-3 ">
                        <div class="form-group fg-line">
                            <label class="fg-label">State</label>
                            <input type="text" name="state" value="<?php echo e($userdetail->state); ?>" class="form-control">

                        </div>
                    </div>
                </div>
                <div class="row">
                     <div class="col-sm-6 mb-3 ">
                        <div class="form-group fg-line">
                            <label class="fg-label">Pin Code</label>
                            <input type="text" name="pincode" value="<?php echo e($userdetail->pincode); ?>" class="form-control">

                        </div>
                    </div>
                     <div class="col-sm-6 mb-3 ">
                        <div class="form-group fg-line">
                            <label class="fg-label">Pan No.</label>
                            <input type="text" name="pan_no" value="<?php echo e($userdetail->pan_no); ?>" class="form-control">

                        </div>
                    </div>
                </div>
                <div class="row">
                     <div class="col-sm-6 mb-3 ">
                        <div class="form-group fg-line">
                            <label class="fg-label">Bank Name</label>
                            <input type="text" name="bank_name" value="<?php echo e($userdetail->bank_name); ?>"
                                class="form-control">

                        </div>
                    </div>
                     <div class="col-sm-6 mb-3 ">
                        <div class="form-group fg-line">
                            <label class="fg-label">Account Holder Name</label>
                            <input type="text" name="account_holder_name" value="<?php echo e($userdetail->account_holder_name); ?>"
                                class="form-control">

                        </div>
                    </div>
                </div>
                <div class="row">
                     <div class="col-sm-6 mb-3 ">
                        <div class="form-group fg-line">
                            <label class="fg-label">IFSC</label>
                            <input type="text" name="ifsc_code" value="<?php echo e($userdetail->ifsc_code); ?>"
                                class="form-control">

                        </div>
                    </div>
                     <div class="col-sm-6 mb-3 ">
                        <div class="form-group fg-line">
                            <label class="fg-label">Cheque</label>
                            <input type="file" name="cheque" value="<?php echo e($userdetail->cheque); ?>" class="form-control">

                        </div>
                    </div>
                </div>
            
                <div class="row">
                    <div class="col-md-6 form-group">
                        
                    <button type="submit" class="btn btn-primary m-t-10 waves-effect">Save</button>
                 
                    <button type="reset" class="btn btn-danger m-t-10 waves-effect">Cancel</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
        </div>
        </div>
    </div>
    </div>
    </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layout.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH F:\xampp\htdocs\myvoicecall\resources\views/admin/profile.blade.php ENDPATH**/ ?>