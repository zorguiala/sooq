<script type="text/javascript">
    $(function () {
        var <?php echo e($model->id); ?> = new Highcharts.Chart({
            colors: [
                <?php $__currentLoopData = $model->colors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    "<?php echo e($c); ?>",
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            ],
            chart: {
                renderTo: "<?php echo e($model->id); ?>",
                <?php echo $__env->make('charts::_partials.dimension.js2', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                plotBackgroundColor: null,
                plotBorderWidth: null,
                plotShadow: false,
                type: 'pie'
            },
            <?php if($model->title): ?>
                title: {
                    text:  "<?php echo $model->title; ?>",
                },
            <?php endif; ?>
            <?php if(!$model->credits): ?>
                credits: {
                    enabled: false
                },
            <?php endif; ?>
            tooltip: {
                pointFormat: '{point.y} <b>({point.percentage:.1f}%)</strong>'
            },
            plotOptions: {
                pie: {
                    allowPointSelect: true,
                    cursor: 'pointer',
                    dataLabels: {
                        enabled: true,
                        format: '<b>{point.name}</strong>: {point.y} ({point.percentage:.1f}%)',
                        style: {
                            color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
                        }
                    }
                }
            },
            legend: {
                <?php if(!$model->legend): ?>
                    enabled: false
                <?php endif; ?>
            },
            series: [{
                colorByPoint: true,
                data: [
                    <?php for($i = 0; $i < count($model->values); $i++): ?>
                        {
                            name: "<?php echo $model->labels[$i]; ?>",
                            y: <?php echo e($model->values[$i]); ?>

                        },
                    <?php endfor; ?>
                ]
            }]
        })
    });
</script>

<?php if(!$model->customId): ?>
    <?php echo $__env->make('charts::_partials.container.div', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php endif; ?>
