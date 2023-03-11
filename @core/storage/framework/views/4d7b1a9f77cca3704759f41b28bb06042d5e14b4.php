<?php $__env->startSection('page-meta-data'); ?>
<meta name="description" content="<?php echo e($page_post->meta_description); ?>">
<meta name="tags" content="<?php echo e($page_post->meta_tags); ?>">
<?php $__env->stopSection(); ?>
<?php $__env->startSection('site-title'); ?>
    <?php echo e($page_post->title); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('page-title'); ?>
    <?php echo e($page_post->title); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <?php if(!empty($page_post->page_builder_status)): ?>
        <?php echo \App\PageBuilder\PageBuilderSetup::render_frontend_pagebuilder_content_by_location('dynamic_page',$page_post->id); ?>

    <?php else: ?>
        <?php echo $__env->make('frontend.partials.dynamic-page-content', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php endif; ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('frontend.frontend-page-master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/xgenxchi/public_html/laravel/nexelit/beta/@core/resources/views/frontend/pages/dynamic-single.blade.php ENDPATH**/ ?>