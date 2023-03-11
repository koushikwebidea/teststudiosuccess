<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Search For:')); ?> <?php echo e($search_term); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('site-title'); ?>
    <?php echo e(__('Search For:')); ?> <?php echo e($search_term); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <section class="blog-content-area padding-120">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <div class="row">
                        <?php if(count($all_knowledgebase) > 0): ?>
                            <?php $__currentLoopData = $all_knowledgebase; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="single-knowledgebase-list-item">
                                    <h4 class="title"><a href="<?php echo e(route('frontend.knowledgebase.single',$data->slug)); ?>"><i class="fas fa-folder"></i> <?php echo e($data->title); ?></a></h4>
                                    <div class="short-content">
                                        <?php echo Str::words(strip_tags($data->content),50); ?>

                                    </div>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php else: ?>
                            <div class="col-lg-12">
                                <div class="alert alert-warning d-block"><?php echo e(__('No Article Found')); ?></div>
                            </div>
                        <?php endif; ?>
                    </div>
                    <div class="col-lg-12">
                        <nav class="pagination-wrapper text-center" aria-label="Page navigation ">
                            <?php echo e($all_knowledgebase->links()); ?>

                        </nav>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="widget-area">
                        <?php echo App\WidgetsBuilder\WidgetBuilderSetup::render_frontend_sidebar('knowledgebase',['column' => false]); ?>

                    </div>
                </div>
            </div>
        </div>
    </section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('frontend.frontend-page-master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/xgenxchi/public_html/laravel/nexelit/@core/resources/views/frontend/pages/knowledgebase/knowledgebase-search.blade.php ENDPATH**/ ?>