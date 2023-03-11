<?php $__env->startSection('site-title'); ?>
    <?php echo e(__('Regenerate Image Settings')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <div class="col-lg-12 col-ml-12 padding-bottom-30">
        <div class="row">
            <div class="col-12 mt-5">
                <?php echo $__env->make('backend.partials.message', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                <div class="card">
                    <div class="card-body">
                        <h4 class="header-title"><?php echo e(__("Regenerate Image Settings")); ?></h4>
                       <div class="message-wrap"></div>
                        <button type="button" class="btn btn-primary mt-4 pr-4 pl-4 regenarate_image"><?php echo e(__('Regenerate Images')); ?></button>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('script'); ?>
    <script>
        $(document).on('click','.regenarate_image',function (){
            $(this).attr('disabled',true);
            $('.message-wrap').html('<p class="alert alert-warning"><?php echo e(__('it may take few minutes to complete the process...')); ?></p>');
            $(this).append('<i class="fas fa-spinner fa-spin"></i>')
           $.ajax({
               type : 'post',
               url: "<?php echo e(route('admin.general.regenerate.thumbnail')); ?>",
               data :{
                   _token: "<?php echo e(csrf_token()); ?>"
               },
               success: function (data){
                   $('.message-wrap').html('<p class="alert alert-'+data.type+'">'+data.msg+'</p>');
                   $('.regenarate_image i').remove();
                   $('.regenarate_image').attr('disabled',false);
               },
               error: function (res){

               }
           })
        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('backend.admin-master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/xgenxchi/public_html/laravel/nexelit/@core/resources/views/backend/general-settings/regenerate-image.blade.php ENDPATH**/ ?>