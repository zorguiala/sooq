<script type="text/javascript">
    google.charts.setOnLoadCallback(draw<?php echo e($model->id); ?>)

    function draw<?php echo e($model->id); ?>() {
        var data = google.visualization.arrayToDataTable([
            ['Country', "<?php echo $model->element_label; ?>"],
            <?php for($i = 0; $i < count($model->values); $i++): ?>
                ["<?php echo e($model->labels[$i]); ?>", <?php echo e($model->values[$i]); ?>],
            <?php endfor; ?>
        ])

        var options = {
            <?php echo $__env->make('charts::_partials.dimension.js', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
            colorAxis: {
                colors: [
                    "#C5CAE9", "#283593"
                ]
            },
            region: "<?php echo e($model->region ? $model->region : 'world'); ?>",
            datalessRegionColor: "#e0e0e0",
            defaultColor: "#607D8",
        };

        var <?php echo e($model->id); ?> = new google.visualization.GeoChart(document.getElementById("<?php echo e($model->id); ?>"))

        <?php echo e($model->id); ?>.draw(data, options)
    }
</script>

<?php if(!$model->customId): ?>
    <?php echo $__env->make('charts::_partials/container.div-titled', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php endif; ?>
